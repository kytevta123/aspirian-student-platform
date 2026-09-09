<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Test Result - {{ $result->test->title }}
    </title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background: #f4f6f9;
            color: #1f2937;
            font-family:
                Arial,
                Helvetica,
                sans-serif;
        }

        .container {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            padding: 30px 20px 50px;
        }

        .result-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow:
                0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0 0 10px;
            font-size: 30px;
            color: #111827;
        }

        .header h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 500;
            color: #4b5563;
        }

        .status {
            display: inline-block;
            margin-top: 18px;
            padding: 8px 18px;
            border-radius: 999px;
            font-size: 14px;
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

        .score-section {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .score-circle {
            width: 170px;
            height: 170px;
            border-radius: 50%;
            border: 10px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #ffffff;
        }

        .score-circle .percentage {
            font-size: 38px;
            font-weight: 700;
            color: #111827;
        }

        .score-circle .label {
            margin-top: 5px;
            font-size: 13px;
            color: #6b7280;
        }

        .stats {
            display: grid;
            grid-template-columns:
                repeat(3, minmax(0, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .stat-card {
            padding: 20px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            text-align: center;
            background: #f9fafb;
        }

        .stat-card .value {
            display: block;
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 6px;
        }

        .stat-card .label {
            display: block;
            font-size: 14px;
            color: #6b7280;
        }

        .details {
            border-top: 1px solid #e5e7eb;
            padding-top: 25px;
        }

        .details h3 {
            margin: 0 0 18px;
            font-size: 20px;
            color: #111827;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #6b7280;
        }

        .detail-value {
            font-weight: 600;
            text-align: right;
            color: #111827;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .button {
            display: inline-block;
            padding: 11px 20px;
            border-radius: 7px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: none;
        }

        .button-primary {
            background: #2563eb;
            color: #ffffff;
        }

        .button-secondary {
            background: #e5e7eb;
            color: #111827;
        }

        .button:hover {
            opacity: 0.9;
        }

        .notice {
            margin-top: 25px;
            padding: 15px 18px;
            border-radius: 8px;
            background: #eff6ff;
            color: #1e40af;
            font-size: 14px;
            line-height: 1.6;
        }

        @media (max-width: 700px) {
            .container {
                padding: 20px 12px 40px;
            }

            .result-card {
                padding: 20px;
            }

            .header h1 {
                font-size: 25px;
            }

            .header h2 {
                font-size: 18px;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .score-circle {
                width: 145px;
                height: 145px;
            }

            .score-circle .percentage {
                font-size: 32px;
            }

            .detail-row {
                flex-direction: column;
                gap: 5px;
            }

            .detail-value {
                text-align: left;
            }
        }

        @media print {
            body {
                background: #ffffff;
            }

            .container {
                max-width: 100%;
                padding: 0;
            }

            .result-card {
                box-shadow: none;
            }

            .actions {
                display: none;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="result-card">

        {{-- Header --}}
        <div class="header">

            <h1>
                Test Result
            </h1>

            <h2>
                {{ $result->test->title }}
            </h2>

            @if ($result->isPassed())
                <span class="status passed">
                    Passed
                </span>
            @else
                <span class="status failed">
                    Failed
                </span>
            @endif

        </div>


        {{-- Percentage --}}
        <div class="score-section">

            <div class="score-circle">

                <span class="percentage">
                    {{ number_format($result->percentage, 2) }}%
                </span>

                <span class="label">
                    Overall Score
                </span>

            </div>

        </div>


        {{-- Main Statistics --}}
        <div class="stats">

            <div class="stat-card">

                <span class="value">
                    {{ $result->obtained_marks }}
                    /
                    {{ $result->total_marks }}
                </span>

                <span class="label">
                    Marks Obtained
                </span>

            </div>


            <div class="stat-card">

                <span class="value">
                    {{ $result->correct_answers }}
                </span>

                <span class="label">
                    Correct Answers
                </span>

            </div>


            <div class="stat-card">

                <span class="value">
                    {{ $result->wrong_answers }}
                </span>

                <span class="label">
                    Wrong Answers
                </span>

            </div>


            <div class="stat-card">

                <span class="value">
                    {{ $result->unanswered }}
                </span>

                <span class="label">
                    Unanswered
                </span>

            </div>

        </div>


        {{-- Result Details --}}
        <div class="details">

            <h3>
                Result Details
            </h3>


            <div class="detail-row">

                <span class="detail-label">
                    Test
                </span>

                <span class="detail-value">
                    {{ $result->test->title }}
                </span>

            </div>


            <div class="detail-row">

                <span class="detail-label">
                    Total Marks
                </span>

                <span class="detail-value">
                    {{ $result->total_marks }}
                </span>

            </div>


            <div class="detail-row">

                <span class="detail-label">
                    Obtained Marks
                </span>

                <span class="detail-value">
                    {{ $result->obtained_marks }}
                </span>

            </div>


            <div class="detail-row">

                <span class="detail-label">
                    Percentage
                </span>

                <span class="detail-value">
                    {{ number_format($result->percentage, 2) }}%
                </span>

            </div>


            <div class="detail-row">

                <span class="detail-label">
                    Correct Answers
                </span>

                <span class="detail-value">
                    {{ $result->correct_answers }}
                </span>

            </div>


            <div class="detail-row">

                <span class="detail-label">
                    Wrong Answers
                </span>

                <span class="detail-value">
                    {{ $result->wrong_answers }}
                </span>

            </div>


            <div class="detail-row">

                <span class="detail-label">
                    Unanswered
                </span>

                <span class="detail-value">
                    {{ $result->unanswered }}
                </span>

            </div>


            <div class="detail-row">

                <span class="detail-label">
                    Status
                </span>

                <span class="detail-value">

                    @if ($result->isPassed())
                        Passed
                    @else
                        Failed
                    @endif

                </span>

            </div>


            @if ($result->testAttempt->submitted_at)

                <div class="detail-row">

                    <span class="detail-label">
                        Submitted At
                    </span>

                    <span class="detail-value">
                        {{ $result->testAttempt->submitted_at->format('d M Y, h:i A') }}
                    </span>

                </div>

            @endif

        </div>


        {{-- Information Notice --}}
        <div class="notice">

            Your result has been calculated and securely
            recorded by the system. This page only displays
            your result summary.

        </div>


        {{-- Actions --}}
        <div class="actions">

            <button
                type="button"
                class="button button-primary"
                onclick="window.print()"
            >
                Print Result
            </button>

            <a
                href="{{ route('dashboard') }}"
                class="button button-secondary"
            >
                Back to Dashboard
            </a>

        </div>

    </div>

</div>

</body>
</html>