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
use App\Models\Topic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestTimerTest extends TestCase
{
    use RefreshDatabase;

    private Topic $topic;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $educationSystem = EducationSystem::first();
        $board = Board::first();
        $academicSession = AcademicSession::first();
        $grade = Grade::where('code', 'G9')->first();
        $subject = Subject::where('code', 'CS')->first();

        $book = Book::create([
            'board_id' => $board->id,
            'grade_id' => $grade->id,
            'subject_id' => $subject->id,
            'academic_session_id' => $academicSession->id,
            'title' => 'Computer Science Class 9',
            'status' => 'active',
        ]);

        $chapter = Chapter::create([
            'book_id' => $book->id,
            'chapter_number' => 1,
            'title' => 'Introduction to Computer',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $this->topic = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Basic Concepts',
            'sort_order' => 1,
            'status' => 'active',
        ]);
    }

    /**
     * Create a verified user for protected routes.
     */
    private function authenticatedUser(): User
    {
        return User::factory()->create([
            'email_verified_at' => now(),
        ]);
    }

    /**
     * Create a published test with one question.
     */
    private function createPublishedTest(): Test
    {
        $question = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'What is a computer?',
            'difficulty' => 'medium',
            'marks' => 1,
            'options' => [
                'A computer is an electronic device.',
                'A computer is a book.',
                'A computer is a chair.',
                'A computer is a vehicle.',
            ],
            'answer' => 'A computer is an electronic device.',
        ]);

        $test = Test::create([
            'title' => 'Timer Test',
            'instructions' => 'Complete the test within the given time.',
            'duration' => 60,
            'marks' => 1,
            'status' => Test::STATUS_PUBLISHED,
            'published_at' => now(),
        ]);

        $test->questions()->attach($question->id, [
            'sort_order' => 1,
            'marks' => $question->marks,
        ]);

        return $test;
    }

    /**
     * Create an attempt for a specific user.
     */
    private function createAttempt(
        Test $test,
        User $user,
        Carbon $startedAt,
        Carbon $expiresAt,
        string $status = TestAttempt::STATUS_IN_PROGRESS
    ): TestAttempt {
        return TestAttempt::create([
            'test_id' => $test->id,
            'user_id' => $user->id,
            'started_at' => $startedAt,
            'expires_at' => $expiresAt,
            'status' => $status,
        ]);
    }

    public function test_attempt_is_expired_when_current_time_reaches_expiry_time(): void
    {
        $user = $this->authenticatedUser();
        $test = $this->createPublishedTest();

        $startedAt = Carbon::parse('2026-09-09 10:00:00');
        $expiresAt = Carbon::parse('2026-09-09 11:00:00');

        $attempt = $this->createAttempt(
            $test,
            $user,
            $startedAt,
            $expiresAt
        );

        Carbon::setTestNow(
            Carbon::parse('2026-09-09 11:00:00')
        );

        $this->assertTrue(
            $attempt->isExpired()
        );

        Carbon::setTestNow();
    }

    public function test_attempt_is_not_expired_before_expiry_time(): void
    {
        $user = $this->authenticatedUser();
        $test = $this->createPublishedTest();

        $startedAt = Carbon::parse('2026-09-09 10:00:00');
        $expiresAt = Carbon::parse('2026-09-09 11:00:00');

        $attempt = $this->createAttempt(
            $test,
            $user,
            $startedAt,
            $expiresAt
        );

        Carbon::setTestNow(
            Carbon::parse('2026-09-09 10:59:59')
        );

        $this->assertFalse(
            $attempt->isExpired()
        );

        Carbon::setTestNow();
    }

    public function test_remaining_seconds_are_calculated_correctly(): void
    {
        $user = $this->authenticatedUser();
        $test = $this->createPublishedTest();

        $startedAt = Carbon::parse('2026-09-09 10:00:00');
        $expiresAt = Carbon::parse('2026-09-09 11:00:00');

        $attempt = $this->createAttempt(
            $test,
            $user,
            $startedAt,
            $expiresAt
        );

        Carbon::setTestNow(
            Carbon::parse('2026-09-09 10:45:00')
        );

        $this->assertSame(
            900,
            $attempt->remainingSeconds()
        );

        Carbon::setTestNow();
    }

    public function test_remaining_seconds_never_becomes_negative(): void
    {
        $user = $this->authenticatedUser();
        $test = $this->createPublishedTest();

        $startedAt = Carbon::parse('2026-09-09 10:00:00');
        $expiresAt = Carbon::parse('2026-09-09 11:00:00');

        $attempt = $this->createAttempt(
            $test,
            $user,
            $startedAt,
            $expiresAt
        );

        Carbon::setTestNow(
            Carbon::parse('2026-09-09 11:10:00')
        );

        $this->assertSame(
            0,
            $attempt->remainingSeconds()
        );

        Carbon::setTestNow();
    }

    public function test_expired_attempt_can_be_marked_as_expired(): void
    {
        $user = $this->authenticatedUser();
        $test = $this->createPublishedTest();

        $startedAt = Carbon::parse('2026-09-09 10:00:00');
        $expiresAt = Carbon::parse('2026-09-09 11:00:00');

        $attempt = $this->createAttempt(
            $test,
            $user,
            $startedAt,
            $expiresAt
        );

        Carbon::setTestNow(
            Carbon::parse('2026-09-09 11:01:00')
        );

        $result = $attempt->markAsExpired();

        $this->assertTrue($result);

        $this->assertSame(
            TestAttempt::STATUS_EXPIRED,
            $attempt->fresh()->status
        );

        $this->assertDatabaseHas('test_attempts', [
            'id' => $attempt->id,
            'status' => TestAttempt::STATUS_EXPIRED,
        ]);

        Carbon::setTestNow();
    }

    public function test_in_progress_attempt_cannot_accept_answer_after_expiry(): void
    {
        $user = $this->authenticatedUser();
        $test = $this->createPublishedTest();

        $question = $test->questions()->first();

        $startedAt = Carbon::parse('2026-09-09 10:00:00');
        $expiresAt = Carbon::parse('2026-09-09 11:00:00');

        $attempt = $this->createAttempt(
            $test,
            $user,
            $startedAt,
            $expiresAt
        );

        Carbon::setTestNow(
            Carbon::parse('2026-09-09 11:01:00')
        );

        $response = $this
            ->actingAs($user)
            ->post(
                route(
                    'tests.attempts.answers.store',
                    [
                        'attempt' => $attempt,
                        'question' => $question,
                    ]
                ),
                [
                    'answer' =>
                        'A computer is an electronic device.',
                ]
            );

        $response->assertRedirect();

        $response->assertSessionHasErrors('answer');

        $this->assertDatabaseMissing(
            'test_attempt_answers',
            [
                'test_attempt_id' => $attempt->id,
                'question_id' => $question->id,
            ]
        );

        $this->assertDatabaseHas('test_attempts', [
            'id' => $attempt->id,
            'status' => TestAttempt::STATUS_EXPIRED,
        ]);

        Carbon::setTestNow();
    }

    public function test_in_progress_attempt_can_accept_answer_before_expiry(): void
    {
        $user = $this->authenticatedUser();
        $test = $this->createPublishedTest();

        $question = $test->questions()->first();

        $startedAt = Carbon::parse('2026-09-09 10:00:00');
        $expiresAt = Carbon::parse('2026-09-09 11:00:00');

        $attempt = $this->createAttempt(
            $test,
            $user,
            $startedAt,
            $expiresAt
        );

        Carbon::setTestNow(
            Carbon::parse('2026-09-09 10:30:00')
        );

        $response = $this
            ->actingAs($user)
            ->post(
                route(
                    'tests.attempts.answers.store',
                    [
                        'attempt' => $attempt,
                        'question' => $question,
                    ]
                ),
                [
                    'answer' =>
                        'A computer is an electronic device.',
                ]
            );

        $response->assertRedirect();

        $response->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas(
            'test_attempt_answers',
            [
                'test_attempt_id' => $attempt->id,
                'question_id' => $question->id,
                'answer' =>
                    'A computer is an electronic device.',
            ]
        );

        $this->assertDatabaseHas('test_attempts', [
            'id' => $attempt->id,
            'status' => TestAttempt::STATUS_IN_PROGRESS,
        ]);

        Carbon::setTestNow();
    }

    public function test_expire_endpoint_rejects_request_before_expiry(): void
    {
        $user = $this->authenticatedUser();
        $test = $this->createPublishedTest();

        $startedAt = Carbon::parse('2026-09-09 10:00:00');
        $expiresAt = Carbon::parse('2026-09-09 11:00:00');

        $attempt = $this->createAttempt(
            $test,
            $user,
            $startedAt,
            $expiresAt
        );

        Carbon::setTestNow(
            Carbon::parse('2026-09-09 10:30:00')
        );

        $response = $this
            ->actingAs($user)
            ->postJson(
                route(
                    'tests.attempts.expire',
                    $attempt
                )
            );

        $response->assertStatus(422);

        $response->assertJson([
            'success' => false,
        ]);

        $response->assertJsonStructure([
            'success',
            'message',
            'remaining_seconds',
        ]);

        $this->assertDatabaseHas('test_attempts', [
            'id' => $attempt->id,
            'status' => TestAttempt::STATUS_IN_PROGRESS,
        ]);

        Carbon::setTestNow();
    }

    public function test_expire_endpoint_marks_attempt_expired_after_time_runs_out(): void
    {
        $user = $this->authenticatedUser();
        $test = $this->createPublishedTest();

        $startedAt = Carbon::parse('2026-09-09 10:00:00');
        $expiresAt = Carbon::parse('2026-09-09 11:00:00');

        $attempt = $this->createAttempt(
            $test,
            $user,
            $startedAt,
            $expiresAt
        );

        Carbon::setTestNow(
            Carbon::parse('2026-09-09 11:01:00')
        );

        $response = $this
            ->actingAs($user)
            ->postJson(
                route(
                    'tests.attempts.expire',
                    $attempt
                )
            );

        $response->assertOk();

        $response->assertJson([
            'success' => true,
            'status' => TestAttempt::STATUS_EXPIRED,
        ]);

        $this->assertDatabaseHas('test_attempts', [
            'id' => $attempt->id,
            'status' => TestAttempt::STATUS_EXPIRED,
        ]);

        Carbon::setTestNow();
    }

    public function test_user_cannot_expire_another_users_attempt(): void
    {
        $user = $this->authenticatedUser();
        $anotherUser = $this->authenticatedUser();

        $test = $this->createPublishedTest();

        $startedAt = Carbon::parse('2026-09-09 10:00:00');
        $expiresAt = Carbon::parse('2026-09-09 11:00:00');

        $attempt = $this->createAttempt(
            $test,
            $anotherUser,
            $startedAt,
            $expiresAt
        );

        Carbon::setTestNow(
            Carbon::parse('2026-09-09 11:01:00')
        );

        $response = $this
            ->actingAs($user)
            ->postJson(
                route(
                    'tests.attempts.expire',
                    $attempt
                )
            );

        $response->assertForbidden();

        $this->assertDatabaseHas('test_attempts', [
            'id' => $attempt->id,
            'status' => TestAttempt::STATUS_IN_PROGRESS,
        ]);

        Carbon::setTestNow();
    }

    public function test_submitted_attempt_cannot_be_expired(): void
    {
        $user = $this->authenticatedUser();
        $test = $this->createPublishedTest();

        $startedAt = Carbon::parse('2026-09-09 10:00:00');
        $expiresAt = Carbon::parse('2026-09-09 11:00:00');

        $attempt = $this->createAttempt(
            $test,
            $user,
            $startedAt,
            $expiresAt,
            TestAttempt::STATUS_SUBMITTED
        );

        Carbon::setTestNow(
            Carbon::parse('2026-09-09 11:01:00')
        );

        $response = $this
            ->actingAs($user)
            ->postJson(
                route(
                    'tests.attempts.expire',
                    $attempt
                )
            );

        $response->assertStatus(409);

        $response->assertJson([
            'success' => false,
        ]);

        $this->assertDatabaseHas('test_attempts', [
            'id' => $attempt->id,
            'status' => TestAttempt::STATUS_SUBMITTED,
        ]);

        Carbon::setTestNow();
    }

    public function test_guest_cannot_use_expire_endpoint(): void
    {
        $user = $this->authenticatedUser();
        $test = $this->createPublishedTest();

        $startedAt = Carbon::parse('2026-09-09 10:00:00');
        $expiresAt = Carbon::parse('2026-09-09 11:00:00');

        $attempt = $this->createAttempt(
            $test,
            $user,
            $startedAt,
            $expiresAt
        );

        Carbon::setTestNow(
            Carbon::parse('2026-09-09 11:01:00')
        );

        $response = $this->postJson(
            route(
                'tests.attempts.expire',
                $attempt
            )
        );

        $response->assertUnauthorized();

        Carbon::setTestNow();
    }

    public function test_expired_status_is_detected_even_if_expiry_time_is_in_the_future(): void
    {
        $user = $this->authenticatedUser();
        $test = $this->createPublishedTest();

        $startedAt = Carbon::parse('2026-09-09 10:00:00');
        $expiresAt = Carbon::parse('2026-09-09 11:00:00');

        $attempt = $this->createAttempt(
            $test,
            $user,
            $startedAt,
            $expiresAt,
            TestAttempt::STATUS_EXPIRED
        );

        Carbon::setTestNow(
            Carbon::parse('2026-09-09 10:30:00')
        );

        $this->assertTrue(
            $attempt->isExpired()
        );

        Carbon::setTestNow();
    }

    public function test_expired_attempt_cannot_be_marked_expired_again(): void
    {
        $user = $this->authenticatedUser();
        $test = $this->createPublishedTest();

        $startedAt = Carbon::parse('2026-09-09 10:00:00');
        $expiresAt = Carbon::parse('2026-09-09 11:00:00');

        $attempt = $this->createAttempt(
            $test,
            $user,
            $startedAt,
            $expiresAt,
            TestAttempt::STATUS_EXPIRED
        );

        $result = $attempt->markAsExpired();

        $this->assertFalse($result);

        $this->assertSame(
            TestAttempt::STATUS_EXPIRED,
            $attempt->fresh()->status
        );
    }
}