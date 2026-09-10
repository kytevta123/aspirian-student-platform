<?php

namespace Database\Factories;

use App\Models\Test;
use App\Models\TestAttempt;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestAttemptFactory extends Factory
{
    protected $model = TestAttempt::class;

    public function definition(): array
    {
        $startedAt = now()->subMinutes(10);

        return [
            'test_id' => Test::factory(),
            'user_id' => User::factory(),
            'started_at' => $startedAt,
            'expires_at' => $startedAt->copy()->addMinutes(30),
            'submitted_at' => now(),
            'status' => TestAttempt::STATUS_SUBMITTED,
        ];
    }
}