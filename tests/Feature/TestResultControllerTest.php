<?php

namespace Tests\Feature;

use App\Models\AcademicSession;
use App\Models\Board;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\EducationSystem;
use App\Models\Grade;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Test;
use App\Models\TestAttempt;
use App\Models\TestResult;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestResultControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_view_own_result(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = $this->createTest();

        $attempt = TestAttempt::create([
            'test_id' => $test->id,
            'user_id' => $user->id,
            'started_at' => now()->subMinutes(5),
            'expires_at' => now()->addMinutes(25),
            'submitted_at' => now(),
            'status' => TestAttempt::STATUS_SUBMITTED,
        ]);

        $result = TestResult::create([
            'test_attempt_id' => $attempt->id,
            'test_id' => $test->id,
            'user_id' => $user->id,
            'total_marks' => 10,
            'obtained_marks' => 8,
            'percentage' => 80,
            'correct_answers' => 8,
            'wrong_answers' => 1,
            'unanswered' => 1,
            'status' => TestResult::STATUS_PASSED,
        ]);

        $response = $this->actingAs($user)
            ->get(
                route(
                    'tests.results.show',
                    $result
                )
            );

        $response->assertOk();

        $response->assertViewIs(
            'tests.results.show'
        );

        $response->assertViewHas(
            'result',
            $result
        );

        $response->assertSee(
            $test->title
        );

        $response->assertSee(
            '80.00%'
        );

        $response->assertSee(
            'Passed'
        );

        $response->assertSee(
            '8'
        );

        $response->assertSee(
            '1'
        );
    }

    public function test_student_cannot_view_another_students_result(): void
    {
        $studentA = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $studentB = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = $this->createTest();

        $attempt = TestAttempt::create([
            'test_id' => $test->id,
            'user_id' => $studentB->id,
            'started_at' => now()->subMinutes(5),
            'expires_at' => now()->addMinutes(25),
            'submitted_at' => now(),
            'status' => TestAttempt::STATUS_SUBMITTED,
        ]);

        $result = TestResult::create([
            'test_attempt_id' => $attempt->id,
            'test_id' => $test->id,
            'user_id' => $studentB->id,
            'total_marks' => 10,
            'obtained_marks' => 6,
            'percentage' => 60,
            'correct_answers' => 6,
            'wrong_answers' => 2,
            'unanswered' => 2,
            'status' => TestResult::STATUS_PASSED,
        ]);

        $response = $this->actingAs($studentA)
            ->get(
                route(
                    'tests.results.show',
                    $result
                )
            );

        $response->assertForbidden();
    }

    public function test_guest_cannot_view_result(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = $this->createTest();

        $attempt = TestAttempt::create([
            'test_id' => $test->id,
            'user_id' => $user->id,
            'started_at' => now()->subMinutes(5),
            'expires_at' => now()->addMinutes(25),
            'submitted_at' => now(),
            'status' => TestAttempt::STATUS_SUBMITTED,
        ]);

        $result = TestResult::create([
            'test_attempt_id' => $attempt->id,
            'test_id' => $test->id,
            'user_id' => $user->id,
            'total_marks' => 10,
            'obtained_marks' => 5,
            'percentage' => 50,
            'correct_answers' => 5,
            'wrong_answers' => 3,
            'unanswered' => 2,
            'status' => TestResult::STATUS_PASSED,
        ]);

        $response = $this->get(
            route(
                'tests.results.show',
                $result
            )
        );

        $response->assertRedirect(
            route('login.form')
        );
    }

    public function test_result_page_does_not_expose_correct_answers(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = $this->createTest();

        $question = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => 'mcq',
            'question_text' => 'What is 2 + 2?',
            'options' => [
                'A' => '3',
                'B' => '4',
                'C' => '5',
                'D' => '6',
            ],
            'answer' => 'B',
            'explanation' => 'The correct answer is 4.',
            'difficulty' => 'easy',
            'status' => 'published',
        ]);

        $test->questions()->attach(
            $question->id,
            [
                'sort_order' => 1,
                'marks' => 1,
            ]
        );

        $attempt = TestAttempt::create([
            'test_id' => $test->id,
            'user_id' => $user->id,
            'started_at' => now()->subMinutes(5),
            'expires_at' => now()->addMinutes(25),
            'submitted_at' => now(),
            'status' => TestAttempt::STATUS_SUBMITTED,
        ]);

        $result = TestResult::create([
            'test_attempt_id' => $attempt->id,
            'test_id' => $test->id,
            'user_id' => $user->id,
            'total_marks' => 1,
            'obtained_marks' => 1,
            'percentage' => 100,
            'correct_answers' => 1,
            'wrong_answers' => 0,
            'unanswered' => 0,
            'status' => TestResult::STATUS_PASSED,
        ]);

        $response = $this->actingAs($user)
            ->get(
                route(
                    'tests.results.show',
                    $result
                )
            );

        $response->assertOk();

        $response->assertDontSee(
            'The correct answer is 4.'
        );

        $response->assertDontSee(
            'What is 2 + 2?'
        );
    }

    protected function createTest(): Test
    {
        $educationSystem = EducationSystem::create([
            'name' => 'Test Education System',
            'country' => 'Pakistan',
            'status' => 'active',
        ]);

        $board = Board::create([
            'education_system_id' => $educationSystem->id,
            'name' => 'Test Board',
            'code' => 'TB',
            'status' => 'active',
        ]);

        $grade = Grade::create([
            'name' => 'Test Grade',
            'code' => 'TG',
            'level' => 9,
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $subject = Subject::create([
            'name' => 'Test Subject',
            'code' => 'TS',
            'description' => 'Test subject',
            'status' => 'active',
        ]);

        $academicSession = AcademicSession::create([
            'name' => '2026-27',
            'start_date' => '2026-08-01',
            'end_date' => '2027-07-31',
            'status' => 'active',
        ]);

        $book = Book::create([
            'board_id' => $board->id,
            'grade_id' => $grade->id,
            'subject_id' => $subject->id,
            'academic_session_id' => $academicSession->id,
            'title' => 'Test Book',
            'publisher' => 'Test Publisher',
            'edition' => '1st',
            'status' => 'active',
        ]);

        $chapter = Chapter::create([
            'book_id' => $book->id,
            'chapter_number' => 1,
            'title' => 'Test Chapter',
            'description' => 'Test chapter',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $this->topic = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Test Result Topic',
            'description' => 'Test result topic',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        return Test::create([
            'title' => 'Result Test',
            'instructions' => 'Answer all questions.',
            'duration' => 30,
            'marks' => 10,
            'status' => Test::STATUS_PUBLISHED,
            'published_at' => now(),
        ]);
    }
}