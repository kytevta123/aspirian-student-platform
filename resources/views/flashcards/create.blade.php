@extends('layouts.app')

@section('title', 'Create Flashcard')

@section('content')

```
<div style="margin-bottom: 25px;">
    <h1 style="margin: 0 0 8px;">Create Flashcard</h1>

    <p style="margin: 0; color: #6b7280;">
        Create a flashcard for an active topic.
    </p>
</div>

@if ($errors->any())
    <div
        style="
            background: #ffebee;
            color: #b71c1c;
            padding: 14px 18px;
            border-radius: 6px;
            margin-bottom: 20px;
        "
    >
        <strong>Please fix the following errors:</strong>

        <ul style="margin: 10px 0 0 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">

    <form
        method="POST"
        action="{{ route('flashcards.store') }}"
    >

        @csrf

        <div style="margin-bottom: 20px;">

            <label
                for="topic_id"
                style="display: block; font-weight: bold; margin-bottom: 7px;"
            >
                Topic
            </label>

            <select
                id="topic_id"
                name="topic_id"
                required
                style="
                    width: 100%;
                    padding: 11px;
                    border: 1px solid #d1d5db;
                    border-radius: 6px;
                    background: white;
                "
            >

                <option value="">
                    Select a topic
                </option>

                @foreach ($topics as $topic)
                    <option
                        value="{{ $topic->id }}"
                        @selected((string) old('topic_id') === (string) $topic->id)
                    >
                        {{ $topic->chapter->book->subject->name ?? 'Subject' }}
                        —
                        {{ $topic->chapter->title ?? 'Chapter' }}
                        —
                        {{ $topic->title }}
                    </option>
                @endforeach

            </select>

            @error('topic_id')
                <div style="color: #b71c1c; margin-top: 6px;">
                    {{ $message }}
                </div>
            @enderror

        </div>

        <div style="margin-bottom: 20px;">

            <label
                for="front"
                style="display: block; font-weight: bold; margin-bottom: 7px;"
            >
                Front / Question
            </label>

            <textarea
                id="front"
                name="front"
                rows="5"
                required
                maxlength="10000"
                placeholder="Enter the question or concept..."
                style="
                    width: 100%;
                    padding: 11px;
                    border: 1px solid #d1d5db;
                    border-radius: 6px;
                    resize: vertical;
                    font-family: Arial, sans-serif;
                "
            >{{ old('front') }}</textarea>

            @error('front')
                <div style="color: #b71c1c; margin-top: 6px;">
                    {{ $message }}
                </div>
            @enderror

        </div>

        <div style="margin-bottom: 20px;">

            <label
                for="back"
                style="display: block; font-weight: bold; margin-bottom: 7px;"
            >
                Back / Answer
            </label>

            <textarea
                id="back"
                name="back"
                rows="6"
                required
                maxlength="10000"
                placeholder="Enter the answer or explanation..."
                style="
                    width: 100%;
                    padding: 11px;
                    border: 1px solid #d1d5db;
                    border-radius: 6px;
                    resize: vertical;
                    font-family: Arial, sans-serif;
                "
            >{{ old('back') }}</textarea>

            @error('back')
                <div style="color: #b71c1c; margin-top: 6px;">
                    {{ $message }}
                </div>
            @enderror

        </div>

        <div
            style="
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 20px;
                margin-bottom: 25px;
            "
        >

            <div>

                <label
                    for="difficulty"
                    style="display: block; font-weight: bold; margin-bottom: 7px;"
                >
                    Difficulty
                </label>

                <select
                    id="difficulty"
                    name="difficulty"
                    required
                    style="
                        width: 100%;
                        padding: 11px;
                        border: 1px solid #d1d5db;
                        border-radius: 6px;
                        background: white;
                    "
                >

                    @foreach (\App\Models\Flashcard::DIFFICULTIES as $difficulty)
                        <option
                            value="{{ $difficulty }}"
                            @selected(old('difficulty', \App\Models\Flashcard::DIFFICULTY_MEDIUM) === $difficulty)
                        >
                            {{ ucfirst($difficulty) }}
                        </option>
                    @endforeach

                </select>

                @error('difficulty')
                    <div style="color: #b71c1c; margin-top: 6px;">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div>

                <label
                    for="status"
                    style="display: block; font-weight: bold; margin-bottom: 7px;"
                >
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                    required
                    style="
                        width: 100%;
                        padding: 11px;
                        border: 1px solid #d1d5db;
                        border-radius: 6px;
                        background: white;
                    "
                >

                    @foreach (\App\Models\Flashcard::STATUSES as $status)
                        <option
                            value="{{ $status }}"
                            @selected(old('status', \App\Models\Flashcard::STATUS_DRAFT) === $status)
                        >
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach

                </select>

                @error('status')
                    <div style="color: #b71c1c; margin-top: 6px;">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>

        <div
            style="
                display: flex;
                gap: 12px;
                flex-wrap: wrap;
            "
        >

            <button
                type="submit"
                style="
                    background: #172A26;
                    color: white;
                    border: none;
                    padding: 11px 20px;
                    border-radius: 6px;
                    cursor: pointer;
                "
            >
                Create Flashcard
            </button>

            <a
                href="{{ route('flashcards.index') }}"
                style="
                    display: inline-block;
                    background: #e5e7eb;
                    color: #1f2937;
                    text-decoration: none;
                    padding: 11px 20px;
                    border-radius: 6px;
                "
            >
                Cancel
            </a>

        </div>

    </form>

</div>
```

@endsection
