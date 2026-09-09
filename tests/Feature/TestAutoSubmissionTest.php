<?php

namespace Tests\Feature;

use App\Models\AcademicSession;
use App\Models\Board;
use App\Models\Book;
use App\Models\Chapter;
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

class TestAutoSubmissionTest extends TestCase
{
    use RefreshDatabase;

    private Topic $topic;

    private Question $question;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

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

        $this->question = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'What is a computer?',
            'normalized_text' => 'what is a computer',
            'options' => [
                'A machine that processes data',
                'A type of food',
                'A type of vehicle',
                'A type of animal',
            ],
            'answer' => 'CORRECT_INTERNAL_ANSWER',
            'explanation' => 'This is the internal correct answer.',
            'marks' => 1,
            'difficulty' => 'medium',
            'status' => 'published',
        ]);
    }

    private function createPublishedTestWithQuestion(
        int $duration = 30
    ): Test {
        $test = Test::create([
            'title' => 'Computer Science Test',
            'instructions' => 'Answer all questions.',
            'duration' => $duration,
            'marks' => $this->question->marks,
            'status' => Test::STATUS_PUBLISHED,
            'published_at' => now(),
        ]);

        $test->questions()->attach(
            $this->question->id,
            [
                'sort_order' => 1,
                'marks' => $this->question->marks,
            ]
        );

        return $test;
    }

    private function createExpiredAttempt(
        User $user,
        Test $test
    ): TestAttempt {
        return TestAttempt::create([
            'test_id' => $test->id,
            'user_id' => $user->id,
            'started_at' => now()->subMinutes(31),
            'expires_at' => now()->subMinute(),
            'status' => TestAttempt::STATUS_IN_PROGRESS,
        ]);
    }

    public function test_guest_cannot_auto_submit_attempt(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = $this->createPublishedTestWithQuestion();

        $attempt = $this->createExpiredAttempt(
            $user,
            $test
        );

        $response = $this->post(
            route(
                'tests.attempts.auto-submit',
                $attempt
            )
        );

        $response->assertRedirect('/login');

        $this->assertDatabaseHas('test_attempts', [
            'id' => $attempt->id,
            'status' => TestAttempt::STATUS_IN_PROGRESS,
        ]);

        $this->assertDatabaseMissing('test_results', [
            'test_attempt_id' => $attempt->id,
        ]);
    }

    public function test_unverified_user_cannot_auto_submit_attempt(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $test = $this->createPublishedTestWithQuestion();

        $attempt = $this->createExpiredAttempt(
            $user,
            $test
        );

        $response = $this
            ->actingAs($user)
            ->post(
                route(
                    'tests.attempts.auto-submit',
                    $attempt
                )
            );

        $response->assertRedirect(
            route('verification.notice')
        );

        $this->assertDatabaseHas('test_attempts', [
            'id' => $attempt->id,
            'status' => TestAttempt::STATUS_IN_PROGRESS,
        ]);

        $this->assertDatabaseMissing('test_results', [
            'test_attempt_id' => $attempt->id,
        ]);
    }

    public function test_unexpired_attempt_cannot_be_auto_submitted(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = $this->createPublishedTestWithQuestion();

        $attempt = TestAttempt::create([
            'test_id' => $test->id,
            'user_id' => $user->id,
            'started_at' => now(),
            'expires_at' => now()->addMinutes(10),
            'status' => TestAttempt::STATUS_IN_PROGRESS,
        ]);

        $response = $this
            ->actingAs($user)
            ->postJson(
                route(
                    'tests.attempts.auto-submit',
                    $attempt
                )
            );

        $response->assertStatus(422);

        $response->assertJson([
            'success' => false,
            'status' => TestAttempt::STATUS_IN_PROGRESS,
        ]);

        $attempt->refresh();

        $this->assertEquals(
            TestAttempt::STATUS_IN_PROGRESS,
            $attempt->status
        );

        $this->assertNull(
            $attempt->submitted_at
        );

        $this->assertDatabaseMissing('test_results', [
            'test_attempt_id' => $attempt->id,
        ]);
    }

    public function test_expired_attempt_is_automatically_submitted(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = $this->createPublishedTestWithQuestion();

        $attempt = $this->createExpiredAttempt(
            $user,
            $test
        );

        $response = $this
            ->actingAs($user)
            ->postJson(
                route(
                    'tests.attempts.auto-submit',
                    $attempt
                )
            );

        $response->assertOk();

        $response->assertJson([
            'success' => true,
            'status' => TestAttempt::STATUS_SUBMITTED,
        ]);

        $response->assertJsonStructure([
            'success',
            'status',
            'message',
            'result_url',
        ]);

        $attempt->refresh();

        $this->assertEquals(
            TestAttempt::STATUS_SUBMITTED,
            $attempt->status
        );

        $this->assertNotNull(
            $attempt->submitted_at
        );

        $this->assertDatabaseHas('test_results', [
            'test_attempt_id' => $attempt->id,
            'test_id' => $test->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_auto_submission_calculates_result_from_saved_answers(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = $this->createPublishedTestWithQuestion();

        $attempt = $this->createExpiredAttempt(
            $user,
            $test
        );

        $attempt->answers()->create([
            'question_id' => $this->question->id,
            'answer' => 'CORRECT_INTERNAL_ANSWER',
            'answered_at' => now()->subMinute(),
        ]);

        $response = $this
            ->actingAs($user)
            ->postJson(
                route(
                    'tests.attempts.auto-submit',
                    $attempt
                )
            );

        $response->assertOk();

        $result = TestResult::where(
            'test_attempt_id',
            $attempt->id
        )->first();

        $this->assertNotNull($result);

        $this->assertEquals(
            1,
            $result->total_marks
        );

        $this->assertEquals(
            1,
            $result->obtained_marks
        );

        $this->assertEquals(
            100.00,
            (float) $result->percentage
        );

        $this->assertEquals(
            1,
            $result->correct_answers
        );

        $this->assertEquals(
            0,
            $result->wrong_answers
        );

        $this->assertEquals(
            0,
            $result->unanswered
        );
    }

    public function test_auto_submission_does_not_create_duplicate_result(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = $this->createPublishedTestWithQuestion();

        $attempt = $this->createExpiredAttempt(
            $user,
            $test
        );

        $firstResponse = $this
            ->actingAs($user)
            ->postJson(
                route(
                    'tests.attempts.auto-submit',
                    $attempt
                )
            );

        $firstResponse->assertOk();

        $secondResponse = $this
            ->actingAs($user)
            ->postJson(
                route(
                    'tests.attempts.auto-submit',
                    $attempt
                )
            );

        $secondResponse->assertOk();

        $this->assertEquals(
            1,
            TestResult::where(
                'test_attempt_id',
                $attempt->id
            )->count()
        );
    }

    public function test_auto_submission_cannot_submit_another_users_attempt(): void
    {
        $owner = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $otherUser = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = $this->createPublishedTestWithQuestion();

        $attempt = $this->createExpiredAttempt(
            $owner,
            $test
        );

        $response = $this
            ->actingAs($otherUser)
            ->postJson(
                route(
                    'tests.attempts.auto-submit',
                    $attempt
                )
            );

        $response->assertForbidden();

        $attempt->refresh();

        $this->assertEquals(
            TestAttempt::STATUS_IN_PROGRESS,
            $attempt->status
        );

        $this->assertDatabaseMissing('test_results', [
            'test_attempt_id' => $attempt->id,
        ]);
    }

    public function test_auto_submission_works_for_already_expired_attempt(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = $this->createPublishedTestWithQuestion();

        $attempt = TestAttempt::create([
            'test_id' => $test->id,
            'user_id' => $user->id,
            'started_at' => now()->subMinutes(31),
            'expires_at' => now()->subMinute(),
            'status' => TestAttempt::STATUS_EXPIRED,
        ]);

        $response = $this
            ->actingAs($user)
            ->postJson(
                route(
                    'tests.attempts.auto-submit',
                    $attempt
                )
            );

        $response->assertOk();

        $response->assertJson([
            'success' => true,
            'status' => TestAttempt::STATUS_SUBMITTED,
        ]);

        $attempt->refresh();

        $this->assertEquals(
            TestAttempt::STATUS_SUBMITTED,
            $attempt->status
        );

        $this->assertNotNull(
            $attempt->submitted_at
        );

        $this->assertDatabaseHas('test_results', [
            'test_attempt_id' => $attempt->id,
        ]);
    }

    public function test_auto_submission_uses_server_time_not_browser_claims(): void
    {
        Carbon::setTestNow(
            Carbon::create(
                2026,
                9,
                9,
                12,
                0,
                0
            )
        );

        try {
            $user = User::factory()->create([
                'email_verified_at' => now(),
            ]);

            $test = $this->createPublishedTestWithQuestion();

            $attempt = TestAttempt::create([
                'test_id' => $test->id,
                'user_id' => $user->id,
                'started_at' => now()->subMinutes(30),
                'expires_at' => now()->subSecond(),
                'status' => TestAttempt::STATUS_IN_PROGRESS,
            ]);

            $response = $this
                ->actingAs($user)
                ->postJson(
                    route(
                        'tests.attempts.auto-submit',
                        $attempt
                    )
                );

            $response->assertOk();

            $attempt->refresh();

            $this->assertEquals(
                TestAttempt::STATUS_SUBMITTED,
                $attempt->status
            );

            $this->assertNotNull(
                $attempt->submitted_at
            );

            $this->assertEquals(
                '2026-09-09 12:00:00',
                $attempt->submitted_at->format(
                    'Y-m-d H:i:s'
                )
            );
        } finally {
            Carbon::setTestNow();
        }
    }
}