<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Revision Queue</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f8fafc;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 32px 20px;
        }

        .header {
            margin-bottom: 24px;
        }

        .header h1 {
            margin: 0 0 8px;
            font-size: 30px;
        }

        .header p {
            margin: 0;
            color: #64748b;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            color: #2563eb;
            font-weight: 600;
        }

        .queue-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 22px;
            margin-bottom: 18px;
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
        }

        .queue-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 16px;
        }

        .queue-number {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 6px;
        }

        .topic-title {
            margin: 0;
            font-size: 22px;
        }

        .priority {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            background: #fef3c7;
            color: #92400e;
            font-size: 13px;
            font-weight: 700;
        }

        .performance {
            margin-bottom: 18px;
        }

        .performance-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 7px;
            font-size: 14px;
        }

        .progress {
            width: 100%;
            height: 10px;
            background: #e5e7eb;
            border-radius: 999px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: #ef4444;
            border-radius: 999px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 18px;
        }

        .stat {
            background: #f8fafc;
            border-radius: 8px;
            padding: 12px;
        }

        .stat-label {
            display: block;
            font-size: 12px;
            color: #64748b;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 18px;
            font-weight: 700;
        }

        .recommendation {
            padding: 14px;
            background: #fff7ed;
            border-radius: 8px;
            color: #9a3412;
        }

        .empty-state {
            background: #ffffff;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 32px;
            text-align: center;
        }

        .empty-state h2 {
            margin-top: 0;
            color: #166534;
        }

        .empty-state p {
            color: #64748b;
            margin-bottom: 20px;
        }

        .dashboard-button {
            display: inline-block;
            padding: 10px 18px;
            background: #2563eb;
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
        }

        @media (max-width: 700px) {

            .queue-header {
                flex-direction: column;
            }

            .stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .container {
                padding: 24px 14px;
            }

        }

    </style>

</head>

<body>

    <main class="container">

        <a
            href="{{ route('dashboard') }}"
            class="back-link"
        >
            ← Back to Dashboard
        </a>

        <div class="header">

            <h1>Revision Queue</h1>

            <p>
                Focus on the topics where your test performance needs improvement.
            </p>

        </div>

        @if ($queue->isEmpty())

            <section class="empty-state">

                <h2>Great work!</h2>

                <p>
                    You currently have no weak topics in your revision queue.
                    Keep practicing and maintain your progress.
                </p>

                <a
                    href="{{ route('dashboard') }}"
                    class="dashboard-button"
                >
                    Go to Dashboard
                </a>

            </section>

        @else

            @foreach ($queue as $item)

                <section class="queue-card">

                    <div class="queue-header">

                        <div>

                            <div class="queue-number">
                                Revision Priority #{{ $item['queue_position'] }}
                            </div>

                            <h2 class="topic-title">
                                {{ $item['topic_title'] }}
                            </h2>

                        </div>

                        <span class="priority">
                            {{ $item['priority'] }} Priority
                        </span>

                    </div>

                    <div class="performance">

                        <div class="performance-label">

                            <strong>Performance</strong>

                            <strong>
                                {{ number_format($item['percentage'], 2) }}%
                            </strong>

                        </div>

                        <div class="progress">

                            <div
                                class="progress-bar"
                                style="width: {{ min(100, max(0, $item['percentage'])) }}%;"
                            ></div>

                        </div>

                    </div>

                    <div class="stats">

                        <div class="stat">

                            <span class="stat-label">
                                Questions
                            </span>

                            <span class="stat-value">
                                {{ $item['total_questions'] }}
                            </span>

                        </div>

                        <div class="stat">

                            <span class="stat-label">
                                Correct
                            </span>

                            <span class="stat-value">
                                {{ $item['correct_answers'] }}
                            </span>

                        </div>

                        <div class="stat">

                            <span class="stat-label">
                                Wrong
                            </span>

                            <span class="stat-value">
                                {{ $item['wrong_answers'] }}
                            </span>

                        </div>

                        <div class="stat">

                            <span class="stat-label">
                                Unanswered
                            </span>

                            <span class="stat-value">
                                {{ $item['unanswered'] }}
                            </span>

                        </div>

                    </div>

                    <div class="recommendation">

                        <strong>Recommended Action:</strong>

                        {{ $item['recommendation'] }}

                    </div>

                </section>

            @endforeach

        @endif

    </main>

</body>

</html>