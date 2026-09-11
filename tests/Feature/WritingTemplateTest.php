<?php

namespace Tests\Feature;

use App\Models\AcademicSession;
use App\Models\Board;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\WritingRubric;
use App\Models\WritingTemplate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WritingTemplateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    private function createTemplate(
        array $overrides = []
    ): WritingTemplate {
        $grade = Grade::where('code', 'G9')->firstOrFail();
        $subject = Subject::where('code', 'ENG')->firstOrFail();
        $board = Board::where('code', 'PB')->firstOrFail();
        $academicSession = AcademicSession::where(
            'name',
            '2026-27'
        )->firstOrFail();

        return WritingTemplate::create(array_merge([
            'type' => WritingTemplate::TYPE_ESSAY,
            'title' => 'Importance of Education',
            'prompt' => 'Write an essay about the importance of education.',
            'instructions' => 'Write a well-organized essay.',
            'model_answer' => 'Education plays an important role in our lives.',
            'grade_id' => $grade->id,
            'subject_id' => $subject->id,
            'board_id' => $board->id,
            'academic_session_id' => $academicSession->id,
            'language' => 'English',
            'difficulty' => WritingTemplate::DIFFICULTY_EASY,
            'marks' => 10,
            'minimum_words' => 100,
            'maximum_words' => 200,
        ], $overrides));
    }

    public function test_writing_template_can_be_created_with_default_status(): void
    {
        $template = $this->createTemplate();

        $this->assertDatabaseHas('writing_templates', [
            'id' => $template->id,
            'title' => 'Importance of Education',
            'type' => WritingTemplate::TYPE_ESSAY,
            'status' => WritingTemplate::STATUS_DRAFT,
        ]);

        $this->assertTrue($template->isDraft());
    }

    public function test_writing_template_supports_all_writing_types(): void
    {
        $this->assertCount(
            15,
            WritingTemplate::TYPES
        );

        $this->assertContains(
            WritingTemplate::TYPE_ESSAY,
            WritingTemplate::TYPES
        );

        $this->assertContains(
            WritingTemplate::TYPE_PARAGRAPH,
            WritingTemplate::TYPES
        );

        $this->assertContains(
            WritingTemplate::TYPE_LETTER,
            WritingTemplate::TYPES
        );

        $this->assertContains(
            WritingTemplate::TYPE_APPLICATION,
            WritingTemplate::TYPES
        );

        $this->assertContains(
            WritingTemplate::TYPE_STORY,
            WritingTemplate::TYPES
        );

        $this->assertContains(
            WritingTemplate::TYPE_DIALOGUE,
            WritingTemplate::TYPES
        );

        $this->assertContains(
            WritingTemplate::TYPE_DESCRIPTIVE,
            WritingTemplate::TYPES
        );

        $this->assertContains(
            WritingTemplate::TYPE_CREATIVE,
            WritingTemplate::TYPES
        );

        $this->assertContains(
            WritingTemplate::TYPE_COMPREHENSION,
            WritingTemplate::TYPES
        );

        $this->assertContains(
            WritingTemplate::TYPE_SHORT_ANSWER,
            WritingTemplate::TYPES
        );

        $this->assertContains(
            WritingTemplate::TYPE_LONG_ANSWER,
            WritingTemplate::TYPES
        );
    }

    public function test_writing_template_supports_all_difficulties(): void
    {
        $this->assertSame(
            [
                WritingTemplate::DIFFICULTY_EASY,
                WritingTemplate::DIFFICULTY_MEDIUM,
                WritingTemplate::DIFFICULTY_HARD,
            ],
            WritingTemplate::DIFFICULTIES
        );
    }

    public function test_writing_template_belongs_to_academic_structure(): void
    {
        $template = $this->createTemplate();

        $this->assertTrue(
            $template->grade->is(
                Grade::where('code', 'G9')->firstOrFail()
            )
        );

        $this->assertTrue(
            $template->subject->is(
                Subject::where('code', 'ENG')->firstOrFail()
            )
        );

        $this->assertTrue(
            $template->board->is(
                Board::where('code', 'PB')->firstOrFail()
            )
        );

        $this->assertTrue(
            $template->academicSession->is(
                AcademicSession::where(
                    'name',
                    '2026-27'
                )->firstOrFail()
            )
        );
    }

    public function test_writing_template_can_have_a_rubric(): void
    {
        $rubric = WritingRubric::create([
            'title' => 'Essay Rubric',
            'writing_type' => WritingTemplate::TYPE_ESSAY,
        ]);

        $template = $this->createTemplate([
            'writing_rubric_id' => $rubric->id,
        ]);

        $this->assertTrue(
            $template->writingRubric->is($rubric)
        );

        $this->assertTrue(
            $template->hasRubric()
        );
    }

    public function test_writing_template_supports_published_and_archived_status(): void
    {
        $template = $this->createTemplate([
            'status' => WritingTemplate::STATUS_PUBLISHED,
        ]);

        $this->assertTrue($template->isPublished());

        $template->update([
            'status' => WritingTemplate::STATUS_ARCHIVED,
        ]);

        $template->refresh();

        $this->assertTrue($template->isArchived());
    }

    public function test_writing_template_casts_numeric_and_date_fields(): void
    {
        $template = $this->createTemplate([
            'marks' => 10,
            'minimum_words' => 100,
            'maximum_words' => 200,
            'published_at' => now(),
        ]);

        $this->assertIsInt($template->marks);
        $this->assertIsInt($template->minimum_words);
        $this->assertIsInt($template->maximum_words);
        $this->assertNotNull($template->published_at);
    }
}