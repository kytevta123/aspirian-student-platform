<?php

namespace App\Http\Controllers;

use App\Models\TestAttempt;
use App\Services\TestResultService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestSubmissionController extends Controller
{
    /**
     * Manually submit a test attempt.
     *
     * Manual submission is only allowed while the attempt
     * is still in progress and has not expired.
     */
    public function submit(
        Request $request,
        TestAttempt $attempt,
        TestResultService $resultService
    ): RedirectResponse {
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
        | Duplicate Submission Protection
        |--------------------------------------------------------------------------
        */

        if ($attempt->isSubmitted()) {
            return back()->withErrors([
                'submission' =>
                    'This test attempt has already been submitted.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Attempt Status Validation
        |--------------------------------------------------------------------------
        */

        if (
            $attempt->status !==
            TestAttempt::STATUS_IN_PROGRESS
        ) {
            return back()->withErrors([
                'submission' =>
                    'This test attempt is no longer available for submission.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Server-Side Timer Validation
        |--------------------------------------------------------------------------
        |
        | Manual submission after the deadline is not accepted.
        | The automatic submission endpoint handles deadline submission.
        |
        */

        if ($attempt->isExpired()) {
            $attempt->markAsExpired();

            return back()->withErrors([
                'submission' =>
                    'The test time has expired. Your attempt has been closed.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Submit Attempt
        |--------------------------------------------------------------------------
        */

        $attempt->markAsSubmitted();

        /*
        |--------------------------------------------------------------------------
        | Calculate Result
        |--------------------------------------------------------------------------
        */

        $result = $resultService->calculate(
            $attempt->fresh()
        );

        /*
        |--------------------------------------------------------------------------
        | Redirect To Result Page
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'tests.results.show',
                $result
            )
            ->with(
                'status',
                'Test submitted successfully.'
            );
    }

    /**
     * Automatically submit an attempt after the timer expires.
     *
     * The browser only triggers this request.
     * The server remains the final authority on whether
     * the test has actually expired.
     */
    public function autoSubmit(
        Request $request,
        TestAttempt $attempt,
        TestResultService $resultService
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
        |
        | Auto-submit is intentionally idempotent.
        | If another request already submitted the attempt,
        | return the existing result instead of creating another one.
        |
        */

        if ($attempt->isSubmitted()) {
            $result = $attempt->result;

            if (! $result) {
                $result = $resultService->calculate(
                    $attempt->fresh()
                );
            }

            return response()->json([
                'success' => true,
                'status' => TestAttempt::STATUS_SUBMITTED,
                'message' =>
                    'This test attempt has already been submitted.',
                'result_url' => route(
                    'tests.results.show',
                    $result
                ),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Attempt Status Validation
        |--------------------------------------------------------------------------
        */

        if (
            $attempt->status !==
            TestAttempt::STATUS_IN_PROGRESS
            &&
            $attempt->status !==
            TestAttempt::STATUS_EXPIRED
        ) {
            return response()->json([
                'success' => false,
                'status' => $attempt->status,
                'message' =>
                    'This test attempt is no longer available.',
            ], 409);
        }

        /*
        |--------------------------------------------------------------------------
        | Server-Side Expiry Validation
        |--------------------------------------------------------------------------
        |
        | JavaScript cannot decide whether the timer has really expired.
        | The server checks expires_at.
        |
        */

        if (
            $attempt->status ===
            TestAttempt::STATUS_IN_PROGRESS
            &&
            ! $attempt->isExpired()
        ) {
            return response()->json([
                'success' => false,
                'status' => $attempt->status,
                'message' =>
                    'The test time has not expired yet.',
                'remaining_seconds' =>
                    $attempt->remainingSeconds(),
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Finalize Automatic Submission
        |--------------------------------------------------------------------------
        |
        | Use a transaction and row lock so that two simultaneous
        | auto-submit requests cannot create duplicate results.
        |
        */

        $result = DB::transaction(
            function () use (
                $attempt,
                $resultService
            ) {
                $lockedAttempt = TestAttempt::query()
                    ->whereKey($attempt->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                /*
                | Already submitted while this request was waiting
                | for the row lock.
                */
                if ($lockedAttempt->isSubmitted()) {
                    return $resultService->calculate(
                        $lockedAttempt->fresh()
                    );
                }

                /*
                | If it is still in progress, verify expiry again
                | after obtaining the database lock.
                */
                if (
                    $lockedAttempt->status ===
                    TestAttempt::STATUS_IN_PROGRESS
                    &&
                    ! $lockedAttempt->isExpired()
                ) {
                    return null;
                }

                /*
                | Convert an expired/in-progress-at-deadline attempt
                | into a submitted attempt.
                */
                $lockedAttempt->status =
                    TestAttempt::STATUS_SUBMITTED;

                $lockedAttempt->submitted_at = now();

                $lockedAttempt->save();

                return $resultService->calculate(
                    $lockedAttempt->fresh()
                );
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Race Condition / Timing Protection
        |--------------------------------------------------------------------------
        */

        if (! $result) {
            $attempt->refresh();

            return response()->json([
                'success' => false,
                'status' => $attempt->status,
                'message' =>
                    'The test time has not expired yet.',
                'remaining_seconds' =>
                    $attempt->remainingSeconds(),
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,
            'status' => TestAttempt::STATUS_SUBMITTED,
            'message' =>
                'The test time expired and your test was automatically submitted.',
            'result_url' => route(
                'tests.results.show',
                $result
            ),
        ]);
    }
}