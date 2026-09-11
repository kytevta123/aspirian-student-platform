<?php

namespace Tests\Feature;

use App\Models\AcademicSession;
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
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class FlashcardControllerTest extends TestCase
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
            'title' => 'Flashcard Study Book ' . uniqid(),
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
        return User::create([
            'name' => 'Flashcard Student',
            'email' => 'flashcard' . uniqid() . '@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }

    protected function createFlashcard(
        Topic $topic,
        ?User $user = null,
        string $status = Flashcard::STATUS_PUBLISHED,
        string $front = 'What is Biology?',
        string $back = 'The study of life.'
    ): Flashcard {
        return Flashcard::create([
            'topic_id' => $topic->id,
            'user_id' => $user?->id,
            'front' => $front,
            'back' => $back,
            'difficulty' => Flashcard::DIFFICULTY_MEDIUM,
            'status' => $status,
        ]);
    }

    public function test_guest_cannot_access_flashcard_study_page(): void
    {
        $topic = $this->createTopic();

        $flashcard = $this->createFlashcard($topic);

        $response = $this->get(
            route('flashcards.study', $flashcard)
        );

        $response->assertRedirect(
            route('login.form')
        );
    }

    public function test_unverified_user_cannot_access_flashcard_study_page(): void
    {
        $topic = $this->createTopic();

        $flashcard = $this->createFlashcard($topic);

        $user = User::create([
            'name' => 'Unverified Student',
            'email' => 'unverified' . uniqid() . '@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => null,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(
                route('flashcards.study', $flashcard)
            );

        $response->assertRedirect(
            route('verification.notice')
        );
    }

    public function test_verified_user_can_access_published_flashcard_study_page(): void
    {
        $topic = $this->createTopic();

        $user = $this->createVerifiedUser();

        $flashcard = $this->createFlashcard(
            $topic,
            $user,
            Flashcard::STATUS_PUBLISHED,
            'What is Biodiversity?',
            'The variety of life on Earth.'
        );

        $response = $this
            ->actingAs($user)
            ->get(
                route('flashcards.study', $flashcard)
            );

        $response->assertOk();

        $response->assertViewIs('flashcards.study');

        $response->assertViewHas(
            'flashcard',
            fn ($viewFlashcard) =>
                $viewFlashcard->is($flashcard)
        );

        $response->assertSee('What is Biodiversity?');

        $response->assertSee(
            'The variety of life on Earth.'
        );
    }

    public function test_draft_flashcard_cannot_be_studied(): void
    {
        $topic = $this->createTopic();

        $user = $this->createVerifiedUser();

        $flashcard = $this->createFlashcard(
            $topic,
            $user,
            Flashcard::STATUS_DRAFT
        );

        $response = $this
            ->actingAs($user)
            ->get(
                route('flashcards.study', $flashcard)
            );

        $response->assertNotFound();
    }

    public function test_previous_and_next_published_flashcards_are_available(): void
    {
        $topic = $this->createTopic();

        $user = $this->createVerifiedUser();

        $first = $this->createFlashcard(
            $topic,
            $user,
            Flashcard::STATUS_PUBLISHED,
            'Question One',
            'Answer One'
        );

        $second = $this->createFlashcard(
            $topic,
            $user,
            Flashcard::STATUS_PUBLISHED,
            'Question Two',
            'Answer Two'
        );

        $third = $this->createFlashcard(
            $topic,
            $user,
            Flashcard::STATUS_PUBLISHED,
            'Question Three',
            'Answer Three'
        );

        $response = $this
            ->actingAs($user)
            ->get(
                route('flashcards.study', $second)
            );

        $response->assertOk();

        $response->assertViewHas(
            'previousFlashcard',
            fn ($previousFlashcard) =>
                $previousFlashcard?->is($first)
        );

        $response->assertViewHas(
            'nextFlashcard',
            fn ($nextFlashcard) =>
                $nextFlashcard?->is($third)
        );
    }

    public function test_first_published_flashcard_has_no_previous_flashcard(): void
    {
        $topic = $this->createTopic();

        $user = $this->createVerifiedUser();

        $first = $this->createFlashcard(
            $topic,
            $user,
            Flashcard::STATUS_PUBLISHED
        );

        $response = $this
            ->actingAs($user)
            ->get(
                route('flashcards.study', $first)
            );

        $response->assertOk();

        $response->assertViewHas(
            'previousFlashcard',
            null
        );
    }

    public function test_last_published_flashcard_has_no_next_flashcard(): void
    {
        $topic = $this->createTopic();

        $user = $this->createVerifiedUser();

        $last = $this->createFlashcard(
            $topic,
            $user,
            Flashcard::STATUS_PUBLISHED
        );

        $response = $this
            ->actingAs($user)
            ->get(
                route('flashcards.study', $last)
            );

        $response->assertOk();

        $response->assertViewHas(
            'nextFlashcard',
            null
        );
    }

    public function test_study_page_counts_only_published_flashcards(): void
    {
        $topic = $this->createTopic();

        $user = $this->createVerifiedUser();

        $first = $this->createFlashcard(
            $topic,
            $user,
            Flashcard::STATUS_PUBLISHED,
            'Published One',
            'Answer One'
        );

        $second = $this->createFlashcard(
            $topic,
            $user,
            Flashcard::STATUS_PUBLISHED,
            'Published Two',
            'Answer Two'
        );

        $this->createFlashcard(
            $topic,
            $user,
            Flashcard::STATUS_DRAFT,
            'Draft Card',
            'Draft Answer'
        );

        $response = $this
            ->actingAs($user)
            ->get(
                route('flashcards.study', $second)
            );

        $response->assertOk();

        $response->assertViewHas(
            'totalFlashcards',
            2
        );

        $response->assertViewHas(
            'currentPosition',
            2
        );

        $response->assertViewHas(
            'flashcard',
            fn ($flashcard) =>
                $flashcard->is($second)
        );
    }

    public function test_first_published_flashcard_has_position_one(): void
    {
        $topic = $this->createTopic();

        $user = $this->createVerifiedUser();

        $first = $this->createFlashcard(
            $topic,
            $user,
            Flashcard::STATUS_PUBLISHED
        );

        $this->createFlashcard(
            $topic,
            $user,
            Flashcard::STATUS_PUBLISHED
        );

        $response = $this
            ->actingAs($user)
            ->get(
                route('flashcards.study', $first)
            );

        $response->assertOk();

        $response->assertViewHas(
            'currentPosition',
            1
        );

        $response->assertViewHas(
            'totalFlashcards',
            2
        );
    }
}
