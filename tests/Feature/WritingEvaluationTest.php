<?php

namespace Tests\Feature;

use App\Models\AcademicSession;
use App\Models\Board;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\User;
use App\Models\WritingAttempt;
use App\Models\WritingEvaluation;
use App\Models\WritingTemplate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class WritingEvaluationTest extends TestCase
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
            'name' => 'Evaluation Student',
            'email' => 'evaluation' . uniqid() . '@example.com',
            'password' => Hash::make('password'),
        ]);

        $user->forceFill([
            'email_verified_at' => now(),
        ])->save();

        return $user;
    }

    private function createAttempt(): WritingAttempt
    {
        $grade = Grade::where('code', 'G9')->firstOrFail();
        $subject = Subject::where('code', 'ENG')->firstOrFail();
        $board = Board::where('code', 'PB')->firstOrFail();
        $academicSession = AcademicSession::where(
            'name',
            '2026-27'
        )->firstOrFail();

        $template = WritingTemplate::create([
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
        ]);

        return WritingAttempt::create([
            'writing_template_id' => $template->id,
            'student_id' => $this->createStudent()->id,
            'attempt_number' => 1,
            'content' => 'Education is important for personal and social development.',
            'status' => WritingAttempt::STATUS_SUBMITTED,
        ]);
    }

    public function test_writing_evaluation_can_be_created_as_pending(): void
    {
        $attempt = $this->createAttempt();

        $evaluation = WritingEvaluation::create([
            'writing_attempt_id' => $attempt->id,
            'evaluator_type' => WritingEvaluation::EVALUATOR_SYSTEM,
        ]);

        $this->assertDatabaseHas('writing_evaluations', [
            'id' => $evaluation->id,
            'writing_attempt_id' => $attempt->id,
            'evaluator_type' => WritingEvaluation::EVALUATOR_SYSTEM,
            'status' => WritingEvaluation::STATUS_PENDING,
        ]);

        $this->assertTrue($evaluation->isPending());
    }

    public function test_writing_evaluation_belongs_to_writing_attempt(): void
    {
        $attempt = $this->createAttempt();

        $evaluation = WritingEvaluation::create([
            'writing_attempt_id' => $attempt->id,
            'evaluator_type' => WritingEvaluation::EVALUATOR_TEACHER,
        ]);

        $this->assertTrue(
            $evaluation->writingAttempt->is($attempt)
        );

        $this->assertTrue(
            $attempt->evaluations->contains($evaluation)
        );
    }

    public function test_writing_evaluation_supports_all_evaluator_types(): void
    {
        $this->assertSame(
            [
                WritingEvaluation::EVALUATOR_TEACHER,
                WritingEvaluation::EVALUATOR_AI,
                WritingEvaluation::EVALUATOR_SYSTEM,
            ],
            WritingEvaluation::EVALUATOR_TYPES
        );

        $attempt = $this->createAttempt();

        $teacherEvaluation = WritingEvaluation::create([
            'writing_attempt_id' => $attempt->id,
            'evaluator_type' => WritingEvaluation::EVALUATOR_TEACHER,
        ]);

        $aiEvaluation = WritingEvaluation::create([
            'writing_attempt_id' => $attempt->id,
            'evaluator_type' => WritingEvaluation::EVALUATOR_AI,
        ]);

        $systemEvaluation = WritingEvaluation::create([
            'writing_attempt_id' => $attempt->id,
            'evaluator_type' => WritingEvaluation::EVALUATOR_SYSTEM,
        ]);

        $this->assertTrue(
            $teacherEvaluation->isTeacherEvaluation()
        );

        $this->assertTrue(
            $aiEvaluation->isAiEvaluation()
        );

        $this->assertTrue(
            $systemEvaluation->isSystemEvaluation()
        );
    }

    public function test_writing_evaluation_can_store_rubric_scores_and_feedback(): void
    {
        $attempt = $this->createAttempt();

        $evaluation = WritingEvaluation::create([
            'writing_attempt_id' => $attempt->id,
            'evaluator_type' => WritingEvaluation::EVALUATOR_TEACHER,
            'content_score' => 9,
            'grammar_score' => 8,
            'vocabulary_score' => 9,
            'organization_score' => 8,
            'spelling_score' => 10,
            'relevance_score' => 9,
            'overall_score' => 53,
            'feedback' => 'Good writing with clear ideas.',
            'strengths' => 'Strong vocabulary and relevant content.',
            'improvements' => 'Improve paragraph organization.',
        ]);

        $this->assertSame(9, $evaluation->content_score);
        $this->assertSame(8, $evaluation->grammar_score);
        $this->assertSame(9, $evaluation->vocabulary_score);
        $this->assertSame(8, $evaluation->organization_score);
        $this->assertSame(10, $evaluation->spelling_score);
        $this->assertSame(9, $evaluation->relevance_score);
        $this->assertSame(53, $evaluation->overall_score);

        $this->assertSame(
            'Good writing with clear ideas.',
            $evaluation->feedback
        );

        $this->assertSame(
            'Strong vocabulary and relevant content.',
            $evaluation->strengths
        );

        $this->assertSame(
            'Improve paragraph organization.',
            $evaluation->improvements
        );
    }

    public function test_writing_evaluation_supports_completed_and_revised_statuses(): void
    {
        $attempt = $this->createAttempt();

        $evaluation = WritingEvaluation::create([
            'writing_attempt_id' => $attempt->id,
            'evaluator_type' => WritingEvaluation::EVALUATOR_AI,
            'status' => WritingEvaluation::STATUS_COMPLETED,
        ]);

        $this->assertTrue($evaluation->isCompleted());

        $evaluation->update([
            'status' => WritingEvaluation::STATUS_REVISED,
        ]);

        $evaluation->refresh();

        $this->assertTrue($evaluation->isRevised());
    }

    public function test_writing_evaluation_can_have_a_user_evaluator(): void
    {
        $attempt = $this->createAttempt();
        $teacher = $this->createStudent();

        $evaluation = WritingEvaluation::create([
            'writing_attempt_id' => $attempt->id,
            'evaluator_type' => WritingEvaluation::EVALUATOR_TEACHER,
            'evaluator_id' => $teacher->id,
        ]);

        $this->assertTrue(
            $evaluation->evaluator->is($teacher)
        );
    }
}