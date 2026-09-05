<?php

namespace Tests\Feature;

use App\Models\AcademicSession;
use App\Models\Board;
use App\Models\EducationSystem;
use App\Models\Grade;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\StudentClassEnrollment;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentClassEnrollmentTest extends TestCase
{
    use RefreshDatabase;

    private function createEnrollmentData(): array
    {
        $educationSystem = EducationSystem::create([
            'name' => 'Pakistan Education System',
            'country' => 'Pakistan',
            'status' => 'active',
        ]);

        $board = Board::create([
            'education_system_id' => $educationSystem->id,
            'name' => 'Punjab Board',
            'code' => 'PB',
            'status' => 'active',
        ]);

        $session = AcademicSession::create([
            'name' => '2026-27',
            'start_date' => '2026-04-01',
            'end_date' => '2027-03-31',
            'status' => 'active',
        ]);

        $grade = Grade::create([
            'name' => 'Class 9',
            'code' => 'G9',
            'level' => 9,
            'sort_order' => 9,
            'status' => 'active',
        ]);

        $school = School::create([
            'name' => 'Test School',
            'code' => 'TEST-SCHOOL',
            'status' => 'active',
        ]);

        $schoolClass = SchoolClass::create([
            'school_id' => $school->id,
            'grade_id' => $grade->id,
            'academic_session_id' => $session->id,
            'name' => 'Class 9-A',
            'status' => 'active',
        ]);

        $user = User::factory()->create();

        $student = Student::create([
            'user_id' => $user->id,
            'date_of_birth' => '2012-01-01',
            'gender' => 'male',
            'current_grade_id' => $grade->id,
            'current_board_id' => $board->id,
            'current_academic_session_id' => $session->id,
            'status' => 'active',
        ]);

        return [
            'educationSystem' => $educationSystem,
            'board' => $board,
            'session' => $session,
            'grade' => $grade,
            'school' => $school,
            'schoolClass' => $schoolClass,
            'student' => $student,
        ];
    }

    public function test_student_can_be_enrolled_in_school_class(): void
    {
        $data = $this->createEnrollmentData();

        $enrollment = StudentClassEnrollment::create([
            'student_id' => $data['student']->id,
            'school_class_id' => $data['schoolClass']->id,
            'academic_session_id' => $data['session']->id,
            'status' => 'active',
            'enrolled_at' => '2026-04-01',
        ]);

        $this->assertDatabaseHas('student_class_enrollments', [
            'id' => $enrollment->id,
            'student_id' => $data['student']->id,
            'school_class_id' => $data['schoolClass']->id,
            'academic_session_id' => $data['session']->id,
            'status' => 'active',
        ]);
    }

    public function test_enrollment_belongs_to_student(): void
    {
        $data = $this->createEnrollmentData();

        $enrollment = StudentClassEnrollment::create([
            'student_id' => $data['student']->id,
            'school_class_id' => $data['schoolClass']->id,
            'academic_session_id' => $data['session']->id,
        ]);

        $this->assertTrue(
            $enrollment->student->is($data['student'])
        );
    }

    public function test_enrollment_belongs_to_school_class(): void
    {
        $data = $this->createEnrollmentData();

        $enrollment = StudentClassEnrollment::create([
            'student_id' => $data['student']->id,
            'school_class_id' => $data['schoolClass']->id,
            'academic_session_id' => $data['session']->id,
        ]);

        $this->assertTrue(
            $enrollment->schoolClass->is($data['schoolClass'])
        );
    }

    public function test_enrollment_belongs_to_academic_session(): void
    {
        $data = $this->createEnrollmentData();

        $enrollment = StudentClassEnrollment::create([
            'student_id' => $data['student']->id,
            'school_class_id' => $data['schoolClass']->id,
            'academic_session_id' => $data['session']->id,
        ]);

        $this->assertTrue(
            $enrollment->academicSession->is($data['session'])
        );
    }

    public function test_student_has_class_enrollments_relationship(): void
    {
        $data = $this->createEnrollmentData();

        $enrollment = StudentClassEnrollment::create([
            'student_id' => $data['student']->id,
            'school_class_id' => $data['schoolClass']->id,
            'academic_session_id' => $data['session']->id,
        ]);

        $this->assertTrue(
            $data['student']
                ->classEnrollments
                ->contains($enrollment)
        );
    }

    public function test_school_class_has_enrollments_relationship(): void
    {
        $data = $this->createEnrollmentData();

        $enrollment = StudentClassEnrollment::create([
            'student_id' => $data['student']->id,
            'school_class_id' => $data['schoolClass']->id,
            'academic_session_id' => $data['session']->id,
        ]);

        $this->assertTrue(
            $data['schoolClass']
                ->enrollments
                ->contains($enrollment)
        );
    }

    public function test_academic_session_has_student_class_enrollments_relationship(): void
    {
        $data = $this->createEnrollmentData();

        $enrollment = StudentClassEnrollment::create([
            'student_id' => $data['student']->id,
            'school_class_id' => $data['schoolClass']->id,
            'academic_session_id' => $data['session']->id,
        ]);

        $this->assertTrue(
            $data['session']
                ->studentClassEnrollments
                ->contains($enrollment)
        );
    }

    public function test_student_cannot_have_two_enrollments_in_same_session(): void
    {
        $data = $this->createEnrollmentData();

        StudentClassEnrollment::create([
            'student_id' => $data['student']->id,
            'school_class_id' => $data['schoolClass']->id,
            'academic_session_id' => $data['session']->id,
        ]);

        $this->expectException(QueryException::class);

        StudentClassEnrollment::create([
            'student_id' => $data['student']->id,
            'school_class_id' => $data['schoolClass']->id,
            'academic_session_id' => $data['session']->id,
        ]);
    }

    public function test_enrollment_can_be_soft_deleted(): void
    {
        $data = $this->createEnrollmentData();

        $enrollment = StudentClassEnrollment::create([
            'student_id' => $data['student']->id,
            'school_class_id' => $data['schoolClass']->id,
            'academic_session_id' => $data['session']->id,
        ]);

        $enrollment->delete();

        $this->assertSoftDeleted(
            'student_class_enrollments',
            [
                'id' => $enrollment->id,
            ]
        );

        $this->assertNull(
            StudentClassEnrollment::find($enrollment->id)
        );

        $this->assertNotNull(
            StudentClassEnrollment::withTrashed()
                ->find($enrollment->id)
        );
    }

    public function test_enrollment_requires_valid_student(): void
    {
        $data = $this->createEnrollmentData();

        $this->expectException(QueryException::class);

        StudentClassEnrollment::create([
            'student_id' => 999999,
            'school_class_id' => $data['schoolClass']->id,
            'academic_session_id' => $data['session']->id,
        ]);
    }

    public function test_enrollment_requires_valid_school_class(): void
    {
        $data = $this->createEnrollmentData();

        $this->expectException(QueryException::class);

        StudentClassEnrollment::create([
            'student_id' => $data['student']->id,
            'school_class_id' => 999999,
            'academic_session_id' => $data['session']->id,
        ]);
    }

    public function test_enrollment_requires_valid_academic_session(): void
    {
        $data = $this->createEnrollmentData();

        $this->expectException(QueryException::class);

        StudentClassEnrollment::create([
            'student_id' => $data['student']->id,
            'school_class_id' => $data['schoolClass']->id,
            'academic_session_id' => 999999,
        ]);
    }

    public function test_enrollment_status_defaults_to_active(): void
    {
        $data = $this->createEnrollmentData();

        $enrollment = StudentClassEnrollment::create([
            'student_id' => $data['student']->id,
            'school_class_id' => $data['schoolClass']->id,
            'academic_session_id' => $data['session']->id,
        ]);

        $this->assertSame(
            'active',
            $enrollment->status
        );
    }

    public function test_enrollment_dates_are_cast_to_dates(): void
    {
        $data = $this->createEnrollmentData();

        $enrollment = StudentClassEnrollment::create([
            'student_id' => $data['student']->id,
            'school_class_id' => $data['schoolClass']->id,
            'academic_session_id' => $data['session']->id,
            'enrolled_at' => '2026-04-01',
            'ended_at' => '2027-03-31',
        ]);

        $this->assertSame(
            '2026-04-01',
            $enrollment->enrolled_at->format('Y-m-d')
        );

        $this->assertSame(
            '2027-03-31',
            $enrollment->ended_at->format('Y-m-d')
        );
    }
}