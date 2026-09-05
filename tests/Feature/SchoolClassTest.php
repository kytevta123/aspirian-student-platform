<?php

namespace Tests\Feature;

use App\Models\AcademicSession;
use App\Models\Grade;
use App\Models\School;
use App\Models\SchoolClass;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchoolClassTest extends TestCase
{
    use RefreshDatabase;

    private function createSchool(): School
    {
        return School::create([
            'name' => 'Aspirian School',
            'code' => 'ASP-001',
            'status' => 'active',
        ]);
    }

    private function createGrade(): Grade
    {
        return Grade::create([
            'name' => 'Class 9',
            'code' => 'G9',
            'level' => 9,
            'sort_order' => 9,
            'status' => 'active',
        ]);
    }

    private function createAcademicSession(
        string $name,
        string $startDate,
        string $endDate
    ): AcademicSession {
        return AcademicSession::create([
            'name' => $name,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active',
        ]);
    }

    public function test_school_class_can_be_created_with_valid_relationships(): void
    {
        $school = $this->createSchool();
        $grade = $this->createGrade();

        $session = $this->createAcademicSession(
            '2026-27',
            '2026-04-01',
            '2027-03-31'
        );

        $schoolClass = SchoolClass::create([
            'school_id' => $school->id,
            'grade_id' => $grade->id,
            'academic_session_id' => $session->id,
            'name' => '9-A',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('school_classes', [
            'id' => $schoolClass->id,
            'school_id' => $school->id,
            'grade_id' => $grade->id,
            'academic_session_id' => $session->id,
            'name' => '9-A',
            'status' => 'active',
        ]);

        $this->assertTrue($schoolClass->school->is($school));
        $this->assertTrue($schoolClass->grade->is($grade));
        $this->assertTrue($schoolClass->academicSession->is($session));
    }

    public function test_duplicate_class_name_is_prevented_within_same_school_and_session(): void
    {
        $school = $this->createSchool();
        $grade = $this->createGrade();

        $session = $this->createAcademicSession(
            '2026-27',
            '2026-04-01',
            '2027-03-31'
        );

        SchoolClass::create([
            'school_id' => $school->id,
            'grade_id' => $grade->id,
            'academic_session_id' => $session->id,
            'name' => '9-A',
            'status' => 'active',
        ]);

        $this->expectException(QueryException::class);

        SchoolClass::create([
            'school_id' => $school->id,
            'grade_id' => $grade->id,
            'academic_session_id' => $session->id,
            'name' => '9-A',
            'status' => 'active',
        ]);
    }

    public function test_same_class_name_can_exist_in_different_academic_sessions(): void
    {
        $school = $this->createSchool();
        $grade = $this->createGrade();

        $sessionOne = $this->createAcademicSession(
            '2026-27',
            '2026-04-01',
            '2027-03-31'
        );

        $sessionTwo = $this->createAcademicSession(
            '2027-28',
            '2027-04-01',
            '2028-03-31'
        );

        SchoolClass::create([
            'school_id' => $school->id,
            'grade_id' => $grade->id,
            'academic_session_id' => $sessionOne->id,
            'name' => '9-A',
            'status' => 'active',
        ]);

        $schoolClass = SchoolClass::create([
            'school_id' => $school->id,
            'grade_id' => $grade->id,
            'academic_session_id' => $sessionTwo->id,
            'name' => '9-A',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('school_classes', [
            'id' => $schoolClass->id,
            'name' => '9-A',
            'academic_session_id' => $sessionTwo->id,
        ]);
    }

    public function test_school_class_can_be_soft_deleted(): void
    {
        $school = $this->createSchool();
        $grade = $this->createGrade();

        $session = $this->createAcademicSession(
            '2026-27',
            '2026-04-01',
            '2027-03-31'
        );

        $schoolClass = SchoolClass::create([
            'school_id' => $school->id,
            'grade_id' => $grade->id,
            'academic_session_id' => $session->id,
            'name' => '9-A',
            'status' => 'active',
        ]);

        $schoolClass->delete();

        $this->assertSoftDeleted('school_classes', [
            'id' => $schoolClass->id,
        ]);
    }
}