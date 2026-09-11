@extends('layouts.app')

@section('title', 'Study Flashcard - Aspirian Student Platform')

@section('content')

    <div class="study-page">

        <div class="study-header">
            <div>
                <p class="eyebrow">
                    Flashcard Study
                </p>

                <h1>
                    {{ $flashcard->topic->title }}
                </h1>

                <p class="breadcrumb">
                    {{ $flashcard->topic->chapter->book->subject->name }}
                    /
                    {{ $flashcard->topic->chapter->title }}
                </p>
            </div>

            <a
                href="{{ route('flashcards.index') }}"
                class="back-button"
            >
                Back to Flashcards
            </a>
        </div>

        <div class="progress-card">

            <div class="progress-info">
                <span>
                    Card {{ $currentPosition }} of {{ $totalFlashcards }}
                </span>

                <span>
                    {{ $flashcard->difficulty }}
                </span>
            </div>

            <div class="progress-bar">
                @php
                    $progressPercentage = $totalFlashcards > 0
                        ? ($currentPosition / $totalFlashcards) * 100
                        : 0;
                @endphp

                <div
                    class="progress-fill"
                    style="width: {{ $progressPercentage }}%;"
                ></div>
            </div>

        </div>

        <div class="flashcard-wrapper">

            <div
                class="flashcard"
                id="flashcard"
                tabindex="0"
                role="button"
                aria-label="Click to reveal the answer"
            >

                <div class="flashcard-inner">

                    <div class="flashcard-front">

                        <span class="card-label">
                            QUESTION
                        </span>

                        <div class="card-content">
                            {!! nl2br(e($flashcard->front)) !!}
                        </div>

                        <p class="flip-hint">
                            Click the card to reveal the answer
                        </p>

                    </div>

                    <div class="flashcard-back">

                        <span class="card-label">
                            ANSWER
                        </span>

                        <div class="card-content">
                            {!! nl2br(e($flashcard->back)) !!}
                        </div>

                        <p class="flip-hint">
                            Click the card to see the question
                        </p>

                    </div>

                </div>

            </div>

        </div>

        @if (session('status'))
            <div class="action-success-message">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="action-error-message">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="progress-actions">

            <div class="progress-actions-heading">
                <span>
                    How well do you know this card?
                </span>
            </div>

            <div class="progress-action-buttons">

                <form
                    method="POST"
                    action="{{ route('flashcards.progress.store', $flashcard) }}"
                >
                    @csrf

                    <input
                        type="hidden"
                        name="status"
                        value="known"
                    >

                    <button
                        type="submit"
                        class="progress-action-button known-button {{ $progress?->status === 'known' ? 'active' : '' }}"
                    >
                        ✓ Known
                    </button>
                </form>

                <form
                    method="POST"
                    action="{{ route('flashcards.progress.store', $flashcard) }}"
                >
                    @csrf

                    <input
                        type="hidden"
                        name="status"
                        value="need_revision"
                    >

                    <button
                        type="submit"
                        class="progress-action-button revision-button {{ $progress?->status === 'need_revision' ? 'active' : '' }}"
                    >
                        ↻ Need Revision
                    </button>
                </form>

            </div>

        </div>

        <div class="study-controls">

            @if ($previousFlashcard)

                <a
                    href="{{ route('flashcards.study', $previousFlashcard) }}"
                    class="navigation-button"
                >
                    ← Previous
                </a>

            @else

                <span class="navigation-button disabled">
                    ← Previous
                </span>

            @endif

            <button
                type="button"
                id="flip-card-button"
                class="flip-button"
            >
                Show Answer
            </button>

            @if ($nextFlashcard)

                <a
                    href="{{ route('flashcards.study', $nextFlashcard) }}"
                    class="navigation-button"
                >
                    Next →
                </a>

            @else

                <span class="navigation-button disabled">
                    Next →
                </span>

            @endif

        </div>

    </div>

@endsection

