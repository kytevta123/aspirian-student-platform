<?php

namespace App\Http\Controllers;

use App\Models\WritingAttempt;
use App\Models\WritingTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WritingController extends Controller
{
    /**
     * Display published writing templates.
     */
    public function index(Request $request): View
    {
        $query = WritingTemplate::query()
            ->with([
                'grade',
                'subject',
                'chapter',
                'topic',
                'writingRubric',
            ])
            ->where(
                'status',
                WritingTemplate::STATUS_PUBLISHED
            );

        if ($request->filled('search')) {
            $search = trim(
                $request->string('search')->toString()
            );

            $query->where(function ($writingQuery) use ($search) {
                $writingQuery
                    ->where(
                        'title',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'prompt',
                        'like',
                        '%' . $search . '%'
                    );
            });
        }

        if ($request->filled('type')) {
            $query->where(
                'type',
                $request->string('type')->toString()
            );
        }

        if ($request->filled('difficulty')) {
            $query->where(
                'difficulty',
                $request->string('difficulty')->toString()
            );
        }

        $writingTemplates = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('writing.index', [
            'writingTemplates' => $writingTemplates,
        ]);
    }

    /**
     * Display a published writing prompt.
     *
     * The model answer is deliberately not exposed
     * before the student's writing is submitted.
     */
    public function show(
        Request $request,
        WritingTemplate $writingTemplate
    ): View {
        abort_unless(
            $writingTemplate->status ===
                WritingTemplate::STATUS_PUBLISHED,
            404
        );

        $writingTemplate->load([
            'grade',
            'subject',
            'chapter',
            'topic',
            'writingRubric.items',
        ]);

        /*
         * Model answers must not be available during
         * the initial prompt/writing stage.
         */
        $writingTemplate->setAttribute(
            'model_answer',
            null
        );

        return view('writing.show', [
            'writingTemplate' => $writingTemplate,
        ]);
    }

    /**
     * Start writing for a published template.
     *
     * Reuses an existing draft for the authenticated
     * student instead of creating unnecessary
     * duplicate drafts.
     */
    public function start(
        Request $request,
        WritingTemplate $writingTemplate
    ): View {
        abort_unless(
            $writingTemplate->status ===
                WritingTemplate::STATUS_PUBLISHED,
            404
        );

        $writingTemplate->load([
            'grade',
            'subject',
            'chapter',
            'topic',
            'writingRubric.items',
        ]);

        $attempt = WritingAttempt::query()
            ->where(
                'writing_template_id',
                $writingTemplate->id
            )
            ->where(
                'student_id',
                $request->user()->id
            )
            ->where(
                'status',
                WritingAttempt::STATUS_DRAFT
            )
            ->latest('id')
            ->first();

        if ($attempt === null) {
            $attempt = WritingAttempt::create([
                'writing_template_id' => $writingTemplate->id,
                'student_id' => $request->user()->id,
                'attempt_number' => $this->getNextAttemptNumber(
                    $writingTemplate->id,
                    $request->user()->id
                ),
                'content' => '',
                'word_count' => 0,
                'character_count' => 0,
                'status' => WritingAttempt::STATUS_DRAFT,
                'started_at' => now(),
            ]);
        } elseif ($attempt->started_at === null) {
            $attempt->started_at = now();
            $attempt->save();
        }

        /*
         * Model answer must remain unavailable
         * while the student is writing.
         */
        $writingTemplate->setAttribute(
            'model_answer',
            null
        );

        return view('writing.write', [
            'writingTemplate' => $writingTemplate,
            'attempt' => $attempt,
        ]);
    }

    /**
     * Save a student's writing as a draft.
     */
    public function store(
        Request $request,
        WritingTemplate $writingTemplate
    ): RedirectResponse {
        abort_unless(
            $writingTemplate->status ===
                WritingTemplate::STATUS_PUBLISHED,
            404
        );

        $validated = $request->validate([
            'content' => [
                'nullable',
                'string',
                'max:100000',
            ],
            'self_review' => [
                'nullable',
                'string',
                'max:10000',
            ],
        ]);

        $attempt = WritingAttempt::query()
            ->where(
                'writing_template_id',
                $writingTemplate->id
            )
            ->where(
                'student_id',
                $request->user()->id
            )
            ->where(
                'status',
                WritingAttempt::STATUS_DRAFT
            )
            ->latest('id')
            ->first();

        if ($attempt === null) {
            $attempt = WritingAttempt::create([
                'writing_template_id' => $writingTemplate->id,
                'student_id' => $request->user()->id,
                'attempt_number' => $this->getNextAttemptNumber(
                    $writingTemplate->id,
                    $request->user()->id
                ),
                'content' => '',
                'word_count' => 0,
                'character_count' => 0,
                'status' => WritingAttempt::STATUS_DRAFT,
                'started_at' => now(),
            ]);
        }

        $content = trim(
            (string) ($validated['content'] ?? '')
        );

        $attempt->update([
            'content' => $content,
            'word_count' => $this->getWordCount(
                $content
            ),
            'character_count' => mb_strlen(
                $content
            ),
            'self_review' => isset(
                $validated['self_review']
            )
                ? trim(
                    (string) $validated['self_review']
                )
                : $attempt->self_review,
        ]);

        return redirect()
            ->route(
                'writing.start',
                $writingTemplate
            )
            ->with(
                'status',
                'Writing draft saved successfully.'
            );
    }

    /**
     * Display a student's writing attempt.
     *
     * Submitted/reviewed attempts may expose the
     * model answer for the review stage.
     */
    public function showAttempt(
        Request $request,
        WritingAttempt $attempt
    ): View {
        if ($attempt->student_id !== $request->user()->id) {
            abort(403);
        }

        $attempt->load([
            'writingTemplate.grade',
            'writingTemplate.subject',
            'writingTemplate.chapter',
            'writingTemplate.topic',
            'writingTemplate.writingRubric.items',
            'evaluations',
        ]);

        /*
         * Model answer becomes available only after
         * the student's writing has been submitted.
         */
        if (
            $attempt->status !==
            WritingAttempt::STATUS_SUBMITTED
            &&
            $attempt->status !==
            WritingAttempt::STATUS_REVIEWED
        ) {
            $attempt->writingTemplate->setAttribute(
                'model_answer',
                null
            );
        }

        return view('writing.attempt', [
            'attempt' => $attempt,
        ]);
    }

    /**
     * Submit the student's writing attempt.
     */
    public function submit(
        Request $request,
        WritingAttempt $attempt
    ): RedirectResponse {
        if ($attempt->student_id !== $request->user()->id) {
            abort(403);
        }

        if ($attempt->isSubmitted()) {
            return back()->withErrors([
                'submission' =>
                    'This writing attempt has already been submitted.',
            ]);
        }

        if (
            $attempt->status !==
            WritingAttempt::STATUS_DRAFT
        ) {
            return back()->withErrors([
                'submission' =>
                    'This writing attempt is no longer available for submission.',
            ]);
        }

        $validated = $request->validate([
            'content' => [
                'required',
                'string',
                'max:100000',
            ],
            'self_review' => [
                'nullable',
                'string',
                'max:10000',
            ],
        ]);

        $content = trim(
            $validated['content']
        );

        if ($content === '') {
            return back()->withErrors([
                'content' =>
                    'Please write your answer before submitting.',
            ]);
        }

        $attempt->content = $content;

        $attempt->word_count = $this->getWordCount(
            $content
        );

        $attempt->character_count = mb_strlen(
            $content
        );

        $attempt->self_review = isset(
            $validated['self_review']
        )
            ? trim(
                (string) $validated['self_review']
            )
            : $attempt->self_review;

        $attempt->status =
            WritingAttempt::STATUS_SUBMITTED;

        $attempt->submitted_at = now();

        $attempt->save();

        return redirect()
            ->route(
                'writing.attempts.show',
                $attempt
            )
            ->with(
                'status',
                'Writing submitted successfully.'
            );
    }

    /**
     * Get the next attempt number for a student
     * and writing template.
     */
    private function getNextAttemptNumber(
        int $writingTemplateId,
        int $studentId
    ): int {
        return (
            WritingAttempt::query()
                ->where(
                    'writing_template_id',
                    $writingTemplateId
                )
                ->where(
                    'student_id',
                    $studentId
                )
                ->max('attempt_number')
            ?? 0
        ) + 1;
    }

    /**
     * Calculate the number of words in writing content.
     */
    private function getWordCount(string $content): int
    {
        if ($content === '') {
            return 0;
        }

        preg_match_all(
            '/\S+/u',
            $content,
            $matches
        );

        return count($matches[0]);
    }
}