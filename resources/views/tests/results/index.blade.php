<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Result History</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 24px;
            background: #f4f6f8;
            color: #1f2937;
            font-family:
                Arial,
                Helvetica,
                sans-serif;
        }

        .container {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
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
            color: #6b7280;
        }

        .filters {
            display: grid;
            grid-template-columns: 1fr 220px auto auto;
            gap: 12px;
            margin-bottom: 24px;
            padding: 18px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
        }

        .filters input,
        .filters select {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            background: #ffffff;
            font-size: 14px;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 11px 16px;
            border: 0;
            border-radius: 7px;
            background: #2563eb;
            color: #ffffff;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .button:hover {
            opacity: 0.9;
        }

        .button.secondary {
            background: #6b7280;
        }

        .results {
            display: grid;
            gap: 14px;
        }

        .result-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 20px;
        }

        .result-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
        }

        .test-title {
            margin: 0 0 8px;
            font-size: 20px;
        }

        .date {
            color: #6b7280;
            font-size: 14px;
        }

        .status {
            display: inline-flex;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .status.passed {
            background: #dcfce7;
            color: #166534;
        }

        .status.failed {
            background: #fee2e2;
            color: #991b1b;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-top: 18px;
        }

        .stat {
            padding: 14px;
            background: #f9fafb;
            border-radius: 8px;
        }

        .stat-label {
            display: block;
            margin-bottom: 5px;
            color: #6b7280;
            font-size: 12px;
        }

        .stat-value {
            font-size: 18px;
            font-weight: 700;
        }

        .result-actions {
            margin-top: 18px;
        }

        .empty {
            padding: 40px 20px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            text-align: center;
        }

        .empty h2 {
            margin: 0 0 8px;
        }

        .empty p {
            margin: 0;
            color: #6b7280;
        }

        .pagination {
            margin-top: 24px;
        }

        @media (max-width: 800px) {
            .filters {
                grid-template-columns: 1fr;
            }

            .stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 500px) {
            body {
                padding: 14px;
            }

            .result-top {
                flex-direction: column;
            }

            .stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <h1>Result History</h1>

        <p>
            View your previous test attempts and results.
        </p>
    </div>

    <form
        method="GET"
        action="{{ route('tests.results.index') }}"
        class="filters"
    >

        <input
            type="search"
            name="search"
            value="{{ $search }}"
            placeholder="Search test by title..."
            aria-label="Search test by title"
        >

        <select
            name="status"
            aria-label="Filter by result status"
        >
            <option value="">All Results</option>

            <option
                value="{{ \App\Models\TestResult::STATUS_PASSED }}"
                @selected($status === \App\Models\TestResult::STATUS_PASSED)
            >
                Passed
            </option>

            <option
                value="{{ \App\Models\TestResult::STATUS_FAILED }}"
                @selected($status === \App\Models\TestResult::STATUS_FAILED)
            >
                Failed
            </option>
        </select>

        <button
            type="submit"
            class="button"
        >
            Filter
        </button>

        <a
            href="{{ route('tests.results.index') }}"
            class="button secondary"
        >
            Clear
        </a>

    </form>

    @if ($results->count())

        <div class="results">

            @foreach ($results as $result)

                <article class="result-card">

                    <div class="result-top">

                        <div>
                            <h2 class="test-title">
                                {{ $result->test?->title ?? 'Test' }}
                            </h2>

                            <div class="date">
                                Completed:
                                {{ $result->created_at?->format('d M Y, h:i A') ?? 'N/A' }}
                            </div>
                        </div>

                        <span
                            class="status {{ $result->isPassed() ? 'passed' : 'failed' }}"
                        >
                            {{ ucfirst($result->status) }}
                        </span>

                    </div>

                    <div class="stats">

                        <div class="stat">
                            <span class="stat-label">
                                Score
                            </span>

                            <span class="stat-value">
                                {{ $result->obtained_marks }}
                                /
                                {{ $result->total_marks }}
                            </span>
                        </div>

                        <div class="stat">
                            <span class="stat-label">
                                Percentage
                            </span>

                            <span class="stat-value">
                                {{ number_format((float) $result->percentage, 2) }}%
                            </span>
                        </div>

                        <div class="stat">
                            <span class="stat-label">
                                Correct
                            </span>

                            <span class="stat-value">
                                {{ $result->correct_answers }}
                            </span>
                        </div>

                        <div class="stat">
                            <span class="stat-label">
                                Wrong
                            </span>

                            <span class="stat-value">
                                {{ $result->wrong_answers }}
                            </span>
                        </div>

                    </div>

                    <div class="result-actions">

                        <a
                            href="{{ route('tests.results.show', $result) }}"
                            class="button"
                        >
                            View Result
                        </a>

                    </div>

                </article>

            @endforeach

        </div>

        <div class="pagination">
            {{ $results->links() }}
        </div>

    @else

        <div class="empty">

            <h2>No Results Found</h2>

            <p>
                You have no completed test results matching the selected filters.
            </p>

        </div>

    @endif

</div>

</body>
</html>