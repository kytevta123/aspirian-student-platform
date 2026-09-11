<?php

namespace Tests\Feature;

use App\Models\AcademicSession;
use App\Models\Board;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\User;
use App\Models\WritingAttempt;
use App\Models\WritingTemplate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class WritingAttemptTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    private function createStudent(): User
    {
        $user = User::create([
            'name' => 'Writing Student',
            'email' => 'writing' . uniqid() . '@example.com',
            'password' => Hash::make('password'),
        ]);

        $user->forceFill([
            'email_verified_at' => now(),
        ])->save();

        return $user;
    }

    private function createTemplate(): WritingTemplate
    {
        $grade = Grade::where('code', 'G9')->firstOrFail();
        $subject = Subject::where('code', 'ENG')->firstOrFail();
        $board = Board::where('code', 'PB')->firstOrFail();
        $academicSession = AcademicSession::where(
            'name',
            '2026-27'
        )->firstOrFail();

        return WritingTemplate::create([
            'type' => WritingTemplate::TYPE_ESSAY,
            'title' => 'Importance of Education',
            'prompt' => 'Write an essay about the importance of education.',
            'instructions' => 'Write a well-organized essay.',
            'grade_id' => $grade->id,
            'subject_id' => $subject->id,
            'board_id' => $board->id,
            'academic_session_id' => $academicSession->id,
            'language' => 'English',
            'difficulty' => WritingTemplate::DIFFICULTY_EASY,
            'marks' => 10,
            'minimum_words' => 100,
            'maximum_words' => 200,
        ]);
    }

    public function test_writing_attempt_can_be_created_as_draft(): void
    {
        $student = $this->createStudent();
        $template = $this->createTemplate();

        $attempt = WritingAttempt::create([
            'writing_template_id' => $template->id,
            'student_id' => $student->id,
            'attempt_number' => 1,
            'content' => 'Education is important for personal and social development.',
        ]);

        $this->assertDatabaseHas('writing_attempts', [
            'id' => $attempt->id,
            'writing_template_id' => $template->id,
            'student_id' => $student->id,
            'attempt_number' => 1,
            'status' => WritingAttempt::STATUS_DRAFT,
        ]);

        $this->assertTrue($attempt->isDraft());
    }

    public function test_writing_attempt_belongs_to_template_and_student(): void
    {
        $student = $this->createStudent();
        $template = $this->createTemplate();

        $attempt = WritingAttempt::create([
            'writing_template_id' => $template->id,
            'student_id' => $student->id,
            'attempt_number' => 1,
            'content' => 'Education helps students develop knowledge and skills.',
        ]);

        $this->assertTrue(
            $attempt->writingTemplate->is($template)
        );

        $this->assertTrue(
            $attempt->student->is($student)
        );
    }

    public function test_writing_attempt_can_store_counts_and_self_review(): void
    {
        $student = $this->createStudent();
        $template = $this->createTemplate();

        $attempt = WritingAttempt::create([
            'writing_template_id' => $template->id,
            'student_id' => $student->id,
            'attempt_number' => 1,
            'content' => 'Education is important for everyone.',
            'word_count' => 6,
            'character_count' => 38,
            'self_review' => 'I need to improve my vocabulary.',
        ]);

        $this->assertSame(6, $attempt->word_count);
        $this->assertSame(38, $attempt->character_count);
        $this->assertSame(
            'I need to improve my vocabulary.',
            $attempt->self_review
        );
    }

    public function test_writing_attempt_supports_submitted_and_reviewed_statuses(): void
    {
        $student = $this->createStudent();
        $template = $this->createTemplate();

        $attempt = WritingAttempt::create([
            'writing_template_id' => $template->id,
            'student_id' => $student->id,
            'attempt_number' => 1,
            'content' => 'Education is important for personal growth.',
            'status' => WritingAttempt::STATUS_SUBMITTED,
        ]);

        $this->assertTrue($attempt->isSubmitted());

        $attempt->update([
            'status' => WritingAttempt::STATUS_REVIEWED,
        ]);

        $attempt->refresh();

        $this->assertTrue($attempt->isReviewed());
    }

    public function test_writing_attempt_can_be_an_improved_attempt(): void
    {
        $student = $this->createStudent();
        $template = $this->createTemplate();

        $firstAttempt = WritingAttempt::create([
            'writing_template_id' => $template->id,
            'student_id' => $student->id,
            'attempt_number' => 1,
            'content' => 'Education is important.',
            'status' => WritingAttempt::STATUS_REVIEWED,
        ]);

        $secondAttempt = WritingAttempt::create([
            'writing_template_id' => $template->id,
            'student_id' => $student->id,
            'attempt_number' => 2,
            'content' => 'Education is important because it develops knowledge and skills.',
            'improved_from_attempt_id' => $firstAttempt->id,
        ]);

        $this->assertTrue(
            $secondAttempt->improvedFromAttempt->is($firstAttempt)
        );

        $this->assertTrue(
            $secondAttempt->hasImprovedFromAttempt()
        );

        $this->assertTrue(
            $firstAttempt->improvedAttempts->contains($secondAttempt)
        );
    }

    public function test_writing_attempt_has_default_counts_and_status(): void
    {
        $student = $this->createStudent();
        $template = $this->createTemplate();

        $attempt = WritingAttempt::create([
            'writing_template_id' => $template->id,
            'student_id' => $student->id,
            'attempt_number' => 1,
            'content' => 'Education is important.',
        ]);

        $this->assertSame(
            WritingAttempt::STATUS_DRAFT,
            $attempt->status
        );

        $this->assertSame(0, $attempt->word_count);
        $this->assertSame(0, $attempt->character_count);
    }
}