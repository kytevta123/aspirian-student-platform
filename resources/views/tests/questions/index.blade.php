<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Select Questions - {{ $test->title }}
    </title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7f9;
            color: #1f2937;
        }

        .navbar {
            background: #172A26;
            color: white;
            padding: 14px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .brand {
            font-size: 22px;
            font-weight: bold;
            white-space: nowrap;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 8px 10px;
            border-radius: 5px;
        }

        .nav-links a:hover,
        .nav-links a.active {
            background: rgba(255, 255, 255, 0.12);
        }

        .logout-button {
            background: transparent;
            border: 1px solid rgba(255,255,255,0.5);
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        .logout-button:hover {
            background: rgba(255,255,255,0.1);
        }

        .container {
            max-width: 1250px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .page-header {
            background: white;
            padding: 24px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            margin-bottom: 20px;
        }

        .page-header h1 {
            margin: 0 0 8px;
        }

        .test-meta {
            color: #6b7280;
            font-size: 14px;
            margin-top: 5px;
        }

        .status-message {
            margin-bottom: 20px;
            padding: 14px 16px;
            border-radius: 7px;
            background: #f0fdf4;
            border: 1px solid #86efac;
            color: #166534;
        }

        .error-message {
            margin-bottom: 20px;
            padding: 14px 16px;
            border-radius: 7px;
            background: #fef2f2;
            border: 1px solid #fca5a5;
            color: #991b1b;
        }

        .error-message ul {
            margin-bottom: 0;
        }

        .selection-tools {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            background: white;
            padding: 22px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        }

        .card h2 {
            margin-top: 0;
            margin-bottom: 18px;
            font-size: 20px;
        }

        .form-row {
            display: flex;
            gap: 10px;
            align-items: end;
        }

        .form-group {
            flex: 1;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
            font-size: 14px;
        }

        input,
        select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            background: white;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
        }

        button,
        .button {
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
        }

        .primary-button {
            background: #2563eb;
            color: white;
        }

        .primary-button:hover {
            background: #1d4ed8;
        }

        .danger-button {
            background: #dc2626;
            color: white;
        }

        .danger-button:hover {
            background: #b91c1c;
        }

        .secondary-button {
            background: #e5e7eb;
            color: #111827;
        }

        .secondary-button:hover {
            background: #d1d5db;
        }

        .save-order-button {
            background: #059669;
            color: white;
            padding: 11px 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        .save-order-button:hover {
            background: #047857;
        }

        .save-order-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .search-card {
            margin-bottom: 20px;
        }

        .filters {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 2fr;
            gap: 12px;
            align-items: end;
        }

        .filter-actions {
            display: flex;
            gap: 8px;
            margin-top: 14px;
        }

        .main-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            align-items: start;
        }

        .question {
            border: 1px solid #e5e7eb;
            padding: 18px;
            margin-bottom: 12px;
            border-radius: 8px;
            background: #ffffff;
        }

        .question:last-child {
            margin-bottom: 0;
        }

        .question-text {
            font-size: 16px;
            font-weight: bold;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .meta {
            color: #555;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .meta strong {
            color: #374151;
        }

        .badges {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin: 10px 0;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            background: #eef2ff;
            color: #3730a3;
            font-size: 12px;
            font-weight: bold;
        }

        .badge.difficulty {
            background: #ecfdf5;
            color: #047857;
        }

        .badge.marks {
            background: #fff7ed;
            color: #c2410c;
        }

        .badge.selected {
            background: #dcfce7;
            color: #166534;
        }

        .question-actions {
            margin-top: 14px;
        }

        .sortable-list {
            margin: 0;
            padding: 0;
        }

        .selected-question {
            display: grid;
            grid-template-columns: 40px 1fr auto;
            gap: 12px;
            align-items: start;
            border: 1px solid #e5e7eb;
            padding: 14px;
            margin-bottom: 10px;
            border-radius: 8px;
            background: #fafafa;
            cursor: grab;
            transition:
                opacity 0.2s,
                transform 0.2s,
                box-shadow 0.2s;
        }

        .selected-question:last-child {
            margin-bottom: 0;
        }

        .selected-question:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .selected-question.dragging {
            opacity: 0.45;
            transform: scale(0.99);
        }

        .drag-handle {
            font-size: 22px;
            color: #6b7280;
            cursor: grab;
            user-select: none;
            text-align: center;
            padding-top: 2px;
        }

        .drag-handle:active {
            cursor: grabbing;
        }

        .sort-number {
            font-size: 14px;
            font-weight: bold;
            color: #374151;
            margin-bottom: 7px;
        }

        .selected-question-text {
            font-size: 15px;
            line-height: 1.45;
        }

        .selected-meta {
            margin-top: 7px;
            color: #6b7280;
            font-size: 13px;
            line-height: 1.5;
        }

        .remove-form {
            margin: 0;
        }

        .order-help {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .save-order-form {
            margin-bottom: 5px;
        }

        .empty {
            padding: 30px 15px;
            text-align: center;
            color: #6b7280;
            border: 1px dashed #d1d5db;
            border-radius: 8px;
        }

        .count {
            display: inline-block;
            margin-left: 6px;
            padding: 3px 8px;
            border-radius: 12px;
            background: #e5e7eb;
            color: #374151;
            font-size: 12px;
            font-weight: bold;
        }

        .pagination {
            margin-top: 20px;
        }

        .pagination nav {
            display: flex;
            justify-content: center;
        }

        .pagination svg {
            width: 20px;
            height: 20px;
        }

        .pagination a,
        .pagination span {
            margin: 0 3px;
        }

        .pagination p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }

        .selection-summary {
            margin-top: 15px;
            padding: 12px;
            background: #f9fafb;
            border-radius: 6px;
            font-size: 13px;
            color: #6b7280;
        }

        @media (max-width: 900px) {
            .selection-tools,
            .main-grid {
                grid-template-columns: 1fr;
            }

            .filters {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 650px) {
            .navbar {
                flex-wrap: wrap;
                padding: 14px 18px;
            }

            .nav-links {
                width: 100%;
                flex-wrap: wrap;
            }

            .container {
                margin-top: 25px;
                padding: 0 12px;
            }

            .filters {
                grid-template-columns: 1fr;
            }

            .form-row {
                flex-direction: column;
                align-items: stretch;
            }

            .selected-question {
                grid-template-columns: 35px 1fr;
            }

            .selected-question > div:last-child {
                grid-column: 2;
            }

            .drag-handle {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>

<header class="navbar">

    <div class="brand">
        Aspirian Student Platform
    </div>

    @auth
        <nav class="nav-links">

            <a
                href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
            >
                Dashboard
            </a>

            <a
                href="{{ route('profile.edit') }}"
                class="{{ request()->routeIs('profile.*') ? 'active' : '' }}"
            >
                Profile
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="logout-button">
                    Logout
                </button>
            </form>

        </nav>
    @endauth

</header>


<main class="container">

    {{-- Page Header --}}
    <div class="page-header">

        <h1>
            Test Question Selection
        </h1>

        <div class="test-meta">
            <strong>Test:</strong>
            {{ $test->title }}
        </div>

        <div class="test-meta">
            <strong>Duration:</strong>
            {{ $test->duration }} minutes
            &nbsp; | &nbsp;
            <strong>Total Marks:</strong>
            {{ $test->marks }}
        </div>

    </div>


    {{-- Success Message --}}
    @if (session('status'))

        <div class="status-message">
            {{ session('status') }}
        </div>

    @endif


    {{-- Validation Errors --}}
    @if ($errors->any())

        <div class="error-message">

            <strong>Please fix the following:</strong>

            <ul>
                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach
            </ul>

        </div>

    @endif


    {{-- Bulk Selection Tools --}}
    <div class="selection-tools">

        {{-- Topic Selection --}}
        <div class="card">

            <h2>
                Add Questions by Topic
            </h2>

            <form
                method="POST"
                action="{{ route('tests.questions.topic', $test) }}"
            >

                @csrf

                <div class="form-row">

                    <div class="form-group">

                        <label for="topic_id">
                            Topic
                        </label>

                        <select
                            id="topic_id"
                            name="topic_id"
                            required
                        >

                            <option value="">
                                Select Topic
                            </option>

                            @foreach ($topics as $topic)

                                <option value="{{ $topic->id }}">

                                    {{ $topic->chapter?->book?->subject?->name ?? 'N/A' }}
                                    →
                                    {{ $topic->chapter?->title ?? 'N/A' }}
                                    →
                                    {{ $topic->title }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <button
                        type="submit"
                        class="primary-button"
                    >
                        Add Topic Questions
                    </button>

                </div>

            </form>

        </div>


        {{-- Difficulty Selection --}}
        <div class="card">

            <h2>
                Add Questions by Difficulty
            </h2>

            <form
                method="POST"
                action="{{ route('tests.questions.difficulty', $test) }}"
            >

                @csrf

                <div class="form-row">

                    <div class="form-group">

                        <label for="difficulty">
                            Difficulty
                        </label>

                        <select
                            id="difficulty"
                            name="difficulty"
                            required
                        >

                            <option value="">
                                Select Difficulty
                            </option>

                            <option value="easy">
                                Easy
                            </option>

                            <option value="medium">
                                Medium
                            </option>

                            <option value="hard">
                                Hard
                            </option>

                        </select>

                    </div>

                    <button
                        type="submit"
                        class="primary-button"
                    >
                        Add Questions
                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- Question Search --}}
    <div class="card search-card">

        <h2>
            Question Bank
        </h2>

        <form
            method="GET"
            action="{{ route('tests.questions.index', $test) }}"
        >

            <div class="filters">

                {{-- Keyword --}}
                <div>

                    <label for="search">
                        Keyword
                    </label>

                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search question..."
                    >

                </div>


                {{-- Question Type --}}
                <div>

                    <label for="question_type">
                        Question Type
                    </label>

                    <select
                        id="question_type"
                        name="question_type"
                    >

                        <option value="">
                            All Types
                        </option>

                        <option
                            value="mcq"
                            @selected(request('question_type') === 'mcq')
                        >
                            MCQ
                        </option>

                        <option
                            value="short"
                            @selected(request('question_type') === 'short')
                        >
                            Short
                        </option>

                        <option
                            value="long"
                            @selected(request('question_type') === 'long')
                        >
                            Long
                        </option>

                    </select>

                </div>


                {{-- Difficulty --}}
                <div>

                    <label for="difficulty_filter">
                        Difficulty
                    </label>

                    <select
                        id="difficulty_filter"
                        name="difficulty"
                    >

                        <option value="">
                            All Difficulties
                        </option>

                        <option
                            value="easy"
                            @selected(request('difficulty') === 'easy')
                        >
                            Easy
                        </option>

                        <option
                            value="medium"
                            @selected(request('difficulty') === 'medium')
                        >
                            Medium
                        </option>

                        <option
                            value="hard"
                            @selected(request('difficulty') === 'hard')
                        >
                            Hard
                        </option>

                    </select>

                </div>


                {{-- Topic --}}
                <div>

                    <label for="topic_filter">
                        Topic
                    </label>

                    <select
                        id="topic_filter"
                        name="topic_id"
                    >

                        <option value="">
                            All Topics
                        </option>

                        @foreach ($topics as $topic)

                            <option
                                value="{{ $topic->id }}"
                                @selected(
                                    (string) request('topic_id') ===
                                    (string) $topic->id
                                )
                            >

                                {{ $topic->title }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>


            <div class="filter-actions">

                <button
                    type="submit"
                    class="primary-button"
                >
                    Search
                </button>

                <a
                    href="{{ route('tests.questions.index', $test) }}"
                    class="button secondary-button"
                >
                    Clear
                </a>

            </div>

        </form>

    </div>


    {{-- Main Two Column Area --}}
    <div class="main-grid">

        {{-- Available Questions --}}
        <div class="card">

            <h2>
                Available Questions

                <span class="count">
                    {{ $questions->total() }}
                </span>
            </h2>


            @forelse ($questions as $question)

                <div class="question">

                    <div class="question-text">
                        {{ $question->question_text }}
                    </div>


                    <div class="badges">

                        <span class="badge">
                            {{ strtoupper($question->question_type) }}
                        </span>

                        <span class="badge difficulty">
                            {{ ucfirst($question->difficulty) }}
                        </span>

                        <span class="badge marks">
                            {{ $question->marks }} mark(s)
                        </span>

                    </div>


                    <div class="meta">

                        <strong>Subject:</strong>

                        {{ $question->topic?->chapter?->book?->subject?->name ?? 'N/A' }}

                    </div>


                    <div class="meta">

                        <strong>Topic:</strong>

                        {{ $question->topic?->title ?? 'N/A' }}

                    </div>


                    <div class="question-actions">

                        @if (in_array($question->id, $selectedQuestionIds))

                            <span class="badge selected">
                                Already Selected
                            </span>

                        @else

                            <form
                                method="POST"
                                action="{{ route(
                                    'tests.questions.store',
                                    $test
                                ) }}"
                            >

                                @csrf

                                <input
                                    type="hidden"
                                    name="question_id"
                                    value="{{ $question->id }}"
                                >

                                <button
                                    type="submit"
                                    class="primary-button"
                                >
                                    + Add to Test
                                </button>

                            </form>

                        @endif

                    </div>

                </div>

            @empty

                <div class="empty">
                    No questions found matching your filters.
                </div>

            @endforelse


            {{-- Pagination --}}
            @if ($questions->hasPages())

                <div class="pagination">
                    {{ $questions->links() }}
                </div>

            @endif

        </div>


        {{-- Selected Questions --}}
        <div class="card">

            <h2>
                Selected Questions

                <span
                    class="count"
                    id="selected-count"
                >
                    {{ $selectedQuestions->count() }}
                </span>
            </h2>


            @if ($selectedQuestions->count() > 0)

                <div class="order-help">

                    ☰ Questions ko drag karke required order mein arrange karein,
                    phir <strong>Save Question Order</strong> par click karein.

                </div>


                <form
                    method="POST"
                    action="{{ route(
                        'tests.questions.order',
                        $test
                    ) }}"
                    class="save-order-form"
                    id="save-order-form"
                >

                    @csrf
                    @method('PATCH')


                    <div
                        class="sortable-list"
                        id="sortable-questions"
                    >

                        @foreach ($selectedQuestions as $index => $question)

                            <div
                                class="selected-question"
                                draggable="true"
                                data-question-id="{{ $question->id }}"
                            >

                                {{-- Drag Handle --}}
                                <div
                                    class="drag-handle"
                                    title="Drag to reorder"
                                >
                                    ☰
                                </div>


                                {{-- Question Information --}}
                                <div>

                                    <div class="sort-number">

                                        Question

                                        <span class="question-number">
                                            {{ $index + 1 }}
                                        </span>

                                    </div>


                                    <div class="selected-question-text">
                                        {{ $question->question_text }}
                                    </div>


                                    <div class="selected-meta">

                                        <strong>Type:</strong>
                                        {{ strtoupper($question->question_type) }}

                                        &nbsp; | &nbsp;

                                        <strong>Difficulty:</strong>
                                        {{ ucfirst($question->difficulty) }}

                                        &nbsp; | &nbsp;

                                        <strong>Marks:</strong>
                                        {{ $question->pivot->marks }}

                                    </div>

                                </div>


                                {{-- Remove Button --}}
                                <div>

                                    <button
                                        type="button"
                                        class="danger-button remove-question-button"
                                        data-question-id="{{ $question->id }}"
                                    >
                                        Remove
                                    </button>

                                </div>

                            </div>

                        @endforeach

                    </div>


                    <button
                        type="submit"
                        class="save-order-button"
                        id="save-order-button"
                    >
                        Save Question Order
                    </button>

                </form>


                {{-- Hidden Remove Forms --}}
                <div id="remove-forms">

                    @foreach ($selectedQuestions as $question)

                        <form
                            method="POST"
                            action="{{ route(
                                'tests.questions.destroy',
                                [
                                    'test' => $test,
                                    'question' => $question
                                ]
                            ) }}"
                            id="remove-form-{{ $question->id }}"
                            style="display: none;"
                        >

                            @csrf
                            @method('DELETE')

                        </form>

                    @endforeach

                </div>


                <div class="selection-summary">

                    <strong>
                        {{ $selectedQuestions->count() }}
                    </strong>

                    question(s) currently selected for this test.

                </div>


            @else

                <div class="empty">
                    No questions have been selected for this test yet.
                </div>

            @endif

        </div>

    </div>

