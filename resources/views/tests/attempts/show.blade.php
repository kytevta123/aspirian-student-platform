<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        {{ $attempt->test->title }} - Test Attempt
    </title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family:
                Arial,
                Helvetica,
                sans-serif;
            background: #f4f6f8;
            color: #1f2937;
        }

        .navbar {
            background: #111827;
            color: #ffffff;
            padding: 16px 24px;
        }

        .navbar-inner {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .brand {
            font-size: 20px;
            font-weight: 700;
        }

        .attempt-label {
            font-size: 14px;
            opacity: 0.85;
        }

        .container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .test-header {
            background: #ffffff;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 20px;
            box-shadow:
                0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .test-header h1 {
            margin: 0 0 12px;
            font-size: 28px;
        }

        .instructions {
            margin: 0 0 20px;
            color: #4b5563;
            line-height: 1.6;
        }

        .test-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .meta-item {
            background: #f3f4f6;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
        }

        .timer-box {
            position: sticky;
            top: 15px;
            z-index: 10;
            background: #ffffff;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 20px;
            box-shadow:
                0 2px 8px rgba(0, 0, 0, 0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .timer-title {
            font-size: 14px;
            color: #6b7280;
        }

        .timer {
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .timer-expired {
            font-size: 16px;
            font-weight: 700;
        }

        .question-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 22px;
            margin-bottom: 16px;
            box-shadow:
                0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .question-number {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .question-text {
            font-size: 17px;
            line-height: 1.6;
            margin-bottom: 16px;
        }

        .question-type {
            display: inline-block;
            margin-bottom: 12px;
            padding: 5px 9px;
            border-radius: 6px;
            background: #eef2ff;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 700;
        }

        .answer-form {
            margin-top: 18px;
            border-top: 1px solid #e5e7eb;
            padding-top: 18px;
        }

        .options {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 16px;
        }

        .option {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 12px 14px;
            background: #f9fafb;
            cursor: pointer;
        }

        .option:hover {
            background: #f3f4f6;
        }

        .option input {
            margin-right: 10px;
        }

        .answer-textarea {
            width: 100%;
            min-height: 130px;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-family: inherit;
            font-size: 15px;
            line-height: 1.5;
            resize: vertical;
        }

        .answer-textarea:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow:
                0 0 0 3px rgba(99, 102, 241, 0.12);
        }

        .answer-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 14px;
        }

        .save-answer {
            border: 0;
            border-radius: 8px;
            padding: 11px 18px;
            background: #111827;
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .save-answer:hover {
            background: #1f2937;
        }

        .save-answer:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .status-message {
            color: #166534;
            font-size: 13px;
            font-weight: 600;
        }

        .notice {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 20px;
            color: #1e40af;
            line-height: 1.5;
        }

        .success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 20px;
            color: #166534;
        }

        .error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 20px;
            color: #991b1b;
        }

        .expired-notice {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 20px;
            color: #991b1b;
            font-weight: 600;
            line-height: 1.5;
        }

        .submitted-notice {
            background: #f0fdf4;
            border: 1px solid #86efac;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 20px;
            color: #166534;
            font-weight: 600;
            line-height: 1.5;
        }

        .submission-box {
            background: #ffffff;
            border-radius: 12px;
            padding: 24px;
            margin-top: 24px;
            margin-bottom: 30px;
            box-shadow:
                0 2px 8px rgba(0, 0, 0, 0.06);
            text-align: center;
        }

        .submission-box h2 {
            margin: 0 0 10px;
            font-size: 22px;
        }

        .submission-box p {
            margin: 0 0 18px;
            color: #6b7280;
            line-height: 1.6;
        }

        .submit-test {
            border: 0;
            border-radius: 8px;
            padding: 13px 24px;
            background: #166534;
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
        }

        .submit-test:hover {
            background: #14532d;
        }

        .submit-test:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .submission-time {
            margin-top: 10px;
            font-size: 13px;
            color: #4b5563;
        }

        .empty {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
        }

        @media (max-width: 700px) {
            .container {
                margin: 20px auto;
                padding: 0 12px;
            }

            .test-header {
                padding: 18px;
            }

            .test-header h1 {
                font-size: 23px;
            }

            .timer-box {
                padding: 14px;
            }

            .timer {
                font-size: 22px;
            }

            .question-card {
                padding: 18px;
            }

            .answer-actions {
                align-items: stretch;
                flex-direction: column;
            }

            .save-answer {
                width: 100%;
            }

            .submit-test {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<nav class="navbar">
    <div class="navbar-inner">

        <div class="brand">
            Aspirian Student Platform
        </div>

        <div class="attempt-label">
            Test Attempt
        </div>

    </div>
</nav>

<main class="container">

    @php
        $test = $attempt->test;
        $questions = $test->questions;
        $isSubmitted = $attempt->isSubmitted();
        $isExpired = $attempt->status === \App\Models\TestAttempt::STATUS_EXPIRED;
        $isInProgress = $attempt->isInProgress();

        $savedAnswers = $attempt->answers
            ->keyBy('question_id');
    @endphp

    <section class="test-header">

        <h1>
            {{ $test->title }}
        </h1>

        @if ($test->instructions)
            <p class="instructions">
                {{ $test->instructions }}
            </p>
        @endif

        <div class="test-meta">

            <div class="meta-item">
                <strong>Duration:</strong>
                {{ $test->duration }} minutes
            </div>

            <div class="meta-item">
                <strong>Marks:</strong>
                {{ $test->marks }}
            </div>

            <div class="meta-item">
                <strong>Questions:</strong>
                {{ $questions->count() }}
            </div>

            <div class="meta-item">
                <strong>Status:</strong>

                @if ($isSubmitted)
                    Submitted
                @elseif ($isExpired)
                    Expired
                @else
                    In Progress
                @endif

            </div>

        </div>

    </section>

    @if ($isInProgress)

        <section
            class="timer-box"
            data-expires-at="{{ $attempt->expires_at->toIso8601String() }}"
            data-expire-url="{{ route(
                'tests.attempts.expire',
                ['attempt' => $attempt->id]
            ) }}"
        >
            <div>
                <div class="timer-title">
                    Time Remaining
                </div>
            </div>

            <div
                class="timer"
                id="timer"
            >
                --:--
            </div>
        </section>

    @elseif ($isSubmitted)

        <div class="submitted-notice">

            Test submitted successfully.

            @if ($attempt->submitted_at)
                <div class="submission-time">
                    Submitted at:
                    {{ $attempt->submitted_at->format('d M Y, h:i A') }}
                </div>
            @endif

        </div>

    @elseif ($isExpired)

        <div
            id="expired-notice"
            class="expired-notice"
        >
            The test time has expired. Your attempt has been closed.
            Your answers can no longer be changed.
        </div>

    @endif

    @if (session('status'))
        <div class="success">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="error">

            <strong>
                Please correct the following:
            </strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>

        </div>
    @endif

    @if ($isInProgress)

        <div class="notice">
            Aap apna answer save kar sakte hain.
            Jab tamam answers complete ho jayen to
            neeche <strong>Submit Test</strong> button se
            apna final test submit karein.
        </div>

    @elseif ($isSubmitted)

        <div class="notice">
            Ye attempt final submit ho chuka hai.
            Ab answers change nahi kiye ja sakte.
        </div>

    @endif

    @forelse ($questions as $index => $question)

        @php
            $savedAnswer = $savedAnswers->get(
                $question->id
            );
        @endphp

        <article class="question-card">

            <div class="question-number">
                Question {{ $index + 1 }}
            </div>

            <div class="question-type">
                {{ $question->question_type }}
            </div>

            <div class="question-text">
                {{ $question->question_text }}
            </div>

            <form
                method="POST"
                action="{{ route(
                    'tests.attempts.answers.store',
                    [
                        'attempt' => $attempt->id,
                        'question' => $question->id,
                    ]
                ) }}"
                class="answer-form"
            >

                @csrf

                @if ($question->question_type === 'mcq')

                    @if (is_array($question->options))

                        <div class="options">

                            @foreach ($question->options as $option)

                                <label class="option">

                                    <input
                                        type="radio"
                                        name="answer"
                                        value="{{ $option }}"
                                        @checked(
                                            $savedAnswer &&
                                            $savedAnswer->answer === $option
                                        )
                                        @disabled(! $isInProgress)
                                    >

                                    {{ $option }}

                                </label>

                            @endforeach

                        </div>

                    @else

                        <textarea
                            name="answer"
                            class="answer-textarea"
                            placeholder="Enter your answer..."
                            @disabled(! $isInProgress)
                        >{{ $savedAnswer?->answer }}</textarea>

                    @endif

                @else

                    <textarea
                        name="answer"
                        class="answer-textarea"
                        placeholder="Write your answer here..."
                        @disabled(! $isInProgress)
                    >{{ $savedAnswer?->answer }}</textarea>

                @endif

                @if ($isInProgress)

                    <div class="answer-actions">

                        <button
                            type="submit"
                            class="save-answer"
                        >
                            Save Answer
                        </button>

                        <span class="status-message">
                            Answer is saved separately for this question.
                        </span>

                    </div>

                @elseif ($isSubmitted)

                    <div class="answer-actions">

                        <span class="status-message">
                            Final submitted answer.
                        </span>

                    </div>

                @elseif ($isExpired)

                    <div class="answer-actions">

                        <span class="status-message">
                            Answer editing is disabled because
                            the test has expired.
                        </span>

                    </div>

                @endif

            </form>

        </article>

    @empty

        <div class="empty">
            No questions are available for this test.
        </div>

    @endforelse

    @if ($isInProgress && $questions->isNotEmpty())

        <section class="submission-box">

            <h2>
                Final Submission
            </h2>

            <p>
                Please make sure that you have saved all your
                answers before submitting the test.
                After final submission, answers cannot be changed.
            </p>

            <form
                method="POST"
                action="{{ route(
                    'tests.attempts.submit',
                    ['attempt' => $attempt->id]
                ) }}"
                id="submit-test-form"
            >

                @csrf

                <button
                    type="submit"
                    class="submit-test"
                    id="submit-test-button"
                >
                    Submit Test
                </button>

            </form>

        </section>

    @elseif ($isSubmitted)

        <section class="submission-box">

            <h2>
                Test Submitted
            </h2>

            <p>
                Your test attempt has been successfully submitted.
                Your answers are now locked.
            </p>

            @if ($attempt->submitted_at)
                <div class="submission-time">
                    Submitted at:
                    {{ $attempt->submitted_at->format('d M Y, h:i A') }}
                </div>
            @endif

        </section>

    @elseif ($isExpired)

        <section class="submission-box">

            <h2>
                Test Expired
            </h2>

            <p>
                The allowed test time has ended.
                This attempt can no longer be edited or submitted.
            </p>

        </section>

    @endif

