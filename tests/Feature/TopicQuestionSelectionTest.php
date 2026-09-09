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

class TopicQuestionSelectionTest extends TestCase
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

    public function test_all_questions_from_a_topic_can_be_added_to_a_test(): void
    {
        $test = Test::create([
            'title' => 'Topic Based Test',
        ]);

        $questionOne = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'What is a computer?',
            'marks' => 1,
        ]);

        $questionTwo = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'Define hardware.',
            'marks' => 2,
        ]);

        $questionThree = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_LONG,
            'question_text' => 'Explain the components of a computer.',
            'marks' => 5,
        ]);

        $addedCount = $test->addQuestionsFromTopic($this->topic);

        $this->assertSame(3, $addedCount);

        $this->assertDatabaseCount('test_questions', 3);

        $this->assertDatabaseHas('test_questions', [
            'test_id' => $test->id,
            'question_id' => $questionOne->id,
            'sort_order' => 1,
            'marks' => 1,
        ]);

        $this->assertDatabaseHas('test_questions', [
            'test_id' => $test->id,
            'question_id' => $questionTwo->id,
            'sort_order' => 2,
            'marks' => 2,
        ]);

        $this->assertDatabaseHas('test_questions', [
            'test_id' => $test->id,
            'question_id' => $questionThree->id,
            'sort_order' => 3,
            'marks' => 5,
        ]);
    }

    public function test_questions_from_other_topics_are_not_added(): void
    {
        $test = Test::create([
            'title' => 'Topic Based Test',
        ]);

        $otherTopic = Topic::create([
            'chapter_id' => $this->topic->chapter_id,
            'title' => 'Other Topic',
            'sort_order' => 2,
            'status' => 'active',
        ]);

        $selectedQuestion = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'Question from selected topic?',
        ]);

        $otherQuestion = Question::create([
            'topic_id' => $otherTopic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'Question from another topic?',
        ]);

        $addedCount = $test->addQuestionsFromTopic($this->topic);

        $this->assertSame(1, $addedCount);

        $this->assertDatabaseHas('test_questions', [
            'test_id' => $test->id,
            'question_id' => $selectedQuestion->id,
        ]);

        $this->assertDatabaseMissing('test_questions', [
            'test_id' => $test->id,
            'question_id' => $otherQuestion->id,
        ]);
    }

    public function test_existing_questions_are_not_added_again_when_topic_is_selected_twice(): void
    {
        $test = Test::create([
            'title' => 'Topic Based Test',
        ]);

        Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'First question?',
        ]);

        Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'Second question?',
        ]);

        $firstCount = $test->addQuestionsFromTopic($this->topic);
        $secondCount = $test->addQuestionsFromTopic($this->topic);

        $this->assertSame(2, $firstCount);
        $this->assertSame(0, $secondCount);

        $this->assertDatabaseCount('test_questions', 2);
    }

    public function test_empty_topic_adds_no_questions(): void
    {
        $test = Test::create([
            'title' => 'Empty Topic Test',
        ]);

        $addedCount = $test->addQuestionsFromTopic($this->topic);

        $this->assertSame(0, $addedCount);

        $this->assertDatabaseCount('test_questions', 0);
    }

    public function test_topic_questions_continue_after_existing_manual_questions(): void
    {
        $test = Test::create([
            'title' => 'Mixed Selection Test',
        ]);

        $manualQuestion = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'Manual question?',
            'marks' => 2,
        ]);

        $topicQuestion = Question::create([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'Topic question?',
            'marks' => 3,
        ]);

        $test->questions()->attach($manualQuestion->id, [
            'sort_order' => 1,
            'marks' => 2,
        ]);

        $addedCount = $test->addQuestionsFromTopic($this->topic);

        $this->assertSame(1, $addedCount);

        $this->assertDatabaseHas('test_questions', [
            'test_id' => $test->id,
            'question_id' => $topicQuestion->id,
            'sort_order' => 2,
            'marks' => 3,
        ]);
    }
}