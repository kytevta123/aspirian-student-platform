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

class QuestionCreationTest extends TestCase
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

    public function test_mcq_can_be_created(): void
    {
        $response = $this->actingAs($this->verifiedUser())
            ->post(route('questions.store'), [
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
                'status' => 'published',
            ]);

        $response->assertSessionHas(
            'status',
            'Question created successfully.'
        );

        $this->assertDatabaseHas('questions', [
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'What is the brain of a computer?',
            'answer' => 'B',
        ]);
    }

    public function test_short_question_can_be_created(): void
    {
        $response = $this->actingAs($this->verifiedUser())
            ->post(route('questions.store'), [
                'topic_id' => $this->topic->id,
                'question_type' => Question::TYPE_SHORT,
                'question_text' => 'What is a computer?',
                'answer' => 'An electronic device that processes data.',
                'marks' => 2,
                'difficulty' => 'medium',
                'status' => 'draft',
            ]);

        $response->assertSessionHas(
            'status',
            'Question created successfully.'
        );

        $this->assertDatabaseHas('questions', [
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'What is a computer?',
            'marks' => 2,
        ]);
    }

    public function test_long_question_can_be_created(): void
    {
        $response = $this->actingAs($this->verifiedUser())
            ->post(route('questions.store'), [
                'topic_id' => $this->topic->id,
                'question_type' => Question::TYPE_LONG,
                'question_text' =>
                    'Explain the basic functions of a computer.',
                'answer' =>
                    'A computer performs input, processing, output and storage.',
                'marks' => 5,
                'difficulty' => 'hard',
                'status' => 'draft',
            ]);

        $response->assertSessionHas(
            'status',
            'Question created successfully.'
        );

        $this->assertDatabaseHas('questions', [
            'question_type' => Question::TYPE_LONG,
            'question_text' =>
                'Explain the basic functions of a computer.',
            'marks' => 5,
        ]);
    }

    public function test_question_type_is_required(): void
    {
        $response = $this->actingAs($this->verifiedUser())
            ->post(route('questions.store'), [
                'topic_id' => $this->topic->id,
                'question_text' => 'Test question',
                'marks' => 1,
                'difficulty' => 'easy',
                'status' => 'draft',
            ]);

        $response->assertSessionHasErrors('question_type');
    }

    public function test_invalid_question_type_is_rejected(): void
    {
        $response = $this->actingAs($this->verifiedUser())
            ->post(route('questions.store'), [
                'topic_id' => $this->topic->id,
                'question_type' => 'invalid',
                'question_text' => 'Test question',
                'marks' => 1,
                'difficulty' => 'easy',
                'status' => 'draft',
            ]);

        $response->assertSessionHasErrors('question_type');
    }

    public function test_question_text_is_required(): void
    {
        $response = $this->actingAs($this->verifiedUser())
            ->post(route('questions.store'), [
                'topic_id' => $this->topic->id,
                'question_type' => Question::TYPE_SHORT,
                'marks' => 1,
                'difficulty' => 'easy',
                'status' => 'draft',
            ]);

        $response->assertSessionHasErrors('question_text');
    }

    public function test_marks_must_be_at_least_one(): void
    {
        $response = $this->actingAs($this->verifiedUser())
            ->post(route('questions.store'), [
                'topic_id' => $this->topic->id,
                'question_type' => Question::TYPE_SHORT,
                'question_text' => 'Test question',
                'marks' => 0,
                'difficulty' => 'easy',
                'status' => 'draft',
            ]);

        $response->assertSessionHasErrors('marks');
    }

    public function test_invalid_difficulty_is_rejected(): void
    {
        $response = $this->actingAs($this->verifiedUser())
            ->post(route('questions.store'), [
                'topic_id' => $this->topic->id,
                'question_type' => Question::TYPE_SHORT,
                'question_text' => 'Test question',
                'marks' => 1,
                'difficulty' => 'invalid',
                'status' => 'draft',
            ]);

        $response->assertSessionHasErrors('difficulty');
    }

    public function test_invalid_status_is_rejected(): void
    {
        $response = $this->actingAs($this->verifiedUser())
            ->post(route('questions.store'), [
                'topic_id' => $this->topic->id,
                'question_type' => Question::TYPE_SHORT,
                'question_text' => 'Test question',
                'marks' => 1,
                'difficulty' => 'easy',
                'status' => 'invalid',
            ]);

        $response->assertSessionHasErrors('status');
    }

    public function test_guest_cannot_create_question(): void
    {
        $response = $this->post(route('questions.store'), [
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'Test question',
            'marks' => 1,
            'difficulty' => 'easy',
            'status' => 'draft',
        ]);

        $response->assertRedirect(route('login.form'));
    }

    private function verifiedUser(): User
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        return $user;
    }
}