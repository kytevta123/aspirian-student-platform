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
use App\Models\TestAttempt;
use App\Models\TestAttemptAnswer;
use App\Models\Topic;
use App\Models\User;
use App\Services\WeakTopicDetectionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeakTopicDetectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_calculates_topic_performance(): void
    {
        $user = User::factory()->create();

        $topic = $this->createTopic('Computer Basics');

        $questions = Question::factory()
            ->count(5)
            ->create([
                'topic_id' => $topic->id,
                'answer' => 'A',
            ]);

        $attempt = TestAttempt::factory()->create([
            'user_id' => $user->id,
            'status' => TestAttempt::STATUS_SUBMITTED,
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $questions[0]->id,
            'answer' => 'A',
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $questions[1]->id,
            'answer' => 'A',
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $questions[2]->id,
            'answer' => 'B',
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $questions[3]->id,
            'answer' => '',
        ]);

        $result = app(WeakTopicDetectionService::class)
            ->detectForUser($user->id);

        $topicResult = $result->first();

        $this->assertNotNull($topicResult);
        $this->assertSame($topic->id, $topicResult['topic_id']);
        $this->assertSame(4, $topicResult['total_questions']);
        $this->assertSame(2, $topicResult['correct_answers']);
        $this->assertSame(1, $topicResult['wrong_answers']);
        $this->assertSame(1, $topicResult['unanswered']);
        $this->assertSame(3, $topicResult['attempted_questions']);
        $this->assertSame(66.67, $topicResult['percentage']);
        $this->assertFalse($topicResult['is_weak']);
    }

    public function test_topic_below_forty_percent_is_weak(): void
    {
        $user = User::factory()->create();

        $topic = $this->createTopic('Weak Topic');

        $questions = Question::factory()
            ->count(5)
            ->create([
                'topic_id' => $topic->id,
                'answer' => 'A',
            ]);

        $attempt = TestAttempt::factory()->create([
            'user_id' => $user->id,
            'status' => TestAttempt::STATUS_SUBMITTED,
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $questions[0]->id,
            'answer' => 'A',
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $questions[1]->id,
            'answer' => 'B',
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $questions[2]->id,
            'answer' => 'B',
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $questions[3]->id,
            'answer' => 'B',
        ]);

        $result = app(WeakTopicDetectionService::class)
            ->weakTopicsForUser($user->id);

        $topicResult = $result->first();

        $this->assertNotNull($topicResult);
        $this->assertSame($topic->id, $topicResult['topic_id']);
        $this->assertSame(25.0, $topicResult['percentage']);
        $this->assertTrue($topicResult['is_weak']);
    }

    public function test_topic_at_forty_percent_is_not_weak(): void
    {
        $user = User::factory()->create();

        $topic = $this->createTopic('Boundary Topic');

        $questions = Question::factory()
            ->count(5)
            ->create([
                'topic_id' => $topic->id,
                'answer' => 'A',
            ]);

        $attempt = TestAttempt::factory()->create([
            'user_id' => $user->id,
            'status' => TestAttempt::STATUS_SUBMITTED,
        ]);

        for ($index = 0; $index < 2; $index++) {
            TestAttemptAnswer::create([
                'test_attempt_id' => $attempt->id,
                'question_id' => $questions[$index]->id,
                'answer' => 'A',
            ]);
        }

        for ($index = 2; $index < 5; $index++) {
            TestAttemptAnswer::create([
                'test_attempt_id' => $attempt->id,
                'question_id' => $questions[$index]->id,
                'answer' => 'B',
            ]);
        }

        $result = app(WeakTopicDetectionService::class)
            ->detectForUser($user->id);

        $topicResult = $result->first();

        $this->assertNotNull($topicResult);
        $this->assertSame(40.0, $topicResult['percentage']);
        $this->assertFalse($topicResult['is_weak']);
    }

    public function test_different_topics_are_calculated_separately(): void
    {
        $user = User::factory()->create();

        $strongTopic = $this->createTopic('Strong Topic');
        $weakTopic = $this->createTopic(
            'Weak Topic',
            $strongTopic->chapter_id
        );

        $strongQuestion = Question::factory()->create([
            'topic_id' => $strongTopic->id,
            'answer' => 'A',
        ]);

        $weakQuestion = Question::factory()->create([
            'topic_id' => $weakTopic->id,
            'answer' => 'A',
        ]);

        $attempt = TestAttempt::factory()->create([
            'user_id' => $user->id,
            'status' => TestAttempt::STATUS_SUBMITTED,
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $strongQuestion->id,
            'answer' => 'A',
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $weakQuestion->id,
            'answer' => 'B',
        ]);

        $result = app(WeakTopicDetectionService::class)
            ->detectForUser($user->id);

        $this->assertCount(2, $result);

        $weakResult = $result
            ->firstWhere('topic_id', $weakTopic->id);

        $strongResult = $result
            ->firstWhere('topic_id', $strongTopic->id);

        $this->assertSame(0.0, $weakResult['percentage']);
        $this->assertTrue($weakResult['is_weak']);

        $this->assertSame(100.0, $strongResult['percentage']);
        $this->assertFalse($strongResult['is_weak']);
    }

    public function test_unanswered_questions_do_not_reduce_attempted_percentage(): void
    {
        $user = User::factory()->create();

        $topic = $this->createTopic('Unanswered Topic');

        $questions = Question::factory()
            ->count(4)
            ->create([
                'topic_id' => $topic->id,
                'answer' => 'A',
            ]);

        $attempt = TestAttempt::factory()->create([
            'user_id' => $user->id,
            'status' => TestAttempt::STATUS_SUBMITTED,
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $questions[0]->id,
            'answer' => 'A',
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $questions[1]->id,
            'answer' => '',
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $questions[2]->id,
            'answer' => '',
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $questions[3]->id,
            'answer' => '',
        ]);

        $result = app(WeakTopicDetectionService::class)
            ->detectForUser($user->id);

        $topicResult = $result->first();

        $this->assertSame(1, $topicResult['attempted_questions']);
        $this->assertSame(3, $topicResult['unanswered']);
        $this->assertSame(100.0, $topicResult['percentage']);
    }

    public function test_other_users_results_are_not_included(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $topic = $this->createTopic('Other User Topic');

        $question = Question::factory()->create([
            'topic_id' => $topic->id,
            'answer' => 'A',
        ]);

        $otherAttempt = TestAttempt::factory()->create([
            'user_id' => $otherUser->id,
            'status' => TestAttempt::STATUS_SUBMITTED,
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $otherAttempt->id,
            'question_id' => $question->id,
            'answer' => 'B',
        ]);

        $result = app(WeakTopicDetectionService::class)
            ->detectForUser($user->id);

        $this->assertCount(0, $result);
    }

    public function test_unsubmitted_attempts_are_not_included(): void
    {
        $user = User::factory()->create();

        $topic = $this->createTopic('In Progress Topic');

        $question = Question::factory()->create([
            'topic_id' => $topic->id,
            'answer' => 'A',
        ]);

        $attempt = TestAttempt::factory()->create([
            'user_id' => $user->id,
            'status' => TestAttempt::STATUS_IN_PROGRESS,
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $question->id,
            'answer' => 'B',
        ]);

        $result = app(WeakTopicDetectionService::class)
            ->detectForUser($user->id);

        $this->assertCount(0, $result);
    }

    public function test_soft_deleted_topic_is_ignored(): void
    {
        $user = User::factory()->create();

        $topic = $this->createTopic('Deleted Topic');

        $question = Question::factory()->create([
            'topic_id' => $topic->id,
            'answer' => 'A',
        ]);

        $topic->delete();

        $attempt = TestAttempt::factory()->create([
            'user_id' => $user->id,
            'status' => TestAttempt::STATUS_SUBMITTED,
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $question->id,
            'answer' => 'A',
        ]);

        $result = app(WeakTopicDetectionService::class)
            ->detectForUser($user->id);

        $this->assertCount(0, $result);
    }

    private function createTopic(
        string $title,
        ?int $chapterId = null
    ): Topic {
        if ($chapterId) {
            return Topic::create([
                'chapter_id' => $chapterId,
                'title' => $title,
                'description' => 'Test topic description',
                'sort_order' => 1,
                'status' => 'active',
            ]);
        }

        $educationSystem = EducationSystem::create([
            'name' => 'Pakistan Education System',
            'country' => 'Pakistan',
            'status' => 'active',
        ]);

        $board = Board::create([
            'education_system_id' => $educationSystem->id,
            'name' => 'Punjab Board',
            'code' => 'PB-' . uniqid(),
            'status' => 'active',
        ]);

        $grade = Grade::create([
            'name' => 'Class 9',
            'code' => 'G9-' . uniqid(),
            'level' => 9,
            'sort_order' => 9,
            'status' => 'active',
        ]);

        $subject = Subject::create([
            'name' => 'Computer Science',
            'code' => 'CS-' . uniqid(),
            'status' => 'active',
        ]);

        $academicSession = AcademicSession::create([
            'name' => '2026-27',
            'start_date' => '2026-04-01',
            'end_date' => '2027-03-31',
            'status' => 'active',
        ]);

        $book = Book::create([
            'board_id' => $board->id,
            'grade_id' => $grade->id,
            'subject_id' => $subject->id,
            'academic_session_id' => $academicSession->id,
            'title' => 'Computer Science Class 9',
            'publisher' => 'Punjab Textbook Board',
            'edition' => '2026',
            'status' => 'active',
        ]);

        $chapter = Chapter::create([
            'book_id' => $book->id,
            'chapter_number' => 1,
            'title' => 'Test Chapter',
            'description' => 'Test chapter description',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        return Topic::create([
            'chapter_id' => $chapter->id,
            'title' => $title,
            'description' => 'Test topic description',
            'sort_order' => 1,
            'status' => 'active',
        ]);
    }
}