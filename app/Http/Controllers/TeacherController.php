<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Test;
use App\Models\TestAttempt;
use App\Models\TestAssignment;
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
     * List/search questions in the Question Bank.
     */
    public function questions(Request $request)
    {
        $this->authorizeTeacher($request);

        $questions = Question::query()
            ->when($request->topic_id, fn($q) => $q->where('topic_id', $request->topic_id))
            ->when($request->difficulty, fn($q) => $q->where('difficulty', $request->difficulty))
            ->when($request->question_type, fn($q) => $q->where('question_type', $request->question_type))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, fn($q) => $q->where('question_text', 'like', '%' . $request->search . '%'))
            ->latest()
            ->paginate(20);

        return response()->json($questions);
    }

    /**
     * Create a new question (starts as draft).
     */
    public function storeQuestion(Request $request)
    {
        $this->authorizeTeacher($request);

        $validated = $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'question_type' => 'required|string',
            'question_text' => 'required|string',
            'options' => 'nullable|array',
            'answer' => 'nullable|string',
            'explanation' => 'nullable|string',
            'marks' => 'required|integer|min:1',
            'difficulty' => 'required|string',
        ]);

        $validated['status'] = 'draft';
        $question = Question::create($validated);

        return response()->json($question, 201);
    }

    /**
     * Update an existing question.
     */
    public function updateQuestion(Request $request, Question $question)
    {
        $this->authorizeTeacher($request);

        $validated = $request->validate([
            'topic_id' => 'sometimes|exists:topics,id',
            'question_type' => 'sometimes|string',
            'question_text' => 'sometimes|string',
            'options' => 'nullable|array',
            'answer' => 'nullable|string',
            'explanation' => 'nullable|string',
            'marks' => 'sometimes|integer|min:1',
            'difficulty' => 'sometimes|string',
        ]);

        $question->update($validated);

        return response()->json($question);
    }

    /**
     * Publish a question (draft -> published).
     */
    public function publishQuestion(Request $request, Question $question)
    {
        $this->authorizeTeacher($request);

        $question->update(['status' => 'published']);

        return response()->json($question);
    }

    /**
     * Archive/delete a question (soft delete).
     */
    public function deleteQuestion(Request $request, Question $question)
    {
        $this->authorizeTeacher($request);

        $question->delete();

        return response()->json(['message' => 'Question deleted.']);
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

        /**
     * Create a new test (draft, using existing questions).
     */
    public function storeTest(Request $request)
    {
        $this->authorizeTeacher($request);

        $validated = $request->validate([
            'title' => 'required|string',
            'instructions' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'question_ids' => 'required|array|min:1',
            'question_ids.*' => 'exists:questions,id',
        ]);

        $test = Test::create([
            'title' => $validated['title'],
            'instructions' => $validated['instructions'] ?? null,
            'duration' => $validated['duration'],
            'marks' => Question::whereIn('id', $validated['question_ids'])->sum('marks'),
            'status' => 'draft',
        ]);

        foreach ($validated['question_ids'] as $i => $qId) {
            $question = Question::find($qId);
            $test->questions()->attach($qId, [
                'sort_order' => $i + 1,
                'marks' => $question->marks,
            ]);
        }

        return response()->json($test->load('questions'), 201);
    }

    /**
     * Publish a test (draft -> published).
     */
    public function publishTest(Request $request, Test $test)
    {
        $this->authorizeTeacher($request);

        $test->update(['status' => 'published', 'published_at' => now()]);

        return response()->json($test);
    }

    /**
     * Assign a test to one or more students, with an optional availability window.
     */
    public function assignTest(Request $request, Test $test)
    {
        $this->authorizeTeacher($request);

        $validated = $request->validate([
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:users,id',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after:start_at',
        ]);

        $assignments = [];
        foreach ($validated['student_ids'] as $studentId) {
            $assignments[] = TestAssignment::updateOrCreate(
                ['test_id' => $test->id, 'student_id' => $studentId],
                [
                    'assigned_by' => $request->user()->id,
                    'start_at' => $validated['start_at'] ?? null,
                    'end_at' => $validated['end_at'] ?? null,
                ]
            );
        }

        return response()->json($assignments, 201);
    }

    /**
     * View attempts for a specific test.
     */
    public function testAttempts(Request $request, Test $test)
    {
        $this->authorizeTeacher($request);

        $attempts = TestAttempt::with('user')
            ->where('test_id', $test->id)
            ->latest()
            ->paginate(20);

        return response()->json($attempts);
    }

    /**
     * View results for a specific test.
     */
    public function testResults(Request $request, Test $test)
    {
        $this->authorizeTeacher($request);

        $results = \App\Models\TestResult::with('user')
            ->where('test_id', $test->id)
            ->latest()
            ->paginate(20);

        return response()->json($results);
    }
}