<?php

namespace Database\Factories;

use App\Models\Test;
use App\Models\TestAttempt;
use App\Models\TestResult;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestResultFactory extends Factory
{
    protected $model = TestResult::class;

    public function definition(): array
    {
        $user = User::factory();
        $test = Test::factory();

        return [
            'test_attempt_id' => TestAttempt::factory()
                ->for($test)
                ->for($user),
            'test_id' => $test,
            'user_id' => $user,
            'total_marks' => 10,
            'obtained_marks' => 5,
            'percentage' => 50.00,
            'correct_answers' => 5,
            'wrong_answers' => 3,
            'unanswered' => 2,
            'status' => TestResult::STATUS_PASSED,
        ];
    }
}