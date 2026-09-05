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

class QuestionDeletionTest extends TestCase
{
    use RefreshDatabase;

    private Topic $topic;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        EducationSystem::first();
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

    public function test_verified_user_can_soft_delete_question(): void
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
            ->delete(
                route('questions.destroy', $question)
            );

        $response->assertSessionHas(
            'status',
            'Question deleted successfully.'
        );

        $this->assertSoftDeleted('questions', [
            'id' => $question->id,
        ]);
    }

    public function test_soft_deleted_question_is_hidden_from_normal_queries(): void
    {
        $user = $this->verifiedUser();

        $question = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'What is a computer?',
            'answer' => 'An electronic device.',
            'marks' => 2,
            'difficulty' => 'medium',
            'status' => 'draft',
        ]);

        $this
            ->actingAs($user)
            ->delete(
                route('questions.destroy', $question)
            );

        $this->assertNull(
            Question::find($question->id)
        );

        $this->assertNotNull(
            Question::withTrashed()->find($question->id)
        );
    }

    public function test_guest_cannot_delete_question(): void
    {
        $question = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'What is a computer?',
            'answer' => 'An electronic device.',
            'marks' => 2,
            'difficulty' => 'medium',
            'status' => 'draft',
        ]);

        $response = $this->delete(
            route('questions.destroy', $question)
        );

        $response->assertRedirect(
            route('login.form')
        );

        $this->assertDatabaseHas('questions', [
            'id' => $question->id,
            'deleted_at' => null,
        ]);
    }

    public function test_unverified_user_cannot_delete_question(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $question = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'What is a computer?',
            'answer' => 'An electronic device.',
            'marks' => 2,
            'difficulty' => 'medium',
            'status' => 'draft',
        ]);

        $response = $this
            ->actingAs($user)
            ->delete(
                route('questions.destroy', $question)
            );

        $response->assertRedirect(
            route('verification.notice')
        );

        $this->assertDatabaseHas('questions', [
            'id' => $question->id,
            'deleted_at' => null,
        ]);
    }

    public function test_question_revisions_are_preserved_after_soft_delete(): void
    {
        $user = $this->verifiedUser();

        $question = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'Original question',
            'answer' => 'Original answer',
            'marks' => 2,
            'difficulty' => 'medium',
            'status' => 'draft',
        ]);

        $revision = $question->revisions()->create([
            'user_id' => $user->id,
            'question_data' => [
                'topic_id' => $question->topic_id,
                'question_type' => $question->question_type,
                'question_text' => $question->question_text,
                'options' => $question->options,
                'answer' => $question->answer,
                'explanation' => $question->explanation,
                'marks' => $question->marks,
                'difficulty' => $question->difficulty,
                'status' => $question->status,
            ],
        ]);

        $this
            ->actingAs($user)
            ->delete(
                route('questions.destroy', $question)
            );

        $this->assertSoftDeleted('questions', [
            'id' => $question->id,
        ]);

        $this->assertDatabaseHas('question_revisions', [
            'id' => $revision->id,
            'question_id' => $question->id,
        ]);
    }

    public function test_already_deleted_question_cannot_be_deleted_again(): void
    {
        $user = $this->verifiedUser();

        $question = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'Question to delete',
            'answer' => 'Answer',
            'marks' => 1,
            'difficulty' => 'easy',
            'status' => 'draft',
        ]);

        $question->delete();

        $response = $this
            ->actingAs($user)
            ->delete(
                route(
                    'questions.destroy',
                    ['question' => $question->id]
                )
            );

        $response->assertNotFound();
    }

    private function verifiedUser(): User
    {
        return User::factory()->create([
            'email_verified_at' => now(),
        ]);
    }
}