</main>

@if ($isInProgress)

<script>
    const timerElement =
        document.getElementById('timer');

    const timerBox =
        document.querySelector('.timer-box');

    const answerForms =
        document.querySelectorAll('.answer-form');

    const submitTestForm =
        document.getElementById('submit-test-form');

    const submitTestButton =
        document.getElementById('submit-test-button');

    const expiresAt =
        new Date(
            timerBox.dataset.expiresAt
        ).getTime();

    const expireUrl =
        timerBox.dataset.expireUrl;

    let expirationRequestSent = false;

    let timerInterval = null;

    function disableAnswerForms() {
        answerForms.forEach(function (form) {

            const controls =
                form.querySelectorAll(
                    'input, textarea, button'
                );

            controls.forEach(function (control) {
                control.disabled = true;
            });

        });
    }

    function disableSubmission() {
        if (submitTestButton) {
            submitTestButton.disabled = true;
        }
    }

    function showExpiredState() {

        if (timerElement) {
            timerElement.textContent = '00:00';

            timerElement.classList.add(
                'timer-expired'
            );
        }

        disableAnswerForms();

        disableSubmission();
    }

    async function notifyServerOfExpiration() {

        if (expirationRequestSent) {
            return;
        }

        expirationRequestSent = true;

        try {

            const response = await fetch(
                expireUrl,
                {
                    method: 'POST',

                    headers: {
                        'X-CSRF-TOKEN':
                            document.querySelector(
                                'meta[name="csrf-token"]'
                            )?.getAttribute('content'),

                        'Accept':
                            'application/json',

                        'Content-Type':
                            'application/json'
                    },

                    credentials: 'same-origin'
                }
            );

            if (response.ok) {

                showExpiredState();

                return;
            }

            if (response.status === 422) {

                const data =
                    await response.json();

                expirationRequestSent = false;

                if (
                    data.remaining_seconds !== undefined
                ) {

                    updateTimerFromSeconds(
                        data.remaining_seconds
                    );
                }

                return;
            }

            if (response.status === 409) {

                showExpiredState();

                return;
            }

            expirationRequestSent = false;

        } catch (error) {

            expirationRequestSent = false;

            console.error(
                'Unable to verify test expiration:',
                error
            );
        }
    }

    function updateTimerFromSeconds(
        totalSeconds
    ) {

        const safeSeconds =
            Math.max(
                0,
                Math.floor(totalSeconds)
            );

        const minutes =
            Math.floor(
                safeSeconds / 60
            );

        const seconds =
            safeSeconds % 60;

        timerElement.textContent =
            String(minutes).padStart(2, '0')
            + ':'
            + String(seconds).padStart(2, '0');
    }

    function updateTimer() {

        const now = Date.now();

        const remaining =
            Math.max(
                0,
                expiresAt - now
            );

        const totalSeconds =
            Math.floor(
                remaining / 1000
            );

        updateTimerFromSeconds(
            totalSeconds
        );

        if (remaining <= 0) {

            clearInterval(timerInterval);

            notifyServerOfExpiration();
        }
    }

    if (submitTestForm) {

        submitTestForm.addEventListener(
            'submit',
            function (event) {

                const confirmed =
                    window.confirm(
                        'Are you sure you want to submit this test? After submission, your answers cannot be changed.'
                    );

                if (! confirmed) {
                    event.preventDefault();

                    return;
                }

                if (submitTestButton) {
                    submitTestButton.disabled = true;

                    submitTestButton.textContent =
                        'Submitting...';
                }
            }
        );
    }

    updateTimer();

    timerInterval = setInterval(
        updateTimer,
        1000
    );
</script>

@endif

</body>
</html>