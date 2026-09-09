<?php

namespace App\Http\Controllers;

use App\Models\TestAttempt;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TestSubmissionController extends Controller
{
    public function submit(
        Request $request,
        TestAttempt $attempt
    ): RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        |
        | A user can only submit their own test attempt.
        |
        */

        if ($attempt->user_id !== $request->user()->id) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | Duplicate Submission Protection
        |--------------------------------------------------------------------------
        |
        | Once an attempt has been submitted, it cannot be submitted again.
        |
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
        |
        | Only an in-progress attempt can be submitted.
        |
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
        | The browser timer cannot be trusted.
        | The server checks expires_at before accepting submission.
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
        |
        | markAsSubmitted() sets the submitted status and records
        | the server-side submitted_at timestamp.
        |
        */

        $attempt->markAsSubmitted();

        return redirect()
            ->route(
                'tests.attempts.show',
                $attempt
            )
            ->with(
                'status',
                'Test submitted successfully.'
            );
    }
}