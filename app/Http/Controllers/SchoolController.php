<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\StudentClassEnrollment;
use App\Models\TestResult;
use App\Models\User;
use Illuminate\Http\Request;

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