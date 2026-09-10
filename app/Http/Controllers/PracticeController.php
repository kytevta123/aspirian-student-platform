<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Topic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PracticeController extends Controller
{
    /**
     * Display the practice topic selection page.
     */
    public function index(Request $request): View
    {
        $topics = Topic::query()
            ->where('status', 'active')
            ->whereHas('questions', function ($questionQuery) {
                $questionQuery
                    ->where('status', 'published');
            })
            ->withCount([
                'questions' => function ($questionQuery) {
                    $questionQuery
                        ->where('status', 'published');
                },
            ])
            ->with([
                'chapter.book.subject',
            ])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('practice.index', [
            'topics' => $topics,
        ]);
    }

    /**
     * Start practice for a topic.
     *
     * Loads the first published question
     * from the selected topic.
     */
    public function start(
        Request $request,
        Topic $topic
    ): View {
        abort_unless(
            $topic->status === 'active',
            404
        );

        $question = $topic->questions()
            ->where('status', 'published')
            ->orderBy('id')
            ->first();

        abort_unless(
            $question !== null,
            404
        );

        return view('practice.question', [
            'topic' => $topic,
            'question' => $question,
            'feedback' => null,
            'nextQuestion' => $this->getNextQuestion(
                $topic,
                $question
            ),
        ]);
    }

    /**
     * Display a specific practice question.
     */
    public function show(
        Request $request,
        Topic $topic,
        Question $question
    ): View {
        abort_unless(
            $topic->status === 'active',
            404
        );

        abort_unless(
            $question->topic_id === $topic->id,
            404
        );

        abort_unless(
            $question->status === 'published',
            404
        );

        return view('practice.question', [
            'topic' => $topic,
            'question' => $question,
            'feedback' => null,
            'nextQuestion' => $this->getNextQuestion(
                $topic,
                $question
            ),
        ]);
    }

    /**
     * Submit an answer for a practice question.
     */
    public function submit(
        Request $request,
        Topic $topic,
        Question $question
    ): View {
        abort_unless(
            $topic->status === 'active',
            404
        );

        abort_unless(
            $question->topic_id === $topic->id,
            404
        );

        abort_unless(
            $question->status === 'published',
            404
        );

        $validated = $request->validate([
            'answer' => [
                'required',
                'string',
                'max:10000',
            ],
        ]);

        $selectedAnswer = trim(
            $validated['answer']
        );

        $isCorrect = $this->isCorrectAnswer(
            $question,
            $selectedAnswer
        );

        $feedback = [
            'submitted_answer' => $selectedAnswer,
            'is_correct' => $isCorrect,
            'correct_answer' => $question->answer,
            'explanation' => $question->explanation,
        ];

        return view('practice.question', [
            'topic' => $topic,
            'question' => $question,
            'feedback' => $feedback,
            'nextQuestion' => $this->getNextQuestion(
                $topic,
                $question
            ),
        ]);
    }

    /**
     * Determine whether the selected answer is correct.
     *
     * Supports answer values stored as:
     * - option text
     * - A/B/C/D style letters
     * - numeric option indexes
     */
    private function isCorrectAnswer(
        Question $question,
        string $selectedAnswer
    ): bool {
        $correctAnswer = trim(
            (string) $question->answer
        );

        if ($correctAnswer === '') {
            return false;
        }

        if (
            strcasecmp(
                $selectedAnswer,
                $correctAnswer
            ) === 0
        ) {
            return true;
        }

        if (
            $question->question_type !== Question::TYPE_MCQ
            || ! is_array($question->options)
        ) {
            return false;
        }

        $options = array_values(
            $question->options
        );

        foreach ($options as $index => $option) {
            $letter = chr(65 + $index);

            if (
                strcasecmp(
                    $selectedAnswer,
                    $letter
                ) === 0
                && strcasecmp(
                    trim((string) $option),
                    $correctAnswer
                ) === 0
            ) {
                return true;
            }

            if (
                strcasecmp(
                    trim((string) $option),
                    $selectedAnswer
                ) === 0
                && (
                    strcasecmp(
                        $correctAnswer,
                        $letter
                    ) === 0
                    || (string) $index === $correctAnswer
                )
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the next published question in the topic.
     */
    private function getNextQuestion(
        Topic $topic,
        Question $question
    ): ?Question {
        return $topic->questions()
            ->where('status', 'published')
            ->where('id', '>', $question->id)
            ->orderBy('id')
            ->first();
    }
}