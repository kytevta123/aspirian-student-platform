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
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class QuestionTest extends TestCase
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

    public function test_questions_table_exists(): void
    {
        $this->assertTrue(
            Schema::hasTable('questions')
        );
    }

    public function test_can_create_mcq_question(): void
    {
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
            'explanation' => 'CPU processes instructions and controls computer operations.',
            'marks' => 1,
            'difficulty' => 'easy',
            'status' => 'published',
        ]);

        $this->assertDatabaseHas('questions', [
            'id' => $question->id,
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'What is the brain of a computer?',
            'answer' => 'B',
            'marks' => 1,
            'difficulty' => 'easy',
            'status' => 'published',
        ]);
    }

    public function test_can_create_short_question(): void
    {
        $question = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'What is a computer?',
            'answer' => 'A computer is an electronic device that processes data.',
            'marks' => 2,
        ]);

        $this->assertDatabaseHas('questions', [
            'id' => $question->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'What is a computer?',
        ]);
    }

    public function test_can_create_long_question(): void
    {
        $question = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_LONG,
            'question_text' => 'Explain the basic functions of a computer.',
            'answer' => 'A computer performs input, processing, output and storage operations.',
            'marks' => 5,
            'difficulty' => 'hard',
        ]);

        $this->assertDatabaseHas('questions', [
            'id' => $question->id,
            'question_type' => Question::TYPE_LONG,
            'question_text' => 'Explain the basic functions of a computer.',
            'marks' => 5,
            'difficulty' => 'hard',
        ]);
    }

    public function test_question_belongs_to_topic(): void
    {
        $question = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'Define data.',
        ]);

        $this->assertTrue(
            $question->topic->is($this->topic)
        );
    }

    public function test_topic_has_questions(): void
    {
        Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'Question One',
        ]);

        Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'Question Two',
        ]);

        $this->assertCount(
            2,
            $this->topic->questions
        );
    }

    public function test_mcq_options_are_cast_to_array(): void
    {
        $question = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'Which device is used for typing?',
            'options' => [
                'A' => 'Keyboard',
                'B' => 'Monitor',
                'C' => 'Printer',
                'D' => 'Speaker',
            ],
        ]);

        $question->refresh();

        $this->assertIsArray($question->options);
        $this->assertSame(
            'Keyboard',
            $question->options['A']
        );
    }

    public function test_question_marks_are_cast_to_integer(): void
    {
        $question = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'What is RAM?',
            'marks' => 2,
        ]);

        $question->refresh();

        $this->assertIsInt($question->marks);
        $this->assertSame(2, $question->marks);
    }

    public function test_question_has_expected_default_values(): void
    {
        $question = new Question([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'What is software?',
        ]);

        $this->assertSame(1, $question->marks);
        $this->assertSame('medium', $question->difficulty);
        $this->assertSame('draft', $question->status);
    }

    public function test_question_can_be_soft_deleted(): void
    {
        $question = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'What is hardware?',
        ]);

        $question->delete();

        $this->assertSoftDeleted('questions', [
            'id' => $question->id,
        ]);

        $this->assertNull(
            Question::find($question->id)
        );

        $this->assertNotNull(
            Question::withTrashed()->find($question->id)
        );
    }

    public function test_question_text_is_not_required_to_be_unique(): void
    {
        $questionText = 'What is an operating system?';

        Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => $questionText,
        ]);

        Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => $questionText,
        ]);

        $this->assertDatabaseCount('questions', 2);
    }
}