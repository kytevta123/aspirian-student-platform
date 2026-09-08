<?php

namespace Tests\Feature;

use App\Models\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestTest extends TestCase
{
    use RefreshDatabase;

    public function test_test_can_be_created(): void
    {
        $test = Test::create([
            'title' => 'Biology Chapter 1 Test',
            'instructions' => 'Attempt all questions.',
            'duration' => 30,
            'marks' => 20,
            'status' => Test::STATUS_DRAFT,
        ]);

        $this->assertDatabaseHas('tests', [
            'id' => $test->id,
            'title' => 'Biology Chapter 1 Test',
            'instructions' => 'Attempt all questions.',
            'duration' => 30,
            'marks' => 20,
            'status' => Test::STATUS_DRAFT,
        ]);
    }

    public function test_test_has_correct_default_values(): void
    {
        $test = Test::create([
            'title' => 'Default Test',
        ]);

        $this->assertSame(60, $test->duration);
        $this->assertSame(0, $test->marks);
        $this->assertSame(Test::STATUS_DRAFT, $test->status);
        $this->assertNull($test->published_at);
    }

    public function test_test_attributes_are_cast_correctly(): void
    {
        $test = Test::create([
            'title' => 'Casting Test',
            'duration' => '45',
            'marks' => '25',
        ]);

        $this->assertIsInt($test->duration);
        $this->assertIsInt($test->marks);
    }

    public function test_test_supports_publishing(): void
    {
        $publishedAt = now();

        $test = Test::create([
            'title' => 'Published Test',
            'status' => Test::STATUS_PUBLISHED,
            'published_at' => $publishedAt,
        ]);

        $this->assertSame(Test::STATUS_PUBLISHED, $test->status);
        $this->assertNotNull($test->published_at);

        $this->assertEquals(
            $publishedAt->format('Y-m-d H:i:s'),
            $test->published_at->format('Y-m-d H:i:s')
        );
    }

    public function test_test_supports_archived_status(): void
    {
        $test = Test::create([
            'title' => 'Archived Test',
            'status' => Test::STATUS_ARCHIVED,
        ]);

        $this->assertSame(Test::STATUS_ARCHIVED, $test->status);
    }

    public function test_test_status_constants_are_defined(): void
    {
        $this->assertSame('draft', Test::STATUS_DRAFT);
        $this->assertSame('published', Test::STATUS_PUBLISHED);
        $this->assertSame('archived', Test::STATUS_ARCHIVED);

        $this->assertSame([
            'draft',
            'published',
            'archived',
        ], Test::STATUSES);
    }
}