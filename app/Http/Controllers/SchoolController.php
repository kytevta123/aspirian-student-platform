<?php

namespace App\Http\Controllers;

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
        abort_unless($request->user()->hasRole('SCHOOL_ADMIN'), 403, 'You do not have school admin access.');
    }

    /**
     * School overview.
     */
    public function overview(Request $request, School $school)
    {
        $this->authorizeSchoolAdmin($request);

        $classIds = SchoolClass::where('school_id', $school->id)->pluck('id');
        $studentCount = StudentClassEnrollment::whereIn('school_class_id', $classIds)->distinct('student_id')->count('student_id');

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

        $teachers = User::whereHas('roles', fn($q) => $q->where('name', 'TEACHER'))
            ->paginate(20);

        return response()->json($teachers);
    }

    /**
     * List classes for this school.
     */
    public function classes(Request $request, School $school)
    {
        $this->authorizeSchoolAdmin($request);

        $classes = SchoolClass::where('school_id', $school->id)
            ->with('grade')
            ->paginate(20);

        return response()->json($classes);
    }

    /**
     * School-level performance summary.
     */
    public function performance(Request $request, School $school)
    {
        $this->authorizeSchoolAdmin($request);

        $classIds = SchoolClass::where('school_id', $school->id)->pluck('id');
        $studentIds = StudentClassEnrollment::whereIn('school_class_id', $classIds)->pluck('student_id');

        // student_id on students table vs user_id on test results: map via Student->user_id
        $userIds = Student::whereIn('id', $studentIds)->pluck('user_id');

        $averagePercentage = TestResult::whereIn('user_id', $userIds)->avg('percentage');
        $totalResults = TestResult::whereIn('user_id', $userIds)->count();

        return response()->json([
            'total_students' => $studentIds->count(),
            'total_results' => $totalResults,
            'average_percentage' => $averagePercentage ? round($averagePercentage, 1) : null,
        ]);
    }
}