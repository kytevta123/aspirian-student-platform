<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\GradeSubject;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\StudentClassEnrollment;
use App\Models\Subject;
use App\Models\Test;
use App\Models\TestAttempt;
use App\Models\TestResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolController extends Controller
{
    /**
     * Ensure the authenticated user has the SCHOOL_ADMIN role.
     */
    private function authorizeSchoolAdmin(Request $request)
    {
        abort_unless(
            $request->user()->hasRole('SCHOOL_ADMIN'),
            403,
            'You do not have school admin access.'
        );
    }

    /**
     * School overview.
     */
    public function overview(Request $request, School $school)
    {
        $this->authorizeSchoolAdmin($request);

        $classIds = SchoolClass::where('school_id', $school->id)->pluck('id');

        $studentCount = StudentClassEnrollment::whereIn('school_class_id', $classIds)
            ->distinct('student_id')
            ->count('student_id');

        return response()->json([
            'school' => $school,
            'total_classes' => $classIds->count(),
            'total_students' => $studentCount,
        ]);
    }

    /**
     * List students enrolled in this school's classes.
     */
    public function students(Request $request, School $school)
    {
        $this->authorizeSchoolAdmin($request);

        $classIds = SchoolClass::where('school_id', $school->id)->pluck('id');

        $studentIds = StudentClassEnrollment::whereIn('school_class_id', $classIds)
            ->pluck('student_id');

        $students = Student::whereIn('id', $studentIds)
            ->with('user')
            ->paginate(20);

        return response()->json($students);
    }

    /**
     * List teachers (MVP: all teachers; school-specific assignment is a future refinement).
     */
    public function teachers(Request $request, School $school)
    {
        $this->authorizeSchoolAdmin($request);

        $teachers = User::whereHas(
            'roles',
            fn($q) => $q->where('name', 'TEACHER')
        )->paginate(20);

        return response()->json($teachers);
    }

    /**
     * List classes for this school.
     */
    public function classes(Request $request, School $school)
    {
        $this->authorizeSchoolAdmin($request);

        $classes = SchoolClass::where('school_id', $school->id)
            ->with(['grade', 'academicSession'])
            ->paginate(20);

        return response()->json($classes);
    }

    /**
     * Create a new class for this school.
     */
    public function storeClass(Request $request, School $school)
    {
        $this->authorizeSchoolAdmin($request);

        $validated = $request->validate([
            'grade_id' => [
                'required',
                'integer',
                'exists:grades,id',
            ],
            'academic_session_id' => [
                'required',
                'integer',
                'exists:academic_sessions,id',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'status' => [
                'nullable',
                'string',
                'in:active,inactive',
            ],
        ]);

        $schoolClass = SchoolClass::create([
            'school_id' => $school->id,
            'grade_id' => $validated['grade_id'],
            'academic_session_id' => $validated['academic_session_id'],
            'name' => $validated['name'],
            'status' => $validated['status'] ?? 'active',
        ]);

        return response()->json(
            $schoolClass->load(['grade', 'academicSession']),
            201
        );
    }

    /**
     * School-level performance summary.
     */
    public function performance(Request $request, School $school)
    {
        $this->authorizeSchoolAdmin($request);

        $classIds = SchoolClass::where('school_id', $school->id)->pluck('id');

        $studentIds = StudentClassEnrollment::whereIn('school_class_id', $classIds)
            ->pluck('student_id');

        // student_id on students table vs user_id on test results:
        // map via Student->user_id.
        $userIds = Student::whereIn('id', $studentIds)->pluck('user_id');

        $averagePercentage = TestResult::whereIn('user_id', $userIds)->avg('percentage');
        $totalResults = TestResult::whereIn('user_id', $userIds)->count();

        return response()->json([
            'total_students' => $studentIds->count(),
            'total_results' => $totalResults,
            'average_percentage' => $averagePercentage
                ? round($averagePercentage, 1)
                : null,
        ]);
    }

    public function studentReports(Request $request, School $school)
    {
        $this->authorizeSchoolAdmin($request);

        $students = Student::query()
            ->whereHas('classEnrollments.schoolClass', function ($query) use ($school) {
                $query->where('school_id', $school->id);
            })
            ->with([
                'user',
                'classEnrollments' => function ($query) use ($school) {
                    $query->whereHas('schoolClass', function ($classQuery) use ($school) {
                        $classQuery->where('school_id', $school->id);
                    })->with('schoolClass');
                },
            ])
            ->get();

        $userIds = $students->pluck('user_id')->filter()->unique();
        $resultStats = TestResult::query()
            ->whereIn('user_id', $userIds)
            ->selectRaw('user_id, COUNT(*) as total_tests, AVG(percentage) as average_percentage')
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');

        $data = $students->map(function (Student $student) use ($resultStats) {
            $stats = $resultStats->get($student->user_id);

            return [
                'id' => $student->id,
                'student_id' => $student->id,
                'name' => $student->user?->name,
                'email' => $student->user?->email,
                'status' => $student->status,
                'class_name' => $student->classEnrollments
                    ->pluck('schoolClass.name')
                    ->filter()
                    ->unique()
                    ->implode(', '),
                'total_tests' => (int) ($stats->total_tests ?? 0),
                'average_percentage' => $stats
                    ? round((float) $stats->average_percentage, 1)
                    : null,
            ];
        })->values();

        return response()->json([
            'data' => $data,
            'total' => $data->count(),
        ]);
    }

    public function classReports(Request $request, School $school)
    {
        $this->authorizeSchoolAdmin($request);

        $classes = SchoolClass::query()
            ->where('school_id', $school->id)
            ->with('grade')
            ->orderBy('name')
            ->get();
        $classIds = $classes->pluck('id');

        $enrollmentStats = StudentClassEnrollment::query()
            ->whereIn('school_class_id', $classIds)
            ->where('status', 'active')
            ->selectRaw('school_class_id, COUNT(DISTINCT student_id) as total_students')
            ->groupBy('school_class_id')
            ->get()
            ->keyBy('school_class_id');

        $resultStats = DB::table('test_results')
            ->join('students', 'students.user_id', '=', 'test_results.user_id')
            ->join('student_class_enrollments as enrollments', 'enrollments.student_id', '=', 'students.id')
            ->whereIn('enrollments.school_class_id', $classIds)
            ->whereNull('enrollments.deleted_at')
            ->selectRaw('enrollments.school_class_id, COUNT(DISTINCT test_results.id) as total_tests_taken, AVG(test_results.percentage) as average_percentage')
            ->groupBy('enrollments.school_class_id')
            ->get()
            ->keyBy('school_class_id');

        $data = $classes->map(function (SchoolClass $schoolClass) use ($enrollmentStats, $resultStats) {
            $enrollment = $enrollmentStats->get($schoolClass->id);
            $results = $resultStats->get($schoolClass->id);

            return [
                'id' => $schoolClass->id,
                'name' => $schoolClass->name,
                'grade' => $schoolClass->grade?->name,
                'total_students' => (int) ($enrollment->total_students ?? 0),
                'total_tests_taken' => (int) ($results->total_tests_taken ?? 0),
                'average_percentage' => $results?->average_percentage !== null
                    ? round((float) $results->average_percentage, 1)
                    : null,
            ];
        })->values();

        return response()->json([
            'data' => $data,
            'total' => $data->count(),
        ]);
    }

    public function subjectReports(Request $request, School $school)
    {
        $this->authorizeSchoolAdmin($request);

        $gradeIds = SchoolClass::query()
            ->where('school_id', $school->id)
            ->pluck('grade_id')
            ->unique();

        $subjects = Subject::query()
            ->whereHas('gradeSubjects', function ($query) use ($gradeIds) {
                $query->whereIn('grade_id', $gradeIds)
                    ->where('status', 'active');
            })
            ->orderBy('name')
            ->get();

        $studentUserIds = Student::query()
            ->whereHas('classEnrollments.schoolClass', function ($query) use ($school) {
                $query->where('school_id', $school->id);
            })
            ->pluck('user_id');

        $data = $subjects->map(function (Subject $subject) use ($studentUserIds) {
            $testIds = DB::table('test_questions as test_questions')
                ->join('questions', 'questions.id', '=', 'test_questions.question_id')
                ->join('topics', 'topics.id', '=', 'questions.topic_id')
                ->join('chapters', 'chapters.id', '=', 'topics.chapter_id')
                ->join('books', 'books.id', '=', 'chapters.book_id')
                ->where('books.subject_id', $subject->id)
                ->whereNull('questions.deleted_at')
                ->whereNull('topics.deleted_at')
                ->whereNull('chapters.deleted_at')
                ->whereNull('books.deleted_at')
                ->distinct()
                ->pluck('test_questions.test_id');

            $results = TestResult::query()
                ->whereIn('test_id', $testIds)
                ->whereIn('user_id', $studentUserIds);

            $totalResults = (clone $results)->count();
            $average = (clone $results)->avg('percentage');

            return [
                'id' => $subject->id,
                'name' => $subject->name,
                'total_tests' => $testIds->count(),
                'total_results' => $totalResults,
                'average_percentage' => $average !== null
                    ? round((float) $average, 1)
                    : null,
            ];
        })->values();

        return response()->json([
            'data' => $data,
            'total' => $data->count(),
        ]);
    }

    public function testReports(Request $request, School $school)
    {
        $this->authorizeSchoolAdmin($request);

        $studentUserIds = Student::query()
            ->whereHas('classEnrollments.schoolClass', function ($query) use ($school) {
                $query->where('school_id', $school->id);
            })
            ->pluck('user_id');

        $assignedTestIds = DB::table('test_assignments as assignments')
            ->join('students', 'students.user_id', '=', 'assignments.student_id')
            ->join('student_class_enrollments as enrollments', 'enrollments.student_id', '=', 'students.id')
            ->join('school_classes', 'school_classes.id', '=', 'enrollments.school_class_id')
            ->where('school_classes.school_id', $school->id)
            ->whereNull('enrollments.deleted_at')
            ->pluck('assignments.test_id');

        $resultTestIds = TestResult::query()
            ->whereIn('user_id', $studentUserIds)
            ->pluck('test_id');
        $testIds = $assignedTestIds->merge($resultTestIds)->unique()->values();

        $attemptStats = TestAttempt::query()
            ->whereIn('test_id', $testIds)
            ->whereIn('user_id', $studentUserIds)
            ->selectRaw('test_id, COUNT(*) as total_attempts')
            ->groupBy('test_id')
            ->get()
            ->keyBy('test_id');

        $resultStats = TestResult::query()
            ->whereIn('test_id', $testIds)
            ->whereIn('user_id', $studentUserIds)
            ->selectRaw('test_id, COUNT(*) as total_results, AVG(percentage) as average_percentage, SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as passed_results', [TestResult::STATUS_PASSED])
            ->groupBy('test_id')
            ->get()
            ->keyBy('test_id');

        $subjectNames = DB::table('test_questions as test_questions')
            ->join('questions', 'questions.id', '=', 'test_questions.question_id')
            ->join('topics', 'topics.id', '=', 'questions.topic_id')
            ->join('chapters', 'chapters.id', '=', 'topics.chapter_id')
            ->join('books', 'books.id', '=', 'chapters.book_id')
            ->join('subjects', 'subjects.id', '=', 'books.subject_id')
            ->whereIn('test_questions.test_id', $testIds)
            ->whereNull('questions.deleted_at')
            ->whereNull('topics.deleted_at')
            ->whereNull('chapters.deleted_at')
            ->whereNull('books.deleted_at')
            ->select('test_questions.test_id', 'subjects.name')
            ->distinct()
            ->get()
            ->groupBy('test_id')
            ->map(fn ($rows) => $rows->pluck('name')->implode(', '));

        $classNames = DB::table('test_assignments as assignments')
            ->join('students', 'students.user_id', '=', 'assignments.student_id')
            ->join('student_class_enrollments as enrollments', 'enrollments.student_id', '=', 'students.id')
            ->join('school_classes', 'school_classes.id', '=', 'enrollments.school_class_id')
            ->where('school_classes.school_id', $school->id)
            ->whereIn('assignments.test_id', $testIds)
            ->whereNull('enrollments.deleted_at')
            ->select('assignments.test_id', 'school_classes.name')
            ->distinct()
            ->get()
            ->groupBy('test_id')
            ->map(fn ($rows) => $rows->pluck('name')->implode(', '));

        $data = Test::query()
            ->whereIn('id', $testIds)
            ->orderBy('title')
            ->get()
            ->map(function (Test $test) use ($attemptStats, $resultStats, $subjectNames, $classNames) {
                $results = $resultStats->get($test->id);
                $totalResults = (int) ($results->total_results ?? 0);

                return [
                    'id' => $test->id,
                    'title' => $test->title,
                    'class_name' => $classNames->get($test->id, '—'),
                    'subject' => $subjectNames->get($test->id, '—'),
                    'attempts' => (int) ($attemptStats->get($test->id)->total_attempts ?? 0),
                    'average_percentage' => $results?->average_percentage !== null
                        ? round((float) $results->average_percentage, 1)
                        : null,
                    'pass_rate' => $totalResults > 0
                        ? round(((int) $results->passed_results / $totalResults) * 100, 1)
                        : null,
                    'status' => $test->status,
                ];
            })
            ->values();

        return response()->json([
            'data' => $data,
            'total' => $data->count(),
        ]);
    }

    /**
     * Create a new student user and enroll them in a class.
     */
    public function storeStudent(Request $request, School $school)
    {
        $this->authorizeSchoolAdmin($request);

        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'school_class_id' => [
                'nullable',
                'integer',
                function ($attribute, $value, $fail) use ($school) {
                    if (
                        !SchoolClass::where('id', $value)
                            ->where('school_id', $school->id)
                            ->exists()
                    ) {
                        $fail('The selected class does not belong to this school.');
                    }
                },
            ],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $studentRole = Role::where('name', 'STUDENT')->firstOrFail();

        $user->roles()->attach($studentRole->id);

        $student = Student::create([
            'user_id' => $user->id,
            'status' => 'active',
        ]);

        if (!empty($validated['school_class_id'])) {
            $schoolClass = SchoolClass::findOrFail($validated['school_class_id']);

            StudentClassEnrollment::create([
                'student_id' => $student->id,
                'school_class_id' => $schoolClass->id,
                'academic_session_id' => $schoolClass->academic_session_id,
                'status' => 'active',
                'enrolled_at' => now(),
            ]);
        }

        return response()->json($student->load('user'), 201);
    }

    /**
     * Update a student's status (e.g. active/inactive).
     */
    public function updateStudentStatus(Request $request, Student $student)
    {
        $this->authorizeSchoolAdmin($request);

        $validated = $request->validate([
            'status' => 'required|string',
        ]);

        $student->update([
            'status' => $validated['status'],
        ]);

        return response()->json($student);
    }

    /**
     * Create a new teacher user.
     */
    public function storeTeacher(Request $request, School $school)
    {
        $this->authorizeSchoolAdmin($request);

        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $teacherRole = Role::where('name', 'TEACHER')->firstOrFail();

        $user->roles()->attach($teacherRole->id);

        return response()->json($user, 201);
    }

    /**
     * Update a user's account status (student or teacher).
     */
    public function updateUserStatus(Request $request, User $user)
    {
        $this->authorizeSchoolAdmin($request);

        $validated = $request->validate([
            'status' => 'required|string',
        ]);

        $user->update([
            'status' => $validated['status'],
        ]);

        return response()->json($user);
    }

    /**
     * Assign a role to a user.
     */
    public function assignRole(Request $request, User $user)
    {
        $this->authorizeSchoolAdmin($request);

        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        if (!$user->roles()->where('role_id', $validated['role_id'])->exists()) {
            $user->roles()->attach($validated['role_id']);
        }

        return response()->json($user->load('roles'));
    }

    /**
     * Remove a role from a user.
     */
    public function removeRole(Request $request, User $user, $roleId)
    {
        $this->authorizeSchoolAdmin($request);

        $user->roles()->detach($roleId);

        return response()->json($user->load('roles'));
    }
}