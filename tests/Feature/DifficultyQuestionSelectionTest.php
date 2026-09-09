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
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DifficultyQuestionSelectionTest extends TestCase
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

    public function test_questions_of_selected_difficulty_can_be_added(): void
    {
        $test = Test::create([
            'title' => 'Easy Questions Test',
        ]);

        $easyQuestionOne = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'Easy question one?',
            'difficulty' => 'easy',
            'marks' => 1,
        ]);

        $easyQuestionTwo = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'Easy question two?',
            'difficulty' => 'easy',
            'marks' => 2,
        ]);

        $mediumQuestion = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'Medium question?',
            'difficulty' => 'medium',
            'marks' => 3,
        ]);

        $addedCount = $test->addQuestionsByDifficulty('easy');

        $this->assertSame(2, $addedCount);

        $this->assertDatabaseHas('test_questions', [
            'test_id' => $test->id,
            'question_id' => $easyQuestionOne->id,
            'sort_order' => 1,
            'marks' => 1,
        ]);

        $this->assertDatabaseHas('test_questions', [
            'test_id' => $test->id,
            'question_id' => $easyQuestionTwo->id,
            'sort_order' => 2,
            'marks' => 2,
        ]);

        $this->assertDatabaseMissing('test_questions', [
            'test_id' => $test->id,
            'question_id' => $mediumQuestion->id,
        ]);
    }

    public function test_medium_difficulty_questions_are_selected_correctly(): void
    {
        $test = Test::create([
            'title' => 'Medium Questions Test',
        ]);

        Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'Easy question?',
            'difficulty' => 'easy',
        ]);

        $mediumQuestion = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'Medium question?',
            'difficulty' => 'medium',
        ]);

        Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_LONG,
            'question_text' => 'Hard question?',
            'difficulty' => 'hard',
        ]);

        $addedCount = $test->addQuestionsByDifficulty('medium');

        $this->assertSame(1, $addedCount);

        $this->assertDatabaseHas('test_questions', [
            'test_id' => $test->id,
            'question_id' => $mediumQuestion->id,
        ]);

        $this->assertDatabaseCount('test_questions', 1);
    }

    public function test_hard_difficulty_questions_are_selected_correctly(): void
    {
        $test = Test::create([
            'title' => 'Hard Questions Test',
        ]);

        Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'Easy question?',
            'difficulty' => 'easy',
        ]);

        Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'Medium question?',
            'difficulty' => 'medium',
        ]);

        $hardQuestion = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_LONG,
            'question_text' => 'Hard question?',
            'difficulty' => 'hard',
        ]);

        $addedCount = $test->addQuestionsByDifficulty('hard');

        $this->assertSame(1, $addedCount);

        $this->assertDatabaseHas('test_questions', [
            'test_id' => $test->id,
            'question_id' => $hardQuestion->id,
        ]);

        $this->assertDatabaseCount('test_questions', 1);
    }

    public function test_existing_questions_are_not_added_again_by_difficulty(): void
    {
        $test = Test::create([
            'title' => 'Duplicate Difficulty Test',
        ]);

        $questionOne = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'Easy question one?',
            'difficulty' => 'easy',
        ]);

        $questionTwo = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'Easy question two?',
            'difficulty' => 'easy',
        ]);

        $test->questions()->attach($questionOne->id, [
            'sort_order' => 1,
            'marks' => 1,
        ]);

        $addedCount = $test->addQuestionsByDifficulty('easy');

        $this->assertSame(1, $addedCount);

        $this->assertDatabaseCount('test_questions', 2);

        $this->assertDatabaseHas('test_questions', [
            'test_id' => $test->id,
            'question_id' => $questionTwo->id,
            'sort_order' => 2,
        ]);
    }

    public function test_difficulty_selection_continues_after_existing_questions(): void
    {
        $test = Test::create([
            'title' => 'Difficulty Ordering Test',
        ]);

        $manualQuestion = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'Manual question?',
            'difficulty' => 'hard',
            'marks' => 2,
        ]);

        $easyQuestion = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'Easy question?',
            'difficulty' => 'easy',
            'marks' => 4,
        ]);

        $test->questions()->attach($manualQuestion->id, [
            'sort_order' => 5,
            'marks' => 2,
        ]);

        $addedCount = $test->addQuestionsByDifficulty('easy');

        $this->assertSame(1, $addedCount);

        $this->assertDatabaseHas('test_questions', [
            'test_id' => $test->id,
            'question_id' => $easyQuestion->id,
            'sort_order' => 6,
            'marks' => 4,
        ]);
    }
}