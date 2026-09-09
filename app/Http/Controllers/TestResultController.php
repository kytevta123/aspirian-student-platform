<?php

namespace App\Http\Controllers;

use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestResultController extends Controller
{
    /**
     * Display a student's own test result.
     */
    public function show(
        Request $request,
        TestResult $result
    ): View {
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        |
        | A student can only view their own result.
        |
        */

        if ($result->user_id !== $request->user()->id) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | Load Result Data
        |--------------------------------------------------------------------------
        |
        | Load the related test and attempt so the result page
        | has all required information.
        |
        */

        $result->load([
            'test',
            'testAttempt',
        ]);

        return view(
            'tests.results.show',
            [
                'result' => $result,
            ]
        );
    }
}