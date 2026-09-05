<?php

namespace App\Http\Requests;

use App\Models\Question;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'topic_id' => [
                'required',
                'integer',
                'exists:topics,id',
            ],

            'question_type' => [
                'required',
                'string',
                Rule::in(Question::TYPES),
            ],

            'question_text' => [
                'required',
                'string',
            ],

            'options' => [
                'nullable',
                'array',
            ],

            'options.*' => [
                'nullable',
                'string',
            ],

            'answer' => [
                'nullable',
                'string',
            ],

            'explanation' => [
                'nullable',
                'string',
            ],

            'marks' => [
                'required',
                'integer',
                'min:1',
            ],

            'difficulty' => [
                'required',
                'string',
                Rule::in([
                    'easy',
                    'medium',
                    'hard',
                ]),
            ],

            'status' => [
                'required',
                'string',
                Rule::in([
                    'draft',
                    'published',
                ]),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'question_type.in' =>
                'The selected question type is invalid.',

            'difficulty.in' =>
                'The selected difficulty is invalid.',

            'status.in' =>
                'The selected status is invalid.',

            'marks.min' =>
                'Marks must be at least 1.',
        ];
    }
}