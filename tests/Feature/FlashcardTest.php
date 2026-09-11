<?php

namespace Tests\Feature;

use App\Models\Board;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\EducationSystem;
use App\Models\Flashcard;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FlashcardTest extends TestCase
{
    use RefreshDatabase;

    public function test_flashcard_can_be_created(): void
    {
        $user = User::factory()->create();

        $topic = $this->createTopic();

        $flashcard = Flashcard::create([
            'topic_id' => $topic->id,
            'user_id' => $user->id,
            'front' => 'What is photosynthesis?',
            'back' => 'The process by which green plants make food using light energy.',
            'difficulty' => Flashcard::DIFFICULTY_EASY,
            'status' => Flashcard::STATUS_PUBLISHED,
        ]);

        $this->assertDatabaseHas('flashcards', [
            'id' => $flashcard->id,
            'topic_id' => $topic->id,
            'user_id' => $user->id,
            'front' => 'What is photosynthesis?',
            'back' => 'The process by which green plants make food using light energy.',
            'difficulty' => Flashcard::DIFFICULTY_EASY,
            'status' => Flashcard::STATUS_PUBLISHED,
        ]);
    }

    public function test_flashcard_has_medium_difficulty_by_default(): void
    {
        $topic = $this->createTopic();

        $flashcard = Flashcard::create([
            'topic_id' => $topic->id,
            'front' => 'What is a cell?',
            'back' => 'The basic structural and functional unit of life.',
        ]);

        $this->assertSame(
            Flashcard::DIFFICULTY_MEDIUM,
            $flashcard->difficulty
        );
    }

    public function test_flashcard_has_draft_status_by_default(): void
    {
        $topic = $this->createTopic();

        $flashcard = Flashcard::create([
            'topic_id' => $topic->id,
            'front' => 'What is DNA?',
            'back' => 'DNA carries genetic information.',
        ]);

        $this->assertSame(
            Flashcard::STATUS_DRAFT,
            $flashcard->status
        );
    }

    public function test_flashcard_belongs_to_topic(): void
    {
        $topic = $this->createTopic();

        $flashcard = Flashcard::create([
            'topic_id' => $topic->id,
            'front' => 'What is a computer?',
            'back' => 'An electronic device that processes data.',
        ]);

        $this->assertTrue(
            $flashcard->topic->is($topic)
        );
    }

    public function test_flashcard_belongs_to_user(): void
    {
        $user = User::factory()->create();

        $topic = $this->createTopic();

        $flashcard = Flashcard::create([
            'topic_id' => $topic->id,
            'user_id' => $user->id,
            'front' => 'What is HTML?',
            'back' => 'HTML is used to structure web pages.',
        ]);

        $this->assertTrue(
            $flashcard->user->is($user)
        );
    }

    public function test_flashcard_can_be_archived(): void
    {
        $topic = $this->createTopic();

        $flashcard = Flashcard::create([
            'topic_id' => $topic->id,
            'front' => 'What is CSS?',
            'back' => 'CSS is used to style web pages.',
        ]);

        $flashcard->update([
            'status' => Flashcard::STATUS_ARCHIVED,
        ]);

        $this->assertDatabaseHas('flashcards', [
            'id' => $flashcard->id,
            'status' => Flashcard::STATUS_ARCHIVED,
        ]);
    }

    protected function createTopic(): Topic
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

        $academicSession = \App\Models\AcademicSession::create([
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
            'title' => 'Flashcard Test Book ' . uniqid(),
            'publisher' => null,
            'edition' => null,
            'status' => 'active',
        ]);

        $chapter = Chapter::create([
            'book_id' => $book->id,
            'chapter_number' => 1,
            'title' => 'Flashcard Test Chapter',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        return Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Flashcard Test Topic',
            'sort_order' => 1,
            'status' => 'active',
        ]);
    }
}