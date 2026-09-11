<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Writing Attempt | Aspirian
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
            margin: 0 0 15px;
            font-size: 20px;
        }

        .content-box {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            line-height: 1.8;
            white-space: pre-line;
            overflow-wrap: break-word;
        }

        .self-review {
            background: #f9fafb;
            border-left: 4px solid #6b7280;
            padding: 15px;
            border-radius: 6px;
            line-height: 1.7;
            white-space: pre-line;
        }

        .details {
            display: grid;
            grid-template-columns: repeat(
                auto-fit,
                minmax(160px, 1fr)
            );
            gap: 12px;
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

        .evaluation {
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
            margin-top: 20px;
        }

        .evaluation:first-child {
            border-top: 0;
            padding-top: 0;
            margin-top: 0;
        }

        .evaluation-scores {
            display: grid;
            grid-template-columns: repeat(
                auto-fit,
                minmax(140px, 1fr)
            );
            gap: 10px;
            margin-top: 15px;
        }

        .score-item {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px;
        }

        .score-label {
            display: block;
            color: #6b7280;
            font-size: 12px;
            margin-bottom: 4px;
        }

        .score-value {
            font-weight: 700;
        }

        .feedback-box {
            margin-top: 15px;
            padding: 15px;
            background: #f8fafc;
            border-radius: 8px;
            line-height: 1.7;
            white-space: pre-line;
        }

        .feedback-title {
            margin-bottom: 6px;
            font-weight: 700;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 6px;
            background: #e5e7eb;
            color: #374151;
            font-size: 12px;
            font-weight: 700;
            text-transform: capitalize;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .button {
            display: inline-block;
            padding: 11px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }

        .primary-button {
            background: #2563eb;
            color: #ffffff;
        }

        .primary-button:hover {
            background: #1d4ed8;
        }

        .back-button {
            background: #e5e7eb;
            color: #374151;
        }

        .back-button:hover {
            background: #d1d5db;
        }

        .empty-state {
            color: #6b7280;
            line-height: 1.6;
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
            {{ $attempt->writingTemplate->title }}
        </h1>

        <p>
            Your writing attempt and review history.
        </p>

        <div class="meta">

            <span class="meta-item">
                {{ ucwords(
                    str_replace(
                        '_',
                        ' ',
                        $attempt->writingTemplate->type
                    )
                ) }}
            </span>

            <span class="meta-item">
                {{ ucfirst(
                    $attempt->writingTemplate->difficulty
                ) }}
            </span>

            @if ($attempt->writingTemplate->grade)

                <span class="meta-item">
                    {{ $attempt->writingTemplate->grade->name }}
                </span>

            @endif

            @if ($attempt->writingTemplate->subject)

                <span class="meta-item">
                    {{ $attempt->writingTemplate->subject->name }}
                </span>

            @endif

        </div>

    </div>

    <div class="writing-card">

        <h2>
            Attempt Details
        </h2>

        <div class="details">

            <div class="detail-item">

                <span class="detail-label">
                    Attempt Number
                </span>

                <span class="detail-value">
                    {{ $attempt->attempt_number }}
                </span>

            </div>

            <div class="detail-item">

                <span class="detail-label">
                    Status
                </span>

                <span class="status-badge">
                    {{ $attempt->status }}
                </span>

            </div>

            <div class="detail-item">

                <span class="detail-label">
                    Words
                </span>

                <span class="detail-value">
                    {{ $attempt->word_count }}
                </span>

            </div>

            <div class="detail-item">

                <span class="detail-label">
                    Characters
                </span>

                <span class="detail-value">
                    {{ $attempt->character_count }}
                </span>

            </div>

            @if ($attempt->submitted_at)

                <div class="detail-item">

                    <span class="detail-label">
                        Submitted
                    </span>

                    <span class="detail-value">
                        {{ $attempt->submitted_at->format(
                            'd M Y, h:i A'
                        ) }}
                    </span>

                </div>

            @endif

            @if ($attempt->reviewed_at)

                <div class="detail-item">

                    <span class="detail-label">
                        Reviewed
                    </span>

                    <span class="detail-value">
                        {{ $attempt->reviewed_at->format(
                            'd M Y, h:i A'
                        ) }}
                    </span>

                </div>

            @endif

        </div>

    </div>

    <div class="writing-card">

        <h2>
            Your Writing
        </h2>

        <div class="content-box">
            {{ $attempt->content }}
        </div>

    </div>

    @if ($attempt->self_review)

        <div class="writing-card">

            <h2>
                Your Self-Review
            </h2>

            <div class="self-review">
                {{ $attempt->self_review }}
            </div>

        </div>

    @endif

    @if ($attempt->evaluations->isNotEmpty())

        <div class="writing-card">

            <h2>
                Writing Review
            </h2>

            @foreach (
                $attempt->evaluations as $evaluation
            )

                <div class="evaluation">

                    <div class="details">

                        <div class="detail-item">

                            <span class="detail-label">
                                Evaluator
                            </span>

                            <span class="detail-value">
                                {{ ucfirst(
                                    $evaluation->evaluator_type
                                ) }}
                            </span>

                        </div>

                        <div class="detail-item">

                            <span class="detail-label">
                                Status
                            </span>

                            <span class="status-badge">
                                {{ $evaluation->status }}
                            </span>

                        </div>

                        @if ($evaluation->overall_score !== null)

                            <div class="detail-item">

                                <span class="detail-label">
                                    Overall Score
                                </span>

                                <span class="detail-value">
                                    {{ $evaluation->overall_score }}
                                </span>

                            </div>

                        @endif

                    </div>

                    <div class="evaluation-scores">

                        @if ($evaluation->content_score !== null)

                            <div class="score-item">

                                <span class="score-label">
                                    Content
                                </span>

                                <span class="score-value">
                                    {{ $evaluation->content_score }}
                                </span>

                            </div>

                        @endif

                        @if ($evaluation->grammar_score !== null)

                            <div class="score-item">

                                <span class="score-label">
                                    Grammar
                                </span>

                                <span class="score-value">
                                    {{ $evaluation->grammar_score }}
                                </span>

                            </div>

                        @endif

                        @if ($evaluation->vocabulary_score !== null)

                            <div class="score-item">

                                <span class="score-label">
                                    Vocabulary
                                </span>

                                <span class="score-value">
                                    {{ $evaluation->vocabulary_score }}
                                </span>

                            </div>

                        @endif

                        @if ($evaluation->organization_score !== null)

                            <div class="score-item">

                                <span class="score-label">
                                    Organization
                                </span>

                                <span class="score-value">
                                    {{ $evaluation->organization_score }}
                                </span>

                            </div>

                        @endif

                        @if ($evaluation->spelling_score !== null)

                            <div class="score-item">

                                <span class="score-label">
                                    Spelling
                                </span>

                                <span class="score-value">
                                    {{ $evaluation->spelling_score }}
                                </span>

                            </div>

                        @endif

                        @if ($evaluation->relevance_score !== null)

                            <div class="score-item">

                                <span class="score-label">
                                    Relevance
                                </span>

                                <span class="score-value">
                                    {{ $evaluation->relevance_score }}
                                </span>

                            </div>

                        @endif

                    </div>

                    @if ($evaluation->feedback)

                        <div class="feedback-box">

                            <div class="feedback-title">
                                Feedback
                            </div>

                            {{ $evaluation->feedback }}

                        </div>

                    @endif

                    @if ($evaluation->strengths)

                        <div class="feedback-box">

                            <div class="feedback-title">
                                Strengths
                            </div>

                            {{ $evaluation->strengths }}

                        </div>

                    @endif

                    @if ($evaluation->improvements)

                        <div class="feedback-box">

                            <div class="feedback-title">
                                Improvements
                            </div>

                            {{ $evaluation->improvements }}

                        </div>

                    @endif

                </div>

            @endforeach

        </div>

    @else

        <div class="writing-card">

            <h2>
                Review
            </h2>

            <p class="empty-state">
                Your writing has been submitted. Review feedback
                will appear here when an evaluation is available.
            </p>

        </div>

    @endif

    <div class="writing-card">

        <div class="actions">

            <a
                href="{{ route('writing.index') }}"
                class="button back-button"
            >
                Back to Writing Practice
            </a>

            <a
                href="{{ route(
                    'writing.show',
                    $attempt->writingTemplate
                ) }}"
                class="button primary-button"
            >
                View Writing Task
            </a>

        </div>

    </div>

</div>

</body>
</html>