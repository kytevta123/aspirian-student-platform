<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Writing Practice | Aspirian</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }

        .writing-container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .writing-header {
            margin-bottom: 30px;
        }

        .writing-header h1 {
            margin: 0 0 10px;
            font-size: 32px;
        }

        .writing-header p {
            margin: 0;
            color: #6b7280;
            font-size: 16px;
        }

        .filters {
            display: grid;
            grid-template-columns:
                minmax(220px, 2fr)
                minmax(160px, 1fr)
                minmax(160px, 1fr)
                auto;
            gap: 12px;
            margin-bottom: 30px;
        }

        .filter-input,
        .filter-select {
            width: 100%;
            box-sizing: border-box;
            padding: 11px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            color: #1f2937;
            font-size: 14px;
        }

        .filter-input:focus,
        .filter-select:focus {
            outline: none;
            border-color: #2563eb;
        }

        .filter-button {
            border: 0;
            padding: 11px 18px;
            border-radius: 8px;
            background: #2563eb;
            color: #ffffff;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .filter-button:hover {
            background: #1d4ed8;
        }

        .writing-grid {
            display: grid;
            grid-template-columns: repeat(
                auto-fit,
                minmax(280px, 1fr)
            );
            gap: 20px;
        }

        .writing-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 22px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .writing-card h2 {
            margin: 0 0 10px;
            font-size: 20px;
        }

        .writing-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 15px;
        }

        .meta-item {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 6px;
            background: #f3f4f6;
            color: #4b5563;
            font-size: 12px;
            font-weight: 600;
        }

        .writing-prompt {
            margin-bottom: 18px;
            color: #4b5563;
            font-size: 14px;
            line-height: 1.6;
        }

        .writing-details {
            margin-bottom: 18px;
            color: #6b7280;
            font-size: 13px;
            line-height: 1.7;
        }

        .writing-button {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 8px;
            background: #2563eb;
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.2s ease;
        }

        .writing-button:hover {
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

        .pagination {
            margin-top: 30px;
        }

        .pagination nav {
            display: flex;
            justify-content: center;
        }

        .pagination svg {
            width: 18px;
            height: 18px;
        }

        @media (max-width: 800px) {
            .filters {
                grid-template-columns: 1fr 1fr;
            }

            .filter-button {
                width: 100%;
            }
        }

        @media (max-width: 640px) {
            .writing-container {
                padding: 25px 15px;
            }

            .writing-header h1 {
                font-size: 26px;
            }

            .filters {
                grid-template-columns: 1fr;
            }

            .writing-card {
                padding: 18px;
            }
        }
    </style>
</head>

<body>

<div class="writing-container">

    <div class="writing-header">

        <h1>
            Writing Practice
        </h1>

        <p>
            Improve your writing skills through essays,
            paragraphs, letters, applications, stories and more.
        </p>

    </div>

    <form
        method="GET"
        action="{{ route('writing.index') }}"
        class="filters"
    >

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            class="filter-input"
            placeholder="Search writing topics..."
        >

        <select
            name="type"
            class="filter-select"
        >

            <option value="">
                All Writing Types
            </option>

            @foreach (\App\Models\WritingTemplate::TYPES as $type)

                <option
                    value="{{ $type }}"
                    @selected(request('type') === $type)
                >
                    {{ ucwords(str_replace('_', ' ', $type)) }}
                </option>

            @endforeach

        </select>

        <select
            name="difficulty"
            class="filter-select"
        >

            <option value="">
                All Difficulties
            </option>

            @foreach (\App\Models\WritingTemplate::DIFFICULTIES as $difficulty)

                <option
                    value="{{ $difficulty }}"
                    @selected(request('difficulty') === $difficulty)
                >
                    {{ ucfirst($difficulty) }}
                </option>

            @endforeach

        </select>

        <button
            type="submit"
            class="filter-button"
        >
            Search
        </button>

    </form>

    @if ($writingTemplates->isEmpty())

        <div class="empty-state">

            No published writing practice topics are available yet.

        </div>

    @else

        <div class="writing-grid">

            @foreach ($writingTemplates as $writingTemplate)

                <div class="writing-card">

                    <h2>
                        {{ $writingTemplate->title }}
                    </h2>

                    <div class="writing-meta">

                        <span class="meta-item">
                            {{ ucwords(
                                str_replace(
                                    '_',
                                    ' ',
                                    $writingTemplate->type
                                )
                            ) }}
                        </span>

                        <span class="meta-item">
                            {{ ucfirst($writingTemplate->difficulty) }}
                        </span>

                        @if ($writingTemplate->grade)

                            <span class="meta-item">
                                {{ $writingTemplate->grade->name }}
                            </span>

                        @endif

                    </div>

                    @if ($writingTemplate->subject)

                        <div class="writing-details">

                            <strong>
                                Subject:
                            </strong>

                            {{ $writingTemplate->subject->name }}

                            @if ($writingTemplate->chapter)

                                <br>

                                <strong>
                                    Chapter:
                                </strong>

                                {{ $writingTemplate->chapter->title }}

                            @endif

                            @if ($writingTemplate->topic)

                                <br>

                                <strong>
                                    Topic:
                                </strong>

                                {{ $writingTemplate->topic->title }}

                            @endif

                        </div>

                    @endif

                    <div class="writing-prompt">

                        <strong>
                            Prompt:
                        </strong>

                        {{ \Illuminate\Support\Str::limit(
                            $writingTemplate->prompt,
                            180
                        ) }}

                    </div>

                    <div class="writing-details">

                        @if ($writingTemplate->marks !== null)

                            Marks:
                            {{ $writingTemplate->marks }}

                        @endif

                        @if (
                            $writingTemplate->minimum_words !== null
                            ||
                            $writingTemplate->maximum_words !== null
                        )

                            <br>

                            Word Limit:

                            @if ($writingTemplate->minimum_words !== null)

                                {{ $writingTemplate->minimum_words }}

                            @endif

                            @if (
                                $writingTemplate->minimum_words !== null
                                &&
                                $writingTemplate->maximum_words !== null
                            )

                                -

                            @endif

                            @if ($writingTemplate->maximum_words !== null)

                                {{ $writingTemplate->maximum_words }}

                            @endif

                        @endif

                    </div>

                    <a
                        href="{{ route(
                            'writing.show',
                            $writingTemplate
                        ) }}"
                        class="writing-button"
                    >
                        View Writing Task
                    </a>

                </div>

            @endforeach

        </div>

        @if ($writingTemplates->hasPages())

            <div class="pagination">

                {{ $writingTemplates->links() }}

            </div>

        @endif

    @endif

</div>

</body>
</html>