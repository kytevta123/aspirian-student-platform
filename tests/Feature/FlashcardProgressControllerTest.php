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

class FlashcardProgressControllerTest extends TestCase
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
            'title' => 'Flashcard Progress Controller Book ' . uniqid(),
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
            'email' => 'flashcard-controller' . uniqid() . '@example.com',
            'password' => Hash::make('password'),
        ]);

        $user->forceFill([
            'email_verified_at' => now(),
        ])->save();

        return $user->fresh();
    }

    protected function createFlashcard(
        Topic $topic,
        string $status = Flashcard::STATUS_PUBLISHED
    ): Flashcard {
        return Flashcard::create([
            'topic_id' => $topic->id,
            'front' => 'What is Biology?',
            'back' => 'The study of life.',
            'difficulty' => Flashcard::DIFFICULTY_MEDIUM,
            'status' => $status,
        ]);
    }

    public function test_authenticated_verified_user_can_mark_flashcard_as_known(): void
    {
        $user = $this->createVerifiedUser();
        $topic = $this->createTopic();
        $flashcard = $this->createFlashcard($topic);

        $response = $this
            ->actingAs($user)
            ->post(
                route('flashcards.progress.store', $flashcard),
                [
                    'status' => FlashcardProgress::STATUS_KNOWN,
                ]
            );

        $response
            ->assertRedirect(
                route('flashcards.study', $flashcard)
            )
            ->assertSessionHas(
                'status',
                'Flashcard progress saved successfully.'
            );

        $this->assertDatabaseHas('flashcard_progress', [
            'user_id' => $user->id,
            'flashcard_id' => $flashcard->id,
            'status' => FlashcardProgress::STATUS_KNOWN,
        ]);
    }

    public function test_authenticated_verified_user_can_mark_flashcard_as_need_revision(): void
    {
        $user = $this->createVerifiedUser();
        $topic = $this->createTopic();
        $flashcard = $this->createFlashcard($topic);

        $response = $this
            ->actingAs($user)
            ->post(
                route('flashcards.progress.store', $flashcard),
                [
                    'status' => FlashcardProgress::STATUS_NEED_REVISION,
                ]
            );

        $response
            ->assertRedirect(
                route('flashcards.study', $flashcard)
            )
            ->assertSessionHas(
                'status',
                'Flashcard progress saved successfully.'
            );

        $this->assertDatabaseHas('flashcard_progress', [
            'user_id' => $user->id,
            'flashcard_id' => $flashcard->id,
            'status' => FlashcardProgress::STATUS_NEED_REVISION,
        ]);
    }

    public function test_existing_flashcard_progress_is_updated_instead_of_creating_duplicate(): void
    {
        $user = $this->createVerifiedUser();
        $topic = $this->createTopic();
        $flashcard = $this->createFlashcard($topic);

        $progress = FlashcardProgress::create([
            'user_id' => $user->id,
            'flashcard_id' => $flashcard->id,
            'status' => FlashcardProgress::STATUS_NEED_REVISION,
        ]);

        $response = $this
            ->actingAs($user)
            ->post(
                route('flashcards.progress.store', $flashcard),
                [
                    'status' => FlashcardProgress::STATUS_KNOWN,
                ]
            );

        $response
            ->assertRedirect(
                route('flashcards.study', $flashcard)
            );

        $this->assertDatabaseHas('flashcard_progress', [
            'id' => $progress->id,
            'user_id' => $user->id,
            'flashcard_id' => $flashcard->id,
            'status' => FlashcardProgress::STATUS_KNOWN,
        ]);

        $this->assertDatabaseCount('flashcard_progress', 1);
    }

    public function test_invalid_progress_status_is_rejected(): void
    {
        $user = $this->createVerifiedUser();
        $topic = $this->createTopic();
        $flashcard = $this->createFlashcard($topic);

        $response = $this
            ->actingAs($user)
            ->post(
                route('flashcards.progress.store', $flashcard),
                [
                    'status' => 'invalid_status',
                ]
            );

        $response->assertSessionHasErrors('status');

        $this->assertDatabaseMissing('flashcard_progress', [
            'user_id' => $user->id,
            'flashcard_id' => $flashcard->id,
        ]);
    }

    public function test_unpublished_flashcard_cannot_receive_progress(): void
    {
        $user = $this->createVerifiedUser();
        $topic = $this->createTopic();

        $flashcard = $this->createFlashcard(
            $topic,
            Flashcard::STATUS_DRAFT
        );

        $response = $this
            ->actingAs($user)
            ->post(
                route('flashcards.progress.store', $flashcard),
                [
                    'status' => FlashcardProgress::STATUS_KNOWN,
                ]
            );

        $response->assertNotFound();

        $this->assertDatabaseMissing('flashcard_progress', [
            'user_id' => $user->id,
            'flashcard_id' => $flashcard->id,
        ]);
    }

    public function test_guest_cannot_store_flashcard_progress(): void
    {
        $topic = $this->createTopic();
        $flashcard = $this->createFlashcard($topic);

        $response = $this->post(
            route('flashcards.progress.store', $flashcard),
            [
                'status' => FlashcardProgress::STATUS_KNOWN,
            ]
        );

        $response->assertRedirect('/login');

        $this->assertDatabaseCount('flashcard_progress', 0);
    }

    public function test_unverified_user_cannot_store_flashcard_progress(): void
    {
        $user = User::create([
            'name' => 'Unverified Student',
            'email' => 'unverified' . uniqid() . '@example.com',
            'password' => Hash::make('password'),
        ]);

        $topic = $this->createTopic();
        $flashcard = $this->createFlashcard($topic);

        $response = $this
            ->actingAs($user)
            ->post(
                route('flashcards.progress.store', $flashcard),
                [
                    'status' => FlashcardProgress::STATUS_KNOWN,
                ]
            );

        $response->assertRedirect('/verify-email');

        $this->assertDatabaseCount('flashcard_progress', 0);
    }
}