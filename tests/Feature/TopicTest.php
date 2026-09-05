<?php

namespace Tests\Feature;

use App\Models\AcademicSession;
use App\Models\Board;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\EducationSystem;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TopicTest extends TestCase
{
    use RefreshDatabase;

    private function createChapter(): Chapter
    {
        $educationSystem = EducationSystem::create([
            'name' => 'Pakistan Education System',
            'country' => 'Pakistan',
            'status' => 'active',
        ]);

        $board = Board::create([
            'education_system_id' => $educationSystem->id,
            'name' => 'Punjab Board',
            'code' => 'PB',
            'status' => 'active',
        ]);

        $grade = Grade::create([
            'name' => 'Class 9',
            'code' => 'G9',
            'level' => 9,
            'sort_order' => 9,
            'status' => 'active',
        ]);

        $session = AcademicSession::create([
            'name' => '2026-27',
            'start_date' => '2026-04-01',
            'end_date' => '2027-03-31',
            'status' => 'active',
        ]);

        $subject = Subject::create([
            'name' => 'Computer Science',
            'code' => 'CS',
            'status' => 'active',
        ]);

        $book = Book::create([
            'board_id' => $board->id,
            'grade_id' => $grade->id,
            'subject_id' => $subject->id,
            'academic_session_id' => $session->id,
            'title' => 'Computer Science Class 9',
            'publisher' => 'Punjab Textbook Board',
            'edition' => '2026',
            'status' => 'active',
        ]);

        return Chapter::create([
            'book_id' => $book->id,
            'chapter_number' => 1,
            'title' => 'Introduction to Computer',
            'description' => 'Basic introduction to computers.',
            'sort_order' => 1,
            'status' => 'active',
        ]);
    }

    public function test_topic_can_be_created(): void
    {
        $chapter = $this->createChapter();

        $topic = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Introduction to Computers',
            'description' => 'Basic concepts of computers.',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('topics', [
            'id' => $topic->id,
            'chapter_id' => $chapter->id,
            'title' => 'Introduction to Computers',
            'status' => 'active',
        ]);
    }

    public function test_topic_belongs_to_chapter(): void
    {
        $chapter = $this->createChapter();

        $topic = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Computer Basics',
            'sort_order' => 1,
        ]);

        $this->assertTrue(
            $topic->chapter->is($chapter)
        );
    }

    public function test_chapter_has_topics_relationship(): void
    {
        $chapter = $this->createChapter();

        $topic = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Computer Basics',
            'sort_order' => 1,
        ]);

        $this->assertTrue(
            $chapter->topics->contains($topic)
        );
    }

    public function test_topic_can_be_soft_deleted(): void
    {
        $chapter = $this->createChapter();

        $topic = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Computer Basics',
            'sort_order' => 1,
        ]);

        $topic->delete();

        $this->assertSoftDeleted('topics', [
            'id' => $topic->id,
        ]);
    }

    public function test_topic_status_defaults_to_active(): void
    {
        $chapter = $this->createChapter();

        Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Computer Basics',
        ]);

        $this->assertDatabaseHas('topics', [
            'chapter_id' => $chapter->id,
            'title' => 'Computer Basics',
            'status' => 'active',
        ]);
    }

    public function test_topic_requires_valid_chapter(): void
    {
        $this->expectException(QueryException::class);

        Topic::create([
            'chapter_id' => 999999,
            'title' => 'Invalid Topic',
        ]);
    }
}