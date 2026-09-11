<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WritingAttempt;
use App\Models\WritingTemplate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Tests\TestCase;

class WritingControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function createStudent(): User
    {
        $user = User::create([
            'name' => 'Writing Student',
            'email' => 'writing' . uniqid() . '@example.com',
            'password' => bcrypt('password'),
        ]);

        $user->forceFill([
            'email_verified_at' => now(),
        ])->save();

        return $user;
    }

    protected function createPublishedTemplate(): WritingTemplate
    {
        $this->seed();

        return WritingTemplate::create([
            'type' => WritingTemplate::TYPE_ESSAY,
            'title' => 'My School',
            'prompt' => 'Write an essay about your school.',
            'instructions' => 'Write clearly and organize your ideas.',
            'model_answer' => 'This is the model answer.',
            'grade_id' => 1,
            'subject_id' => 1,
            'board_id' => 1,
            'academic_session_id' => 1,
            'language' => 'English',
            'difficulty' => WritingTemplate::DIFFICULTY_EASY,
            'marks' => 10,
            'minimum_words' => 100,
            'maximum_words' => 200,
            'status' => WritingTemplate::STATUS_PUBLISHED,
        ]);
    }

    protected function createRequest(User $user): Request
    {
        $request = Request::create(
            '/',
            'GET'
        );

        $request->setUserResolver(
            fn () => $user
        );

        return $request;
    }

    public function test_index_returns_published_writing_templates(): void
    {
        $student = $this->createStudent();

        $template = $this->createPublishedTemplate();

        $request = $this->createRequest($student);

        $response = app(\App\Http\Controllers\WritingController::class)
            ->index($request);

        $this->assertInstanceOf(
            View::class,
            $response
        );

        $writingTemplates = $response->getData()[
            'writingTemplates'
        ];

        $this->assertTrue(
            $writingTemplates->contains(
                'id',
                $template->id
            )
        );
    }

    public function test_show_does_not_expose_model_answer(): void
    {
        $student = $this->createStudent();

        $template = $this->createPublishedTemplate();

        $request = $this->createRequest($student);

        $response = app(\App\Http\Controllers\WritingController::class)
            ->show(
                $request,
                $template
            );

        $this->assertInstanceOf(
            View::class,
            $response
        );

        $writingTemplate = $response->getData()[
            'writingTemplate'
        ];

        $this->assertNull(
            $writingTemplate->model_answer
        );
    }

    public function test_start_creates_a_new_draft_attempt(): void
    {
        $student = $this->createStudent();

        $template = $this->createPublishedTemplate();

        $request = $this->createRequest($student);

        $response = app(\App\Http\Controllers\WritingController::class)
            ->start(
                $request,
                $template
            );

        $this->assertInstanceOf(
            View::class,
            $response
        );

        $attempt = $response->getData()['attempt'];

        $this->assertDatabaseHas(
            'writing_attempts',
            [
                'id' => $attempt->id,
                'writing_template_id' => $template->id,
                'student_id' => $student->id,
                'attempt_number' => 1,
                'status' => WritingAttempt::STATUS_DRAFT,
            ]
        );
    }

    public function test_start_reuses_existing_draft_attempt(): void
    {
        $student = $this->createStudent();

        $template = $this->createPublishedTemplate();

        $existingAttempt = WritingAttempt::create([
            'writing_template_id' => $template->id,
            'student_id' => $student->id,
            'attempt_number' => 1,
            'content' => 'Existing draft.',
            'word_count' => 2,
            'character_count' => 15,
            'status' => WritingAttempt::STATUS_DRAFT,
            'started_at' => now(),
        ]);

        $request = $this->createRequest($student);

        $response = app(\App\Http\Controllers\WritingController::class)
            ->start(
                $request,
                $template
            );

        $attempt = $response->getData()['attempt'];

        $this->assertSame(
            $existingAttempt->id,
            $attempt->id
        );

        $this->assertDatabaseCount(
            'writing_attempts',
            1
        );
    }

    public function test_store_saves_draft_and_calculates_counts(): void
    {
        $student = $this->createStudent();

        $template = $this->createPublishedTemplate();

        $request = Request::create(
            '/',
            'POST',
            [
                'content' => 'My school is a beautiful place to learn.',
                'self_review' => 'I need to improve my vocabulary.',
            ]
        );

        $request->setUserResolver(
            fn () => $student
        );

        $response = app(\App\Http\Controllers\WritingController::class)
            ->store(
                $request,
                $template
            );

        $this->assertSame(
            8,
            WritingAttempt::query()
                ->where(
                    'writing_template_id',
                    $template->id
                )
                ->where(
                    'student_id',
                    $student->id
                )
                ->value('word_count')
        );

        $attempt = WritingAttempt::query()
            ->where(
                'writing_template_id',
                $template->id
            )
            ->where(
                'student_id',
                $student->id
            )
            ->firstOrFail();

        $this->assertSame(
            'My school is a beautiful place to learn.',
            $attempt->content
        );

        $this->assertSame(
            'I need to improve my vocabulary.',
            $attempt->self_review
        );

        $this->assertSame(
            8,
            $attempt->word_count
        );

        $this->assertSame(
            mb_strlen(
                'My school is a beautiful place to learn.'
            ),
            $attempt->character_count
        );

        $this->assertSame(
            route(
                'writing.start',
                $template
            ),
            $response->getTargetUrl()
        );
    }

    public function test_submit_changes_attempt_to_submitted(): void
    {
        $student = $this->createStudent();

        $template = $this->createPublishedTemplate();

        $attempt = WritingAttempt::create([
            'writing_template_id' => $template->id,
            'student_id' => $student->id,
            'attempt_number' => 1,
            'content' => '',
            'word_count' => 0,
            'character_count' => 0,
            'status' => WritingAttempt::STATUS_DRAFT,
            'started_at' => now(),
        ]);

        $request = Request::create(
            '/',
            'POST',
            [
                'content' =>
                    'My school is a wonderful place for learning.',
                'self_review' =>
                    'I should improve my sentence structure.',
            ]
        );

        $request->setUserResolver(
            fn () => $student
        );

        $response = app(\App\Http\Controllers\WritingController::class)
            ->submit(
                $request,
                $attempt
            );

        $attempt->refresh();

        $this->assertSame(
            WritingAttempt::STATUS_SUBMITTED,
            $attempt->status
        );

        $this->assertNotNull(
            $attempt->submitted_at
        );

        $this->assertSame(
            'My school is a wonderful place for learning.',
            $attempt->content
        );

        $this->assertSame(
            route(
                'writing.attempts.show',
                $attempt
            ),
            $response->getTargetUrl()
        );
    }

    public function test_student_cannot_submit_another_students_attempt(): void
    {
        $student = $this->createStudent();

        $anotherStudent = $this->createStudent();

        $template = $this->createPublishedTemplate();

        $attempt = WritingAttempt::create([
            'writing_template_id' => $template->id,
            'student_id' => $anotherStudent->id,
            'attempt_number' => 1,
            'content' => 'Another student writing.',
            'word_count' => 3,
            'character_count' => 24,
            'status' => WritingAttempt::STATUS_DRAFT,
            'started_at' => now(),
        ]);

        $request = Request::create(
            '/',
            'POST'
        );

        $request->setUserResolver(
            fn () => $student
        );

        $this->expectException(
            \Symfony\Component\HttpKernel\Exception\HttpException::class
        );

        app(\App\Http\Controllers\WritingController::class)
            ->submit(
                $request,
                $attempt
            );
    }

    public function test_show_attempt_allows_owner_to_view_submitted_attempt(): void
    {
        $student = $this->createStudent();

        $template = $this->createPublishedTemplate();

        $attempt = WritingAttempt::create([
            'writing_template_id' => $template->id,
            'student_id' => $student->id,
            'attempt_number' => 1,
            'content' => 'My submitted essay.',
            'word_count' => 3,
            'character_count' => 19,
            'status' => WritingAttempt::STATUS_SUBMITTED,
            'started_at' => now(),
            'submitted_at' => now(),
        ]);

        $request = $this->createRequest($student);

        $response = app(\App\Http\Controllers\WritingController::class)
            ->showAttempt(
                $request,
                $attempt
            );

        $this->assertInstanceOf(
            View::class,
            $response
        );

        $returnedAttempt = $response->getData()[
            'attempt'
        ];

        $this->assertSame(
            $attempt->id,
            $returnedAttempt->id
        );

        $this->assertSame(
            'This is the model answer.',
            $returnedAttempt
                ->writingTemplate
                ->model_answer
        );
    }

    public function test_show_attempt_does_not_expose_model_answer_for_draft(): void
    {
        $student = $this->createStudent();

        $template = $this->createPublishedTemplate();

        $attempt = WritingAttempt::create([
            'writing_template_id' => $template->id,
            'student_id' => $student->id,
            'attempt_number' => 1,
            'content' => 'Draft writing.',
            'word_count' => 2,
            'character_count' => 14,
            'status' => WritingAttempt::STATUS_DRAFT,
            'started_at' => now(),
        ]);

        $request = $this->createRequest($student);

        $response = app(\App\Http\Controllers\WritingController::class)
            ->showAttempt(
                $request,
                $attempt
            );

        $returnedAttempt = $response->getData()[
            'attempt'
        ];

        $this->assertNull(
            $returnedAttempt
                ->writingTemplate
                ->model_answer
        );
    }
}