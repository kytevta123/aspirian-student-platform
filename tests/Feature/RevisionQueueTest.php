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
use App\Models\TestAttemptAnswer;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RevisionQueueTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_revision_queue(): void
    {
        $response = $this->get(route('revision.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_unverified_user_cannot_access_revision_queue(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('revision.index'));

        $response->assertRedirect(route('verification.notice'));
    }

    public function test_verified_user_can_access_revision_queue(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('revision.index'));

        $response->assertOk();
        $response->assertSee('Revision Queue');
    }

    public function test_revision_queue_contains_only_weak_topics_for_current_user(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        [
            'book' => $book,
        ] = $this->createBookStructure();

        $chapter = Chapter::create([
            'book_id' => $book->id,
            'chapter_number' => 1,
            'title' => 'Weak Topic Chapter',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $weakTopic = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Weak Topic',
            'sort_order' => 1,
            'status' => 'published',
        ]);

        $strongTopic = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Strong Topic',
            'sort_order' => 2,
            'status' => 'published',
        ]);

        $test = Test::factory()->create([
            'status' => Test::STATUS_PUBLISHED,
        ]);

        $weakQuestion = Question::factory()->create([
            'topic_id' => $weakTopic->id,
            'answer' => 'A',
            'status' => 'published',
        ]);

        $strongQuestion = Question::factory()->create([
            'topic_id' => $strongTopic->id,
            'answer' => 'A',
            'status' => 'published',
        ]);

        $test->questions()->attach(
            $weakQuestion->id,
            [
                'sort_order' => 1,
                'marks' => 1,
            ]
        );

        $test->questions()->attach(
            $strongQuestion->id,
            [
                'sort_order' => 2,
                'marks' => 1,
            ]
        );

        $attempt = TestAttempt::factory()->create([
            'test_id' => $test->id,
            'user_id' => $user->id,
            'status' => TestAttempt::STATUS_SUBMITTED,
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $weakQuestion->id,
            'answer' => 'B',
            'answered_at' => now(),
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $strongQuestion->id,
            'answer' => 'A',
            'answered_at' => now(),
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('revision.index'));

        $response->assertOk();
        $response->assertSee('Weak Topic');
        $response->assertDontSee('Strong Topic');
    }

    public function test_revision_queue_shows_weak_topic_performance(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        [
            'book' => $book,
        ] = $this->createBookStructure();

        $chapter = Chapter::create([
            'book_id' => $book->id,
            'chapter_number' => 1,
            'title' => 'Revision Performance Chapter',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $topic = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Weak Computer Science Topic',
            'sort_order' => 1,
            'status' => 'published',
        ]);

        $test = Test::factory()->create([
            'status' => Test::STATUS_PUBLISHED,
        ]);

        $correctQuestion = Question::factory()->create([
            'topic_id' => $topic->id,
            'answer' => 'A',
            'status' => 'published',
        ]);

        $wrongQuestionOne = Question::factory()->create([
            'topic_id' => $topic->id,
            'answer' => 'B',
            'status' => 'published',
        ]);

        $wrongQuestionTwo = Question::factory()->create([
            'topic_id' => $topic->id,
            'answer' => 'C',
            'status' => 'published',
        ]);

        $test->questions()->attach(
            $correctQuestion->id,
            [
                'sort_order' => 1,
                'marks' => 1,
            ]
        );

        $test->questions()->attach(
            $wrongQuestionOne->id,
            [
                'sort_order' => 2,
                'marks' => 1,
            ]
        );

        $test->questions()->attach(
            $wrongQuestionTwo->id,
            [
                'sort_order' => 3,
                'marks' => 1,
            ]
        );

        $attempt = TestAttempt::factory()->create([
            'test_id' => $test->id,
            'user_id' => $user->id,
            'status' => TestAttempt::STATUS_SUBMITTED,
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $correctQuestion->id,
            'answer' => 'A',
            'answered_at' => now(),
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $wrongQuestionOne->id,
            'answer' => 'A',
            'answered_at' => now(),
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $wrongQuestionTwo->id,
            'answer' => 'A',
            'answered_at' => now(),
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('revision.index'));

        $response->assertOk();
        $response->assertSee('Weak Computer Science Topic');
        $response->assertSee('Performance');
        $response->assertSee('33.33%');
        $response->assertSee('Correct');
        $response->assertSee('Wrong');
        $response->assertSee('Recommended Action');
    }

    public function test_revision_queue_is_empty_when_student_has_no_weak_topics(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('revision.index'));

        $response->assertOk();
        $response->assertSee('You currently have no weak topics in your revision queue.');
    }

    public function test_revision_queue_orders_weakest_topics_first(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        [
            'book' => $book,
        ] = $this->createBookStructure();

        $chapter = Chapter::create([
            'book_id' => $book->id,
            'chapter_number' => 1,
            'title' => 'Revision Order Chapter',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $veryWeakTopic = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Very Weak Mathematics Topic',
            'sort_order' => 1,
            'status' => 'published',
        ]);

        $moderateWeakTopic = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Moderate Weak Mathematics Topic',
            'sort_order' => 2,
            'status' => 'published',
        ]);

        $test = Test::factory()->create([
            'status' => Test::STATUS_PUBLISHED,
        ]);

        $veryWeakQuestion = Question::factory()->create([
            'topic_id' => $veryWeakTopic->id,
            'answer' => 'A',
            'status' => 'published',
        ]);

        $moderateCorrectQuestion = Question::factory()->create([
            'topic_id' => $moderateWeakTopic->id,
            'answer' => 'A',
            'status' => 'published',
        ]);

        $moderateWrongQuestionOne = Question::factory()->create([
            'topic_id' => $moderateWeakTopic->id,
            'answer' => 'B',
            'status' => 'published',
        ]);

        $moderateWrongQuestionTwo = Question::factory()->create([
            'topic_id' => $moderateWeakTopic->id,
            'answer' => 'C',
            'status' => 'published',
        ]);

        $test->questions()->attach(
            $veryWeakQuestion->id,
            [
                'sort_order' => 1,
                'marks' => 1,
            ]
        );

        $test->questions()->attach(
            $moderateCorrectQuestion->id,
            [
                'sort_order' => 2,
                'marks' => 1,
            ]
        );

        $test->questions()->attach(
            $moderateWrongQuestionOne->id,
            [
                'sort_order' => 3,
                'marks' => 1,
            ]
        );

        $test->questions()->attach(
            $moderateWrongQuestionTwo->id,
            [
                'sort_order' => 4,
                'marks' => 1,
            ]
        );

        $attempt = TestAttempt::factory()->create([
            'test_id' => $test->id,
            'user_id' => $user->id,
            'status' => TestAttempt::STATUS_SUBMITTED,
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $veryWeakQuestion->id,
            'answer' => 'B',
            'answered_at' => now(),
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $moderateCorrectQuestion->id,
            'answer' => 'A',
            'answered_at' => now(),
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $moderateWrongQuestionOne->id,
            'answer' => 'A',
            'answered_at' => now(),
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $moderateWrongQuestionTwo->id,
            'answer' => 'A',
            'answered_at' => now(),
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('revision.index'));

        $response->assertOk();

        $content = $response->getContent();

        $veryWeakPosition = strpos(
            $content,
            'Very Weak Mathematics Topic'
        );

        $moderateWeakPosition = strpos(
            $content,
            'Moderate Weak Mathematics Topic'
        );

        $this->assertNotFalse($veryWeakPosition);
        $this->assertNotFalse($moderateWeakPosition);

        $this->assertLessThan(
            $moderateWeakPosition,
            $veryWeakPosition
        );
    }

    public function test_revision_queue_shows_high_priority_for_very_low_performance(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        [
            'book' => $book,
        ] = $this->createBookStructure();

        $chapter = Chapter::create([
            'book_id' => $book->id,
            'chapter_number' => 1,
            'title' => 'High Priority Chapter',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $topic = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Critical Weak Topic',
            'sort_order' => 1,
            'status' => 'published',
        ]);

        $test = Test::factory()->create([
            'status' => Test::STATUS_PUBLISHED,
        ]);

        $question = Question::factory()->create([
            'topic_id' => $topic->id,
            'answer' => 'A',
            'status' => 'published',
        ]);

        $test->questions()->attach(
            $question->id,
            [
                'sort_order' => 1,
                'marks' => 1,
            ]
        );

        $attempt = TestAttempt::factory()->create([
            'test_id' => $test->id,
            'user_id' => $user->id,
            'status' => TestAttempt::STATUS_SUBMITTED,
        ]);

        TestAttemptAnswer::create([
            'test_attempt_id' => $attempt->id,
            'question_id' => $question->id,
            'answer' => 'B',
            'answered_at' => now(),
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('revision.index'));

        $response->assertOk();
        $response->assertSee('Critical Weak Topic');
        $response->assertSee('High');
    }

    protected function createBookStructure(): array
    {
        $educationSystem = EducationSystem::create([
            'name' => 'Test Education System ' . uniqid(),
            'country' => 'Pakistan',
            'status' => 'active',
        ]);

        $board = Board::create([
            'education_system_id' => $educationSystem->id,
            'name' => 'Test Board ' . uniqid(),
            'code' => 'TB' . strtoupper(substr(uniqid(), -6)),
            'status' => 'active',
        ]);

        $grade = Grade::create([
            'name' => 'Test Grade ' . uniqid(),
            'code' => 'TG' . strtoupper(substr(uniqid(), -6)),
            'level' => random_int(1000, 9999),
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $subject = Subject::create([
            'name' => 'Test Subject ' . uniqid(),
            'code' => 'TS' . strtoupper(substr(uniqid(), -6)),
            'description' => null,
            'status' => 'active',
        ]);

        $academicSession = AcademicSession::create([
            'name' => 'Test Session ' . uniqid(),
            'start_date' => now()->startOfYear()->toDateString(),
            'end_date' => now()->endOfYear()->toDateString(),
            'status' => 'active',
        ]);

        $book = Book::create([
            'board_id' => $board->id,
            'grade_id' => $grade->id,
            'subject_id' => $subject->id,
            'academic_session_id' => $academicSession->id,
            'title' => 'Revision Test Book ' . uniqid(),
            'publisher' => null,
            'edition' => null,
            'status' => 'active',
        ]);

        return [
            'educationSystem' => $educationSystem,
            'board' => $board,
            'grade' => $grade,
            'subject' => $subject,
            'academicSession' => $academicSession,
            'book' => $book,
        ];
    }
}