<?php

namespace Tests\Feature;

use App\Models\AcademicSession;
use App\Models\Board;
use App\Models\Chapter;
use App\Models\EducationSystem;
use App\Models\Grade;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Test;
use App\Models\TestAttempt;
use App\Models\TestAttemptAnswer;
use App\Models\TestResult;
use App\Models\Topic;
use App\Models\User;
use App\Services\TestResultService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RuntimeException;
use Tests\TestCase;

class TestResultServiceTest extends TestCase
{
    use RefreshDatabase;

    private TestResultService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(TestResultService::class);
    }

    public function test_it_calculates_correct_wrong_and_unanswered_answers(): void
    {
        $user = User::factory()->create();

        $test = $this->createTest();

        $topic = $this->createTopic();

        $questionOne = $this->createQuestion(
            $topic,
            'Question One',
            'A',
            2
        );

        $questionTwo = $this->createQuestion(
            $topic,
            'Question Two',
            'B',
            3
        );

        $questionThree = $this->createQuestion(
            $topic,
            'Question Three',
            'C',
            5
        );

        $test->questions()->attach(
            $questionOne->id,
            [
                'sort_order' => 1,
                'marks' => 2,
            ]
        );

        $test->questions()->attach(
            $questionTwo->id,
            [
                'sort_order' => 2,
                'marks' => 3,
            ]
        );

        $test->questions()->attach(
            $questionThree->id,
            [
                'sort_order' => 3,
                'marks' => 5,
            ]
        );

        $attempt = $this->createSubmittedAttempt(
            $test,
            $user
        );

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $questionOne->id,
            'answer' => 'A',
            'answered_at' => now(),
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $questionTwo->id,
            'answer' => 'A',
            'answered_at' => now(),
        ]);

        $result = $this->service->calculate($attempt);

        $this->assertSame(10, $result->total_marks);
        $this->assertSame(2, $result->obtained_marks);
        $this->assertSame(1, $result->correct_answers);
        $this->assertSame(1, $result->wrong_answers);
        $this->assertSame(1, $result->unanswered);
        $this->assertSame(
            '20.00',
            $result->percentage
        );
        $this->assertTrue($result->isFailed());
    }

    public function test_it_marks_result_as_passed_at_forty_percent(): void
    {
        $user = User::factory()->create();

        $test = $this->createTest();

        $topic = $this->createTopic();

        $questionOne = $this->createQuestion(
            $topic,
            'Question One',
            'A',
            4
        );

        $questionTwo = $this->createQuestion(
            $topic,
            'Question Two',
            'B',
            6
        );

        $test->questions()->attach(
            $questionOne->id,
            [
                'sort_order' => 1,
                'marks' => 4,
            ]
        );

        $test->questions()->attach(
            $questionTwo->id,
            [
                'sort_order' => 2,
                'marks' => 6,
            ]
        );

        $attempt = $this->createSubmittedAttempt(
            $test,
            $user
        );

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $questionOne->id,
            'answer' => 'A',
            'answered_at' => now(),
        ]);

        $result = $this->service->calculate($attempt);

        $this->assertSame(10, $result->total_marks);
        $this->assertSame(4, $result->obtained_marks);
        $this->assertSame(
            '40.00',
            $result->percentage
        );
        $this->assertTrue($result->isPassed());
    }

    public function test_it_treats_empty_answers_as_unanswered(): void
    {
        $user = User::factory()->create();

        $test = $this->createTest();

        $topic = $this->createTopic();

        $question = $this->createQuestion(
            $topic,
            'Question One',
            'A',
            5
        );

        $test->questions()->attach(
            $question->id,
            [
                'sort_order' => 1,
                'marks' => 5,
            ]
        );

        $attempt = $this->createSubmittedAttempt(
            $test,
            $user
        );

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $question->id,
            'answer' => '   ',
            'answered_at' => now(),
        ]);

        $result = $this->service->calculate($attempt);

        $this->assertSame(5, $result->total_marks);
        $this->assertSame(0, $result->obtained_marks);
        $this->assertSame(0, $result->correct_answers);
        $this->assertSame(0, $result->wrong_answers);
        $this->assertSame(1, $result->unanswered);
        $this->assertSame(
            '0.00',
            $result->percentage
        );
        $this->assertTrue($result->isFailed());
    }

    public function test_it_compares_answers_without_case_sensitivity_or_extra_spaces(): void
    {
        $user = User::factory()->create();

        $test = $this->createTest();

        $topic = $this->createTopic();

        $question = $this->createQuestion(
            $topic,
            'Question One',
            'A',
            5
        );

        $test->questions()->attach(
            $question->id,
            [
                'sort_order' => 1,
                'marks' => 5,
            ]
        );

        $attempt = $this->createSubmittedAttempt(
            $test,
            $user
        );

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $question->id,
            'answer' => '  a  ',
            'answered_at' => now(),
        ]);

        $result = $this->service->calculate($attempt);

        $this->assertSame(5, $result->obtained_marks);
        $this->assertSame(1, $result->correct_answers);
        $this->assertSame(0, $result->wrong_answers);
        $this->assertSame(0, $result->unanswered);
        $this->assertSame(
            '100.00',
            $result->percentage
        );
        $this->assertTrue($result->isPassed());
    }

    public function test_it_returns_existing_result_instead_of_creating_duplicate(): void
    {
        $user = User::factory()->create();

        $test = $this->createTest();

        $topic = $this->createTopic();

        $question = $this->createQuestion(
            $topic,
            'Question One',
            'A',
            5
        );

        $test->questions()->attach(
            $question->id,
            [
                'sort_order' => 1,
                'marks' => 5,
            ]
        );

        $attempt = $this->createSubmittedAttempt(
            $test,
            $user
        );

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $question->id,
            'answer' => 'A',
            'answered_at' => now(),
        ]);

        $firstResult = $this->service->calculate(
            $attempt
        );

        $secondResult = $this->service->calculate(
            $attempt->fresh()
        );

        $this->assertSame(
            $firstResult->id,
            $secondResult->id
        );

        $this->assertDatabaseCount(
            'test_results',
            1
        );
    }

    public function test_it_rejects_unsubmitted_attempt(): void
    {
        $user = User::factory()->create();

        $test = $this->createTest();

        $attempt = TestAttempt::create([
            'test_id' => $test->id,
            'user_id' => $user->id,
            'started_at' => now(),
            'expires_at' => now()->addMinutes(30),
            'status' => TestAttempt::STATUS_IN_PROGRESS,
        ]);

        $this->expectException(RuntimeException::class);

        $this->service->calculate($attempt);
    }

    private function createTest(int $marks = 10): Test
    {
        return Test::create([
            'title' => 'Result Calculation Test',
            'instructions' => 'Answer all questions.',
            'duration' => 30,
            'marks' => $marks,
            'status' => Test::STATUS_PUBLISHED,
            'published_at' => now(),
        ]);
    }

    private function createTopic(): Topic
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
            'description' => 'Test subject for result calculation.',
            'status' => 'active',
        ]);

        $academicSession = AcademicSession::create([
            'name' => '2026-27',
            'start_date' => '2026-08-01',
            'end_date' => '2027-07-31',
            'status' => 'active',
        ]);

        $book = \App\Models\Book::create([
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
            'description' => 'Test chapter for result calculation.',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        return Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Test Result Topic',
            'description' => 'Test topic for result calculation.',
            'sort_order' => 1,
            'status' => 'active',
        ]);
    }

    private function createQuestion(
        Topic $topic,
        string $text,
        string $answer,
        int $marks
    ): Question {
        return Question::create([
            'topic_id' => $topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => $text,
            'normalized_text' => strtolower($text),
            'answer' => $answer,
            'marks' => $marks,
            'difficulty' => 'medium',
            'status' => 'published',
        ]);
    }

    private function createSubmittedAttempt(
        Test $test,
        User $user
    ): TestAttempt {
        return TestAttempt::create([
            'test_id' => $test->id,
            'user_id' => $user->id,
            'started_at' => now()->subMinutes(5),
            'expires_at' => now()->addMinutes(25),
            'submitted_at' => now(),
            'status' => TestAttempt::STATUS_SUBMITTED,
        ]);
    }
}