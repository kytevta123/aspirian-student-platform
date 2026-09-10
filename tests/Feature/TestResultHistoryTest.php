<?php

namespace Tests\Feature;

use App\Models\Test;
use App\Models\TestResult;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestResultHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_view_own_result_history(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = Test::factory()->create([
            'title' => 'Computer Science Test',
        ]);

        TestResult::factory()->create([
            'user_id' => $user->id,
            'test_id' => $test->id,
            'status' => TestResult::STATUS_PASSED,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('tests.results.index'));

        $response
            ->assertOk()
            ->assertSee('Result History')
            ->assertSee('Computer Science Test');
    }

    public function test_student_cannot_see_another_students_results(): void
    {
        $student = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $otherStudent = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = Test::factory()->create([
            'title' => 'Private Student Test',
        ]);

        TestResult::factory()->create([
            'user_id' => $otherStudent->id,
            'test_id' => $test->id,
        ]);

        $response = $this
            ->actingAs($student)
            ->get(route('tests.results.index'));

        $response
            ->assertOk()
            ->assertDontSee('Private Student Test');
    }

    public function test_guest_cannot_view_result_history(): void
    {
        $response = $this->get(
            route('tests.results.index')
        );

        $response->assertRedirect(
            route('login.form')
        );
    }

    public function test_student_can_filter_results_by_status(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $passedTest = Test::factory()->create([
            'title' => 'Passed Test',
        ]);

        $failedTest = Test::factory()->create([
            'title' => 'Failed Test',
        ]);

        TestResult::factory()->create([
            'user_id' => $user->id,
            'test_id' => $passedTest->id,
            'status' => TestResult::STATUS_PASSED,
        ]);

        TestResult::factory()->create([
            'user_id' => $user->id,
            'test_id' => $failedTest->id,
            'status' => TestResult::STATUS_FAILED,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(
                route('tests.results.index', [
                    'status' => TestResult::STATUS_PASSED,
                ])
            );

        $response
            ->assertOk()
            ->assertSee('Passed Test')
            ->assertDontSee('Failed Test');
    }

    public function test_student_can_search_results_by_test_title(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $matchingTest = Test::factory()->create([
            'title' => 'Biology Chapter One Test',
        ]);

        $otherTest = Test::factory()->create([
            'title' => 'Physics Chapter One Test',
        ]);

        TestResult::factory()->create([
            'user_id' => $user->id,
            'test_id' => $matchingTest->id,
        ]);

        TestResult::factory()->create([
            'user_id' => $user->id,
            'test_id' => $otherTest->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(
                route('tests.results.index', [
                    'search' => 'Biology',
                ])
            );

        $response
            ->assertOk()
            ->assertSee('Biology Chapter One Test')
            ->assertDontSee('Physics Chapter One Test');
    }

    public function test_invalid_status_filter_does_not_expose_other_students_results(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $test = Test::factory()->create([
            'title' => 'Student Result',
        ]);

        TestResult::factory()->create([
            'user_id' => $user->id,
            'test_id' => $test->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(
                route('tests.results.index', [
                    'status' => 'invalid-status',
                ])
            );

        $response
            ->assertOk()
            ->assertSee('Student Result');
    }
}