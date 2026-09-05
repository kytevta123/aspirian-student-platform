<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function store(
        StoreQuestionRequest $request
    ): RedirectResponse {
        Question::create(
            $request->validated()
        );

        return back()->with(
            'status',
            'Question created successfully.'
        );
    }

    public function update(
        UpdateQuestionRequest $request,
        Question $question
    ): RedirectResponse {
        $validated = $request->validated();

        $question->revisions()->create([
            'user_id' => Auth::id(),
            'question_data' => [
                'topic_id' => $question->topic_id,
                'question_type' => $question->question_type,
                'question_text' => $question->question_text,
                'options' => $question->options,
                'answer' => $question->answer,
                'explanation' => $question->explanation,
                'marks' => $question->marks,
                'difficulty' => $question->difficulty,
                'status' => $question->status,
            ],
        ]);

        $question->update($validated);

        return back()->with(
            'status',
            'Question updated successfully.'
        );
    }

    public function destroy(
        Question $question
    ): RedirectResponse {
        $question->delete();

        return back()->with(
            'status',
            'Question deleted successfully.'
        );
    }
}