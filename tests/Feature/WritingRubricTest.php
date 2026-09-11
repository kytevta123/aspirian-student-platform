<?php

namespace Tests\Feature;

use App\Models\AcademicSession;
use App\Models\Board;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\WritingRubric;
use App\Models\WritingRubricItem;
use App\Models\WritingTemplate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WritingRubricTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    private function createRubric(): WritingRubric
    {
        return WritingRubric::create([
            'title' => 'Essay Writing Rubric',
            'description' => 'Standard rubric for essay writing.',
            'writing_type' => WritingTemplate::TYPE_ESSAY,
        ]);
    }

    public function test_writing_rubric_can_be_created_with_default_status(): void
    {
        $rubric = $this->createRubric();

        $this->assertDatabaseHas('writing_rubrics', [
            'id' => $rubric->id,
            'title' => 'Essay Writing Rubric',
            'writing_type' => WritingTemplate::TYPE_ESSAY,
            'status' => 'active',
        ]);

        $this->assertTrue($rubric->isActive());
    }

    public function test_writing_rubric_belongs_to_grade(): void
    {
        $grade = Grade::where('code', 'G9')->firstOrFail();

        $rubric = WritingRubric::create([
            'title' => 'Paragraph Rubric',
            'writing_type' => WritingTemplate::TYPE_PARAGRAPH,
            'grade_id' => $grade->id,
        ]);

        $this->assertTrue(
            $rubric->grade->is($grade)
        );
    }

    public function test_writing_rubric_belongs_to_subject(): void
    {
        $subject = Subject::where('code', 'ENG')->firstOrFail();

        $rubric = WritingRubric::create([
            'title' => 'English Writing Rubric',
            'writing_type' => WritingTemplate::TYPE_ESSAY,
            'subject_id' => $subject->id,
        ]);

        $this->assertTrue(
            $rubric->subject->is($subject)
        );
    }

    public function test_writing_rubric_has_ordered_items(): void
    {
        $rubric = $this->createRubric();

        WritingRubricItem::create([
            'writing_rubric_id' => $rubric->id,
            'criterion' => 'Grammar',
            'maximum_marks' => 10,
            'sort_order' => 2,
        ]);

        WritingRubricItem::create([
            'writing_rubric_id' => $rubric->id,
            'criterion' => 'Content',
            'maximum_marks' => 10,
            'sort_order' => 1,
        ]);

        $items = $rubric->items;

        $this->assertCount(2, $items);
        $this->assertSame(
            'Content',
            $items->first()->criterion
        );
        $this->assertSame(
            'Grammar',
            $items->last()->criterion
        );
    }

    public function test_writing_rubric_has_writing_templates(): void
    {
        $rubric = $this->createRubric();

        $grade = Grade::where('code', 'G9')->firstOrFail();
        $subject = Subject::where('code', 'ENG')->firstOrFail();
        $board = Board::where('code', 'PB')->firstOrFail();
        $academicSession = AcademicSession::where(
            'name',
            '2026-27'
        )->firstOrFail();

        $template = WritingTemplate::create([
            'type' => WritingTemplate::TYPE_ESSAY,
            'title' => 'Essay Practice',
            'prompt' => 'Write an essay about the importance of education.',
            'grade_id' => $grade->id,
            'subject_id' => $subject->id,
            'board_id' => $board->id,
            'academic_session_id' => $academicSession->id,
            'language' => 'English',
            'difficulty' => WritingTemplate::DIFFICULTY_EASY,
            'writing_rubric_id' => $rubric->id,
        ]);

        $this->assertTrue(
            $rubric->writingTemplates->contains($template)
        );
    }

    public function test_writing_rubric_can_be_inactive(): void
    {
        $rubric = WritingRubric::create([
            'title' => 'Inactive Rubric',
            'writing_type' => WritingTemplate::TYPE_ESSAY,
            'status' => 'inactive',
        ]);

        $this->assertFalse($rubric->isActive());
        $this->assertSame(
            'inactive',
            $rubric->status
        );
    }
}