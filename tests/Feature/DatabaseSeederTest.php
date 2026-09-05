<?php

namespace Tests\Feature;

use App\Models\AcademicSession;
use App\Models\Board;
use App\Models\EducationSystem;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_academic_seeders_create_required_master_data(): void
    {
        $this->seed();

        $this->assertDatabaseHas('education_systems', [
            'name' => 'Pakistan Education System',
            'country' => 'Pakistan',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('boards', [
            'name' => 'Punjab Board',
            'code' => 'PB',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('academic_sessions', [
            'name' => '2026-27',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('grades', [
            'name' => 'Class 9',
            'code' => 'G9',
            'level' => 9,
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('grades', [
            'name' => 'Class 12',
            'code' => 'G12',
            'level' => 12,
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('subjects', [
            'name' => 'Computer Science',
            'code' => 'CS',
            'status' => 'active',
        ]);
    }

    public function test_seeded_board_belongs_to_seeded_education_system(): void
    {
        $this->seed();

        $educationSystem = EducationSystem::where(
            'name',
            'Pakistan Education System'
        )->firstOrFail();

        $board = Board::where(
            'code',
            'PB'
        )->firstOrFail();

        $this->assertTrue(
            $board->educationSystem->is($educationSystem)
        );
    }

    public function test_required_grade_range_is_seeded(): void
    {
        $this->seed();

        $this->assertSame(
            14,
            Grade::count()
        );

        $this->assertNotNull(
            Grade::where('code', 'G1')->first()
        );

        $this->assertNotNull(
            Grade::where('code', 'G9')->first()
        );

        $this->assertNotNull(
            Grade::where('code', 'G12')->first()
        );
    }

    public function test_required_subjects_are_seeded(): void
    {
        $this->seed();

        $requiredSubjects = [
            'ENG',
            'URD',
            'MATH',
            'SCI',
            'CS',
            'PHY',
            'CHEM',
            'BIO',
            'PAK',
            'ISL',
        ];

        foreach ($requiredSubjects as $code) {
            $this->assertDatabaseHas('subjects', [
                'code' => $code,
                'status' => 'active',
            ]);
        }
    }

    public function test_academic_session_dates_are_seeded_correctly(): void
    {
        $this->seed();

        $session = AcademicSession::where(
            'name',
            '2026-27'
        )->firstOrFail();

        $this->assertSame(
            '2026-04-01',
            $session->start_date->format('Y-m-d')
        );

        $this->assertSame(
            '2027-03-31',
            $session->end_date->format('Y-m-d')
        );

        $this->assertSame(
            'active',
            $session->status
        );
    }

    public function test_seeders_are_idempotent(): void
    {
        $this->seed();

        $this->seed();

        $this->assertSame(
            1,
            EducationSystem::where(
                'name',
                'Pakistan Education System'
            )->count()
        );

        $this->assertSame(
            1,
            Board::where(
                'code',
                'PB'
            )->count()
        );

        $this->assertSame(
            1,
            AcademicSession::where(
                'name',
                '2026-27'
            )->count()
        );

        $this->assertSame(
            1,
            Grade::where(
                'code',
                'G9'
            )->count()
        );

        $this->assertSame(
            1,
            Subject::where(
                'code',
                'CS'
            )->count()
        );
    }
}