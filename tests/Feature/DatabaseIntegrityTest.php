<?php

namespace Tests\Feature;

use App\Models\AcademicSession;
use App\Models\Board;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\EducationSystem;
use App\Models\Grade;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseIntegrityTest extends TestCase
{
    use RefreshDatabase;

    private function createAcademicStructure(): array
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

        $subject = Subject::create([
            'name' => 'Computer Science',
            'code' => 'CS',
            'status' => 'active',
        ]);

        $academicSession = AcademicSession::create([
            'name' => '2026-27',
            'start_date' => '2026-04-01',
            'end_date' => '2027-03-31',
            'status' => 'active',
        ]);

        $book = Book::create([
            'board_id' => $board->id,
            'grade_id' => $grade->id,
            'subject_id' => $subject->id,
            'academic_session_id' => $academicSession->id,
            'title' => 'Computer Science Class 9',
            'publisher' => 'Punjab Textbook Board',
            'edition' => '2026',
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

    public function test_board_requires_valid_education_system(): void
    {
        $this->expectException(QueryException::class);

        Board::create([
            'education_system_id' => 999999,
            'name' => 'Invalid Board',
            'code' => 'INVALID',
            'status' => 'active',
        ]);
    }

    public function test_book_requires_valid_board(): void
    {
        $data = $this->createAcademicStructure();

        $this->expectException(QueryException::class);

        Book::create([
            'board_id' => 999999,
            'grade_id' => $data['grade']->id,
            'subject_id' => $data['subject']->id,
            'academic_session_id' => $data['academicSession']->id,
            'title' => 'Invalid Book',
        ]);
    }

    public function test_book_requires_valid_grade(): void
    {
        $data = $this->createAcademicStructure();

        $this->expectException(QueryException::class);

        Book::create([
            'board_id' => $data['board']->id,
            'grade_id' => 999999,
            'subject_id' => $data['subject']->id,
            'academic_session_id' => $data['academicSession']->id,
            'title' => 'Invalid Book',
        ]);
    }

    public function test_book_requires_valid_subject(): void
    {
        $data = $this->createAcademicStructure();

        $this->expectException(QueryException::class);

        Book::create([
            'board_id' => $data['board']->id,
            'grade_id' => $data['grade']->id,
            'subject_id' => 999999,
            'academic_session_id' => $data['academicSession']->id,
            'title' => 'Invalid Book',
        ]);
    }

    public function test_book_requires_valid_academic_session(): void
    {
        $data = $this->createAcademicStructure();

        $this->expectException(QueryException::class);

        Book::create([
            'board_id' => $data['board']->id,
            'grade_id' => $data['grade']->id,
            'subject_id' => $data['subject']->id,
            'academic_session_id' => 999999,
            'title' => 'Invalid Book',
        ]);
    }

    public function test_chapter_requires_valid_book(): void
    {
        $this->expectException(QueryException::class);

        Chapter::create([
            'book_id' => 999999,
            'chapter_number' => 1,
            'title' => 'Invalid Chapter',
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

    public function test_school_class_requires_valid_school(): void
    {
        $data = $this->createAcademicStructure();

        $this->expectException(QueryException::class);

        SchoolClass::create([
            'school_id' => 999999,
            'grade_id' => $data['grade']->id,
            'academic_session_id' => $data['academicSession']->id,
            'name' => 'Invalid Class',
        ]);
    }

    public function test_school_class_requires_valid_grade(): void
    {
        $data = $this->createAcademicStructure();

        $school = School::create([
            'name' => 'Aspirian Public School',
            'code' => 'APS001',
            'status' => 'active',
        ]);

        $this->expectException(QueryException::class);

        SchoolClass::create([
            'school_id' => $school->id,
            'grade_id' => 999999,
            'academic_session_id' => $data['academicSession']->id,
            'name' => 'Class 9-A',
        ]);
    }

    public function test_school_class_requires_valid_academic_session(): void
    {
        $data = $this->createAcademicStructure();

        $school = School::create([
            'name' => 'Aspirian Public School',
            'code' => 'APS002',
            'status' => 'active',
        ]);

        $this->expectException(QueryException::class);

        SchoolClass::create([
            'school_id' => $school->id,
            'grade_id' => $data['grade']->id,
            'academic_session_id' => 999999,
            'name' => 'Class 9-A',
        ]);
    }

    public function test_subject_code_must_be_unique(): void
    {
        Subject::create([
            'name' => 'Computer Science',
            'code' => 'CS',
            'status' => 'active',
        ]);

        $this->expectException(QueryException::class);

        Subject::create([
            'name' => 'Computer Studies',
            'code' => 'CS',
            'status' => 'active',
        ]);
    }

    public function test_board_code_must_be_unique(): void
    {
        EducationSystem::create([
            'name' => 'Pakistan Education System',
            'country' => 'Pakistan',
            'status' => 'active',
        ]);

        $educationSystem = EducationSystem::first();

        Board::create([
            'education_system_id' => $educationSystem->id,
            'name' => 'Punjab Board',
            'code' => 'PB',
            'status' => 'active',
        ]);

        $this->expectException(QueryException::class);

        Board::create([
            'education_system_id' => $educationSystem->id,
            'name' => 'Punjab Board Duplicate',
            'code' => 'PB',
            'status' => 'active',
        ]);
    }

    public function test_school_code_must_be_unique(): void
    {
        School::create([
            'name' => 'Aspirian Public School',
            'code' => 'APS001',
            'status' => 'active',
        ]);

        $this->expectException(QueryException::class);

        School::create([
            'name' => 'Another School',
            'code' => 'APS001',
            'status' => 'active',
        ]);
    }

    public function test_chapter_number_must_be_unique_within_book(): void
    {
        $data = $this->createAcademicStructure();

        Chapter::create([
            'book_id' => $data['book']->id,
            'chapter_number' => 1,
            'title' => 'Introduction to Computer',
        ]);

        $this->expectException(QueryException::class);

        Chapter::create([
            'book_id' => $data['book']->id,
            'chapter_number' => 1,
            'title' => 'Duplicate Chapter',
        ]);
    }

    public function test_same_chapter_number_can_exist_in_different_books(): void
    {
        $data = $this->createAcademicStructure();

        $bookTwo = Book::create([
            'board_id' => $data['board']->id,
            'grade_id' => $data['grade']->id,
            'subject_id' => $data['subject']->id,
            'academic_session_id' => $data['academicSession']->id,
            'title' => 'Computer Science Second Book',
            'status' => 'active',
        ]);

        $chapterOne = Chapter::create([
            'book_id' => $data['book']->id,
            'chapter_number' => 1,
            'title' => 'Introduction',
        ]);

        $chapterTwo = Chapter::create([
            'book_id' => $bookTwo->id,
            'chapter_number' => 1,
            'title' => 'Introduction',
        ]);

        $this->assertDatabaseHas('chapters', [
            'id' => $chapterOne->id,
            'book_id' => $data['book']->id,
            'chapter_number' => 1,
        ]);

        $this->assertDatabaseHas('chapters', [
            'id' => $chapterTwo->id,
            'book_id' => $bookTwo->id,
            'chapter_number' => 1,
        ]);
    }

    public function test_school_class_name_must_be_unique_within_school_and_session(): void
    {
        $data = $this->createAcademicStructure();

        $school = School::create([
            'name' => 'Aspirian Public School',
            'code' => 'APS003',
            'status' => 'active',
        ]);

        SchoolClass::create([
            'school_id' => $school->id,
            'grade_id' => $data['grade']->id,
            'academic_session_id' => $data['academicSession']->id,
            'name' => 'Class 9-A',
        ]);

        $this->expectException(QueryException::class);

        SchoolClass::create([
            'school_id' => $school->id,
            'grade_id' => $data['grade']->id,
            'academic_session_id' => $data['academicSession']->id,
            'name' => 'Class 9-A',
        ]);
    }

    public function test_soft_deleted_topic_is_not_returned_by_default(): void
    {
        $data = $this->createAcademicStructure();

        $chapter = Chapter::create([
            'book_id' => $data['book']->id,
            'chapter_number' => 1,
            'title' => 'Introduction',
        ]);

        $topic = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Computer Basics',
        ]);

        $topic->delete();

        $this->assertSoftDeleted('topics', [
            'id' => $topic->id,
        ]);

        $this->assertNull(
            Topic::find($topic->id)
        );

        $this->assertNotNull(
            Topic::withTrashed()->find($topic->id)
        );
    }

    public function test_soft_deleted_book_is_not_returned_by_default(): void
    {
        $data = $this->createAcademicStructure();

        $book = $data['book'];

        $book->delete();

        $this->assertSoftDeleted('books', [
            'id' => $book->id,
        ]);

        $this->assertNull(
            Book::find($book->id)
        );

        $this->assertNotNull(
            Book::withTrashed()->find($book->id)
        );
    }
}