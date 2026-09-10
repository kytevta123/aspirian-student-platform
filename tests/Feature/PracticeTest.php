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

class PracticeTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_practice(): void
    {
        $response = $this->get(
            route('practice.index')
        );

        $response->assertRedirect(
            route('login')
        );
    }

    public function test_unverified_user_cannot_access_practice(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('practice.index'));

        $response->assertRedirect(
            route('verification.notice')
        );
    }

    public function test_verified_user_can_access_practice(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('practice.index'));

        $response->assertOk();
        $response->assertSee('Practice');
    }

    public function test_topic_without_published_questions_is_not_shown(): void
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
            'title' => 'Practice Chapter',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $topic = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Draft Only Topic',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        Question::factory()->create([
            'topic_id' => $topic->id,
            'question_text' => 'Draft practice question',
            'status' => 'draft',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('practice.index'));

        $response->assertOk();
        $response->assertDontSee('Draft Only Topic');
        $response->assertSee(
            'No published practice topics are available yet.'
        );
    }

    public function test_topic_with_published_questions_is_shown(): void
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
            'title' => 'Published Practice Chapter',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $topic = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Published Practice Topic',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        Question::factory()->create([
            'topic_id' => $topic->id,
            'question_text' => 'Published practice question',
            'status' => 'published',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('practice.index'));

        $response->assertOk();
        $response->assertSee(
            'Published Practice Topic'
        );

        $response->assertSee('1');
        $response->assertSee('published');
        $response->assertSee('question');

        $response->assertSee(
            route('practice.start', $topic)
        );
    }

    public function test_start_practice_loads_first_published_question(): void
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
            'title' => 'First Question Chapter',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $topic = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'First Question Topic',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        Question::factory()->create([
            'topic_id' => $topic->id,
            'question_text' => 'First published practice question',
            'status' => 'published',
        ]);

        Question::factory()->create([
            'topic_id' => $topic->id,
            'question_text' => 'Second published practice question',
            'status' => 'published',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(
                route('practice.start', $topic)
            );

        $response->assertOk();
        $response->assertSee(
            'First published practice question'
        );
        $response->assertDontSee(
            'Second published practice question'
        );
    }

    public function test_draft_question_cannot_be_accessed(): void
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
            'title' => 'Draft Question Chapter',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $topic = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Draft Question Topic',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $draftQuestion = Question::factory()->create([
            'topic_id' => $topic->id,
            'question_text' => 'Draft question must stay hidden',
            'status' => 'draft',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(
                route(
                    'practice.question',
                    [$topic, $draftQuestion]
                )
            );

        $response->assertNotFound();
    }

    public function test_question_from_another_topic_cannot_be_accessed(): void
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
            'title' => 'Topic Isolation Chapter',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $topicOne = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Topic One',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $topicTwo = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Topic Two',
            'sort_order' => 2,
            'status' => 'active',
        ]);

        $questionFromTopicTwo = Question::factory()->create([
            'topic_id' => $topicTwo->id,
            'question_text' => 'Question belongs to topic two',
            'status' => 'published',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(
                route(
                    'practice.question',
                    [$topicOne, $questionFromTopicTwo]
                )
            );

        $response->assertNotFound();
    }

    public function test_correct_answer_shows_correct_feedback(): void
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
            'title' => 'Correct Answer Chapter',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $topic = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Correct Answer Topic',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $question = Question::factory()->create([
            'topic_id' => $topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'Which letter comes first?',
            'options' => [
                'A',
                'B',
                'C',
                'D',
            ],
            'answer' => 'A',
            'explanation' => 'A comes first.',
            'status' => 'published',
        ]);

        $response = $this
            ->actingAs($user)
            ->post(
                route(
                    'practice.answer',
                    [$topic, $question]
                ),
                [
                    'answer' => 'A',
                ]
            );

        $response->assertOk();
        $response->assertSee('Correct!');
        $response->assertSee(
            'Your answer is correct.'
        );
        $response->assertSee(
            'A comes first.'
        );
    }

    public function test_wrong_answer_shows_correct_answer_feedback(): void
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
            'title' => 'Wrong Answer Chapter',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $topic = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Wrong Answer Topic',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $question = Question::factory()->create([
            'topic_id' => $topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'Which letter comes first?',
            'options' => [
                'A',
                'B',
                'C',
                'D',
            ],
            'answer' => 'A',
            'explanation' => 'A comes first.',
            'status' => 'published',
        ]);

        $response = $this
            ->actingAs($user)
            ->post(
                route(
                    'practice.answer',
                    [$topic, $question]
                ),
                [
                    'answer' => 'B',
                ]
            );

        $response->assertOk();
        $response->assertSee('Incorrect');
        $response->assertSee(
            'Your answer is not correct.'
        );
        $response->assertSee(
            'Correct Answer:'
        );
        $response->assertSee('A');
        $response->assertSee(
            'A comes first.'
        );
    }

    public function test_next_published_question_is_available_after_answer(): void
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
            'title' => 'Next Question Chapter',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $topic = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Next Question Topic',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $firstQuestion = Question::factory()->create([
            'topic_id' => $topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'First practice question',
            'options' => [
                'A',
                'B',
                'C',
                'D',
            ],
            'answer' => 'A',
            'status' => 'published',
        ]);

        $secondQuestion = Question::factory()->create([
            'topic_id' => $topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => 'Second practice question',
            'options' => [
                'A',
                'B',
                'C',
                'D',
            ],
            'answer' => 'B',
            'status' => 'published',
        ]);

        $response = $this
            ->actingAs($user)
            ->post(
                route(
                    'practice.answer',
                    [$topic, $firstQuestion]
                ),
                [
                    'answer' => 'A',
                ]
            );

        $response->assertOk();
        $response->assertSee(
            'Next Question'
        );
        $response->assertSee(
            route(
                'practice.question',
                [$topic, $secondQuestion]
            )
        );
    }

    public function test_practice_answer_is_required(): void
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
            'title' => 'Validation Chapter',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $topic = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Validation Topic',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $question = Question::factory()->create([
            'topic_id' => $topic->id,
            'question_type' => Question::TYPE_MCQ,
            'options' => [
                'A',
                'B',
                'C',
                'D',
            ],
            'answer' => 'A',
            'status' => 'published',
        ]);

        $response = $this
            ->actingAs($user)
            ->post(
                route(
                    'practice.answer',
                    [$topic, $question]
                ),
                []
            );

        $response->assertSessionHasErrors('answer');
    }

    public function test_unpublished_topic_cannot_be_started(): void
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
            'title' => 'Inactive Topic Chapter',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $topic = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Inactive Practice Topic',
            'sort_order' => 1,
            'status' => 'inactive',
        ]);

        Question::factory()->create([
            'topic_id' => $topic->id,
            'status' => 'published',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(
                route('practice.start', $topic)
            );

        $response->assertNotFound();
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
            'code' => 'TB' . strtoupper(
                substr(uniqid(), -6)
            ),
            'status' => 'active',
        ]);

        $grade = Grade::create([
            'name' => 'Test Grade ' . uniqid(),
            'code' => 'TG' . strtoupper(
                substr(uniqid(), -6)
            ),
            'level' => random_int(1000, 9999),
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $subject = Subject::create([
            'name' => 'Test Subject ' . uniqid(),
            'code' => 'TS' . strtoupper(
                substr(uniqid(), -6)
            ),
            'description' => null,
            'status' => 'active',
        ]);

        $academicSession = AcademicSession::create([
            'name' => 'Test Session ' . uniqid(),
            'start_date' => now()
                ->startOfYear()
                ->toDateString(),
            'end_date' => now()
                ->endOfYear()
                ->toDateString(),
            'status' => 'active',
        ]);

        $book = Book::create([
            'board_id' => $board->id,
            'grade_id' => $grade->id,
            'subject_id' => $subject->id,
            'academic_session_id' => $academicSession->id,
            'title' => 'Practice Test Book ' . uniqid(),
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