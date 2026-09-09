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
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TestAttemptTest extends TestCase
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

    public function test_guest_cannot_start_test_attempt(): void
    {
        $test = $this->createPublishedTestWithQuestion();

        $response = $this->get(
            route('tests.start', $test)
        );

        $response->assertRedirect('/login');
    }

    public function test_unverified_user_cannot_start_test_attempt(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $test = $this->createPublishedTestWithQuestion();

        $response = $this
            ->actingAs($user)
            ->get(route('tests.start', $test));

        $response->assertRedirect(
            route('verification.notice')
        );
    }

    public function test_published_test_can_be_started_by_verified_user(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = $this->createPublishedTestWithQuestion();

        $response = $this
            ->actingAs($user)
            ->get(route('tests.start', $test));

        $response->assertStatus(200);

        $response->assertViewIs(
            'tests.attempts.show'
        );

        $response->assertViewHas(
            'test',
            $test
        );

        $response->assertViewHas('attempt');

        $response->assertViewHas('questions');

        $response->assertSee(
            $this->question->question_text
        );
    }

    public function test_starting_published_test_creates_attempt(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = $this->createPublishedTestWithQuestion();

        $this
            ->actingAs($user)
            ->get(route('tests.start', $test));

        $this->assertDatabaseHas('test_attempts', [
            'test_id' => $test->id,
            'user_id' => $user->id,
            'status' => TestAttempt::STATUS_IN_PROGRESS,
        ]);
    }

    public function test_attempt_stores_correct_start_and_expiry_times(): void
    {
        Carbon::setTestNow(
            Carbon::create(
                2026,
                9,
                9,
                11,
                0,
                0
            )
        );

        try {
            $user = User::factory()->create([
                'email_verified_at' => now(),
            ]);

            $test = $this->createPublishedTestWithQuestion(
                30
            );

            $this
                ->actingAs($user)
                ->get(route('tests.start', $test));

            $attempt = TestAttempt::query()
                ->where('test_id', $test->id)
                ->where('user_id', $user->id)
                ->first();

            $this->assertNotNull($attempt);

            $this->assertEquals(
                '2026-09-09 11:00:00',
                $attempt->started_at->format(
                    'Y-m-d H:i:s'
                )
            );

            $this->assertEquals(
                '2026-09-09 11:30:00',
                $attempt->expires_at->format(
                    'Y-m-d H:i:s'
                )
            );
        } finally {
            Carbon::setTestNow();
        }
    }

    public function test_new_attempt_has_in_progress_status(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = $this->createPublishedTestWithQuestion();

        $this
            ->actingAs($user)
            ->get(route('tests.start', $test));

        $attempt = TestAttempt::query()
            ->where('test_id', $test->id)
            ->where('user_id', $user->id)
            ->first();

        $this->assertNotNull($attempt);

        $this->assertEquals(
            TestAttempt::STATUS_IN_PROGRESS,
            $attempt->status
        );
    }

    public function test_draft_test_cannot_be_started(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = Test::create([
            'title' => 'Draft Test',
            'instructions' => 'Draft test.',
            'duration' => 30,
            'marks' => 1,
            'status' => Test::STATUS_DRAFT,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('tests.start', $test));

        $response->assertForbidden();

        $this->assertDatabaseMissing(
            'test_attempts',
            [
                'test_id' => $test->id,
                'user_id' => $user->id,
            ]
        );
    }

    public function test_archived_test_cannot_be_started(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = Test::create([
            'title' => 'Archived Test',
            'instructions' => 'Archived test.',
            'duration' => 30,
            'marks' => 1,
            'status' => Test::STATUS_ARCHIVED,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('tests.start', $test));

        $response->assertForbidden();

        $this->assertDatabaseMissing(
            'test_attempts',
            [
                'test_id' => $test->id,
                'user_id' => $user->id,
            ]
        );
    }

    public function test_test_without_questions_cannot_be_started(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = Test::create([
            'title' => 'Empty Test',
            'instructions' => 'This test has no questions.',
            'duration' => 30,
            'marks' => 0,
            'status' => Test::STATUS_PUBLISHED,
            'published_at' => now(),
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('tests.start', $test));

        $response->assertStatus(422);

        $this->assertDatabaseMissing(
            'test_attempts',
            [
                'test_id' => $test->id,
                'user_id' => $user->id,
            ]
        );
    }

    public function test_non_existing_test_returns_404(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/tests/999999/start');

        $response->assertNotFound();
    }

    public function test_attempt_is_bound_to_authenticated_user_and_test(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = $this->createPublishedTestWithQuestion();

        $this
            ->actingAs($user)
            ->get(route('tests.start', $test));

        $attempt = TestAttempt::query()->first();

        $this->assertNotNull($attempt);

        $this->assertEquals(
            $user->id,
            $attempt->user_id
        );

        $this->assertEquals(
            $test->id,
            $attempt->test_id
        );
    }

    public function test_correct_answer_and_explanation_are_not_exposed(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = $this->createPublishedTestWithQuestion();

        $response = $this
            ->actingAs($user)
            ->get(route('tests.start', $test));

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
