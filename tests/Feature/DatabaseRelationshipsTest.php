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
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseRelationshipsTest extends TestCase
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
            'description' => 'Computer Science subject',
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

        $chapter = Chapter::create([
            'book_id' => $book->id,
            'chapter_number' => 1,
            'title' => 'Introduction to Computer',
            'description' => 'Basic introduction to computers.',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        $topic = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Introduction to Computers',
            'description' => 'Basic concepts of computers.',
            'sort_order' => 1,
            'status' => 'active',
        ]);

        return [
            'educationSystem' => $educationSystem,
            'board' => $board,
            'grade' => $grade,
            'subject' => $subject,
            'academicSession' => $academicSession,
            'book' => $book,
            'chapter' => $chapter,
            'topic' => $topic,
        ];
    }

    public function test_education_system_has_boards(): void
    {
        $data = $this->createAcademicStructure();

        $this->assertTrue(
            $data['educationSystem']->boards->contains($data['board'])
        );
    }

    public function test_board_belongs_to_education_system(): void
    {
        $data = $this->createAcademicStructure();

        $this->assertTrue(
            $data['board']->educationSystem->is($data['educationSystem'])
        );
    }

    public function test_board_has_books(): void
    {
        $data = $this->createAcademicStructure();

        $this->assertTrue(
            $data['board']->books->contains($data['book'])
        );
    }

    public function test_book_has_academic_relationships(): void
    {
        $data = $this->createAcademicStructure();

        $book = $data['book'];

        $this->assertTrue($book->board->is($data['board']));
        $this->assertTrue($book->grade->is($data['grade']));
        $this->assertTrue($book->subject->is($data['subject']));
        $this->assertTrue(
            $book->academicSession->is($data['academicSession'])
        );
    }

    public function test_grade_has_books(): void
    {
        $data = $this->createAcademicStructure();

        $this->assertTrue(
            $data['grade']->books->contains($data['book'])
        );
    }

    public function test_subject_has_books(): void
    {
        $data = $this->createAcademicStructure();

        $this->assertTrue(
            $data['subject']->books->contains($data['book'])
        );
    }

    public function test_academic_session_has_books(): void
    {
        $data = $this->createAcademicStructure();

        $this->assertTrue(
            $data['academicSession']->books->contains($data['book'])
        );
    }

    public function test_book_has_chapters(): void
    {
        $data = $this->createAcademicStructure();

        $this->assertTrue(
            $data['book']->chapters->contains($data['chapter'])
        );
    }

    public function test_chapter_belongs_to_book(): void
    {
        $data = $this->createAcademicStructure();

        $this->assertTrue(
            $data['chapter']->book->is($data['book'])
        );
    }

    public function test_chapter_has_topics(): void
    {
        $data = $this->createAcademicStructure();

        $this->assertTrue(
            $data['chapter']->topics->contains($data['topic'])
        );
    }

    public function test_topic_belongs_to_chapter(): void
    {
        $data = $this->createAcademicStructure();

        $this->assertTrue(
            $data['topic']->chapter->is($data['chapter'])
        );
    }

    public function test_school_has_school_classes(): void
    {
        $data = $this->createAcademicStructure();

        $school = School::create([
            'name' => 'Aspirian Public School',
            'code' => 'APS001',
            'email' => 'school@example.com',
            'phone' => '03000000000',
            'address' => 'Lahore, Pakistan',
            'status' => 'active',
        ]);

        $schoolClass = SchoolClass::create([
            'school_id' => $school->id,
            'grade_id' => $data['grade']->id,
            'academic_session_id' => $data['academicSession']->id,
            'name' => 'Class 9-A',
            'status' => 'active',
        ]);

        $this->assertTrue(
            $school->schoolClasses->contains($schoolClass)
        );
    }

    public function test_school_class_belongs_to_school(): void
    {
        $data = $this->createAcademicStructure();

        $school = School::create([
            'name' => 'Aspirian Public School',
            'code' => 'APS002',
            'status' => 'active',
        ]);

        $schoolClass = SchoolClass::create([
            'school_id' => $school->id,
            'grade_id' => $data['grade']->id,
            'academic_session_id' => $data['academicSession']->id,
            'name' => 'Class 9-A',
            'status' => 'active',
        ]);

        $this->assertTrue(
            $schoolClass->school->is($school)
        );
    }

    public function test_school_class_belongs_to_grade_and_academic_session(): void
    {
        $data = $this->createAcademicStructure();

        $school = School::create([
            'name' => 'Aspirian Public School',
            'code' => 'APS003',
            'status' => 'active',
        ]);

        $schoolClass = SchoolClass::create([
            'school_id' => $school->id,
            'grade_id' => $data['grade']->id,
            'academic_session_id' => $data['academicSession']->id,
            'name' => 'Class 9-A',
            'status' => 'active',
        ]);

        $this->assertTrue(
            $schoolClass->grade->is($data['grade'])
        );

        $this->assertTrue(
            $schoolClass->academicSession->is($data['academicSession'])
        );
    }

    public function test_grade_has_school_classes(): void
    {
        $data = $this->createAcademicStructure();

        $school = School::create([
            'name' => 'Aspirian Public School',
            'code' => 'APS004',
            'status' => 'active',
        ]);

        $schoolClass = SchoolClass::create([
            'school_id' => $school->id,
            'grade_id' => $data['grade']->id,
            'academic_session_id' => $data['academicSession']->id,
            'name' => 'Class 9-A',
            'status' => 'active',
        ]);

        $this->assertTrue(
            $data['grade']->schoolClasses->contains($schoolClass)
        );
    }

    public function test_academic_session_has_school_classes(): void
    {
        $data = $this->createAcademicStructure();

        $school = School::create([
            'name' => 'Aspirian Public School',
            'code' => 'APS005',
            'status' => 'active',
        ]);

        $schoolClass = SchoolClass::create([
            'school_id' => $school->id,
            'grade_id' => $data['grade']->id,
            'academic_session_id' => $data['academicSession']->id,
            'name' => 'Class 9-A',
            'status' => 'active',
        ]);

        $this->assertTrue(
            $data['academicSession']->schoolClasses->contains($schoolClass)
        );
    }
}