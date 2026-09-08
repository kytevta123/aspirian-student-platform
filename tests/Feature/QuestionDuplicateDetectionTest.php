<?php

namespace Tests\Feature;

use App\Models\AcademicSession;
use App\Models\Board;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\EducationSystem;
use App\Models\Grade;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Topic;
use App\Services\QuestionDuplicateDetector;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionDuplicateDetectionTest extends TestCase
{
    use RefreshDatabase;

    private function createTopic(): Topic
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

        return Topic::create([
            'chapter_id' => $chapter->id,
            'title' => 'Introduction to Computers',
            'description' => 'Basic concepts of computers.',
            'sort_order' => 1,
            'status' => 'active',
        ]);
    }

    private function createQuestion(
        Topic $topic,
        string $text
    ): Question {
        $detector = new QuestionDuplicateDetector();

        return Question::create([
            'topic_id' => $topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => $text,
            'normalized_text' => $detector->normalize($text),
            'options' => [
                'A' => 'Option A',
                'B' => 'Option B',
                'C' => 'Option C',
                'D' => 'Option D',
            ],
            'answer' => 'Option A',
            'explanation' => 'Test explanation.',
            'marks' => 1,
            'difficulty' => 'medium',
            'status' => 'draft',
        ]);
    }

    public function test_question_text_is_normalized(): void
    {
        $detector = new QuestionDuplicateDetector();

        $normalized = $detector->normalize(
            '  What is a Computer?  '
        );

        $this->assertSame(
            'what is a computer',
            $normalized
        );
    }

    public function test_extra_spaces_are_normalized(): void
    {
        $detector = new QuestionDuplicateDetector();

        $normalized = $detector->normalize(
            'What   is    a   Computer?'
        );

        $this->assertSame(
            'what is a computer',
            $normalized
        );
    }

    public function test_uppercase_and_lowercase_are_treated_as_same(): void
    {
        $detector = new QuestionDuplicateDetector();

        $first = $detector->normalize(
            'What is a Computer?'
        );

        $second = $detector->normalize(
            'WHAT IS A COMPUTER'
        );

        $this->assertSame(
            $first,
            $second
        );
    }

    public function test_punctuation_is_ignored_for_exact_duplicate_detection(): void
    {
        $detector = new QuestionDuplicateDetector();

        $first = $detector->normalize(
            'What is a Computer?'
        );

        $second = $detector->normalize(
            'What is a Computer!'
        );

        $this->assertSame(
            $first,
            $second
        );
    }

    public function test_exact_duplicate_question_is_found(): void
    {
        $topic = $this->createTopic();

        $this->createQuestion(
            $topic,
            'What is a Computer?'
        );

        $detector = new QuestionDuplicateDetector();

        $duplicate = $detector->findExact(
            'What is a Computer?'
        );

        $this->assertNotNull($duplicate);

        $this->assertSame(
            'What is a Computer?',
            $duplicate->question_text
        );
    }

    public function test_duplicate_is_found_even_when_text_formatting_is_different(): void
    {
        $topic = $this->createTopic();

        $this->createQuestion(
            $topic,
            'What is a Computer?'
        );

        $detector = new QuestionDuplicateDetector();

        $duplicate = $detector->findExact(
            '  WHAT   IS   A COMPUTER! '
        );

        $this->assertNotNull($duplicate);
    }

    public function test_non_duplicate_question_returns_null(): void
    {
        $topic = $this->createTopic();

        $this->createQuestion(
            $topic,
            'What is a Computer?'
        );

        $detector = new QuestionDuplicateDetector();

        $duplicate = $detector->findExact(
            'What is an Operating System?'
        );

        $this->assertNull($duplicate);
    }

    public function test_current_question_can_be_excluded_during_update(): void
    {
        $topic = $this->createTopic();

        $question = $this->createQuestion(
            $topic,
            'What is a Computer?'
        );

        $detector = new QuestionDuplicateDetector();

        $duplicate = $detector->findExact(
            'What is a Computer?',
            $question->id
        );

        $this->assertNull($duplicate);
    }

    public function test_soft_deleted_question_is_not_returned_as_duplicate(): void
    {
        $topic = $this->createTopic();

        $question = $this->createQuestion(
            $topic,
            'What is a Computer?'
        );

        $question->delete();

        $detector = new QuestionDuplicateDetector();

        $duplicate = $detector->findExact(
            'What is a Computer?'
        );

        $this->assertNull($duplicate);
    }

    public function test_identical_questions_have_full_similarity(): void
    {
        $detector = new QuestionDuplicateDetector();

        $score = $detector->similarity(
            'What is a Computer?',
            'What is a Computer?'
        );

        $this->assertSame(
            1.0,
            $score
        );
    }

    public function test_similar_questions_have_high_similarity(): void
    {
        $detector = new QuestionDuplicateDetector();

        $score = $detector->similarity(
            'What is a computer?',
            'What is a computer system?'
        );

        $this->assertGreaterThanOrEqual(
            0.80,
            $score
        );
    }

    public function test_different_questions_have_low_similarity(): void
    {
        $detector = new QuestionDuplicateDetector();

        $score = $detector->similarity(
            'What is a computer?',
            'What is photosynthesis in plants?'
        );

        $this->assertLessThan(
            0.80,
            $score
        );
    }

    public function test_similar_questions_can_be_found(): void
    {
        $topic = $this->createTopic();

        $this->createQuestion(
            $topic,
            'What is a computer?'
        );

        $this->createQuestion(
            $topic,
            'What is an operating system?'
        );

        $detector = new QuestionDuplicateDetector();

        $similar = $detector->findSimilar(
            'What is a computer system?',
            0.80
        );

        $this->assertNotEmpty($similar);

        $this->assertSame(
            'What is a computer?',
            $similar->first()->question_text
        );

        $this->assertGreaterThanOrEqual(
            0.80,
            $similar->first()->similarity_score
        );
    }

    public function test_current_question_can_be_excluded_from_similarity_results(): void
    {
        $topic = $this->createTopic();

        $question = $this->createQuestion(
            $topic,
            'What is a computer?'
        );

        $detector = new QuestionDuplicateDetector();

        $similar = $detector->findSimilar(
            'What is a computer system?',
            0.80,
            $question->id
        );

        $this->assertEmpty($similar);
    }

    public function test_duplicate_warning_data_contains_exact_duplicate(): void
    {
        $topic = $this->createTopic();

        $existingQuestion = $this->createQuestion(
            $topic,
            'What is a Computer?'
        );

        $detector = new QuestionDuplicateDetector();

        $exactDuplicate = $detector->findExact(
            'What is a Computer?'
        );

        $this->assertNotNull($exactDuplicate);

        $this->assertSame(
            $existingQuestion->id,
            $exactDuplicate->id
        );
    }

    public function test_similar_question_warning_contains_similarity_score(): void
    {
        $topic = $this->createTopic();

        $this->createQuestion(
            $topic,
            'What is a computer?'
        );

        $detector = new QuestionDuplicateDetector();

        $similar = $detector->findSimilar(
            'What is a computer system?',
            0.80
        );

        $this->assertNotEmpty($similar);

        $this->assertNotNull(
            $similar->first()->similarity_score
        );

        $this->assertGreaterThanOrEqual(
            0.80,
            $similar->first()->similarity_score
        );
    }

    public function test_normalized_text_is_stored_when_question_is_created(): void
    {
        $topic = $this->createTopic();

        $detector = new QuestionDuplicateDetector();

        $questionText =
            '  What   is   a Computer?  ';

        $question = Question::create([
            'topic_id' => $topic->id,
            'question_type' => Question::TYPE_MCQ,
            'question_text' => $questionText,
            'normalized_text' =>
                $detector->normalize($questionText),
            'options' => [
                'A' => 'Option A',
                'B' => 'Option B',
                'C' => 'Option C',
                'D' => 'Option D',
            ],
            'answer' => 'Option A',
            'explanation' => 'Test explanation.',
            'marks' => 1,
            'difficulty' => 'medium',
            'status' => 'draft',
        ]);

        $this->assertSame(
            'what is a computer',
            $question->normalized_text
        );
    }

    public function test_duplicate_detection_excludes_soft_deleted_questions(): void
    {
        $topic = $this->createTopic();

        $question = $this->createQuestion(
            $topic,
            'What is a Computer?'
        );

        $question->delete();

        $detector = new QuestionDuplicateDetector();

        $exactDuplicate = $detector->findExact(
            'What is a Computer?'
        );

        $similarQuestions = $detector->findSimilar(
            'What is a Computer?',
            0.80
        );

        $this->assertNull(
            $exactDuplicate
        );

        $this->assertEmpty(
            $similarQuestions
        );
    }
}