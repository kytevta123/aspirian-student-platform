<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\StudentClassEnrollment;
use App\Models\Test;
use App\Models\TestAssignment;
use App\Models\TestAttempt;
use App\Models\TestResult;
use App\Models\User;
use App\Models\AcademicSession;
use App\Models\Board;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\EducationSystem;
use App\Models\Grade;
use App\Models\GradeSubject;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SchoolReportsTest extends TestCase
{
    use RefreshDatabase;

    public function test_school_admin_can_open_all_report_endpoints(): void
    {
        $school = School::create([
            'name' => 'Reports School',
            'code' => 'RPT-001',
            'status' => 'active',
        ]);
        $admin = User::factory()->create();
        $role = Role::firstOrCreate(
            ['name' => 'SCHOOL_ADMIN'],
            [
                'display_name' => 'School Admin',
                'description' => 'School administrator.',
            ]
        );
        $admin->roles()->syncWithoutDetaching([$role->id]);

        foreach (['students', 'classes', 'subjects', 'tests'] as $report) {
            $this->actingAs($admin)
                ->getJson("/api/school/{$school->id}/reports/{$report}")
                ->assertOk()
                ->assertJsonPath('data', [])
                ->assertJsonPath('total', 0);
        }
    }

    public function test_report_endpoints_reject_unauthenticated_requests(): void
    {
        $school = School::create([
            'name' => 'Reports School',
            'code' => 'RPT-002',
            'status' => 'active',
        ]);

        foreach (['students', 'classes', 'subjects', 'tests'] as $report) {
            $this->getJson("/api/school/{$school->id}/reports/{$report}")
                ->assertUnauthorized();
        }
    }

    public function test_login_session_authenticates_school_report_api_requests(): void
    {
        $school = School::create([
            'name' => 'Session Reports School',
            'code' => 'RPT-SESSION',
            'status' => 'active',
        ]);
        $admin = User::factory()->create([
            'email' => 'reports-admin@example.test',
            'password' => Hash::make('valid-password'),
        ]);
        $role = Role::firstOrCreate(
            ['name' => 'SCHOOL_ADMIN'],
            [
                'display_name' => 'School Admin',
                'description' => 'School administrator.',
            ]
        );
        $admin->roles()->syncWithoutDetaching([$role->id]);

        $this->withHeader('Origin', 'http://localhost:5173')
            ->postJson('/login', [
                'email' => 'reports-admin@example.test',
                'password' => 'valid-password',
            ])
            ->assertOk()
            ->assertJsonPath('user.id', $admin->id);

        $this->withHeader('Origin', 'http://localhost:5173')
            ->getJson("/api/school/{$school->id}/reports/students")
            ->assertOk()
            ->assertJsonPath('data', []);
    }

    public function test_reports_include_school_scoped_student_test_and_subject_metrics(): void
    {
        $school = School::create([
            'name' => 'Metrics School',
            'code' => 'RPT-003',
            'status' => 'active',
        ]);
        $grade = Grade::create([
            'name' => 'Class 9',
            'code' => 'RPT-G9',
            'level' => 9,
            'sort_order' => 9,
            'status' => 'active',
        ]);
        $session = AcademicSession::create([
            'name' => 'Reports 2026-27',
            'start_date' => '2026-04-01',
            'end_date' => '2027-03-31',
            'status' => 'active',
        ]);
        $schoolClass = SchoolClass::create([
            'school_id' => $school->id,
            'grade_id' => $grade->id,
            'academic_session_id' => $session->id,
            'name' => '9-A',
            'status' => 'active',
        ]);
        $studentUser = User::factory()->create(['name' => 'Report Student']);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'status' => 'active',
        ]);
        StudentClassEnrollment::create([
            'student_id' => $student->id,
            'school_class_id' => $schoolClass->id,
            'academic_session_id' => $session->id,
            'status' => 'active',
        ]);

        $system = EducationSystem::create([
            'name' => 'Reports Education System',
            'country' => 'Pakistan',
            'status' => 'active',
        ]);
        $board = Board::create([
            'education_system_id' => $system->id,
            'name' => 'Reports Board',
            'code' => 'RPT-BOARD',
            'status' => 'active',
        ]);
        $subject = Subject::create([
            'name' => 'Mathematics',
            'code' => 'RPT-MATH',
            'status' => 'active',
        ]);
        GradeSubject::create([
            'grade_id' => $grade->id,
            'subject_id' => $subject->id,
            'board_id' => $board->id,
            'academic_session_id' => $session->id,
            'status' => 'active',
        ]);
        $book = Book::create([
            'board_id' => $board->id,
            'grade_id' => $grade->id,
            'subject_id' => $subject->id,
            'academic_session_id' => $session->id,
            'title' => 'Reports Mathematics',
            'status' => 'active',
        ]);
        $chapter = Chapter::create([
            'book_id' => $book->id,
            'chapter_number' => 1,
            'title' => 'Numbers',
            'status' => 'active',
        ]);
        $topic = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Fractions',
            'status' => 'active',
        ]);
        $question = Question::create([
            'topic_id' => $topic->id,
            'question_type' => 'mcq',
            'question_text' => 'One half equals?',
            'options' => ['A', 'B'],
            'answer' => 'A',
            'marks' => 1,
            'difficulty' => 'easy',
            'status' => 'published',
        ]);
        $test = Test::create([
            'title' => 'Fractions Test',
            'marks' => 1,
            'status' => 'published',
        ]);
        DB::table('test_questions')->insert([
            'test_id' => $test->id,
            'question_id' => $question->id,
            'sort_order' => 1,
            'marks' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        TestAssignment::create([
            'test_id' => $test->id,
            'student_id' => $studentUser->id,
        ]);
        $attempt = TestAttempt::create([
            'test_id' => $test->id,
            'user_id' => $studentUser->id,
            'status' => TestAttempt::STATUS_SUBMITTED,
        ]);
        TestResult::create([
            'test_attempt_id' => $attempt->id,
            'test_id' => $test->id,
            'user_id' => $studentUser->id,
            'total_marks' => 2,
            'obtained_marks' => 1,
            'percentage' => 50,
            'correct_answers' => 1,
            'wrong_answers' => 1,
            'unanswered' => 0,
            'status' => TestResult::STATUS_FAILED,
        ]);

        $admin = User::factory()->create();
        $role = Role::firstOrCreate(
            ['name' => 'SCHOOL_ADMIN'],
            [
                'display_name' => 'School Admin',
                'description' => 'School administrator.',
            ]
        );
        $admin->roles()->syncWithoutDetaching([$role->id]);

        $this->actingAs($admin)
            ->getJson("/api/school/{$school->id}/reports/students")
            ->assertOk()
            ->assertJsonPath('data.0.name', 'Report Student')
            ->assertJsonPath('data.0.total_tests', 1)
            ->assertJsonPath('data.0.average_percentage', 50);

        $this->getJson("/api/school/{$school->id}/reports/classes")
            ->assertOk()
            ->assertJsonPath('data.0.name', '9-A')
            ->assertJsonPath('data.0.total_students', 1)
            ->assertJsonPath('data.0.total_tests_taken', 1)
            ->assertJsonPath('data.0.average_percentage', 50);

        $this->getJson("/api/school/{$school->id}/reports/subjects")
            ->assertOk()
            ->assertJsonPath('data.0.name', 'Mathematics')
            ->assertJsonPath('data.0.total_tests', 1)
            ->assertJsonPath('data.0.total_results', 1)
            ->assertJsonPath('data.0.average_percentage', 50);

        $this->getJson("/api/school/{$school->id}/reports/tests")
            ->assertOk()
            ->assertJsonPath('data.0.title', 'Fractions Test')
            ->assertJsonPath('data.0.class_name', '9-A')
            ->assertJsonPath('data.0.subject', 'Mathematics')
            ->assertJsonPath('data.0.attempts', 1)
            ->assertJsonPath('data.0.average_percentage', 50)
            ->assertJsonPath('data.0.pass_rate', 0);
    }
}