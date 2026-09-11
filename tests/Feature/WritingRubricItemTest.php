<?php

namespace Tests\Feature;

use App\Models\WritingRubric;
use App\Models\WritingRubricItem;
use App\Models\WritingTemplate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WritingRubricItemTest extends TestCase
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

    public function test_writing_rubric_item_can_be_created(): void
    {
        $rubric = $this->createRubric();

        $item = WritingRubricItem::create([
            'writing_rubric_id' => $rubric->id,
            'criterion' => 'Content',
            'description' => 'Measures the quality and relevance of content.',
            'maximum_marks' => 10,
            'sort_order' => 1,
        ]);

        $this->assertDatabaseHas('writing_rubric_items', [
            'id' => $item->id,
            'writing_rubric_id' => $rubric->id,
            'criterion' => 'Content',
            'maximum_marks' => 10,
            'sort_order' => 1,
        ]);
    }

    public function test_writing_rubric_item_belongs_to_rubric(): void
    {
        $rubric = $this->createRubric();

        $item = WritingRubricItem::create([
            'writing_rubric_id' => $rubric->id,
            'criterion' => 'Grammar',
            'maximum_marks' => 10,
            'sort_order' => 2,
        ]);

        $this->assertTrue(
            $item->writingRubric->is($rubric)
        );
    }

    public function test_writing_rubric_item_uses_default_sort_order(): void
    {
        $rubric = $this->createRubric();

        $item = WritingRubricItem::create([
            'writing_rubric_id' => $rubric->id,
            'criterion' => 'Vocabulary',
            'maximum_marks' => 10,
        ]);

        $this->assertSame(0, $item->sort_order);
    }

    public function test_rubric_items_can_be_ordered_by_sort_order(): void
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
        $this->assertSame('Content', $items->first()->criterion);
        $this->assertSame('Grammar', $items->last()->criterion);
    }

    public function test_rubric_item_can_store_optional_description(): void
    {
        $rubric = $this->createRubric();

        $item = WritingRubricItem::create([
            'writing_rubric_id' => $rubric->id,
            'criterion' => 'Organization',
            'description' => 'Measures logical organization of ideas.',
            'maximum_marks' => 10,
            'sort_order' => 3,
        ]);

        $this->assertSame(
            'Measures logical organization of ideas.',
            $item->description
        );
    }
}