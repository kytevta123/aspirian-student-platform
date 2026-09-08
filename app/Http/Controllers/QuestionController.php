<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Question;
use App\Services\QuestionDuplicateDetector;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function create(): View
    {
        return view('questions.create');
    }

    public function index(Request $request): View
    {
        $query = Question::query()
            ->with([
                'topic.chapter.book.subject',
            ]);

        if ($request->filled('search')) {
            $search = trim(
                $request->string('search')->toString()
            );

            $query->where(
                'question_text',
                'like',
                '%' . $search . '%'
            );
        }

        if ($request->filled('question_type')) {
            $query->where(
                'question_type',
                $request->string('question_type')->toString()
            );
        }

        if ($request->filled('difficulty')) {
            $query->where(
                'difficulty',
                $request->string('difficulty')->toString()
            );
        }

        if ($request->filled('topic_id')) {
            $query->where(
                'topic_id',
                $request->integer('topic_id')
            );
        }

        if ($request->filled('chapter_id')) {
            $query->whereHas(
                'topic.chapter',
                function ($chapterQuery) use ($request) {
                    $chapterQuery->where(
                        'id',
                        $request->integer('chapter_id')
                    );
                }
            );
        }

        if ($request->filled('subject_id')) {
            $query->whereHas(
                'topic.chapter.book',
                function ($bookQuery) use ($request) {
                    $bookQuery->where(
                        'subject_id',
                        $request->integer('subject_id')
                    );
                }
            );
        }

        $questions = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view(
            'questions.index',
            compact('questions')
        );
    }

    public function store(
        StoreQuestionRequest $request,
        QuestionDuplicateDetector $detector
    ): RedirectResponse {
        $validated = $request->validated();

        $questionText = $validated['question_text'];

        $exactDuplicate = $detector->findExact(
            $questionText
        );

        $similarQuestions = $detector->findSimilar(
            $questionText,
            0.80
        );

        /*
         * Remove the exact duplicate from
         * similarity results.
         */
        if ($exactDuplicate !== null) {
            $similarQuestions = $similarQuestions
                ->reject(
                    fn (Question $question) =>
                        $question->id === $exactDuplicate->id
                )
                ->values();
        }

        if (
            $exactDuplicate !== null
            || $similarQuestions->isNotEmpty()
        ) {
            if (
                ! $request->boolean('confirm_duplicate')
            ) {
                return back()
                    ->withInput()
                    ->with(
                        'duplicate_warning',
                        $this->buildDuplicateWarning(
                            $exactDuplicate,
                            $similarQuestions
                        )
                    );
            }
        }

        $validated['normalized_text'] =
            $detector->normalize($questionText);

        unset(
            $validated['confirm_duplicate']
        );

        Question::create($validated);

        return redirect()
            ->route('questions.index')
            ->with(
                'status',
                'Question created successfully.'
            );
    }

    public function update(
        UpdateQuestionRequest $request,
        Question $question,
        QuestionDuplicateDetector $detector
    ): RedirectResponse {
        $validated = $request->validated();

        $questionText = $validated['question_text'];

        $exactDuplicate = $detector->findExact(
            $questionText,
            $question->id
        );

        $similarQuestions = $detector->findSimilar(
            $questionText,
            0.80,
            $question->id
        );

        /*
         * Remove the exact duplicate from
         * similarity results.
         */
        if ($exactDuplicate !== null) {
            $similarQuestions = $similarQuestions
                ->reject(
                    fn (Question $similarQuestion) =>
                        $similarQuestion->id ===
                        $exactDuplicate->id
                )
                ->values();
        }

        if (
            $exactDuplicate !== null
            || $similarQuestions->isNotEmpty()
        ) {
            if (
                ! $request->boolean('confirm_duplicate')
            ) {
                return back()
                    ->withInput()
                    ->with(
                        'duplicate_warning',
                        $this->buildDuplicateWarning(
                            $exactDuplicate,
                            $similarQuestions
                        )
                    );
            }
        }

        /*
         * Save current version before update.
         */
        $question->revisions()->create([
            'user_id' => Auth::id(),

            'question_data' => [
                'topic_id' =>
                    $question->topic_id,

                'question_type' =>
                    $question->question_type,

                'question_text' =>
                    $question->question_text,

                'normalized_text' =>
                    $question->normalized_text,

                'options' =>
                    $question->options,

                'answer' =>
                    $question->answer,

                'explanation' =>
                    $question->explanation,

                'marks' =>
                    $question->marks,

                'difficulty' =>
                    $question->difficulty,

                'status' =>
                    $question->status,
            ],
        ]);

        $validated['normalized_text'] =
            $detector->normalize($questionText);

        unset(
            $validated['confirm_duplicate']
        );

        $question->update($validated);

        return redirect()
            ->route('questions.index')
            ->with(
                'status',
                'Question updated successfully.'
            );
    }

    public function destroy(
        Question $question
    ): RedirectResponse {
        $question->delete();

        return back()->with(
            'status',
            'Question deleted successfully.'
        );
    }

    private function buildDuplicateWarning(
        ?Question $exactDuplicate,
        $similarQuestions
    ): array {
        $warning = [
            'exact' => null,
            'similar' => [],
        ];

        if ($exactDuplicate !== null) {
            $warning['exact'] = [
                'id' =>
                    $exactDuplicate->id,

                'question_text' =>
                    $exactDuplicate->question_text,

                'topic_id' =>
                    $exactDuplicate->topic_id,
            ];
        }

        foreach (
            $similarQuestions->take(5)
            as $similarQuestion
        ) {
            $warning['similar'][] = [
                'id' =>
                    $similarQuestion->id,

                'question_text' =>
                    $similarQuestion->question_text,

                'similarity_score' =>
                    $similarQuestion->similarity_score,

                'topic_id' =>
                    $similarQuestion->topic_id,
            ];
        }

        return $warning;
    }
}