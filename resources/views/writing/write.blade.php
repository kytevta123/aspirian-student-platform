<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Write: {{ $writingTemplate->title }} | Aspirian
    </title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }

        .writing-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .writing-header {
            margin-bottom: 25px;
        }

        .writing-header h1 {
            margin: 0 0 12px;
            font-size: 32px;
        }

        .writing-header p {
            margin: 0;
            color: #6b7280;
            line-height: 1.6;
        }

        .meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 15px;
        }

        .meta-item {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 6px;
            background: #e5e7eb;
            color: #4b5563;
            font-size: 13px;
            font-weight: 600;
        }

        .writing-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .writing-card h2 {
            margin: 0 0 12px;
            font-size: 20px;
        }

        .prompt-box {
            background: #f8fafc;
            border-left: 4px solid #2563eb;
            padding: 18px;
            border-radius: 6px;
            line-height: 1.7;
        }

        .instructions {
            color: #4b5563;
            line-height: 1.7;
            white-space: pre-line;
        }

        .writing-textarea {
            width: 100%;
            min-height: 400px;
            box-sizing: border-box;
            padding: 15px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            resize: vertical;
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.7;
            color: #1f2937;
        }

        .writing-textarea:focus {
            outline: none;
            border-color: #2563eb;
        }

        .self-review {
            width: 100%;
            min-height: 130px;
            box-sizing: border-box;
            padding: 15px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            resize: vertical;
            font-family: Arial, sans-serif;
            font-size: 15px;
            line-height: 1.6;
        }

        .self-review:focus {
            outline: none;
            border-color: #2563eb;
        }

        .writing-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .writing-help {
            margin-top: 8px;
            color: #6b7280;
            font-size: 13px;
        }

        .counter-box {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 12px;
            color: #6b7280;
            font-size: 13px;
        }

        .counter-item {
            padding: 6px 10px;
            background: #f3f4f6;
            border-radius: 6px;
        }

        .status-message {
            margin-bottom: 20px;
            padding: 12px 15px;
            border-radius: 8px;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        .error-message {
            margin-bottom: 20px;
            padding: 12px 15px;
            border-radius: 8px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .error-list {
            margin: 0;
            padding-left: 20px;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        .button {
            border: 0;
            padding: 11px 18px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .save-button {
            background: #6b7280;
            color: #ffffff;
        }

        .save-button:hover {
            background: #4b5563;
        }

        .submit-button {
            background: #2563eb;
            color: #ffffff;
        }

        .submit-button:hover {
            background: #1d4ed8;
        }

        .back-button {
            background: #e5e7eb;
            color: #374151;
        }

        .back-button:hover {
            background: #d1d5db;
        }

        @media (max-width: 640px) {
            .writing-container {
                padding: 25px 15px;
            }

            .writing-header h1 {
                font-size: 26px;
            }

            .writing-card {
                padding: 18px;
            }

            .writing-textarea {
                min-height: 320px;
            }

            .actions {
                flex-direction: column;
            }

            .button {
                width: 100%;
                box-sizing: border-box;
                text-align: center;
            }
        }
    </style>
</head>

<body>

<div class="writing-container">

    <div class="writing-header">

        <h1>
            {{ $writingTemplate->title }}
        </h1>

        <p>
            Write your answer carefully and submit it when
            you are ready for review.
        </p>

        <div class="meta">

            <span class="meta-item">
                {{ ucwords(
                    str_replace(
                        '_',
                        ' ',
                        $writingTemplate->type
                    )
                ) }}
            </span>

            <span class="meta-item">
                {{ ucfirst($writingTemplate->difficulty) }}
            </span>

            @if ($writingTemplate->grade)

                <span class="meta-item">
                    {{ $writingTemplate->grade->name }}
                </span>

            @endif

            @if ($writingTemplate->subject)

                <span class="meta-item">
                    {{ $writingTemplate->subject->name }}
                </span>

            @endif

        </div>

    </div>

    @if (session('status'))

        <div class="status-message">

            {{ session('status') }}

        </div>

    @endif

    @if ($errors->any())

        <div class="error-message">

            <ul class="error-list">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif

    <div class="writing-card">

        <h2>
            Writing Prompt
        </h2>

        <div class="prompt-box">

            {{ $writingTemplate->prompt }}

        </div>

    </div>

    @if ($writingTemplate->instructions)

        <div class="writing-card">

            <h2>
                Instructions
            </h2>

            <div class="instructions">

                {{ $writingTemplate->instructions }}

            </div>

        </div>

    @endif

    <div class="writing-card">

        <form
            method="POST"
            action="{{ route(
                'writing.store',
                $writingTemplate
            ) }}"
            id="writing-form"
        >

            @csrf

            <label
                for="content"
                class="writing-label"
            >
                Your Writing
            </label>

            <textarea
                id="content"
                name="content"
                class="writing-textarea"
                placeholder="Write your answer here..."
                required
            >{{ old('content', $attempt->content) }}</textarea>

            <div class="counter-box">

                <div class="counter-item">
                    Words:
                    <strong id="word-count">
                        {{ $attempt->word_count }}
                    </strong>
                </div>

                <div class="counter-item">
                    Characters:
                    <strong id="character-count">
                        {{ $attempt->character_count }}
                    </strong>
                </div>

                @if ($writingTemplate->minimum_words !== null)

                    <div class="counter-item">
                        Minimum:
                        <strong>
                            {{ $writingTemplate->minimum_words }}
                        </strong>
                        words
                    </div>

                @endif

                @if ($writingTemplate->maximum_words !== null)

                    <div class="counter-item">
                        Maximum:
                        <strong>
                            {{ $writingTemplate->maximum_words }}
                        </strong>
                        words
                    </div>

                @endif

            </div>

            <div class="writing-help">

                Your writing is saved as a draft when you use
                "Save Draft".

            </div>

            <div style="margin-top: 25px;">

                <label
                    for="self_review"
                    class="writing-label"
                >
                    Self-Review
                </label>

                <textarea
                    id="self_review"
                    name="self_review"
                    class="self-review"
                    placeholder="After writing, mention what you think you did well and what you want to improve..."
                >{{ old(
                    'self_review',
                    $attempt->self_review
                ) }}</textarea>

                <div class="writing-help">

                    Self-review is your own reflection and is
                    stored separately from teacher or AI evaluation.

                </div>

            </div>

            <div class="actions">

                <button
                    type="submit"
                    class="button save-button"
                >
                    Save Draft
                </button>

                <button
                    type="button"
                    class="button submit-button"
                    id="submit-writing"
                >
                    Submit Writing
                </button>

                <a
                    href="{{ route(
                        'writing.show',
                        $writingTemplate
                    ) }}"
                    class="button back-button"
                >
                    Back
                </a>

            </div>

        </form>

        <form
            method="POST"
            action="{{ route(
                'writing.attempts.submit',
                $attempt
            ) }}"
            id="submit-form"
            style="display: none;"
        >

            @csrf

            <input
                type="hidden"
                name="content"
                id="submit-content"
            >

            <input
                type="hidden"
                name="self_review"
                id="submit-self-review"
            >

        </form>

    </div>

