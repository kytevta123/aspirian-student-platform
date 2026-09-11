<?php

namespace Tests\Feature;

use App\Models\AcademicSession;
use App\Models\Board;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\EducationSystem;
use App\Models\Flashcard;
use App\Models\FlashcardProgress;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class FlashcardProgressTest extends TestCase
{
    use RefreshDatabase;

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
            'code' => 'TB' . strtoupper(substr(uniqid(), -6)),
            'status' => 'active',
        ]);

        $grade = Grade::create([
            'name' => 'Test Grade ' . uniqid(),
            'code' => 'TG' . strtoupper(substr(uniqid(), -6)),
            'level' => random_int(1000, 9999),
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $subject = Subject::create([
            'name' => 'Test Subject ' . uniqid(),
            'code' => 'TS' . strtoupper(substr(uniqid(), -6)),
            'description' => null,
            'status' => 'active',
        ]);

        $academicSession = AcademicSession::create([
            'name' => 'Test Session ' . uniqid(),
            'start_date' => now()->startOfYear()->toDateString(),
            'end_date' => now()->endOfYear()->toDateString(),
            'status' => 'active',
        ]);

        $book = Book::create([
            'board_id' => $board->id,
            'grade_id' => $grade->id,
            'subject_id' => $subject->id,
            'academic_session_id' => $academicSession->id,
            'title' => 'Flashcard Progress Book ' . uniqid(),
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

    protected function createTopic(): Topic
    {
        $structure = $this->createBookStructure();

        $chapter = Chapter::create([
            'book_id' => $structure['book']->id,
            'chapter_number' => 1,
            'title' => 'Test Chapter ' . uniqid(),
            'description' => null,
            'sort_order' => 1,
            'status' => 'active',
        ]);

        return Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Test Topic ' . uniqid(),
            'description' => null,
            'sort_order' => 1,
            'status' => 'active',
        ]);
    }

    protected function createVerifiedUser(): User
    {
        $user = User::create([
            'name' => 'Flashcard Student',
            'email' => 'flashcard' . uniqid() . '@example.com',
            'password' => Hash::make('password'),
        ]);

        $user->forceFill([
            'email_verified_at' => now(),
        ])->save();

        return $user->fresh();
    }

    protected function createFlashcard(
        Topic $topic
    ): Flashcard {
        return Flashcard::create([
            'topic_id' => $topic->id,
            'front' => 'What is Biology?',
            'back' => 'The study of life.',
            'difficulty' => Flashcard::DIFFICULTY_MEDIUM,
            'status' => Flashcard::STATUS_PUBLISHED,
        ]);
    }

    public function test_flashcard_progress_can_be_created(): void
    {
        $user = $this->createVerifiedUser();
        $topic = $this->createTopic();
        $flashcard = $this->createFlashcard($topic);

        $progress = FlashcardProgress::create([
            'user_id' => $user->id,
            'flashcard_id' => $flashcard->id,
            'status' => FlashcardProgress::STATUS_KNOWN,
            'studied_at' => now(),
        ]);

        $this->assertDatabaseHas('flashcard_progress', [
            'id' => $progress->id,
            'user_id' => $user->id,
            'flashcard_id' => $flashcard->id,
            'status' => FlashcardProgress::STATUS_KNOWN,
        ]);
    }

    public function test_flashcard_progress_defaults_to_need_revision(): void
    {
        $user = $this->createVerifiedUser();
        $topic = $this->createTopic();
        $flashcard = $this->createFlashcard($topic);

        $progress = FlashcardProgress::create([
            'user_id' => $user->id,
            'flashcard_id' => $flashcard->id,
            'studied_at' => now(),
        ]);

        $this->assertSame(
            FlashcardProgress::STATUS_NEED_REVISION,
            $progress->status
        );
    }

    public function test_flashcard_progress_belongs_to_user(): void
    {
        $user = $this->createVerifiedUser();
        $topic = $this->createTopic();
        $flashcard = $this->createFlashcard($topic);

        $progress = FlashcardProgress::create([
            'user_id' => $user->id,
            'flashcard_id' => $flashcard->id,
            'status' => FlashcardProgress::STATUS_KNOWN,
        ]);

        $this->assertTrue(
            $progress->user->is($user)
        );
    }

    public function test_flashcard_progress_belongs_to_flashcard(): void
    {
        $user = $this->createVerifiedUser();
        $topic = $this->createTopic();
        $flashcard = $this->createFlashcard($topic);

        $progress = FlashcardProgress::create([
            'user_id' => $user->id,
            'flashcard_id' => $flashcard->id,
            'status' => FlashcardProgress::STATUS_KNOWN,
        ]);

        $this->assertTrue(
            $progress->flashcard->is($flashcard)
        );
    }

    public function test_flashcard_progress_can_be_marked_need_revision(): void
    {
        $user = $this->createVerifiedUser();
        $topic = $this->createTopic();
        $flashcard = $this->createFlashcard($topic);

        $progress = FlashcardProgress::create([
            'user_id' => $user->id,
            'flashcard_id' => $flashcard->id,
            'status' => FlashcardProgress::STATUS_NEED_REVISION,
        ]);

        $this->assertSame(
            FlashcardProgress::STATUS_NEED_REVISION,
            $progress->status
        );
    }

    public function test_same_user_cannot_have_duplicate_progress_for_same_flashcard(): void
    {
        $user = $this->createVerifiedUser();
        $topic = $this->createTopic();
        $flashcard = $this->createFlashcard($topic);

        FlashcardProgress::create([
            'user_id' => $user->id,
            'flashcard_id' => $flashcard->id,
            'status' => FlashcardProgress::STATUS_KNOWN,
        ]);

        $this->expectException(
            \Illuminate\Database\QueryException::class
        );

        FlashcardProgress::create([
            'user_id' => $user->id,
            'flashcard_id' => $flashcard->id,
            'status' => FlashcardProgress::STATUS_NEED_REVISION,
        ]);
    }
}