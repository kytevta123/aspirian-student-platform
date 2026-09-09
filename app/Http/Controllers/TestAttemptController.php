<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestAttempt;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class TestAttemptController extends Controller
{
    /**
     * Start a new test attempt.
     */
    public function start(
        Request $request,
        Test $test
    ): View {
        /*
        |--------------------------------------------------------------------------
        | Test Availability
        |--------------------------------------------------------------------------
        |
        | Only published tests can be attempted by students.
        |
        */

        if ($test->status !== Test::STATUS_PUBLISHED) {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | Load Questions
        |--------------------------------------------------------------------------
        |
        | Only safe question fields are loaded.
        | Correct answers and explanations must never be exposed.
        |
        */

        $test->load([
            'questions' => function ($query) {
                $query->select([
                    'questions.id',
                    'questions.topic_id',
                    'questions.question_type',
                    'questions.question_text',
                    'questions.options',
                ]);
            },
        ]);

        /*
        |--------------------------------------------------------------------------
        | Empty Test Protection
        |--------------------------------------------------------------------------
        */

        if ($test->questions->isEmpty()) {
            abort(422, 'This test does not contain any questions.');
        }

        /*
        |--------------------------------------------------------------------------
        | Create Attempt
        |--------------------------------------------------------------------------
        */

        $startedAt = now();

        $attempt = TestAttempt::create([
            'test_id' => $test->id,
            'user_id' => $request->user()->id,
            'started_at' => $startedAt,
            'expires_at' => $startedAt->copy()->addMinutes(
                $test->duration_minutes
            ),
            'status' => TestAttempt::STATUS_IN_PROGRESS,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Display Attempt
        |--------------------------------------------------------------------------
        */

        return view(
            'tests.attempts.show',
            compact('attempt', 'test')
        );
    }

    /**
     * Show an existing test attempt.
     *
     * This is different from start().
     * It does NOT create a new attempt.
     */
    public function show(
        Request $request,
        TestAttempt $attempt
    ): View {
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        |
        | A user can only view their own test attempt.
        |
        */

        if ($attempt->user_id !== $request->user()->id) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | Load Test and Questions
        |--------------------------------------------------------------------------
        |
        | Correct answers and explanations are deliberately excluded.
        |
        */

        $attempt->load([
            'test',
            'answers',
            'test.questions' => function ($query) {
                $query->select([
                    'questions.id',
                    'questions.topic_id',
                    'questions.question_type',
                    'questions.question_text',
                    'questions.options',
                ]);
            },
        ]);

        /*
        |--------------------------------------------------------------------------
        | Display Existing Attempt
        |--------------------------------------------------------------------------
        */

        return view(
            'tests.attempts.show',
            compact('attempt')
        );
    }

    /**
     * Expire an attempt when its timer reaches zero.
     */
    public function expire(
        Request $request,
        TestAttempt $attempt
    ): JsonResponse {
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        if ($attempt->user_id !== $request->user()->id) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | Already Submitted
        |--------------------------------------------------------------------------
        */

        if ($attempt->isSubmitted()) {
            return response()->json([
                'message' =>
                    'This test attempt has already been submitted.',
            ], 409);
        }

        /*
        |--------------------------------------------------------------------------
        | Already Expired
        |--------------------------------------------------------------------------
        */

        if ($attempt->status === TestAttempt::STATUS_EXPIRED) {
            return response()->json([
                'message' =>
                    'This test attempt has already expired.',
                'status' => TestAttempt::STATUS_EXPIRED,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Server-Side Expiry Check
        |--------------------------------------------------------------------------
        */

        if (! $attempt->isExpired()) {
            return response()->json([
                'message' =>
                    'The test time has not expired yet.',
                'status' => $attempt->status,
                'remaining_seconds' =>
                    $attempt->remainingSeconds(),
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Mark Attempt Expired
        |--------------------------------------------------------------------------
        */

        $attempt->markAsExpired();

        return response()->json([
            'message' =>
                'The test time has expired. Your attempt has been closed.',
            'status' => TestAttempt::STATUS_EXPIRED,
        ]);
    }
}