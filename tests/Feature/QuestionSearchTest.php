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

class QuestionSearchTest extends TestCase
{
    use RefreshDatabase;

    private Subject $subject;

    private Subject $secondSubject;

    private Chapter $chapter;

    private Chapter $secondChapter;

    private Topic $topic;

    private Topic $secondTopic;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        EducationSystem::first();

        $board = Board::first();
        $academicSession = AcademicSession::first();
        $grade = Grade::where('code', 'G9')->first();

        $this->subject = Subject::where('code', 'CS')->first();

        $this->secondSubject = Subject::where(
            'code',
            'BIO'
        )->first();

        $book = Book::create([
            'board_id' => $board->id,
            'grade_id' => $grade->id,
            'subject_id' => $this->subject->id,
            'academic_session_id' => $academicSession->id,
            'title' => 'Computer Science Class 9',
            'status' => 'active',
        ]);

        $secondBook = Book::create([
            'board_id' => $board->id,
            'grade_id' => $grade->id,
            'subject_id' => $this->secondSubject->id,
            'academic_session_id' => $academicSession->id,
            'title' => 'Biology Class 9',
            'status' => 'active',
        ]);

        $this->chapter = Chapter::create([
            'book_id' => $book->id,
            'chapter_number' => 1,
            'title' => 'Introduction to Computer',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $this->secondChapter = Chapter::create([
            'book_id' => $secondBook->id,
            'chapter_number' => 1,
            'title' => 'Introduction to Biology',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $this->topic = Topic::create([
            'chapter_id' => $this->chapter->id,
            'title' => 'Basic Concepts',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $this->secondTopic = Topic::create([
            'chapter_id' => $this->secondChapter->id,
            'title' => 'Cell Biology',
            'sort_order' => 1,
            'status' => 'active',
        ]);
    }

    public function test_verified_user_can_search_questions_by_keyword(): void
    {
        $user = $this->verifiedUser();

        $matchingQuestion = $this->createQuestion([
            'question_text' => 'What is the CPU of a computer?',
        ]);

        $this->createQuestion([
            'question_text' => 'What is a keyboard?',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('questions.index', [
                'search' => 'CPU',
            ]));

        $response->assertOk();

        $response->assertViewHas(
            'questions',
            function ($questions) use ($matchingQuestion) {
                return $questions->contains(
                    'id',
                    $matchingQuestion->id
                )
                && $questions->count() === 1;
            }
        );
    }

    public function test_search_is_case_insensitive(): void
    {
        $user = $this->verifiedUser();

        $matchingQuestion = $this->createQuestion([
            'question_text' => 'What is the Central Processing Unit?',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('questions.index', [
                'search' => 'central processing unit',
            ]));

        $response->assertOk();

        $response->assertViewHas(
            'questions',
            function ($questions) use ($matchingQuestion) {
                return $questions->contains(
                    'id',
                    $matchingQuestion->id
                );
            }
        );
    }

    public function test_questions_can_be_filtered_by_subject(): void
    {
        $user = $this->verifiedUser();

        $computerQuestion = $this->createQuestion([
            'topic_id' => $this->topic->id,
            'question_text' => 'What is a computer?',
        ]);

        $biologyQuestion = $this->createQuestion([
            'topic_id' => $this->secondTopic->id,
            'question_text' => 'What is a cell?',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('questions.index', [
                'subject_id' => $this->subject->id,
            ]));

        $response->assertOk();

        $response->assertViewHas(
            'questions',
            function ($questions) use (
                $computerQuestion,
                $biologyQuestion
            ) {
                return $questions->contains(
                    'id',
                    $computerQuestion->id
                )
                && ! $questions->contains(
                    'id',
                    $biologyQuestion->id
                );
            }
        );
    }

    public function test_questions_can_be_filtered_by_chapter(): void
    {
        $user = $this->verifiedUser();

        $matchingQuestion = $this->createQuestion([
            'topic_id' => $this->topic->id,
            'question_text' => 'What is hardware?',
        ]);

        $otherQuestion = $this->createQuestion([
            'topic_id' => $this->secondTopic->id,
            'question_text' => 'What is a cell?',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('questions.index', [
                'chapter_id' => $this->chapter->id,
            ]));

        $response->assertOk();

        $response->assertViewHas(
            'questions',
            function ($questions) use (
                $matchingQuestion,
                $otherQuestion
            ) {
                return $questions->contains(
                    'id',
                    $matchingQuestion->id
                )
                && ! $questions->contains(
                    'id',
                    $otherQuestion->id
                );
            }
        );
    }

    public function test_questions_can_be_filtered_by_topic(): void
    {
        $user = $this->verifiedUser();

        $matchingQuestion = $this->createQuestion([
            'topic_id' => $this->topic->id,
            'question_text' => 'What is software?',
        ]);

        $otherQuestion = $this->createQuestion([
            'topic_id' => $this->secondTopic->id,
            'question_text' => 'What is photosynthesis?',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('questions.index', [
                'topic_id' => $this->topic->id,
            ]));

        $response->assertOk();

        $response->assertViewHas(
            'questions',
            function ($questions) use (
                $matchingQuestion,
                $otherQuestion
            ) {
                return $questions->contains(
                    'id',
                    $matchingQuestion->id
                )
                && ! $questions->contains(
                    'id',
                    $otherQuestion->id
                );
            }
        );
    }

    public function test_questions_can_be_filtered_by_question_type(): void
    {
        $user = $this->verifiedUser();

        $mcqQuestion = $this->createQuestion([
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'What is CPU?',
        ]);

        $shortQuestion = $this->createQuestion([
            'question_type' => Question::TYPE_SHORT,
            'question_text' => 'Define computer.',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('questions.index', [
                'question_type' => Question::TYPE_MCQ,
            ]));

        $response->assertOk();

        $response->assertViewHas(
            'questions',
            function ($questions) use (
                $mcqQuestion,
                $shortQuestion
            ) {
                return $questions->contains(
                    'id',
                    $mcqQuestion->id
                )
                && ! $questions->contains(
                    'id',
                    $shortQuestion->id
                );
            }
        );
    }

    public function test_questions_can_be_filtered_by_difficulty(): void
    {
        $user = $this->verifiedUser();

        $easyQuestion = $this->createQuestion([
            'difficulty' => 'easy',
            'question_text' => 'What is RAM?',
        ]);

        $hardQuestion = $this->createQuestion([
            'difficulty' => 'hard',
            'question_text' => 'Explain computer architecture.',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('questions.index', [
                'difficulty' => 'easy',
            ]));

        $response->assertOk();

        $response->assertViewHas(
            'questions',
            function ($questions) use (
                $easyQuestion,
                $hardQuestion
            ) {
                return $questions->contains(
                    'id',
                    $easyQuestion->id
                )
                && ! $questions->contains(
                    'id',
                    $hardQuestion->id
                );
            }
        );
    }

    public function test_multiple_filters_can_be_combined(): void
    {
        $user = $this->verifiedUser();

        $matchingQuestion = $this->createQuestion([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_MCQ,
            'difficulty' => 'easy',
            'question_text' => 'What is CPU?',
        ]);

        $wrongType = $this->createQuestion([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_SHORT,
            'difficulty' => 'easy',
            'question_text' => 'What is CPU?',
        ]);

        $wrongDifficulty = $this->createQuestion([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_MCQ,
            'difficulty' => 'hard',
            'question_text' => 'What is CPU?',
        ]);

        $wrongTopic = $this->createQuestion([
            'topic_id' => $this->secondTopic->id,
            'question_type' => Question::TYPE_MCQ,
            'difficulty' => 'easy',
            'question_text' => 'What is CPU?',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('questions.index', [
                'search' => 'CPU',
                'subject_id' => $this->subject->id,
                'chapter_id' => $this->chapter->id,
                'topic_id' => $this->topic->id,
                'question_type' => Question::TYPE_MCQ,
                'difficulty' => 'easy',
            ]));

        $response->assertOk();

        $response->assertViewHas(
            'questions',
            function ($questions) use (
                $matchingQuestion,
                $wrongType,
                $wrongDifficulty,
                $wrongTopic
            ) {
                return $questions->contains(
                    'id',
                    $matchingQuestion->id
                )
                && ! $questions->contains(
                    'id',
                    $wrongType->id
                )
                && ! $questions->contains(
                    'id',
                    $wrongDifficulty->id
                )
                && ! $questions->contains(
                    'id',
                    $wrongTopic->id
                );
            }
        );
    }

    public function test_soft_deleted_questions_are_not_returned(): void
    {
        $user = $this->verifiedUser();

        $activeQuestion = $this->createQuestion([
            'question_text' => 'Active computer question',
        ]);

        $deletedQuestion = $this->createQuestion([
            'question_text' => 'Deleted computer question',
        ]);

        $deletedQuestion->delete();

        $response = $this
            ->actingAs($user)
            ->get(route('questions.index', [
                'search' => 'computer',
            ]));

        $response->assertOk();

        $response->assertViewHas(
            'questions',
            function ($questions) use (
                $activeQuestion,
                $deletedQuestion
            ) {
                return $questions->contains(
                    'id',
                    $activeQuestion->id
                )
                && ! $questions->contains(
                    'id',
                    $deletedQuestion->id
                );
            }
        );
    }

    public function test_questions_are_paginated(): void
    {
        $user = $this->verifiedUser();

        for ($i = 1; $i <= 25; $i++) {
            $this->createQuestion([
                'question_text' => 'Computer question ' . $i,
            ]);
        }

        $response = $this
            ->actingAs($user)
            ->get(route('questions.index'));

        $response->assertOk();

        $response->assertViewHas(
            'questions',
            function ($questions) {
                return $questions->perPage() === 20
                    && $questions->total() === 25;
            }
        );
    }

    public function test_guest_cannot_search_questions(): void
    {
        $response = $this->get(
            route('questions.index')
        );

        $response->assertRedirect(
            route('login.form')
        );
    }

    public function test_unverified_user_cannot_search_questions(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('questions.index'));

        $response->assertRedirect(
            route('verification.notice')
        );
    }

    private function createQuestion(array $overrides = []): Question
    {
        return Question::create(array_merge([
            'topic_id' => $this->topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'Default computer question',
            'options' => [
                'A' => 'Option A',
                'B' => 'Option B',
                'C' => 'Option C',
                'D' => 'Option D',
            ],
            'answer' => 'A',
            'explanation' => 'Default explanation.',
            'marks' => 1,
            'difficulty' => 'medium',
            'status' => 'draft',
        ], $overrides));
    }

    private function verifiedUser(): User
    {
        return User::factory()->create([
            'email_verified_at' => now(),
        ]);
    }
}