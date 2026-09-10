<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Practice Question | Aspirian</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }

        .practice-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .practice-header {
            margin-bottom: 25px;
        }

        .practice-header h1 {
            margin: 0 0 8px;
            font-size: 30px;
        }

        .practice-header p {
            margin: 0;
            color: #6b7280;
            font-size: 15px;
        }

        .question-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
        }

        .question-meta {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 22px;
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 6px;
            background: #eef2ff;
            color: #3730a3;
            font-size: 13px;
            font-weight: 600;
        }

        .question-number {
            margin-bottom: 12px;
            color: #6b7280;
            font-size: 14px;
            font-weight: 600;
        }

        .question-text {
            margin-bottom: 25px;
            font-size: 22px;
            line-height: 1.6;
            font-weight: 600;
        }

        .options {
            display: grid;
            gap: 12px;
        }

        .option {
            display: block;
            padding: 15px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .option:hover {
            background: #f9fafb;
            border-color: #9ca3af;
        }

        .option input {
            margin-right: 10px;
        }

        .option-label {
            display: inline-block;
            min-width: 25px;
            font-weight: 700;
        }

        .submit-button {
            margin-top: 22px;
            padding: 11px 18px;
            border: 0;
            border-radius: 8px;
            background: #2563eb;
            color: #ffffff;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
        }

        .submit-button:hover {
            background: #1d4ed8;
        }

        .feedback {
            margin-top: 25px;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid;
        }

        .feedback.correct {
            background: #ecfdf5;
            border-color: #86efac;
        }

        .feedback.incorrect {
            background: #fef2f2;
            border-color: #fca5a5;
        }

        .feedback-title {
            margin: 0 0 10px;
            font-size: 20px;
            font-weight: 700;
        }

        .feedback p {
            margin: 7px 0;
            line-height: 1.5;
        }

        .next-button {
            display: inline-block;
            margin-top: 15px;
            padding: 11px 18px;
            border-radius: 8px;
            background: #059669;
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
        }

        .next-button:hover {
            background: #047857;
        }

        .completed-message {
            margin-top: 15px;
            color: #166534;
            font-weight: 600;
        }

        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 16px;
            border-radius: 8px;
            background: #6b7280;
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
        }

        .back-button:hover {
            background: #4b5563;
        }

        @media (max-width: 640px) {
            .practice-container {
                padding: 25px 15px;
            }

            .question-card {
                padding: 20px;
            }

            .practice-header h1 {
                font-size: 26px;
            }

            .question-text {
                font-size: 19px;
            }
        }
    </style>
</head>

<body>

<div class="practice-container">

    <div class="practice-header">

        <h1>
            {{ $topic->title }}
        </h1>

        @if ($topic->chapter)
            <p>
                Chapter:
                {{ $topic->chapter->title }}
            </p>
        @endif

    </div>

    <div class="question-card">

        <div class="question-meta">

            <span class="badge">
                {{ strtoupper($question->question_type) }}
            </span>

            <span class="badge">
                {{ ucfirst($question->difficulty) }}
            </span>

            <span class="badge">
                {{ $question->marks }}
                {{ $question->marks === 1 ? 'Mark' : 'Marks' }}
            </span>

        </div>

        <div class="question-number">
            Question 1
        </div>

        <div class="question-text">
            {{ $question->question_text }}
        </div>

        @if (
            $question->question_type === \App\Models\Question::TYPE_MCQ
            && is_array($question->options)
            && count($question->options) > 0
        )

            <form
                method="POST"
                action="{{ route('practice.answer', [$topic, $question]) }}"
            >

                @csrf

                <div class="options">

                    @foreach (
                        array_values($question->options)
                        as $index => $option
                    )

                        <label class="option">

                            <input
                                type="radio"
                                name="answer"
                                value="{{ $option }}"
                                required
                                @if (
                                    $feedback
                                    && $feedback['submitted_answer'] === $option
                                )
                                    checked
                                @endif
                            >

                            <span class="option-label">
                                {{ chr(65 + $index) }}.
                            </span>

                            {{ $option }}

                        </label>

                    @endforeach

                </div>

                @if (! $feedback)

                    <button
                        type="submit"
                        class="submit-button"
                    >
                        Submit Answer
                    </button>

                @endif

            </form>

        @else

            <div class="question-footer">
                This question type will be supported in the
                next practice interaction phase.
            </div>

        @endif

        @if ($feedback)

            <div
                class="feedback
                    {{ $feedback['is_correct']
                        ? 'correct'
                        : 'incorrect'
                    }}"
            >

                @if ($feedback['is_correct'])

                    <div class="feedback-title">
                        Correct! 🎉
                    </div>

                    <p>
                        Your answer is correct.
                    </p>

                @else

                    <div class="feedback-title">
                        Incorrect
                    </div>

                    <p>
                        Your answer is not correct.
                    </p>

                    <p>
                        <strong>
                            Correct Answer:
                        </strong>

                        {{ $feedback['correct_answer'] }}
                    </p>

                @endif

                @if (
                    ! empty($feedback['explanation'])
                )

                    <p>
                        <strong>
                            Explanation:
                        </strong>

                        {{ $feedback['explanation'] }}
                    </p>

                @endif

            </div>

            @if ($nextQuestion)

                <a
                    href="{{ route(
                        'practice.question',
                        [$topic, $nextQuestion]
                    ) }}"
                    class="next-button"
                >
                    Next Question
                </a>

            @else

                <div class="completed-message">
                    🎉 You have completed all published
                    questions in this topic.
                </div>

            @endif

        @endif

    </div>

    <a
        href="{{ route('practice.index') }}"
        class="back-button"
    >
        Back to Practice Topics
    </a>

</div>

</body>
</html>