</div>

<script>
    const writingContent =
        document.getElementById('content');

    const wordCount =
        document.getElementById('word-count');

    const characterCount =
        document.getElementById('character-count');

    const submitWriting =
        document.getElementById('submit-writing');

    const submitForm =
        document.getElementById('submit-form');

    const submitContent =
        document.getElementById('submit-content');

    const submitSelfReview =
        document.getElementById('submit-self-review');

    const selfReview =
        document.getElementById('self_review');

    function calculateWordCount(text) {

        const trimmedText = text.trim();

        if (trimmedText === '') {
            return 0;
        }

        return trimmedText
            .split(/\s+/)
            .length;
    }

    function updateCounters() {

        const content =
            writingContent.value;

        wordCount.textContent =
            calculateWordCount(content);

        characterCount.textContent =
            content.length;
    }

    writingContent.addEventListener(
        'input',
        updateCounters
    );

    submitWriting.addEventListener(
        'click',
        function () {

            const content =
                writingContent.value.trim();

            if (content === '') {

                alert(
                    'Please write your answer before submitting.'
                );

                writingContent.focus();

                return;
            }

            const minimumWords =
                {{ $writingTemplate->minimum_words ?? 0 }};

            const maximumWords =
                {{ $writingTemplate->maximum_words ?? 0 }};

            const currentWordCount =
                calculateWordCount(content);

            if (
                minimumWords > 0
                &&
                currentWordCount < minimumWords
            ) {

                const proceed =
                    confirm(
                        'Your writing has fewer than the recommended minimum word count. Do you want to submit anyway?'
                    );

                if (!proceed) {
                    return;
                }
            }

            if (
                maximumWords > 0
                &&
                currentWordCount > maximumWords
            ) {

                const proceed =
                    confirm(
                        'Your writing is above the recommended maximum word count. Do you want to submit anyway?'
                    );

                if (!proceed) {
                    return;
                }
            }

            submitContent.value =
                content;

            submitSelfReview.value =
                selfReview.value.trim();

            submitForm.submit();
        }
    );

    updateCounters();
</script>

</body>
</html>