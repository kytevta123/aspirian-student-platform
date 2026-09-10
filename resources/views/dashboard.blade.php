@extends('layouts.app')

@section('title', 'Dashboard - Aspirian Student Platform')

@section('content')

<section class="welcome">
    <h1>Welcome, {{ auth()->user()->name }}</h1>
    <p>Your Aspirian Student Platform dashboard.</p>
</section>

<section class="card-grid">

    {{-- Profile --}}
    <div class="card">
        <h3>Profile</h3>

        <p>
            <strong>Name:</strong>
            {{ auth()->user()->name }}
        </p>

        <p>
            <strong>Email:</strong>
            {{ auth()->user()->email }}
        </p>

        <p>
            <strong>Role:</strong>
            {{ implode(', ', auth()->user()->roleNames()) ?: 'No role assigned' }}
        </p>

        <span class="status">Verified Account</span>
    </div>

    {{-- Test Progress --}}
    <div class="card">
        <h3>Test Progress</h3>

        <p>
            <strong>Tests Attempted:</strong>
            {{ $testsAttempted }}
        </p>

        <p>
            <strong>Tests Passed:</strong>
            {{ $testsPassed }}
        </p>

        <p>
            <strong>Tests Failed:</strong>
            {{ $testsFailed }}
        </p>

        <p>
            <strong>Average Score:</strong>
            {{ number_format($averagePercentage, 2) }}%
        </p>

        <p>
            <strong>Best Score:</strong>
            {{ number_format($bestPercentage, 2) }}%
        </p>

        <p>
            <a href="{{ route('tests.results.index') }}">
                View Result History
            </a>
        </p>
    </div>

</section>

<section class="card-grid">

    {{-- Answer Performance --}}
    <div class="card">
        <h3>Answer Performance</h3>

        <p>
            <strong>Correct:</strong>
            {{ $totalCorrect }}
        </p>

        <p>
            <strong>Wrong:</strong>
            {{ $totalWrong }}
        </p>

        <p>
            <strong>Unanswered:</strong>
            {{ $totalUnanswered }}
        </p>
    </div>

    {{-- Recent Tests --}}
    <div class="card">
        <h3>Recent Tests</h3>

        @if ($recentResults->isEmpty())

            <p>
                You have not completed any tests yet.
            </p>

            <p>
                <a href="{{ route('tests.results.index') }}">
                    View Result History
                </a>
            </p>

        @else

            @foreach ($recentResults as $result)

                <div style="margin-bottom: 16px;">

                    <p>
                        <strong>
                            {{ $result->test?->title ?? 'Test' }}
                        </strong>
                    </p>

                    <p>
                        <strong>Score:</strong>
                        {{ $result->obtained_marks }}/{{ $result->total_marks }}
                    </p>

                    <p>
                        <strong>Percentage:</strong>
                        {{ number_format((float) $result->percentage, 2) }}%
                    </p>

                    <p>
                        <strong>Status:</strong>
                        {{ ucfirst($result->status) }}
                    </p>

                    <p>
                        <a href="{{ route('tests.results.show', $result) }}">
                            View Result
                        </a>
                    </p>

                </div>

            @endforeach

        @endif
    </div>

</section>

{{-- T043 Weak Topic Detection --}}
<section class="card-grid">

    <div class="card">

        <h3>Weak Topics</h3>

        <p>
            Topics where your test performance is below
            {{ number_format(
                \App\Services\WeakTopicDetectionService::WEAK_THRESHOLD,
                0
            ) }}%.
        </p>

        @if ($weakTopics->isEmpty())

            <div
                style="
                    margin-top: 16px;
                    padding: 14px;
                    border-radius: 8px;
                    background: #f0fdf4;
                "
            >
                <strong>Great work!</strong>

                <p style="margin-bottom: 0;">
                    No weak topics detected from your completed tests.
                    Keep practicing to maintain your progress.
                </p>
            </div>

        @else

            @foreach ($weakTopics as $topic)

                <div
                    style="
                        margin-top: 16px;
                        padding: 14px;
                        border: 1px solid #fecaca;
                        border-radius: 8px;
                    "
                >

                    <p style="margin-bottom: 8px;">
                        <strong>
                            {{ $topic['topic_title'] }}
                        </strong>
                    </p>

                    <p style="margin-bottom: 6px;">
                        <strong>Performance:</strong>
                        {{ number_format($topic['percentage'], 2) }}%
                    </p>

                    <p style="margin-bottom: 6px;">
                        <strong>Correct:</strong>
                        {{ $topic['correct_answers'] }}
                    </p>

                    <p style="margin-bottom: 6px;">
                        <strong>Wrong:</strong>
                        {{ $topic['wrong_answers'] }}
                    </p>

                    <p style="margin-bottom: 0;">
                        <strong>Unanswered:</strong>
                        {{ $topic['unanswered'] }}
                    </p>

                </div>

            @endforeach

        @endif

    </div>

</section>

<section class="card-grid">

    {{-- Upcoming Student Features --}}
    <div class="card">
        <h3>Coming Soon</h3>

        <p>
            Notes, topic-wise progress, revision recommendations
            and other student tools will be added in upcoming phases.
        </p>
    </div>

</section>

@endsection