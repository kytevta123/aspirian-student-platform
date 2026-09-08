<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Create Question</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f5f5;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
        }

        h1 {
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        button,
        .back-button {
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        button {
            background: #2563eb;
            color: #ffffff;
        }

        .back-button {
            background: #e5e7eb;
            color: #111827;
        }

        .error-box {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 6px;
            background: #fef2f2;
            border: 1px solid #ef4444;
            color: #991b1b;
        }

        .error-box ul {
            margin: 0;
            padding-left: 20px;
        }

        .duplicate-warning {
            margin-bottom: 20px;
            padding: 18px;
            border-radius: 6px;
            background: #fffbeb;
            border: 1px solid #f59e0b;
            color: #92400e;
        }

        .duplicate-warning h2 {
            margin-top: 0;
        }

        .duplicate-question {
            margin-top: 12px;
            padding: 12px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 5px;
        }

        .similarity {
            display: inline-block;
            margin-top: 6px;
            padding: 4px 7px;
            background: #fef3c7;
            border-radius: 4px;
            font-size: 13px;
            font-weight: bold;
        }

        .review-actions {
            margin-top: 18px;
            display: flex;
            gap: 10px;
        }

        .confirm-button {
            background: #dc2626;
        }

        .cancel-button {
            background: #6b7280;
        }

        @media (max-width: 768px) {
            body {
                margin: 15px;
            }

            .options {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Create Question</h1>


    {{-- Validation errors --}}
    @if ($errors->any())

        <div class="error-box">

            <ul>

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- Duplicate warning --}}
    @if (session('duplicate_warning'))

        @php
            $duplicateWarning = session('duplicate_warning');
        @endphp

        <div class="duplicate-warning">

            <h2>
                ⚠ Duplicate Question Detected
            </h2>

            <p>
                This question appears to be an existing
                or very similar question.
                Please review it before saving.
            </p>


            {{-- Exact duplicate --}}
            @if (!empty($duplicateWarning['exact']))

                <div class="duplicate-question">

                    <strong>
                        Exact Duplicate
                    </strong>

                    <p>
                        {{ $duplicateWarning['exact']['question_text'] }}
                    </p>

                    <small>
                        Question ID:
                        {{ $duplicateWarning['exact']['id'] }}
                    </small>

                </div>

            @endif


            {{-- Similar questions --}}
            @if (!empty($duplicateWarning['similar']))

                <h3>
                    Similar Questions
                </h3>

                @foreach (
                    $duplicateWarning['similar']
                    as $similar
                )

                    <div class="duplicate-question">

                        <strong>
                            Similar Question
                        </strong>

                        <p>
                            {{ $similar['question_text'] }}
                        </p>

                        <small>
                            Question ID:
                            {{ $similar['id'] }}
                        </small>

                        <br>

                        <span class="similarity">

                            Similarity:
                            {{ number_format(
                                $similar['similarity_score'] * 100,
                                1
                            ) }}%

                        </span>

                    </div>

                @endforeach

            @endif


            <div class="review-actions">

                <button
                    type="button"
                    class="confirm-button"
                    onclick="document.getElementById(
                        'confirm_duplicate'
                    ).value = '1'; document.getElementById(
                        'question-form'
                    ).submit();"
                >
                    Review & Continue
                </button>

                <button
                    type="button"
                    class="cancel-button"
                    onclick="window.location.href='{{ route('questions.index') }}'"
                >
                    Cancel
                </button>

            </div>

        </div>

    @endif


    <form
        id="question-form"
        method="POST"
        action="{{ route('questions.store') }}"
    >

        @csrf

        <input
            type="hidden"
            id="confirm_duplicate"
            name="confirm_duplicate"
            value="{{ old('confirm_duplicate', '0') }}"
        >


        {{-- Topic --}}
        <div class="form-group">

            <label for="topic_id">
                Topic ID
            </label>

            <input
                type="number"
                id="topic_id"
                name="topic_id"
                value="{{ old('topic_id') }}"
                required
            >

        </div>


        {{-- Question Type --}}
        <div class="form-group">

            <label for="question_type">
                Question Type
            </label>

            <select
                id="question_type"
                name="question_type"
                required
            >

                <option value="">
                    Select Question Type
                </option>

                <option
                    value="mcq"
                    @selected(old('question_type') === 'mcq')
                >
                    MCQ
                </option>

                <option
                    value="short"
                    @selected(old('question_type') === 'short')
                >
                    Short Question
                </option>

                <option
                    value="long"
                    @selected(old('question_type') === 'long')
                >
                    Long Question
                </option>

            </select>

        </div>


        {{-- Question Text --}}
        <div class="form-group">

            <label for="question_text">
                Question Text
            </label>

            <textarea
                id="question_text"
                name="question_text"
                required
                placeholder="Enter question text..."
            >{{ old('question_text') }}</textarea>

        </div>


        {{-- MCQ Options --}}
        <div class="form-group">

            <label>
                MCQ Options
            </label>

            <div class="options">

                <input
                    type="text"
                    name="options[A]"
                    value="{{ old('options.A') }}"
                    placeholder="Option A"
                >

                <input
                    type="text"
                    name="options[B]"
                    value="{{ old('options.B') }}"
                    placeholder="Option B"
                >

                <input
                    type="text"
                    name="options[C]"
                    value="{{ old('options.C') }}"
                    placeholder="Option C"
                >

                <input
                    type="text"
                    name="options[D]"
                    value="{{ old('options.D') }}"
                    placeholder="Option D"
                >

            </div>

        </div>


        {{-- Answer --}}
        <div class="form-group">

            <label for="answer">
                Answer
            </label>

            <textarea
                id="answer"
                name="answer"
                placeholder="Enter answer..."
            >{{ old('answer') }}</textarea>

        </div>


        {{-- Explanation --}}
        <div class="form-group">

            <label for="explanation">
                Explanation
            </label>

            <textarea
                id="explanation"
                name="explanation"
                placeholder="Enter explanation..."
            >{{ old('explanation') }}</textarea>

        </div>


        {{-- Marks --}}
        <div class="form-group">

            <label for="marks">
                Marks
            </label>

            <input
                type="number"
                id="marks"
                name="marks"
                value="{{ old('marks', 1) }}"
                min="1"
                required
            >

        </div>


        {{-- Difficulty --}}
        <div class="form-group">

            <label for="difficulty">
                Difficulty
            </label>

            <select
                id="difficulty"
                name="difficulty"
                required
            >

                <option
                    value="easy"
                    @selected(old('difficulty') === 'easy')
                >
                    Easy
                </option>

                <option
                    value="medium"
                    @selected(
                        old('difficulty', 'medium') === 'medium'
                    )
                >
                    Medium
                </option>

                <option
                    value="hard"
                    @selected(old('difficulty') === 'hard')
                >
                    Hard
                </option>

            </select>

        </div>


        {{-- Status --}}
        <div class="form-group">

            <label for="status">
                Status
            </label>

            <select
                id="status"
                name="status"
                required
            >

                <option
                    value="draft"
                    @selected(
                        old('status', 'draft') === 'draft'
                    )
                >
                    Draft
                </option>

                <option
                    value="published"
                    @selected(
                        old('status') === 'published'
                    )
                >
                    Published
                </option>

            </select>

        </div>


        <div class="buttons">

            <button type="submit">
                Create Question
            </button>

            <a
                href="{{ route('questions.index') }}"
                class="back-button"
            >
                Back to Questions
            </a>

        </div>

    </form>

</div>

</body>
</html>