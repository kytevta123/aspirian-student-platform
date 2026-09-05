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
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionEditingTest extends TestCase
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

    public function test_verified_user_can_edit_question(): void
    {
        $user = $this->verifiedUser();

        $question = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'What is the brain of a computer?',
            'options' => [
                'A' => 'Monitor',
                'B' => 'CPU',
                'C' => 'Keyboard',
                'D' => 'Mouse',
            ],
            'answer' => 'B',
            'explanation' => 'CPU processes instructions.',
            'marks' => 1,
            'difficulty' => 'easy',
            'status' => 'draft',
        ]);

        $response = $this
            ->actingAs($user)
            ->put(route('questions.update', $question), [
                'topic_id' => $this->topic->id,
                'question_type' => Question::TYPE_SHORT,
                'question_text' => 'What is a computer?',
                'options' => null,
                'answer' => 'An electronic device that processes data.',
                'explanation' => 'Updated explanation.',
                'marks' => 2,
                'difficulty' => 'medium',
                'status' => 'published',
            ]);

        $response->assertSessionHas(
            'status',
            'Question updated successfully.'
        );

        $question->refresh();

        $this->assertSame(
            Question::TYPE_SHORT,
            $question->question_type
        );

        $this->assertSame(
            'What is a computer?',
            $question->question_text
        );

        $this->assertSame(
            'An electronic device that processes data.',
            $question->answer
        );

        $this->assertSame(2, $question->marks);

        $this->assertSame(
            'medium',
            $question->difficulty
        );

        $this->assertSame(
            'published',
            $question->status
        );
    }

    public function test_previous_question_data_is_saved_as_revision(): void
    {
        $user = $this->verifiedUser();

        $question = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'Original question',
            'options' => [
                'A' => 'First',
                'B' => 'Second',
            ],
            'answer' => 'A',
            'explanation' => 'Original explanation.',
            'marks' => 1,
            'difficulty' => 'easy',
            'status' => 'draft',
        ]);

        $this
            ->actingAs($user)
            ->put(route('questions.update', $question), [
                'topic_id' => $this->topic->id,
                'question_type' => Question::TYPE_MCQ,
                'question_text' => 'Updated question',
                'options' => [
                    'A' => 'Updated first',
                    'B' => 'Updated second',
                ],
                'answer' => 'B',
                'explanation' => 'Updated explanation.',
                'marks' => 2,
                'difficulty' => 'hard',
                'status' => 'published',
            ]);

        $this->assertDatabaseHas('question_revisions', [
            'question_id' => $question->id,
            'user_id' => $user->id,
        ]);

        $revision = $question
            ->revisions()
            ->latest()
            ->first();

        $this->assertNotNull($revision);

        $this->assertSame(
            'Original question',
            $revision->question_data['question_text']
        );

        $this->assertSame(
            Question::TYPE_MCQ,
            $revision->question_data['question_type']
        );

        $this->assertSame(
            'A',
            $revision->question_data['answer']
        );

        $this->assertSame(
            1,
            $revision->question_data['marks']
        );

        $this->assertSame(
            'easy',
            $revision->question_data['difficulty']
        );

        $this->assertSame(
            'draft',
            $revision->question_data['status']
        );
    }

    public function test_question_type_is_required_when_editing(): void
    {
        $user = $this->verifiedUser();

        $question = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'Original question',
            'marks' => 2,
            'difficulty' => 'medium',
            'status' => 'draft',
        ]);

        $response = $this
            ->actingAs($user)
            ->put(route('questions.update', $question), [
                'topic_id' => $this->topic->id,
                'question_text' => 'Updated question',
                'marks' => 2,
                'difficulty' => 'medium',
                'status' => 'draft',
            ]);

        $response->assertSessionHasErrors('question_type');
    }

    public function test_question_text_is_required_when_editing(): void
    {
        $user = $this->verifiedUser();

        $question = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'Original question',
            'marks' => 2,
            'difficulty' => 'medium',
            'status' => 'draft',
        ]);

        $response = $this
            ->actingAs($user)
            ->put(route('questions.update', $question), [
                'topic_id' => $this->topic->id,
                'question_type' => Question::TYPE_SHORT,
                'marks' => 2,
                'difficulty' => 'medium',
                'status' => 'draft',
            ]);

        $response->assertSessionHasErrors('question_text');
    }

    public function test_marks_must_be_at_least_one_when_editing(): void
    {
        $user = $this->verifiedUser();

        $question = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'Original question',
            'marks' => 2,
            'difficulty' => 'medium',
            'status' => 'draft',
        ]);

        $response = $this
            ->actingAs($user)
            ->put(route('questions.update', $question), [
                'topic_id' => $this->topic->id,
                'question_type' => Question::TYPE_SHORT,
                'question_text' => 'Updated question',
                'marks' => 0,
                'difficulty' => 'medium',
                'status' => 'draft',
            ]);

        $response->assertSessionHasErrors('marks');
    }

    public function test_invalid_question_type_is_rejected_when_editing(): void
    {
        $user = $this->verifiedUser();

        $question = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'Original question',
            'marks' => 2,
            'difficulty' => 'medium',
            'status' => 'draft',
        ]);

        $response = $this
            ->actingAs($user)
            ->put(route('questions.update', $question), [
                'topic_id' => $this->topic->id,
                'question_type' => 'invalid',
                'question_text' => 'Updated question',
                'marks' => 2,
                'difficulty' => 'medium',
                'status' => 'draft',
            ]);

        $response->assertSessionHasErrors('question_type');
    }

    public function test_guest_cannot_edit_question(): void
    {
        $question = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'Original question',
            'marks' => 2,
            'difficulty' => 'medium',
            'status' => 'draft',
        ]);

        $response = $this->put(
            route('questions.update', $question),
            [
                'topic_id' => $this->topic->id,
                'question_type' => Question::TYPE_SHORT,
                'question_text' => 'Updated question',
                'marks' => 2,
                'difficulty' => 'medium',
                'status' => 'draft',
            ]
        );

        $response->assertRedirect(route('login.form'));
    }

    private function verifiedUser(): User
    {
        return User::factory()->create([
            'email_verified_at' => now(),
        ]);
    }
}