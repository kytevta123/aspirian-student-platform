<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition(): array
    {
        return [
            'topic_id' => Topic::factory(),
            'question_type' => Question::TYPE_MCQ,
            'question_text' => fake()->sentence(8),
            'normalized_text' => null,
            'options' => [
                'A' => 'Option A',
                'B' => 'Option B',
                'C' => 'Option C',
                'D' => 'Option D',
            ],
            'answer' => 'A',
            'explanation' => fake()->sentence(),
            'marks' => 1,
            'difficulty' => 'medium',
            'status' => 'draft',
        ];
    }
}