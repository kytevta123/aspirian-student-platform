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
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TestSubmissionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected Topic $topic;

    protected function setUp(): void
    {
        parent::setUp();

        $this->topic = $this->createTestHierarchy();
    }

    public function test_it_submits_attempt_and_creates_result(): void
    {
        $user = User::factory()->create();

        $test = Test::create([
            'title' => 'Submission Test',
            'instructions' => 'Answer all questions.',
            'duration' => 30,
            'marks' => 2,
            'status' => Test::STATUS_PUBLISHED,
            'published_at' => now(),
        ]);

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
            'difficulty' => 'easy',
            'marks' => 2,
            'status' => 'published',
        ]);

        $test->questions()->attach($question->id, [
            'sort_order' => 1,
            'marks' => 2,
        ]);

        $attempt = TestAttempt::create([
            'test_id' => $test->id,
            'user_id' => $user->id,
            'started_at' => now(),
            'expires_at' => now()->addMinutes(30),
            'status' => TestAttempt::STATUS_IN_PROGRESS,
        ]);

        $attempt->answers()->create([
            'question_id' => $question->id,
            'answer' => 'B',
            'answered_at' => now(),
        ]);

        $response = $this->actingAs($user)->post(
            route(
                'tests.attempts.submit',
                $attempt
            )
        );

        $result = TestResult::where(
            'test_attempt_id',
            $attempt->id
        )->firstOrFail();

        $response->assertRedirect(
            route(
                'tests.results.show',
                $result
            )
        );

        $this->assertDatabaseHas('test_attempts', [
            'id' => $attempt->id,
            'status' => TestAttempt::STATUS_SUBMITTED,
        ]);

        $this->assertDatabaseHas('test_results', [
            'test_attempt_id' => $attempt->id,
            'test_id' => $test->id,
            'user_id' => $user->id,
            'total_marks' => 2,
            'obtained_marks' => 2,
            'correct_answers' => 1,
            'wrong_answers' => 0,
            'unanswered' => 0,
            'status' => TestResult::STATUS_PASSED,
        ]);
    }

    public function test_it_does_not_create_duplicate_result_on_second_submission(): void
    {
        $user = User::factory()->create();

        $test = Test::create([
            'title' => 'Duplicate Submission Test',
            'instructions' => 'Answer all questions.',
            'duration' => 30,
            'marks' => 1,
            'status' => Test::STATUS_PUBLISHED,
            'published_at' => now(),
        ]);

        $question = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => 'mcq',
            'question_text' => 'What is 1 + 1?',
            'options' => [
                'A' => '1',
                'B' => '2',
                'C' => '3',
                'D' => '4',
            ],
            'answer' => 'B',
            'difficulty' => 'easy',
            'marks' => 1,
            'status' => 'published',
        ]);

        $test->questions()->attach($question->id, [
            'sort_order' => 1,
            'marks' => 1,
        ]);

        $attempt = TestAttempt::create([
            'test_id' => $test->id,
            'user_id' => $user->id,
            'started_at' => now(),
            'expires_at' => now()->addMinutes(30),
            'status' => TestAttempt::STATUS_IN_PROGRESS,
        ]);

        $response = $this->actingAs($user)->post(
            route(
                'tests.attempts.submit',
                $attempt
            )
        );

        $response->assertRedirect();

        $this->assertDatabaseCount(
            'test_results',
            1
        );

        $attempt->refresh();

        $secondResponse = $this->actingAs($user)->post(
            route(
                'tests.attempts.submit',
                $attempt
            )
        );

        $secondResponse->assertSessionHasErrors(
            'submission'
        );

        $this->assertDatabaseCount(
            'test_results',
            1
        );
    }

    public function test_user_cannot_submit_another_users_attempt(): void
    {
        $owner = User::factory()->create();

        $otherUser = User::factory()->create();

        $test = Test::create([
            'title' => 'Authorization Test',
            'instructions' => 'Answer all questions.',
            'duration' => 30,
            'marks' => 1,
            'status' => Test::STATUS_PUBLISHED,
            'published_at' => now(),
        ]);

        $attempt = TestAttempt::create([
            'test_id' => $test->id,
            'user_id' => $owner->id,
            'started_at' => now(),
            'expires_at' => now()->addMinutes(30),
            'status' => TestAttempt::STATUS_IN_PROGRESS,
        ]);

        $response = $this->actingAs($otherUser)->post(
            route(
                'tests.attempts.submit',
                $attempt
            )
        );

        $response->assertForbidden();

        $this->assertDatabaseHas('test_attempts', [
            'id' => $attempt->id,
            'status' => TestAttempt::STATUS_IN_PROGRESS,
        ]);

        $this->assertDatabaseCount(
            'test_results',
            0
        );
    }

    public function test_expired_attempt_cannot_be_submitted(): void
    {
        $user = User::factory()->create();

        $test = Test::create([
            'title' => 'Expired Test',
            'instructions' => 'Answer all questions.',
            'duration' => 30,
            'marks' => 1,
            'status' => Test::STATUS_PUBLISHED,
            'published_at' => now(),
        ]);

        $attempt = TestAttempt::create([
            'test_id' => $test->id,
            'user_id' => $user->id,
            'started_at' => now()->subMinutes(31),
            'expires_at' => now()->subMinute(),
            'status' => TestAttempt::STATUS_IN_PROGRESS,
        ]);

        $response = $this->actingAs($user)->post(
            route(
                'tests.attempts.submit',
                $attempt
            )
        );

        $response->assertSessionHasErrors(
            'submission'
        );

        $attempt->refresh();

        $this->assertSame(
            TestAttempt::STATUS_EXPIRED,
            $attempt->status
        );

        $this->assertDatabaseCount(
            'test_results',
            0
        );
    }

    public function test_already_submitted_attempt_cannot_be_submitted_again(): void
    {
        $user = User::factory()->create();

        $test = Test::create([
            'title' => 'Already Submitted Test',
            'instructions' => 'Answer all questions.',
            'duration' => 30,
            'marks' => 1,
            'status' => Test::STATUS_PUBLISHED,
            'published_at' => now(),
        ]);

        $attempt = TestAttempt::create([
            'test_id' => $test->id,
            'user_id' => $user->id,
            'started_at' => now()->subMinutes(5),
            'expires_at' => now()->addMinutes(25),
            'status' => TestAttempt::STATUS_SUBMITTED,
            'submitted_at' => now(),
        ]);

        TestResult::create([
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

        $response = $this->actingAs($user)->post(
            route(
                'tests.attempts.submit',
                $attempt
            )
        );

        $response->assertSessionHasErrors(
            'submission'
        );

        $this->assertDatabaseCount(
            'test_results',
            1
        );
    }

    protected function createTestHierarchy(): Topic
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

        return Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Test Result Topic',
            'description' => 'Test result topic',
            'sort_order' => 1,
            'status' => 'active',
        ]);
    }
}