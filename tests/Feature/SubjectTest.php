<?php

namespace Tests\Feature;

use App\Models\AcademicSession;
use App\Models\Board;
use App\Models\EducationSystem;
use App\Models\Grade;
use App\Models\GradeSubject;
use App\Models\Subject;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_subject_can_be_created(): void
    {
        $subject = Subject::create([
            'name' => 'Computer Science',
            'code' => 'CS',
            'description' => 'Computer Science subject',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('subjects', [
            'id' => $subject->id,
            'name' => 'Computer Science',
            'code' => 'CS',
            'status' => 'active',
        ]);
    }

    public function test_subject_code_must_be_unique(): void
    {
        Subject::create([
            'name' => 'Computer Science',
            'code' => 'CS',
            'status' => 'active',
        ]);

        $this->expectException(QueryException::class);

        Subject::create([
            'name' => 'Computer Studies',
            'code' => 'CS',
            'status' => 'active',
        ]);
    }

    public function test_subject_has_grade_subject_relationship(): void
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

        $grade = Grade::create([
            'name' => 'Class 9',
            'code' => 'G9',
            'level' => 9,
            'sort_order' => 9,
            'status' => 'active',
        ]);

        $session = AcademicSession::create([
            'name' => '2026-27',
            'start_date' => '2026-04-01',
            'end_date' => '2027-03-31',
            'status' => 'active',
        ]);

        $subject = Subject::create([
            'name' => 'Computer Science',
            'code' => 'CS',
            'status' => 'active',
        ]);

        $gradeSubject = GradeSubject::create([
            'board_id' => $board->id,
            'grade_id' => $grade->id,
            'subject_id' => $subject->id,
            'academic_session_id' => $session->id,
        ]);

        $this->assertTrue(
            $subject->gradeSubjects->contains($gradeSubject)
        );
    }

    public function test_subject_can_be_soft_deleted(): void
    {
        $subject = Subject::create([
            'name' => 'Computer Science',
            'code' => 'CS',
            'status' => 'active',
        ]);

        $subject->delete();

        $this->assertSoftDeleted('subjects', [
            'id' => $subject->id,
        ]);
    }

    public function test_subject_status_defaults_to_active(): void
    {
        Subject::create([
            'name' => 'English',
            'code' => 'ENG',
        ]);

        $this->assertDatabaseHas('subjects', [
            'name' => 'English',
            'code' => 'ENG',
            'status' => 'active',
        ]);
    }
}