@php
    $test = $test ?? $attempt->test;
    $questions = $questions ?? $attempt->test->questions;
@endphp

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
        {{ $test->title }} - Test Attempt
    </title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family:
                Arial,
                Helvetica,
                sans-serif;
            background: #f4f6f8;
            color: #1f2937;
        }

        .container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            padding: 30px 20px 50px;
        }

        .header {
            background: #ffffff;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 20px;
            box-shadow:
                0 2px 10px rgba(0, 0, 0, 0.06);
        }

        .header h1 {
            margin: 0 0 10px;
            font-size: 28px;
        }

        .instructions {
            margin: 0;
            color: #6b7280;
            line-height: 1.6;
        }

        .timer-wrapper {
            position: sticky;
            top: 15px;
            z-index: 100;
            margin-bottom: 20px;
        }

        .timer {
            background: #ffffff;
            border-radius: 12px;
            padding: 18px 22px;
            box-shadow:
                0 2px 10px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .timer-label {
            font-size: 15px;
            color: #6b7280;
        }

        .timer-value {
            font-size: 28px;
            font-weight: 700;
            font-variant-numeric: tabular-nums;
        }

        .timer-value.expired {
            color: #b91c1c;
        }

        .notice {
            display: none;
            background: #fff7ed;
            border: 1px solid #fdba74;
            color: #9a3412;
            border-radius: 10px;
            padding: 15px 18px;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .notice.show {
            display: block;
        }

        .questions {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .question-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 22px;
            box-shadow:
                0 2px 10px rgba(0, 0, 0, 0.06);
        }

        .question-number {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .question-text {
            font-size: 18px;
            font-weight: 600;
            line-height: 1.6;
            margin-bottom: 18px;
        }

        .options {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .option {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 12px 14px;
            transition: background 0.15s ease;
        }

        .option:hover {
            background: #f9fafb;
        }

        .option label {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            cursor: pointer;
            line-height: 1.5;
        }

        .option input {
            margin-top: 4px;
        }

        .answer-status {
            margin-top: 12px;
            font-size: 13px;
            color: #6b7280;
        }

        .actions {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
            box-shadow:
                0 2px 10px rgba(0, 0, 0, 0.06);
        }

        .submit-form {
            margin: 0;
        }

        .btn {
            display: inline-block;
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-primary {
            background: #2563eb;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-danger {
            background: #dc2626;
            color: #ffffff;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        .btn:disabled {
            opacity: 0.55;
            cursor: not-allowed;
        }

        .success-message {
            background: #ecfdf5;
            border: 1px solid #86efac;
            color: #166534;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 20px;
        }

        .error-message {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            color: #991b1b;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 20px;
        }

        .status-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 22px;
            margin-bottom: 20px;
            box-shadow:
                0 2px 10px rgba(0, 0, 0, 0.06);
        }

        .status-card h2 {
            margin-top: 0;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
        }

        .status-in-progress {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .status-submitted {
            background: #dcfce7;
            color: #166534;
        }

        .status-expired {
            background: #fee2e2;
            color: #991b1b;
        }

        .security-note {
            margin-top: 18px;
            padding: 12px 14px;
            background: #f9fafb;
            border-radius: 8px;
            color: #6b7280;
            font-size: 13px;
            line-height: 1.5;
        }

        @media (max-width: 700px) {
            .container {
                padding: 20px 12px 40px;
            }

            .header h1 {
                font-size: 23px;
            }

            .timer {
                align-items: flex-start;
                flex-direction: column;
                gap: 8px;
            }

            .timer-value {
                font-size: 25px;
            }

            .question-card {
                padding: 17px;
            }

            .question-text {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    {{-- ---------------------------------------------------------
        Test Header
    ---------------------------------------------------------- --}}

    <div class="header">

        <h1>
            {{ $test->title }}
        </h1>

        @if ($test->instructions)
            <p class="instructions">
                {{ $test->instructions }}
            </p>
        @endif

    </div>

    {{-- ---------------------------------------------------------
        Session Messages
    ---------------------------------------------------------- --}}

    @if (session('status'))
        <div class="success-message">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="error-message">

            @foreach ($errors->all() as $error)
                <div>
                    {{ $error }}
                </div>
            @endforeach

        </div>
    @endif

    {{-- ---------------------------------------------------------
        Attempt Status
    ---------------------------------------------------------- --}}

    @if ($attempt->isSubmitted())

        <div class="status-card">

            <h2>
                Test Submitted
            </h2>

            <span
                class="
                    status-badge
                    status-submitted
                "
            >
                Submitted
            </span>

            @if ($attempt->submitted_at)
                <p>
                    Submitted at:
                    <strong>
                        {{ $attempt->submitted_at->format('d M Y, h:i A') }}
                    </strong>
                </p>
            @endif

            <div class="security-note">
                Your answers are locked because this test attempt
                has already been submitted.
            </div>

        </div>

    @elseif ($attempt->isExpired())

        <div class="status-card">

            <h2>
                Test Time Expired
            </h2>

            <span
                class="
                    status-badge
                    status-expired
                "
            >
                Expired
            </span>

            <div class="security-note">
                The test time has expired. This attempt is no longer
                accepting answers.
            </div>

        </div>

    @else

        {{-- -----------------------------------------------------
            Timer
        ------------------------------------------------------ --}}

        <div class="timer-wrapper">

            <div
                class="timer"
                id="test-timer"
                data-expires-at="{{ optional($attempt->expires_at)->toIso8601String() }}"
            >

                <div>
                    <div class="timer-label">
                        Time Remaining
                    </div>
                </div>

                <div
                    class="timer-value"
                    id="timer-value"
                >
                    --:--
                </div>

            </div>

        </div>

        {{-- -----------------------------------------------------
            Expiry / Auto Submission Notice
        ------------------------------------------------------ --}}

        <div
            class="notice"
            id="expiry-notice"
        >
            The test time has expired.
            Your test is being submitted automatically.
            Please wait...
        </div>

    @endif

    {{-- ---------------------------------------------------------
        Questions
    ---------------------------------------------------------- --}}

    @if ($questions->isNotEmpty())

        <div class="questions">

            @foreach ($questions as $index => $question)

                @php
                    $existingAnswer = $attempt->answers
                        ->firstWhere(
                            'question_id',
                            $question->id
                        );

                    $selectedAnswer = $existingAnswer
                        ? $existingAnswer->answer
                        : null;
                @endphp

                <div
                    class="question-card"
                    data-question-id="{{ $question->id }}"
                >

                    <div class="question-number">
                        Question {{ $index + 1 }}
                    </div>

                    <div class="question-text">
                        {{ $question->question_text }}
                    </div>

                    @if (
                        is_array($question->options)
                        && count($question->options) > 0
                    )

                        <div class="options">

                            @foreach ($question->options as $optionKey => $option)

                                @php
                                    if (is_array($option)) {
                                        $optionValue =
                                            $option['value']
                                            ?? $option['text']
                                            ?? '';

                                        $optionLabel =
                                            $option['label']
                                            ?? $option['text']
                                            ?? $optionValue;
                                    } else {
                                        $optionValue = $option;
                                        $optionLabel = $option;
                                    }
                                @endphp

                                <div class="option">

                                    <label>

                                        <input
                                            type="radio"
                                            name="question_{{ $question->id }}"
                                            value="{{ $optionValue }}"
                                            data-question-id="{{ $question->id }}"
                                            @checked(
                                                $selectedAnswer !== null
                                                && $selectedAnswer == $optionValue
                                            )
                                            @disabled(
                                                ! $attempt->isInProgress()
                                                || $attempt->isExpired()
                                            )
                                        >

                                        <span>
                                            {{ $optionLabel }}
                                        </span>

                                    </label>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <input
                            type="text"
                            class="text-answer"
                            data-question-id="{{ $question->id }}"
                            value="{{ $selectedAnswer ?? '' }}"
                            placeholder="Enter your answer"
                            @disabled(
                                ! $attempt->isInProgress()
                                || $attempt->isExpired()
                            )
                            style="
                                width: 100%;
                                padding: 12px;
                                border: 1px solid #d1d5db;
                                border-radius: 8px;
                                font-size: 15px;
                            "
                        >

                    @endif

                    @if ($selectedAnswer !== null)

                        <div class="answer-status">
                            Answer saved.
                        </div>

                    @else

                        <div class="answer-status">
                            No answer saved yet.
                        </div>

                    @endif

                </div>

            @endforeach

        </div>

    @else

        <div class="error-message">
            This test does not contain any questions.
        </div>

    @endif

    {{-- ---------------------------------------------------------
        Manual Submit
    ---------------------------------------------------------- --}}

    @if ($attempt->isInProgress())

        <div class="actions">

            <form
                method="POST"
                action="{{
                    route(
                        'tests.attempts.submit',
                        ['attempt' => $attempt->id]
                    )
                }}"
                id="manual-submit-form"
                class="submit-form"
            >

                @csrf

                <button
                    type="submit"
                    class="btn btn-danger"
                    id="manual-submit-button"
                >
                    Submit Test
                </button>

            </form>

            <div class="security-note">
                Once you submit the test, your answers will be locked
                and the result will be calculated.
            </div>

        </div>

    @endif

</div>

<script>
    /*
    |--------------------------------------------------------------------------
    | Test Attempt Timer + Automatic Submission
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            const timerElement =
                document.getElementById('test-timer');

            const timerValue =
                document.getElementById('timer-value');

            const expiryNotice =
                document.getElementById('expiry-notice');

            const manualSubmitForm =
                document.getElementById(
                    'manual-submit-form'
                );

            const manualSubmitButton =
                document.getElementById(
                    'manual-submit-button'
                );

            if (!timerElement || !timerValue) {
                return;
            }

            const expiresAt =
                timerElement.dataset.expiresAt;

            const autoSubmitUrl =
                "{{ route(
                    'tests.attempts.auto-submit',
                    ['attempt' => $attempt->id]
                ) }}";

            const csrfToken =
                document.querySelector(
                    'meta[name="csrf-token"]'
                ).getAttribute('content');

            let autoSubmitRequested = false;

            let timerInterval = null;

            /*
            |--------------------------------------------------------------------------
            | Format Remaining Time
            |--------------------------------------------------------------------------
            */

            function formatTime(seconds) {

                seconds = Math.max(
                    0,
                    Math.floor(seconds)
                );

                const minutes =
                    Math.floor(seconds / 60);

                const remainingSeconds =
                    seconds % 60;

                return (
                    String(minutes).padStart(2, '0')
                    + ':'
                    + String(remainingSeconds).padStart(2, '0')
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Disable Test Controls
            |--------------------------------------------------------------------------
            */

            function disableTestControls() {

                const controls =
                    document.querySelectorAll(
                        'input, button, textarea, select'
                    );

                controls.forEach(
                    function (control) {

                        if (
                            control.id ===
                            'manual-submit-button'
                        ) {
                            control.disabled = true;
                            return;
                        }

                        if (
                            control.form &&
                            control.form.id ===
                            'manual-submit-form'
                        ) {
                            control.disabled = true;
                            return;
                        }

                        control.disabled = true;
                    }
                );

                if (manualSubmitButton) {
                    manualSubmitButton.disabled = true;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Show Expiry Notice
            |--------------------------------------------------------------------------
            */

            function showExpiryNotice() {

                if (expiryNotice) {
                    expiryNotice.classList.add('show');
                }

                timerValue.textContent = '00:00';
                timerValue.classList.add('expired');

                disableTestControls();
            }

            /*
            |--------------------------------------------------------------------------
            | Auto Submit Test
            |--------------------------------------------------------------------------
            */

            async function autoSubmitTest() {

                if (autoSubmitRequested) {
                    return;
                }

                autoSubmitRequested = true;

                showExpiryNotice();

                try {

                    const response =
                        await fetch(
                            autoSubmitUrl,
                            {
                                method: 'POST',

                                headers: {
                                    'Content-Type':
                                        'application/json',

                                    'Accept':
                                        'application/json',

                                    'X-CSRF-TOKEN':
                                        csrfToken,

                                    'X-Requested-With':
                                        'XMLHttpRequest'
                                },

                                body: JSON.stringify({})
                            }
                        );

                    const data =
                        await response.json();

                    /*
                    |--------------------------------------------------------------------------
                    | Successful Automatic Submission
                    |--------------------------------------------------------------------------
                    */

                    if (
                        response.ok
                        && data.success
                        && data.result_url
                    ) {

                        timerValue.textContent =
                            '00:00';

                        window.location.href =
                            data.result_url;

                        return;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Server Says Test Is Not Yet Expired
                    |--------------------------------------------------------------------------
                    |
                    | Browser timer can reach zero slightly before the
                    | server time. In this case, use the server's
                    | remaining_seconds value and continue.
                    |
                    */

                    if (
                        response.status === 422
                        && typeof data.remaining_seconds
                            !== 'undefined'
                    ) {

                        autoSubmitRequested = false;

                        const remainingSeconds =
                            Math.max(
                                0,
                                Number(
                                    data.remaining_seconds
                                )
                            );

                        timerValue.textContent =
                            formatTime(
                                remainingSeconds
                            );

                        timerValue.classList.remove(
                            'expired'
                        );

                        if (expiryNotice) {
                            expiryNotice.classList.remove(
                                'show'
                            );
                        }

                        enableTestControls();

                        startTimer(
                            remainingSeconds
                        );

                        return;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Already Submitted / Existing Result
                    |--------------------------------------------------------------------------
                    */

                    if (
                        data.result_url
                    ) {

                        window.location.href =
                            data.result_url;

                        return;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Unexpected Server Response
                    |--------------------------------------------------------------------------
                    */

                    console.error(
                        'Automatic submission failed.',
                        data
                    );

                    autoSubmitRequested = false;

                } catch (error) {

                    /*
                    |--------------------------------------------------------------------------
                    | Network / Fetch Error
                    |--------------------------------------------------------------------------
                    */

                    console.error(
                        'Automatic submission request failed.',
                        error
                    );

                    autoSubmitRequested = false;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Enable Controls
            |--------------------------------------------------------------------------
            */

            function enableTestControls() {

                const controls =
                    document.querySelectorAll(
                        'input, button, textarea, select'
                    );

                controls.forEach(
                    function (control) {

                        if (
                            control.id ===
                            'manual-submit-button'
                        ) {
                            control.disabled = false;
                            return;
                        }

                        if (
                            control.form &&
                            control.form.id ===
                            'manual-submit-form'
                        ) {
                            return;
                        }

                        control.disabled = false;
                    }
                );

                if (manualSubmitButton) {
                    manualSubmitButton.disabled = false;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Start Timer
            |--------------------------------------------------------------------------
            */

            function startTimer(
                initialRemainingSeconds = null
            ) {

                if (timerInterval) {
                    clearInterval(timerInterval);
                }

                function updateTimer() {

                    let remainingSeconds;

                    if (
                        initialRemainingSeconds !== null
                    ) {

                        remainingSeconds =
                            initialRemainingSeconds;

                        initialRemainingSeconds = null;

                    } else {

                        const now =
                            Date.now();

                        const expiryTime =
                            new Date(
                                expiresAt
                            ).getTime();

                        remainingSeconds =
                            Math.ceil(
                                (
                                    expiryTime -
                                    now
                                ) / 1000
                            );
                    }

                    remainingSeconds =
                        Math.max(
                            0,
                            remainingSeconds
                        );

                    timerValue.textContent =
                        formatTime(
                            remainingSeconds
                        );

                    /*
                    |--------------------------------------------------------------------------
                    | Time Reached Zero
                    |--------------------------------------------------------------------------
                    */

                    if (
                        remainingSeconds <= 0
                    ) {

                        clearInterval(
                            timerInterval
                        );

                        timerInterval = null;

                        autoSubmitTest();

                        return;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Normal Timer Display
                    |--------------------------------------------------------------------------
                    */

                    timerValue.classList.remove(
                        'expired'
                    );
                }

                updateTimer();

                timerInterval =
                    setInterval(
                        updateTimer,
                        1000
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | Manual Submit Confirmation
            |--------------------------------------------------------------------------
            */

            if (manualSubmitForm) {

                manualSubmitForm.addEventListener(
                    'submit',
                    function (event) {

                        const confirmed =
                            window.confirm(
                                'Are you sure you want to submit this test? You will not be able to change your answers after submission.'
                            );

                        if (!confirmed) {
                            event.preventDefault();
                            return;
                        }

                        if (manualSubmitButton) {
                            manualSubmitButton.disabled =
                                true;

                            manualSubmitButton.textContent =
                                'Submitting...';
                        }
                    }
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Start Timer
            |--------------------------------------------------------------------------
            */

            startTimer();

        }
    );
</script>

</body>
</html>