@push('styles')
<style>

    .study-page {
        max-width: 900px;
        margin: 0 auto;
    }

    .study-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 25px;
    }

    .eyebrow {
        margin: 0 0 6px;
        font-size: 13px;
        font-weight: bold;
        color: #659287;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .study-header h1 {
        margin: 0;
        font-size: 30px;
        color: #172A26;
    }

    .breadcrumb {
        margin: 8px 0 0;
        color: #6b7280;
        font-size: 14px;
    }

    .back-button {
        display: inline-block;
        padding: 10px 16px;
        background: #172A26;
        color: white;
        text-decoration: none;
        border-radius: 7px;
        font-weight: bold;
        white-space: nowrap;
    }

    .back-button:hover {
        opacity: 0.9;
    }

    .progress-card {
        background: white;
        padding: 18px 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        margin-bottom: 25px;
    }

    .progress-info {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 10px;
        font-size: 14px;
        font-weight: bold;
        color: #4b5563;
    }

    .progress-bar {
        width: 100%;
        height: 8px;
        background: #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: #659287;
        border-radius: 10px;
        transition: width 0.3s ease;
    }

    .flashcard-wrapper {
        position: relative;
        z-index: 1;
        perspective: 1200px;
    }

    .flashcard {
        width: 100%;
        min-height: 420px;
        cursor: pointer;
        outline: none;
    }

    .flashcard-inner {
        position: relative;
        width: 100%;
        min-height: 420px;
        transition: transform 0.6s;
        transform-style: preserve-3d;
    }

    .flashcard.flipped .flashcard-inner {
        transform: rotateY(180deg);
    }

    .flashcard-front,
    .flashcard-back {
        position: absolute;
        inset: 0;
        min-height: 420px;
        padding: 50px;
        border-radius: 16px;
        background: white;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.10);

        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;

        text-align: center;

        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
    }

    .flashcard-back {
        transform: rotateY(180deg);
    }

    .card-label {
        display: inline-block;
        margin-bottom: 25px;
        padding: 7px 14px;
        border-radius: 20px;
        background: #E6F2DD;
        color: #172A26;
        font-size: 12px;
        font-weight: bold;
        letter-spacing: 1px;
    }

    .card-content {
        max-width: 750px;
        font-size: 28px;
        line-height: 1.5;
        font-weight: 600;
        color: #172A26;
    }

    .flip-hint {
        margin: 30px 0 0;
        color: #6b7280;
        font-size: 14px;
    }

    .action-success-message {
        position: relative;
        z-index: 10;
        margin-top: 25px;
        margin-bottom: 15px;
        padding: 12px 16px;
        border-radius: 8px;
        background: #e8f5e9;
        color: #256029;
        text-align: center;
        font-weight: bold;
    }

    .action-error-message {
        position: relative;
        z-index: 10;
        margin-top: 25px;
        margin-bottom: 15px;
        padding: 12px 16px;
        border-radius: 8px;
        background: #ffebee;
        color: #b71c1c;
        text-align: center;
        font-weight: bold;
    }

    .progress-actions {
        position: relative;
        z-index: 10;
        margin-top: 25px;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
    }

    .progress-actions-heading {
        margin-bottom: 15px;
        text-align: center;
        font-size: 15px;
        font-weight: bold;
        color: #374151;
    }

    .progress-action-buttons {
        position: relative;
        z-index: 11;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .progress-action-buttons form {
        position: relative;
        z-index: 12;
        margin: 0;
    }

    .progress-action-button {
        position: relative;
        z-index: 13;
        width: 100%;
        min-height: 48px;
        padding: 11px 18px;
        border-radius: 8px;
        font-size: 15px;
        font-weight: bold;
        cursor: pointer;
        pointer-events: auto;
        transition:
            transform 0.2s ease,
            opacity 0.2s ease,
            box-shadow 0.2s ease;
    }

    .progress-action-button:hover {
        transform: translateY(-1px);
    }

    .known-button {
        border: 1px solid #659287;
        background: #E6F2DD;
        color: #172A26;
    }

    .known-button.active {
        background: #659287;
        border-color: #659287;
        color: white;
        box-shadow: 0 0 0 3px rgba(101, 146, 135, 0.20);
    }

    .revision-button {
        border: 1px solid #d1d5db;
        background: #f9fafb;
        color: #374151;
    }

    .revision-button.active {
        border-color: #172A26;
        background: #172A26;
        color: white;
        box-shadow: 0 0 0 3px rgba(23, 42, 38, 0.15);
    }

    .study-controls {
        position: relative;
        z-index: 10;
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        gap: 15px;
        margin-top: 25px;
    }

    .navigation-button,
    .flip-button {
        min-height: 46px;
        padding: 11px 18px;
        border-radius: 7px;
        font-size: 15px;
        font-weight: bold;
        text-decoration: none;
        text-align: center;
    }

    .navigation-button {
        background: white;
        color: #172A26;
        border: 1px solid #d1d5db;
    }

    .navigation-button:hover {
        background: #f9fafb;
    }

    .navigation-button:last-child {
        justify-self: end;
    }

    .flip-button {
        border: 0;
        background: #172A26;
        color: white;
        cursor: pointer;
    }

    .flip-button:hover {
        opacity: 0.9;
    }

    .navigation-button.disabled {
        color: #9ca3af;
        background: #f3f4f6;
        cursor: not-allowed;
    }

    @media (max-width: 700px) {

        .study-header {
            flex-direction: column;
        }

        .study-header h1 {
            font-size: 24px;
        }

        .back-button {
            width: 100%;
            text-align: center;
        }

        .flashcard,
        .flashcard-inner,
        .flashcard-front,
        .flashcard-back {
            min-height: 360px;
        }

        .flashcard-front,
        .flashcard-back {
            padding: 30px 20px;
        }

        .card-content {
            font-size: 22px;
        }

        .progress-action-buttons {
            grid-template-columns: 1fr;
        }

        .study-controls {
            grid-template-columns: 1fr 1fr;
        }

        .flip-button {
            grid-column: 1 / -1;
            grid-row: 1;
        }

        .navigation-button:last-child {
            justify-self: stretch;
        }

        .navigation-button {
            width: 100%;
        }

    }

</style>
@endpush

@push('scripts')
<script>

    document.addEventListener('DOMContentLoaded', function () {

        const flashcard = document.getElementById('flashcard');
        const flipButton = document.getElementById('flip-card-button');

        if (!flashcard || !flipButton) {
            return;
        }

        function flipCard() {
            flashcard.classList.toggle('flipped');

            if (flashcard.classList.contains('flipped')) {
                flipButton.textContent = 'Show Question';
            } else {
                flipButton.textContent = 'Show Answer';
            }
        }

        flashcard.addEventListener('click', flipCard);

        flashcard.addEventListener('keydown', function (event) {

            if (
                event.key === 'Enter'
                || event.key === ' '
            ) {
                event.preventDefault();
                flipCard();
            }

        });

        flipButton.addEventListener('click', function (event) {
            event.stopPropagation();
            flipCard();
        });

    });

</script>
@endpush