</main>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const list = document.getElementById(
        'sortable-questions'
    );

    const saveForm = document.getElementById(
        'save-order-form'
    );

    const saveButton = document.getElementById(
        'save-order-button'
    );


    /*
    |--------------------------------------------------------------------------
    | Question Numbering
    |--------------------------------------------------------------------------
    */

    function updateQuestionNumbers() {

        if (!list) {
            return;
        }

        const items = list.querySelectorAll(
            '.selected-question'
        );

        items.forEach(function (item, index) {

            const number = item.querySelector(
                '.question-number'
            );

            if (number) {
                number.textContent = index + 1;
            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Drag & Drop
    |--------------------------------------------------------------------------
    */

    let draggedItem = null;


    if (list) {

        list.addEventListener(
            'dragstart',
            function (event) {

                const item =
                    event.target.closest(
                        '.selected-question'
                    );

                if (!item) {
                    return;
                }

                draggedItem = item;

                item.classList.add(
                    'dragging'
                );

                event.dataTransfer.effectAllowed =
                    'move';

                event.dataTransfer.setData(
                    'text/plain',
                    item.dataset.questionId
                );

            }
        );


        list.addEventListener(
            'dragend',
            function () {

                if (draggedItem) {

                    draggedItem.classList.remove(
                        'dragging'
                    );

                }

                draggedItem = null;

                updateQuestionNumbers();

            }
        );


        list.addEventListener(
            'dragover',
            function (event) {

                event.preventDefault();

                if (!draggedItem) {
                    return;
                }

                const target =
                    event.target.closest(
                        '.selected-question'
                    );

                if (
                    !target ||
                    target === draggedItem
                ) {
                    return;
                }

                const rect =
                    target.getBoundingClientRect();

                const middle =
                    rect.top +
                    (rect.height / 2);


                if (event.clientY < middle) {

                    list.insertBefore(
                        draggedItem,
                        target
                    );

                } else {

                    list.insertBefore(
                        draggedItem,
                        target.nextSibling
                    );

                }

                updateQuestionNumbers();

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Save Question Order
    |--------------------------------------------------------------------------
    */

    if (saveForm) {

        saveForm.addEventListener(
            'submit',
            function () {

                const existingInputs =
                    saveForm.querySelectorAll(
                        'input[name="question_ids[]"]'
                    );


                existingInputs.forEach(
                    function (input) {
                        input.remove();
                    }
                );


                const items =
                    list.querySelectorAll(
                        '.selected-question'
                    );


                items.forEach(
                    function (item) {

                        const input =
                            document.createElement(
                                'input'
                            );

                        input.type = 'hidden';

                        input.name =
                            'question_ids[]';

                        input.value =
                            item.dataset.questionId;

                        saveForm.appendChild(
                            input
                        );

                    }
                );


                if (saveButton) {

                    saveButton.disabled = true;

                    saveButton.textContent =
                        'Saving...';

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Remove Selected Question
    |--------------------------------------------------------------------------
    */

    if (list) {

        list.addEventListener(
            'click',
            function (event) {

                const button =
                    event.target.closest(
                        '.remove-question-button'
                    );

                if (!button) {
                    return;
                }


                const questionId =
                    button.dataset.questionId;


                if (!questionId) {
                    return;
                }


                const confirmed =
                    confirm(
                        'Remove this question from the test?'
                    );


                if (!confirmed) {
                    return;
                }


                const form =
                    document.getElementById(
                        'remove-form-' +
                        questionId
                    );


                if (form) {

                    button.disabled = true;

                    button.textContent =
                        'Removing...';

                    form.submit();

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Initial Numbering
    |--------------------------------------------------------------------------
    */

    updateQuestionNumbers();

});
</script>

</body>
</html>