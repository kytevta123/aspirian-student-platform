<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Test;
use App\Models\Topic;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TestQuestionController extends Controller
{
    /**
     * Show the question selection screen for a test.
     */
    public function index(
        Request $request,
        Test $test
    ): View {
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

        $questions = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $selectedQuestionIds = $test->questions()
            ->pluck('questions.id')
            ->all();

        $topics = Topic::query()
            ->with([
                'chapter.book.subject',
            ])
            ->orderBy('title')
            ->get();

        $selectedQuestions = $test->questions()->get();

        return view(
            'tests.questions.index',
            compact(
                'test',
                'questions',
                'topics',
                'selectedQuestionIds',
                'selectedQuestions'
            )
        );
    }

    /**
     * Manually add a question to the test.
     */
    public function store(
        Request $request,
        Test $test
    ): RedirectResponse {
        $validated = $request->validate([
            'question_id' => [
                'required',
                'integer',
                'exists:questions,id',
            ],
        ]);

        $question = Question::findOrFail(
            $validated['question_id']
        );

        if (
            ! $test->questions()
                ->where('questions.id', $question->id)
                ->exists()
        ) {
            $nextSortOrder = (int) (
                $test->questions()
                    ->max('test_questions.sort_order') ?? 0
            );

            $test->questions()->attach(
                $question->id,
                [
                    'sort_order' => $nextSortOrder + 1,
                    'marks' => $question->marks,
                ]
            );
        }

        return back()->with(
            'status',
            'Question added to test successfully.'
        );
    }

    /**
     * Remove a question from the test.
     */
    public function destroy(
        Test $test,
        Question $question
    ): RedirectResponse {
        $test->questions()->detach($question->id);

        return back()->with(
            'status',
            'Question removed from test successfully.'
        );
    }

    /**
     * Add all questions from a topic.
     */
    public function storeTopic(
        Request $request,
        Test $test
    ): RedirectResponse {
        $validated = $request->validate([
            'topic_id' => [
                'required',
                'integer',
                'exists:topics,id',
            ],
        ]);

        $topic = Topic::findOrFail(
            $validated['topic_id']
        );

        $addedCount = $test->addQuestionsFromTopic(
            $topic
        );

        return back()->with(
            'status',
            $addedCount . ' question(s) added from topic.'
        );
    }

    /**
     * Add all questions of a difficulty.
     */
    public function storeDifficulty(
        Request $request,
        Test $test
    ): RedirectResponse {
        $validated = $request->validate([
            'difficulty' => [
                'required',
                'string',
                'in:easy,medium,hard',
            ],
        ]);

        $addedCount = $test->addQuestionsByDifficulty(
            $validated['difficulty']
        );

        return back()->with(
            'status',
            $addedCount . ' question(s) added by difficulty.'
        );
    }
/**
 * Update the order of questions in a test.
 */
public function updateOrder(
    Request $request,
    Test $test
): RedirectResponse {
    $validated = $request->validate([
        'question_ids' => [
            'required',
            'array',
            'min:1',
        ],
        'question_ids.*' => [
            'required',
            'integer',
            'distinct',
            'exists:questions,id',
        ],
    ]);

    $questionIds = $validated['question_ids'];

    $selectedQuestionIds = $test->questions()
        ->pluck('questions.id')
        ->map(fn ($id) => (int) $id)
        ->all();

    $submittedQuestionIds = array_map(
        'intval',
        $questionIds
    );

    sort($selectedQuestionIds);
    sort($submittedQuestionIds);

    if ($selectedQuestionIds !== $submittedQuestionIds) {
        return back()->withErrors([
            'question_ids' =>
                'The submitted question order does not match the questions selected for this test.',
        ]);
    }

    foreach ($questionIds as $index => $questionId) {
        $test->questions()->updateExistingPivot(
            $questionId,
            [
                'sort_order' => $index + 1,
            ]
        );
    }

    return back()->with(
        'status',
        'Question order updated successfully.'
    );
}
}