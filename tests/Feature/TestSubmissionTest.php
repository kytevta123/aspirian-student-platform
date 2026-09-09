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

class TestSubmissionTest extends TestCase
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

    private function createInProgressAttempt(
        User $user,
        Test $test,
        int $minutesRemaining = 30
    ): TestAttempt {
        $startedAt = now();

        return TestAttempt::create([
            'test_id' => $test->id,
            'user_id' => $user->id,
            'started_at' => $startedAt,
            'expires_at' => $startedAt->copy()->addMinutes(
                $minutesRemaining
            ),
            'status' => TestAttempt::STATUS_IN_PROGRESS,
        ]);
    }

    public function test_guest_cannot_submit_test_attempt(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = $this->createPublishedTestWithQuestion();

        $attempt = $this->createInProgressAttempt(
            $user,
            $test
        );

        $response = $this->post(
            route(
                'tests.attempts.submit',
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

    public function test_unverified_user_cannot_submit_test_attempt(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $test = $this->createPublishedTestWithQuestion();

        $attempt = $this->createInProgressAttempt(
            $user,
            $test
        );

        $response = $this
            ->actingAs($user)
            ->post(
                route(
                    'tests.attempts.submit',
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

    public function test_verified_user_can_submit_own_in_progress_attempt(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = $this->createPublishedTestWithQuestion();

        $attempt = $this->createInProgressAttempt(
            $user,
            $test
        );

        $response = $this
            ->actingAs($user)
            ->post(
                route(
                    'tests.attempts.submit',
                    $attempt
                )
            );

        $attempt->refresh();

        $result = TestResult::where(
            'test_attempt_id',
            $attempt->id
        )->first();

        $this->assertNotNull($result);

        $response->assertRedirect(
            route(
                'tests.results.show',
                $result
            )
        );

        $response->assertSessionHas(
            'status',
            'Test submitted successfully.'
        );

        $this->assertDatabaseHas('test_attempts', [
            'id' => $attempt->id,
            'user_id' => $user->id,
            'test_id' => $test->id,
            'status' => TestAttempt::STATUS_SUBMITTED,
        ]);

        $this->assertDatabaseHas('test_results', [
            'test_attempt_id' => $attempt->id,
            'test_id' => $test->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_submission_sets_submitted_at_timestamp(): void
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

            $attempt = $this->createInProgressAttempt(
                $user,
                $test
            );

            $this
                ->actingAs($user)
                ->post(
                    route(
                        'tests.attempts.submit',
                        $attempt
                    )
                );

            $attempt->refresh();

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

    public function test_submitted_attempt_cannot_be_submitted_again(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = $this->createPublishedTestWithQuestion();

        $attempt = $this->createInProgressAttempt(
            $user,
            $test
        );

        $this
            ->actingAs($user)
            ->post(
                route(
                    'tests.attempts.submit',
                    $attempt
                )
            );

        $attempt->refresh();

        $originalSubmittedAt = $attempt->submitted_at;

        $resultCount = TestResult::where(
            'test_attempt_id',
            $attempt->id
        )->count();

        $this->assertSame(1, $resultCount);

        $response = $this
            ->actingAs($user)
            ->post(
                route(
                    'tests.attempts.submit',
                    $attempt
                )
            );

        $response->assertSessionHasErrors([
            'submission',
        ]);

        $attempt->refresh();

        $this->assertEquals(
            TestAttempt::STATUS_SUBMITTED,
            $attempt->status
        );

        $this->assertEquals(
            $originalSubmittedAt?->format(
                'Y-m-d H:i:s'
            ),
            $attempt->submitted_at?->format(
                'Y-m-d H:i:s'
            )
        );

        $this->assertSame(
            1,
            TestResult::where(
                'test_attempt_id',
                $attempt->id
            )->count()
        );
    }

    public function test_expired_attempt_cannot_be_submitted(): void
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
            'status' => TestAttempt::STATUS_IN_PROGRESS,
        ]);

        $response = $this
            ->actingAs($user)
            ->post(
                route(
                    'tests.attempts.submit',
                    $attempt
                )
            );

        $response->assertSessionHasErrors([
            'submission',
        ]);

        $attempt->refresh();

        $this->assertEquals(
            TestAttempt::STATUS_EXPIRED,
            $attempt->status
        );

        $this->assertNull(
            $attempt->submitted_at
        );

        $this->assertDatabaseMissing('test_results', [
            'test_attempt_id' => $attempt->id,
        ]);
    }

    public function test_already_expired_attempt_cannot_be_submitted(): void
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
            ->post(
                route(
                    'tests.attempts.submit',
                    $attempt
                )
            );

        $response->assertSessionHasErrors([
            'submission',
        ]);

        $attempt->refresh();

        $this->assertEquals(
            TestAttempt::STATUS_EXPIRED,
            $attempt->status
        );

        $this->assertNull(
            $attempt->submitted_at
        );

        $this->assertDatabaseMissing('test_results', [
            'test_attempt_id' => $attempt->id,
        ]);
    }

    public function test_user_cannot_submit_another_users_attempt(): void
    {
        $owner = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $otherUser = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = $this->createPublishedTestWithQuestion();

        $attempt = $this->createInProgressAttempt(
            $owner,
            $test
        );

        $response = $this
            ->actingAs($otherUser)
            ->post(
                route(
                    'tests.attempts.submit',
                    $attempt
                )
            );

        $response->assertForbidden();

        $this->assertDatabaseHas('test_attempts', [
            'id' => $attempt->id,
            'user_id' => $owner->id,
            'status' => TestAttempt::STATUS_IN_PROGRESS,
        ]);

        $this->assertDatabaseMissing('test_results', [
            'test_attempt_id' => $attempt->id,
        ]);
    }

    public function test_submitted_attempt_can_be_viewed_by_owner(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = $this->createPublishedTestWithQuestion();

        $attempt = $this->createInProgressAttempt(
            $user,
            $test
        );

        $this
            ->actingAs($user)
            ->post(
                route(
                    'tests.attempts.submit',
                    $attempt
                )
            );

        $response = $this
            ->actingAs($user)
            ->get(
                route(
                    'tests.attempts.show',
                    $attempt
                )
            );

        $response->assertStatus(200);

        $response->assertViewIs(
            'tests.attempts.show'
        );

        $response->assertSee(
            'Test Submitted'
        );
    }

    public function test_user_cannot_view_another_users_attempt(): void
    {
        $owner = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $otherUser = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = $this->createPublishedTestWithQuestion();

        $attempt = $this->createInProgressAttempt(
            $owner,
            $test
        );

        $response = $this
            ->actingAs($otherUser)
            ->get(
                route(
                    'tests.attempts.show',
                    $attempt
                )
            );

        $response->assertForbidden();
    }

    public function test_viewing_existing_attempt_does_not_create_new_attempt(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = $this->createPublishedTestWithQuestion();

        $attempt = $this->createInProgressAttempt(
            $user,
            $test
        );

        $beforeCount = TestAttempt::query()
            ->where('user_id', $user->id)
            ->where('test_id', $test->id)
            ->count();

        $response = $this
            ->actingAs($user)
            ->get(
                route(
                    'tests.attempts.show',
                    $attempt
                )
            );

        $response->assertStatus(200);

        $afterCount = TestAttempt::query()
            ->where('user_id', $user->id)
            ->where('test_id', $test->id)
            ->count();

        $this->assertEquals(
            $beforeCount,
            $afterCount
        );
    }

    public function test_submission_does_not_expose_correct_answer_or_explanation(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = $this->createPublishedTestWithQuestion();

        $attempt = $this->createInProgressAttempt(
            $user,
            $test
        );

        $this
            ->actingAs($user)
            ->post(
                route(
                    'tests.attempts.submit',
                    $attempt
                )
            );

        $response = $this
            ->actingAs($user)
            ->get(
                route(
                    'tests.attempts.show',
                    $attempt
                )
            );

        $response->assertStatus(200);

        $response->assertSee(
            $this->question->question_text
        );

        $response->assertDontSee(
            'CORRECT_INTERNAL_ANSWER'
        );

        $response->assertDontSee(
            'This is the internal correct answer.'
        );
    }
}