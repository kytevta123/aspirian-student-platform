<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Question Search</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f5f5;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
        }

        h1 {
            margin-bottom: 25px;
        }

        .filters {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .filters input,
        .filters select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        button,
        .clear-button {
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        button {
            background: #2563eb;
            color: white;
        }

        .clear-button {
            background: #e5e7eb;
            color: #111827;
        }

        /*
         * Duplicate warning
         */
        .duplicate-warning {
            margin: 25px 0;
            padding: 20px;
            border: 1px solid #f59e0b;
            background: #fffbeb;
            border-radius: 8px;
        }

        .duplicate-warning h2 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #92400e;
            font-size: 20px;
        }

        .duplicate-warning p {
            margin-bottom: 15px;
            color: #78350f;
        }

        .duplicate-item {
            padding: 15px;
            margin-top: 12px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
        }

        .duplicate-item strong {
            display: block;
            margin-bottom: 6px;
        }

        .duplicate-score {
            display: inline-block;
            margin-top: 8px;
            padding: 4px 8px;
            border-radius: 4px;
            background: #fef3c7;
            color: #92400e;
            font-size: 13px;
            font-weight: bold;
        }

        .review-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .review-button {
            background: #dc2626;
            color: #ffffff;
            padding: 10px 18px;
            border-radius: 5px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .dismiss-button {
            background: #e5e7eb;
            color: #111827;
            padding: 10px 18px;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        /*
         * Success message
         */
        .success-message {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #16a34a;
            background: #f0fdf4;
            color: #166534;
            border-radius: 6px;
        }

        .question {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 6px;
        }

        .question-text {
            font-size: 17px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .meta {
            color: #555;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .status {
            display: inline-block;
            padding: 4px 8px;
            background: #eee;
            border-radius: 4px;
            font-size: 12px;
        }

        .empty {
            padding: 25px;
            text-align: center;
            color: #666;
        }

        .pagination {
            margin-top: 25px;
        }

        @media (max-width: 768px) {
            body {
                margin: 15px;
            }

            .filters {
                grid-template-columns: 1fr;
            }

            .review-actions {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Question Search</h1>

    {{-- Success message --}}
    @if (session('status'))
        <div class="success-message">
            {{ session('status') }}
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
                The question you submitted appears to be
                an existing or very similar question.
                Please review the questions below before continuing.
            </p>


            {{-- Exact duplicate --}}
            @if (!empty($duplicateWarning['exact']))

                <div class="duplicate-item">

                    <strong>
                        Exact Duplicate
                    </strong>

                    <div>
                        {{ $duplicateWarning['exact']['question_text'] }}
                    </div>

                    <div class="meta">
                        Question ID:
                        {{ $duplicateWarning['exact']['id'] }}
                    </div>

                </div>

            @endif


            {{-- Similar questions --}}
            @if (!empty($duplicateWarning['similar']))

                <h3>
                    Similar Questions
                </h3>

                @foreach ($duplicateWarning['similar'] as $similar)

                    <div class="duplicate-item">

                        <strong>
                            Similar Question
                        </strong>

                        <div>
                            {{ $similar['question_text'] }}
                        </div>

                        <div class="meta">
                            Question ID:
                            {{ $similar['id'] }}
                        </div>

                        <span class="duplicate-score">
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

                {{-- 
                    At this stage the user should review the
                    existing question before continuing.
                    The actual confirmation submit will be
                    connected to the Create/Edit form.
                --}}

                <button
                    type="button"
                    class="review-button"
                    onclick="window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    })"
                >
                    Review & Continue
                </button>

                <button
                    type="button"
                    class="dismiss-button"
                    onclick="this.closest('.duplicate-warning').remove()"
                >
                    Cancel
                </button>

            </div>

        </div>

    @endif


    <form method="GET" action="{{ route('questions.index') }}">

        <div class="filters">

            <div>
                <label for="search">
                    Keyword
                </label>

                <input
                    type="text"
                    id="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search question..."
                >
            </div>


            <div>
                <label for="subject_id">
                    Subject ID
                </label>

                <input
                    type="number"
                    id="subject_id"
                    name="subject_id"
                    value="{{ request('subject_id') }}"
                    placeholder="Subject ID"
                >
            </div>


            <div>
                <label for="chapter_id">
                    Chapter ID
                </label>

                <input
                    type="number"
                    id="chapter_id"
                    name="chapter_id"
                    value="{{ request('chapter_id') }}"
                    placeholder="Chapter ID"
                >
            </div>


            <div>
                <label for="topic_id">
                    Topic ID
                </label>

                <input
                    type="number"
                    id="topic_id"
                    name="topic_id"
                    value="{{ request('topic_id') }}"
                    placeholder="Topic ID"
                >
            </div>


            <div>
                <label for="question_type">
                    Question Type
                </label>

                <select
                    id="question_type"
                    name="question_type"
                >
                    <option value="">
                        All Types
                    </option>

                    <option
                        value="mcq"
                        @selected(
                            request('question_type') === 'mcq'
                        )
                    >
                        MCQ
                    </option>

                    <option
                        value="short"
                        @selected(
                            request('question_type') === 'short'
                        )
                    >
                        Short Question
                    </option>

                    <option
                        value="long"
                        @selected(
                            request('question_type') === 'long'
                        )
                    >
                        Long Question
                    </option>
                </select>
            </div>


            <div>
                <label for="difficulty">
                    Difficulty
                </label>

                <select
                    id="difficulty"
                    name="difficulty"
                >
                    <option value="">
                        All Difficulties
                    </option>

                    <option
                        value="easy"
                        @selected(
                            request('difficulty') === 'easy'
                        )
                    >
                        Easy
                    </option>

                    <option
                        value="medium"
                        @selected(
                            request('difficulty') === 'medium'
                        )
                    >
                        Medium
                    </option>

                    <option
                        value="hard"
                        @selected(
                            request('difficulty') === 'hard'
                        )
                    >
                        Hard
                    </option>
                </select>
            </div>

        </div>


        <div class="buttons">

            <button type="submit">
                Search
            </button>

            <a
                href="{{ route('questions.index') }}"
                class="clear-button"
            >
                Clear
            </a>

        </div>

    </form>


    <hr>


    @forelse ($questions as $question)

        <div class="question">

            <div class="question-text">
                {{ $question->question_text }}
            </div>


            <div class="meta">
                <strong>Type:</strong>
                {{ strtoupper($question->question_type) }}
            </div>


            <div class="meta">
                <strong>Difficulty:</strong>
                {{ ucfirst($question->difficulty) }}
            </div>


            <div class="meta">
                <strong>Marks:</strong>
                {{ $question->marks }}
            </div>


            <div class="meta">
                <strong>Subject:</strong>
                {{ $question->topic?->chapter?->book?->subject?->name ?? 'N/A' }}
            </div>


            <div class="meta">
                <strong>Topic:</strong>
                {{ $question->topic?->title ?? 'N/A' }}
            </div>


            <span class="status">
                {{ ucfirst($question->status) }}
            </span>

        </div>

    @empty

        <div class="empty">
            No questions found.
        </div>

    @endforelse


    <div class="pagination">
        {{ $questions->links() }}
    </div>

</div>

</body>
</html>