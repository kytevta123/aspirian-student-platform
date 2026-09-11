@extends('layouts.app')

@section('title', 'Flashcards')

@section('content')

<div style="display: flex; justify-content: space-between; align-items: center; gap: 20px; margin-bottom: 25px; flex-wrap: wrap;">
    <div>
        <h1 style="margin: 0 0 8px;">Flashcards</h1>
        <p style="margin: 0; color: #6b7280;">
            Review important concepts quickly with topic-based flashcards.
        </p>
    </div>

    <a
        href="{{ route('flashcards.create') }}"
        style="display: inline-block; background: #172A26; color: white; text-decoration: none; padding: 10px 16px; border-radius: 6px;"
    >
        Create Flashcard
    </a>
</div>

@if (session('status'))
    <div
        style="background: #e8f5e9; color: #256029; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;"
    >
        {{ session('status') }}
    </div>
@endif

<div class="card" style="margin-bottom: 25px;">

    <form
        method="GET"
        action="{{ route('flashcards.index') }}"
        style="display: grid; grid-template-columns: 1fr 180px auto auto; gap: 12px; align-items: end;"
    >

        <div>
            <label
                for="search"
                style="display: block; font-weight: bold; margin-bottom: 6px;"
            >
                Search
            </label>

            <input
                type="text"
                id="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search flashcards..."
                style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;"
            >
        </div>

        <div>
            <label
                for="difficulty"
                style="display: block; font-weight: bold; margin-bottom: 6px;"
            >
                Difficulty
            </label>

            <select
                id="difficulty"
                name="difficulty"
                style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;"
            >
                <option value="">All</option>

                @foreach (\App\Models\Flashcard::DIFFICULTIES as $difficulty)
                    <option
                        value="{{ $difficulty }}"
                        @selected(request('difficulty') === $difficulty)
                    >
                        {{ ucfirst($difficulty) }}
                    </option>
                @endforeach
            </select>
        </div>

        <button
            type="submit"
            style="background: #172A26; color: white; border: none; padding: 10px 18px; border-radius: 6px; cursor: pointer;"
        >
            Search
        </button>

        <a
            href="{{ route('flashcards.index') }}"
            style="display: inline-block; text-align: center; background: #e5e7eb; color: #1f2937; text-decoration: none; padding: 10px 18px; border-radius: 6px;"
        >
            Clear
        </a>

    </form>

</div>

@if ($flashcards->count())

    <div class="card-grid">

        @foreach ($flashcards as $flashcard)

            <article class="card">

                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 15px; margin-bottom: 15px;">

                    <span
                        style="
                            display: inline-block;
                            padding: 5px 10px;
                            border-radius: 20px;
                            background:
                                {{ $flashcard->difficulty === 'easy'
                                    ? '#e8f5e9'
                                    : ($flashcard->difficulty === 'hard'
                                        ? '#ffebee'
                                        : '#fff8e1') }};
                            color:
                                {{ $flashcard->difficulty === 'easy'
                                    ? '#256029'
                                    : ($flashcard->difficulty === 'hard'
                                        ? '#b71c1c'
                                        : '#8a6d1d') }};
                            font-size: 13px;
                            font-weight: bold;
                        "
                    >
                        {{ ucfirst($flashcard->difficulty) }}
                    </span>

                </div>

                <h3 style="margin-bottom: 10px;">
                    Question
                </h3>

                <div style="line-height: 1.6; margin-bottom: 20px;">
                    {!! nl2br(e($flashcard->front)) !!}
                </div>

                <h3 style="margin-bottom: 10px;">
                    Answer
                </h3>

                <div style="line-height: 1.6; margin-bottom: 20px;">
                    {!! nl2br(e($flashcard->back)) !!}
                </div>

                <div
                    style="
                        border-top: 1px solid #e5e7eb;
                        padding-top: 15px;
                        color: #6b7280;
                        font-size: 14px;
                    "
                >

                    <div>
                        <strong>Topic:</strong>
                        {{ $flashcard->topic->title ?? 'N/A' }}
                    </div>

                    <div>
                        <strong>Chapter:</strong>
                        {{ $flashcard->topic->chapter->title ?? 'N/A' }}
                    </div>

                    <div>
                        <strong>Subject:</strong>
                        {{ $flashcard->topic->chapter->book->subject->name ?? 'N/A' }}
                    </div>

                </div>

                <div
                    style="
                        margin-top: 20px;
                        padding-top: 15px;
                        border-top: 1px solid #e5e7eb;
                    "
                >
                    <a
                        href="{{ route('flashcards.study', $flashcard) }}"
                        style="
                            display: inline-block;
                            width: 100%;
                            box-sizing: border-box;
                            text-align: center;
                            background: #172A26;
                            color: white;
                            text-decoration: none;
                            padding: 11px 16px;
                            border-radius: 6px;
                            font-weight: bold;
                        "
                    >
                        Study Flashcard
                    </a>
                </div>

            </article>

        @endforeach

    </div>

    <div style="margin-top: 25px;">
        {{ $flashcards->links() }}
    </div>

@else

    <div class="card" style="text-align: center;">

        <h3>No flashcards found</h3>

        <p style="color: #6b7280;">
            There are currently no published flashcards matching your search.
        </p>

        <a
            href="{{ route('flashcards.create') }}"
            style="display: inline-block; margin-top: 10px; background: #172A26; color: white; text-decoration: none; padding: 10px 16px; border-radius: 6px;"
        >
            Create Flashcard
        </a>

    </div>

@endif

@endsection