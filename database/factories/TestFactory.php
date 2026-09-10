<?php

namespace Database\Factories;

use App\Models\Test;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestFactory extends Factory
{
    protected $model = Test::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'instructions' => fake()->sentence(),
            'duration' => 30,
            'marks' => 10,
            'status' => Test::STATUS_PUBLISHED,
            'published_at' => now(),
        ];
    }
}