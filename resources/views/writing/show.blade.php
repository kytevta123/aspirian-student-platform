<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $writingTemplate->title }} | Aspirian
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

        .writing-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
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

        .writing-card p {
            margin: 0;
            color: #4b5563;
            line-height: 1.7;
        }

        .prompt-box {
            background: #f8fafc;
            border-left: 4px solid #2563eb;
            padding: 18px;
            margin-top: 15px;
            border-radius: 6px;
            line-height: 1.7;
        }

        .details {
            display: grid;
            grid-template-columns: repeat(
                auto-fit,
                minmax(180px, 1fr)
            );
            gap: 12px;
            margin-top: 18px;
        }

        .detail-item {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px;
        }

        .detail-label {
            display: block;
            margin-bottom: 5px;
            color: #6b7280;
            font-size: 12px;
            font-weight: 600;
        }

        .detail-value {
            color: #1f2937;
            font-size: 14px;
            font-weight: 600;
        }

        .instructions {
            white-space: pre-line;
        }

        .rubric-list {
            margin: 15px 0 0;
            padding-left: 20px;
        }

        .rubric-list li {
            margin-bottom: 8px;
            color: #4b5563;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 25px;
        }

        .writing-button {
            display: inline-block;
            padding: 11px 18px;
            border-radius: 8px;
            background: #2563eb;
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.2s ease;
        }

        .writing-button:hover {
            background: #1d4ed8;
        }

        .back-button {
            display: inline-block;
            padding: 11px 18px;
            border-radius: 8px;
            background: #e5e7eb;
            color: #374151;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.2s ease;
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

            .actions a {
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

        <div class="writing-meta">

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
                Writing Instructions
            </h2>

            <p class="instructions">
                {{ $writingTemplate->instructions }}
            </p>

        </div>

    @endif

    <div class="writing-card">

        <h2>
            Writing Details
        </h2>

        <div class="details">

            @if ($writingTemplate->marks !== null)

                <div class="detail-item">

                    <span class="detail-label">
                        Marks
                    </span>

                    <span class="detail-value">
                        {{ $writingTemplate->marks }}
                    </span>

                </div>

            @endif

            @if ($writingTemplate->minimum_words !== null)

                <div class="detail-item">

                    <span class="detail-label">
                        Minimum Words
                    </span>

                    <span class="detail-value">
                        {{ $writingTemplate->minimum_words }}
                    </span>

                </div>

            @endif

            @if ($writingTemplate->maximum_words !== null)

                <div class="detail-item">

                    <span class="detail-label">
                        Maximum Words
                    </span>

                    <span class="detail-value">
                        {{ $writingTemplate->maximum_words }}
                    </span>

                </div>

            @endif

            <div class="detail-item">

                <span class="detail-label">
                    Language
                </span>

                <span class="detail-value">
                    {{ $writingTemplate->language }}
                </span>

            </div>

        </div>

    </div>

    @if ($writingTemplate->writingRubric)

        <div class="writing-card">

            <h2>
                Writing Review Criteria
            </h2>

            <p>
                Your writing can be reviewed using the following
                criteria:
            </p>

            @if ($writingTemplate->writingRubric->items->isNotEmpty())

                <ul class="rubric-list">

                    @foreach (
                        $writingTemplate->writingRubric->items
                        as $rubricItem
                    )

                        <li>

                            <strong>
                                {{ $rubricItem->criterion }}
                            </strong>

                            @if ($rubricItem->description)

                                -
                                {{ $rubricItem->description }}

                            @endif

                            @if ($rubricItem->maximum_marks)

                                ({{ $rubricItem->maximum_marks }} marks)

                            @endif

                        </li>

                    @endforeach

                </ul>

            @endif

        </div>

    @endif

    <div class="writing-card">

        <h2>
            Ready to Write?
        </h2>

        <p>
            Start your writing attempt and submit your work
            for review and improvement.
        </p>

        <div class="actions">

            <a
                href="{{ route(
                    'writing.start',
                    $writingTemplate
                ) }}"
                class="writing-button"
            >
                Start Writing
            </a>

            <a
                href="{{ route('writing.index') }}"
                class="back-button"
            >
                Back to Writing Practice
            </a>

        </div>

    </div>

</div>

</body>
</html>