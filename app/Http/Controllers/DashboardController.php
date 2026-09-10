<?php

namespace App\Http\Controllers;

use App\Models\TestResult;
use App\Services\WeakTopicDetectionService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the authenticated user's dashboard.
     */
    public function index(
        Request $request,
        WeakTopicDetectionService $weakTopicDetectionService
    ): View {
        $userId = $request->user()->id;

        $resultsQuery = TestResult::query()
            ->where('user_id', $userId);

        $testsAttempted = (clone $resultsQuery)->count();

        $testsPassed = (clone $resultsQuery)
            ->where('status', TestResult::STATUS_PASSED)
            ->count();

        $testsFailed = (clone $resultsQuery)
            ->where('status', TestResult::STATUS_FAILED)
            ->count();

        $averagePercentage = (float) (
            (clone $resultsQuery)->avg('percentage') ?? 0
        );

        $bestPercentage = (float) (
            (clone $resultsQuery)->max('percentage') ?? 0
        );

        $totalCorrect = (int) (
            (clone $resultsQuery)->sum('correct_answers')
        );

        $totalWrong = (int) (
            (clone $resultsQuery)->sum('wrong_answers')
        );

        $totalUnanswered = (int) (
            (clone $resultsQuery)->sum('unanswered')
        );

        $recentResults = (clone $resultsQuery)
            ->with('test')
            ->latest()
            ->limit(5)
            ->get();

        /*
         * T043 - Weak Topic Detection
         *
         * Only submitted test attempts are considered
         * by the WeakTopicDetectionService.
         */
        $weakTopics = $weakTopicDetectionService
            ->weakTopicsForUser($userId);

        return view('dashboard', [
            'testsAttempted' => $testsAttempted,
            'testsPassed' => $testsPassed,
            'testsFailed' => $testsFailed,
            'averagePercentage' => $averagePercentage,
            'bestPercentage' => $bestPercentage,
            'totalCorrect' => $totalCorrect,
            'totalWrong' => $totalWrong,
            'totalUnanswered' => $totalUnanswered,
            'recentResults' => $recentResults,
            'weakTopics' => $weakTopics,
        ]);
    }
}