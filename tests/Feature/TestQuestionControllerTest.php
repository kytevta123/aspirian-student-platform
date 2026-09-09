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
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestQuestionControllerTest extends TestCase
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
     * Create a verified authenticated user.
     */
    private function authenticatedUser(): User
    {
        return User::factory()->create([
            'email_verified_at' => now(),
        ]);
    }

    /**
     * Create an additional topic under the existing chapter.
     */
    private function createAdditionalTopic(string $title): Topic
    {
        return Topic::create([
            'chapter_id' => $this->topic->chapter_id,
            'title' => $title,
            'sort_order' => 2,
            'status' => 'active',
        ]);
    }

    /**
     * Create a question belonging to a topic.
     */
    private function createQuestion(
        Topic $topic,
        string $text,
        string $difficulty = 'medium'
    ): Question {
        return Question::create([
            'topic_id' => $topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => $text,
            'normalized_text' => strtolower(trim($text)),
            'options' => [
                'A' => 'Option A',
                'B' => 'Option B',
                'C' => 'Option C',
                'D' => 'Option D',
            ],
            'answer' => 'A',
            'explanation' => 'Test explanation',
            'marks' => 1,
            'difficulty' => $difficulty,
            'status' => 'published',
        ]);
    }

    public function test_authenticated_user_can_open_test_question_selection_page(): void
    {
        $user = $this->authenticatedUser();

        $test = Test::create([
            'title' => 'Biology Test',
            'duration' => 60,
            'marks' => 10,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('tests.questions.index', $test));

        $response->assertOk();

        $response->assertViewIs('tests.questions.index');
        $response->assertViewHas('test', $test);
        $response->assertViewHas('questions');
        $response->assertViewHas('topics');
        $response->assertViewHas('selectedQuestionIds');
        $response->assertViewHas('selectedQuestions');
    }

    public function test_user_can_manually_add_question_to_test(): void
    {
        $user = $this->authenticatedUser();

        $question = $this->createQuestion(
            $this->topic,
            'What is a computer?'
        );

        $test = Test::create([
            'title' => 'Computer Science Test',
            'duration' => 60,
            'marks' => 10,
        ]);

        $response = $this
            ->actingAs($user)
            ->post(
                route('tests.questions.store', $test),
                [
                    'question_id' => $question->id,
                ]
            );

        $response->assertRedirect();

        $this->assertDatabaseHas('test_questions', [
            'test_id' => $test->id,
            'question_id' => $question->id,
            'sort_order' => 1,
            'marks' => $question->marks,
        ]);
    }

    public function test_same_question_is_not_added_twice_manually(): void
    {
        $user = $this->authenticatedUser();

        $question = $this->createQuestion(
            $this->topic,
            'What is RAM?'
        );

        $test = Test::create([
            'title' => 'Computer Science Test',
            'duration' => 60,
            'marks' => 10,
        ]);

        $this
            ->actingAs($user)
            ->post(
                route('tests.questions.store', $test),
                [
                    'question_id' => $question->id,
                ]
            );

        $this
            ->actingAs($user)
            ->post(
                route('tests.questions.store', $test),
                [
                    'question_id' => $question->id,
                ]
            );

        $this->assertDatabaseCount('test_questions', 1);

        $this->assertDatabaseHas('test_questions', [
            'test_id' => $test->id,
            'question_id' => $question->id,
        ]);
    }

    public function test_user_can_add_questions_from_topic(): void
    {
        $user = $this->authenticatedUser();

        $questionOne = $this->createQuestion(
            $this->topic,
            'What is CPU?'
        );

        $questionTwo = $this->createQuestion(
            $this->topic,
            'What is memory?'
        );

        $otherTopic = $this->createAdditionalTopic(
            'Other Concepts'
        );

        $otherQuestion = $this->createQuestion(
            $otherTopic,
            'What is an operating system?'
        );

        $test = Test::create([
            'title' => 'Topic Test',
            'duration' => 60,
            'marks' => 10,
        ]);

        $response = $this
            ->actingAs($user)
            ->post(
                route('tests.questions.topic', $test),
                [
                    'topic_id' => $this->topic->id,
                ]
            );

        $response->assertRedirect();

        $this->assertDatabaseHas('test_questions', [
            'test_id' => $test->id,
            'question_id' => $questionOne->id,
        ]);

        $this->assertDatabaseHas('test_questions', [
            'test_id' => $test->id,
            'question_id' => $questionTwo->id,
        ]);

        $this->assertDatabaseMissing('test_questions', [
            'test_id' => $test->id,
            'question_id' => $otherQuestion->id,
        ]);
    }

    public function test_user_can_add_questions_by_difficulty(): void
    {
        $user = $this->authenticatedUser();

        $easyQuestion = $this->createQuestion(
            $this->topic,
            'Easy question',
            'easy'
        );

        $mediumQuestion = $this->createQuestion(
            $this->topic,
            'Medium question',
            'medium'
        );

        $hardQuestion = $this->createQuestion(
            $this->topic,
            'Hard question',
            'hard'
        );

        $test = Test::create([
            'title' => 'Difficulty Test',
            'duration' => 60,
            'marks' => 10,
        ]);

        $response = $this
            ->actingAs($user)
            ->post(
                route('tests.questions.difficulty', $test),
                [
                    'difficulty' => 'hard',
                ]
            );

        $response->assertRedirect();

        $this->assertDatabaseHas('test_questions', [
            'test_id' => $test->id,
            'question_id' => $hardQuestion->id,
        ]);

        $this->assertDatabaseMissing('test_questions', [
            'test_id' => $test->id,
            'question_id' => $easyQuestion->id,
        ]);

        $this->assertDatabaseMissing('test_questions', [
            'test_id' => $test->id,
            'question_id' => $mediumQuestion->id,
        ]);
    }

    public function test_user_can_remove_question_from_test(): void
    {
        $user = $this->authenticatedUser();

        $question = $this->createQuestion(
            $this->topic,
            'Question to remove'
        );

        $test = Test::create([
            'title' => 'Removal Test',
            'duration' => 60,
            'marks' => 10,
        ]);

        $test->questions()->attach($question->id, [
            'sort_order' => 1,
            'marks' => $question->marks,
        ]);

        $response = $this
            ->actingAs($user)
            ->delete(
                route(
                    'tests.questions.destroy',
                    [
                        'test' => $test,
                        'question' => $question,
                    ]
                )
            );

        $response->assertRedirect();

        $this->assertDatabaseMissing('test_questions', [
            'test_id' => $test->id,
            'question_id' => $question->id,
        ]);
    }

    public function test_user_can_update_question_order(): void
    {
        $user = $this->authenticatedUser();

        $questionOne = $this->createQuestion(
            $this->topic,
            'First question'
        );

        $questionTwo = $this->createQuestion(
            $this->topic,
            'Second question'
        );

        $questionThree = $this->createQuestion(
            $this->topic,
            'Third question'
        );

        $test = Test::create([
            'title' => 'Ordering Test',
            'duration' => 60,
            'marks' => 10,
        ]);

        $test->questions()->attach($questionOne->id, [
            'sort_order' => 1,
            'marks' => $questionOne->marks,
        ]);

        $test->questions()->attach($questionTwo->id, [
            'sort_order' => 2,
            'marks' => $questionTwo->marks,
        ]);

        $test->questions()->attach($questionThree->id, [
            'sort_order' => 3,
            'marks' => $questionThree->marks,
        ]);

        $response = $this
            ->actingAs($user)
            ->patch(
                route('tests.questions.order', $test),
                [
                    'question_ids' => [
                        $questionThree->id,
                        $questionOne->id,
                        $questionTwo->id,
                    ],
                ]
            );

        $response->assertRedirect();

        $this->assertDatabaseHas('test_questions', [
            'test_id' => $test->id,
            'question_id' => $questionThree->id,
            'sort_order' => 1,
        ]);

        $this->assertDatabaseHas('test_questions', [
            'test_id' => $test->id,
            'question_id' => $questionOne->id,
            'sort_order' => 2,
        ]);

        $this->assertDatabaseHas('test_questions', [
            'test_id' => $test->id,
            'question_id' => $questionTwo->id,
            'sort_order' => 3,
        ]);
    }

    public function test_invalid_question_order_is_rejected(): void
    {
        $user = $this->authenticatedUser();

        $questionOne = $this->createQuestion(
            $this->topic,
            'Selected question'
        );

        $questionTwo = $this->createQuestion(
            $this->topic,
            'Another selected question'
        );

        $unselectedQuestion = $this->createQuestion(
            $this->topic,
            'Unselected question'
        );

        $test = Test::create([
            'title' => 'Invalid Order Test',
            'duration' => 60,
            'marks' => 10,
        ]);

        $test->questions()->attach($questionOne->id, [
            'sort_order' => 1,
            'marks' => $questionOne->marks,
        ]);

        $test->questions()->attach($questionTwo->id, [
            'sort_order' => 2,
            'marks' => $questionTwo->marks,
        ]);

        $response = $this
            ->actingAs($user)
            ->patch(
                route('tests.questions.order', $test),
                [
                    'question_ids' => [
                        $questionOne->id,
                        $unselectedQuestion->id,
                    ],
                ]
            );

        $response->assertRedirect();

        $response->assertSessionHasErrors('question_ids');

        $this->assertDatabaseHas('test_questions', [
            'test_id' => $test->id,
            'question_id' => $questionOne->id,
            'sort_order' => 1,
        ]);

        $this->assertDatabaseHas('test_questions', [
            'test_id' => $test->id,
            'question_id' => $questionTwo->id,
            'sort_order' => 2,
        ]);

        $this->assertDatabaseMissing('test_questions', [
            'test_id' => $test->id,
            'question_id' => $unselectedQuestion->id,
        ]);
    }

    public function test_guest_cannot_access_test_question_selection_page(): void
    {
        $test = Test::create([
            'title' => 'Protected Test',
            'duration' => 60,
            'marks' => 10,
        ]);

        $response = $this->get(
            route('tests.questions.index', $test)
        );

        $response->assertRedirect(route('login.form'));
    }
}