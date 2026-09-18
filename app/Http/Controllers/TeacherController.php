<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Test;
use App\Models\TestAttempt;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Ensure the authenticated user has the TEACHER role.
     */
    private function authorizeTeacher(Request $request)
    {
        abort_unless($request->user()->hasRole('TEACHER'), 403, 'You do not have teacher access.');
    }

    /**
     * Get the authenticated teacher's profile.
     */
    public function profile(Request $request)
    {
        $this->authorizeTeacher($request);

        return response()->json($request->user());
    }

    /**
     * List students (MVP: all students; class/section scoping is a future refinement).
     */
    public function students(Request $request)
    {
        $this->authorizeTeacher($request);

        $students = User::whereHas('roles', fn($q) => $q->where('name', 'STUDENT'))
            ->paginate(20);

        return response()->json($students);
    }

    /**
     * List questions in the Question Bank.
     */
    public function questions(Request $request)
    {
        $this->authorizeTeacher($request);

        $questions = Question::when($request->topic_id, fn($q) => $q->where('topic_id', $request->topic_id))
            ->latest()
            ->paginate(20);

        return response()->json($questions);
    }

    /**
     * List tests.
     */
    public function tests(Request $request)
    {
        $this->authorizeTeacher($request);

        $tests = Test::latest()->paginate(20);

        return response()->json($tests);
    }

    /**
     * List test results (attempts) across students.
     */
    public function results(Request $request)
    {
        $this->authorizeTeacher($request);

        $results = TestAttempt::with(['user', 'test'])
            ->when($request->test_id, fn($q) => $q->where('test_id', $request->test_id))
            ->latest()
            ->paginate(20);

        return response()->json($results);
    }

    /**
     * Simple aggregate reports.
     */
    public function reports(Request $request)
    {
        $this->authorizeTeacher($request);

        $totalStudents = User::whereHas('roles', fn($q) => $q->where('name', 'STUDENT'))->count();
        $totalTests = Test::count();
        $totalAttempts = TestAttempt::count();
        $completedAttempts = TestAttempt::whereNotNull('submitted_at')->count();
        $averageScore = \App\Models\TestResult::avg('percentage');

        return response()->json([
            'total_students' => $totalStudents,
            'total_tests' => $totalTests,
            'total_attempts' => $totalAttempts,
            'completed_attempts' => $completedAttempts,
            'completion_rate' => $totalAttempts > 0 ? round(($completedAttempts / $totalAttempts) * 100, 1) : 0,
            'average_score' => $averageScore ? round($averageScore, 1) : null,
        ]);
    }
}