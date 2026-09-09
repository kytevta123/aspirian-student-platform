<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\TestAttempt;
use App\Models\TestAttemptAnswer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TestAttemptAnswerController extends Controller
{
    public function store(
        Request $request,
        TestAttempt $attempt,
        Question $question
    ): RedirectResponse {
        if ($attempt->user_id !== $request->user()->id) {
            abort(403);
        }

        if (
            $attempt->status !==
            TestAttempt::STATUS_IN_PROGRESS
        ) {
            return back()->withErrors([
                'answer' =>
                    'This test attempt is no longer accepting answers.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Server-Side Timer Validation
        |--------------------------------------------------------------------------
        |
        | Client-side JavaScript timer cannot be trusted.
        | The server always checks the database expires_at value.
        |
        */

        if ($attempt->isExpired()) {
            $attempt->markAsExpired();

            return back()->withErrors([
                'answer' =>
                    'The test time has expired. Your attempt has been closed.',
            ]);
        }

        $questionBelongsToTest = $attempt->test()
            ->whereHas('questions', function ($query) use ($question) {
                $query->where(
                    'questions.id',
                    $question->id
                );
            })
            ->exists();

        if (! $questionBelongsToTest) {
            abort(404);
        }

        $validated = $request->validate([
            'answer' => [
                'nullable',
                'string',
                'max:10000',
            ],
        ]);

        TestAttemptAnswer::updateOrCreate(
            [
                'test_attempt_id' => $attempt->id,
                'question_id' => $question->id,
            ],
            [
                'answer' => $validated['answer'] ?? null,
                'answered_at' => now(),
            ]
        );

        return back()->with(
            'status',
            'Answer saved successfully.'
        );
    }
}