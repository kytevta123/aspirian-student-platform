<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Practice | Aspirian</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }

        .practice-container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .practice-header {
            margin-bottom: 30px;
        }

        .practice-header h1 {
            margin: 0 0 10px;
            font-size: 32px;
        }

        .practice-header p {
            margin: 0;
            color: #6b7280;
            font-size: 16px;
        }

        .topics-grid {
            display: grid;
            grid-template-columns: repeat(
                auto-fit,
                minmax(280px, 1fr)
            );
            gap: 20px;
        }

        .topic-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 22px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .topic-card h2 {
            margin: 0 0 8px;
            font-size: 20px;
        }

        .topic-card .subject {
            margin-bottom: 5px;
            color: #4b5563;
            font-size: 14px;
        }

        .topic-card .chapter {
            margin-bottom: 15px;
            color: #6b7280;
            font-size: 14px;
        }

        .question-count {
            margin-bottom: 18px;
            font-size: 14px;
            font-weight: 600;
        }

        .practice-button {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 8px;
            background: #2563eb;
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
        }

        .practice-button:hover {
            background: #1d4ed8;
        }

        .empty-state {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            color: #6b7280;
        }

        @media (max-width: 640px) {
            .practice-container {
                padding: 25px 15px;
            }

            .practice-header h1 {
                font-size: 26px;
            }
        }
    </style>
</head>

<body>

<div class="practice-container">

    <div class="practice-header">
        <h1>Practice</h1>

        <p>
            Choose a topic and practice questions
            from the Aspirian Question Bank.
        </p>
    </div>

    @if ($topics->isEmpty())

        <div class="empty-state">
            No published practice topics are available yet.
        </div>

    @else

        <div class="topics-grid">

            @foreach ($topics as $topic)

                <div class="topic-card">

                    <h2>
                        {{ $topic->title }}
                    </h2>

                    @if ($topic->chapter?->book?->subject)
                        <div class="subject">
                            Subject:
                            {{ $topic->chapter->book->subject->name }}
                        </div>
                    @endif

                    @if ($topic->chapter)
                        <div class="chapter">
                            Chapter:
                            {{ $topic->chapter->title }}
                        </div>
                    @endif

                    <div class="question-count">
                        {{ $topic->questions_count }}
                        published
                        {{ $topic->questions_count === 1 ? 'question' : 'questions' }}
                    </div>

                    <a
                        href="#"
                        class="practice-button"
                        aria-disabled="true"
                        onclick="return false;"
                    >
                        Start Practice
                    </a>

                </div>

            @endforeach

        </div>

    @endif

</div>

</body>
</html>