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
use App\Models\TestAttemptAnswer;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TestAttemptAnswerTest extends TestCase
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

    private function createPublishedTest(): Test
    {
        $test = Test::create([
            'title' => 'Computer Science Test',
            'instructions' => 'Answer all questions.',
            'duration' => 30,
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

    private function createAttempt(
        User $user,
        ?Test $test = null
    ): TestAttempt {
        $test ??= $this->createPublishedTest();

        $startedAt = now();

        return TestAttempt::create([
            'test_id' => $test->id,
            'user_id' => $user->id,
            'started_at' => $startedAt,
            'expires_at' => $startedAt->copy()->addMinutes(
                $test->duration
            ),
            'status' => TestAttempt::STATUS_IN_PROGRESS,
        ]);
    }

    public function test_guest_cannot_submit_answer(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $attempt = $this->createAttempt($user);

        $response = $this->post(
            route(
                'tests.attempts.answers.store',
                [
                    'attempt' => $attempt->id,
                    'question' => $this->question->id,
                ]
            ),
            [
                'answer' => 'A machine that processes data',
            ]
        );

        $response->assertRedirect('/login');

        $this->assertDatabaseCount(
            'test_attempt_answers',
            0
        );
    }

    public function test_unverified_user_cannot_submit_answer(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $attempt = $this->createAttempt($user);

        $response = $this
            ->actingAs($user)
            ->post(
                route(
                    'tests.attempts.answers.store',
                    [
                        'attempt' => $attempt->id,
                        'question' => $this->question->id,
                    ]
                ),
                [
                    'answer' =>
                        'A machine that processes data',
                ]
            );

        $response->assertRedirect(
            route('verification.notice')
        );

        $this->assertDatabaseCount(
            'test_attempt_answers',
            0
        );
    }

    public function test_verified_user_can_save_answer(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $attempt = $this->createAttempt($user);

        $response = $this
            ->actingAs($user)
            ->post(
                route(
                    'tests.attempts.answers.store',
                    [
                        'attempt' => $attempt->id,
                        'question' => $this->question->id,
                    ]
                ),
                [
                    'answer' =>
                        'A machine that processes data',
                ]
            );

        $response->assertRedirect();

        $response->assertSessionHas(
            'status',
            'Answer saved successfully.'
        );

        $this->assertDatabaseHas(
            'test_attempt_answers',
            [
                'test_attempt_id' => $attempt->id,
                'question_id' => $this->question->id,
                'answer' =>
                    'A machine that processes data',
            ]
        );
    }

    public function test_answer_is_bound_to_correct_attempt_and_question(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $attempt = $this->createAttempt($user);

        $this
            ->actingAs($user)
            ->post(
                route(
                    'tests.attempts.answers.store',
                    [
                        'attempt' => $attempt->id,
                        'question' => $this->question->id,
                    ]
                ),
                [
                    'answer' => 'My submitted answer',
                ]
            );

        $answer = TestAttemptAnswer::query()->first();

        $this->assertNotNull($answer);

        $this->assertEquals(
            $attempt->id,
            $answer->test_attempt_id
        );

        $this->assertEquals(
            $this->question->id,
            $answer->question_id
        );

        $this->assertEquals(
            'My submitted answer',
            $answer->answer
        );
    }

    public function test_existing_answer_is_updated_instead_of_creating_duplicate(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $attempt = $this->createAttempt($user);

        $route = route(
            'tests.attempts.answers.store',
            [
                'attempt' => $attempt->id,
                'question' => $this->question->id,
            ]
        );

        $this
            ->actingAs($user)
            ->post(
                $route,
                [
                    'answer' => 'First answer',
                ]
            );

        $firstAnswer = TestAttemptAnswer::query()
            ->where('test_attempt_id', $attempt->id)
            ->where('question_id', $this->question->id)
            ->first();

        $this->assertNotNull($firstAnswer);

        $firstAnswerId = $firstAnswer->id;

        $this
            ->actingAs($user)
            ->post(
                $route,
                [
                    'answer' => 'Updated answer',
                ]
            );

        $this->assertDatabaseCount(
            'test_attempt_answers',
            1
        );

        $this->assertDatabaseHas(
            'test_attempt_answers',
            [
                'id' => $firstAnswerId,
                'test_attempt_id' => $attempt->id,
                'question_id' => $this->question->id,
                'answer' => 'Updated answer',
            ]
        );
    }

    public function test_answer_timestamp_is_recorded(): void
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

            $attempt = $this->createAttempt($user);

            $this
                ->actingAs($user)
                ->post(
                    route(
                        'tests.attempts.answers.store',
                        [
                            'attempt' => $attempt->id,
                            'question' =>
                                $this->question->id,
                        ]
                    ),
                    [
                        'answer' => 'Timestamp test',
                    ]
                );

            $answer = TestAttemptAnswer::query()
                ->where(
                    'test_attempt_id',
                    $attempt->id
                )
                ->where(
                    'question_id',
                    $this->question->id
                )
                ->first();

            $this->assertNotNull($answer);

            $this->assertEquals(
                '2026-09-09 12:00:00',
                $answer->answered_at->format(
                    'Y-m-d H:i:s'
                )
            );
        } finally {
            Carbon::setTestNow();
        }
    }

    public function test_user_cannot_submit_answer_to_another_users_attempt(): void
    {
        $attemptOwner = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $otherUser = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $attempt = $this->createAttempt(
            $attemptOwner
        );

        $response = $this
            ->actingAs($otherUser)
            ->post(
                route(
                    'tests.attempts.answers.store',
                    [
                        'attempt' => $attempt->id,
                        'question' =>
                            $this->question->id,
                    ]
                ),
                [
                    'answer' =>
                        'Unauthorized answer',
                ]
            );

        $response->assertForbidden();

        $this->assertDatabaseCount(
            'test_attempt_answers',
            0
        );
    }

    public function test_answer_cannot_be_submitted_for_question_not_in_test(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = $this->createPublishedTest();

        $otherQuestion = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'What is RAM?',
            'normalized_text' => 'what is ram',
            'options' => [
                'Random Access Memory',
                'Read Only Memory',
                'Central Processing Unit',
                'Hard Disk',
            ],
            'answer' => 'CORRECT_RAM_ANSWER',
            'explanation' => 'RAM is Random Access Memory.',
            'marks' => 1,
            'difficulty' => 'easy',
            'status' => 'published',
        ]);

        $attempt = $this->createAttempt(
            $user,
            $test
        );

        $response = $this
            ->actingAs($user)
            ->post(
                route(
                    'tests.attempts.answers.store',
                    [
                        'attempt' => $attempt->id,
                        'question' =>
                            $otherQuestion->id,
                    ]
                ),
                [
                    'answer' => 'Invalid question answer',
                ]
            );

        $response->assertNotFound();

        $this->assertDatabaseCount(
            'test_attempt_answers',
            0
        );
    }

    public function test_answer_cannot_be_saved_to_submitted_attempt(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $attempt = $this->createAttempt($user);

        $attempt->update([
            'status' =>
                TestAttempt::STATUS_SUBMITTED,
        ]);

        $response = $this
            ->actingAs($user)
            ->post(
                route(
                    'tests.attempts.answers.store',
                    [
                        'attempt' => $attempt->id,
                        'question' =>
                            $this->question->id,
                    ]
                ),
                [
                    'answer' => 'Late answer',
                ]
            );

        $response->assertRedirect();

        $response->assertSessionHasErrors(
            'answer'
        );

        $this->assertDatabaseCount(
            'test_attempt_answers',
            0
        );
    }

    public function test_answer_cannot_be_saved_to_expired_attempt_status(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $attempt = $this->createAttempt($user);

        $attempt->update([
            'status' =>
                TestAttempt::STATUS_EXPIRED,
        ]);

        $response = $this
            ->actingAs($user)
            ->post(
                route(
                    'tests.attempts.answers.store',
                    [
                        'attempt' => $attempt->id,
                        'question' =>
                            $this->question->id,
                    ]
                ),
                [
                    'answer' => 'Expired attempt answer',
                ]
            );

        $response->assertRedirect();

        $response->assertSessionHasErrors(
            'answer'
        );

        $this->assertDatabaseCount(
            'test_attempt_answers',
            0
        );
    }

    public function test_answer_is_validated_as_string(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $attempt = $this->createAttempt($user);

        $response = $this
            ->actingAs($user)
            ->post(
                route(
                    'tests.attempts.answers.store',
                    [
                        'attempt' => $attempt->id,
                        'question' =>
                            $this->question->id,
                    ]
                ),
                [
                    'answer' => [
                        'invalid',
                        'array',
                    ],
                ]
            );

        $response->assertSessionHasErrors(
            'answer'
        );

        $this->assertDatabaseCount(
            'test_attempt_answers',
            0
        );
    }

    public function test_answer_length_cannot_exceed_10000_characters(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $attempt = $this->createAttempt($user);

        $response = $this
            ->actingAs($user)
            ->post(
                route(
                    'tests.attempts.answers.store',
                    [
                        'attempt' => $attempt->id,
                        'question' =>
                            $this->question->id,
                    ]
                ),
                [
                    'answer' => str_repeat(
                        'A',
                        10001
                    ),
                ]
            );

        $response->assertSessionHasErrors(
            'answer'
        );

        $this->assertDatabaseCount(
            'test_attempt_answers',
            0
        );
    }

    public function test_empty_answer_can_be_saved(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $attempt = $this->createAttempt($user);

        $response = $this
            ->actingAs($user)
            ->post(
                route(
                    'tests.attempts.answers.store',
                    [
                        'attempt' => $attempt->id,
                        'question' =>
                            $this->question->id,
                    ]
                ),
                [
                    'answer' => null,
                ]
            );

        $response->assertRedirect();

        $this->assertDatabaseHas(
            'test_attempt_answers',
            [
                'test_attempt_id' => $attempt->id,
                'question_id' => $this->question->id,
                'answer' => null,
            ]
        );
    }

    public function test_test_attempt_answers_relationship_returns_saved_answers(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $attempt = $this->createAttempt($user);

        $this
            ->actingAs($user)
            ->post(
                route(
                    'tests.attempts.answers.store',
                    [
                        'attempt' => $attempt->id,
                        'question' =>
                            $this->question->id,
                    ]
                ),
                [
                    'answer' => 'Relationship test',
                ]
            );

        $attempt->refresh();

        $this->assertCount(
            1,
            $attempt->answers
        );

        $this->assertEquals(
            'Relationship test',
            $attempt->answers->first()->answer
        );
    }

    public function test_question_attempt_answers_relationship_returns_saved_answer(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $attempt = $this->createAttempt($user);

        $this
            ->actingAs($user)
            ->post(
                route(
                    'tests.attempts.answers.store',
                    [
                        'attempt' => $attempt->id,
                        'question' =>
                            $this->question->id,
                    ]
                ),
                [
                    'answer' => 'Question relationship test',
                ]
            );

        $this->question->refresh();

        $this->assertCount(
            1,
            $this->question->attemptAnswers
        );

        $this->assertEquals(
            $attempt->id,
            $this->question
                ->attemptAnswers
                ->first()
                ->test_attempt_id
        );
    }
}