<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use App\Models\FlashcardProgress;
use App\Models\Topic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FlashcardController extends Controller
{
    public function index(Request $request): View
    {
        $query = Flashcard::query()
            ->with([
                'topic.chapter.book.subject',
            ])
            ->where(
                'status',
                Flashcard::STATUS_PUBLISHED
            );

        if ($request->filled('search')) {
            $search = trim(
                $request->string('search')->toString()
            );

            $query->where(function ($flashcardQuery) use ($search) {
                $flashcardQuery
                    ->where('front', 'like', '%' . $search . '%')
                    ->orWhere('back', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('topic_id')) {
            $query->where(
                'topic_id',
                $request->integer('topic_id')
            );
        }

        if ($request->filled('difficulty')) {
            $query->where(
                'difficulty',
                $request->string('difficulty')->toString()
            );
        }

        $flashcards = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('flashcards.index', [
            'flashcards' => $flashcards,
        ]);
    }

    public function create(): View
    {
        $topics = Topic::query()
            ->where('status', 'active')
            ->with([
                'chapter.book.subject',
            ])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('flashcards.create', [
            'topics' => $topics,
        ]);
    }

    public function store(
        Request $request
    ): RedirectResponse {
        $validated = $request->validate([
            'topic_id' => [
                'required',
                'integer',
                'exists:topics,id',
            ],
            'front' => [
                'required',
                'string',
                'max:10000',
            ],
            'back' => [
                'required',
                'string',
                'max:10000',
            ],
            'difficulty' => [
                'required',
                'string',
                'in:' . implode(',', Flashcard::DIFFICULTIES),
            ],
            'status' => [
                'required',
                'string',
                'in:' . implode(',', Flashcard::STATUSES),
            ],
        ]);

        $topic = Topic::query()
            ->where('id', $validated['topic_id'])
            ->where('status', 'active')
            ->firstOrFail();

        Flashcard::create([
            'topic_id' => $topic->id,
            'user_id' => $request->user()->id,
            'front' => trim($validated['front']),
            'back' => trim($validated['back']),
            'difficulty' => $validated['difficulty'],
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('flashcards.index')
            ->with(
                'status',
                'Flashcard created successfully.'
            );
    }

    public function study(
        Request $request,
        Flashcard $flashcard
    ): View {
        abort_unless(
            $flashcard->status === Flashcard::STATUS_PUBLISHED,
            404
        );

        $flashcard->load([
            'topic.chapter.book.subject',
        ]);

        $progress = FlashcardProgress::query()
            ->where('user_id', $request->user()->id)
            ->where('flashcard_id', $flashcard->id)
            ->first();

        $previousFlashcard = Flashcard::query()
            ->where(
                'status',
                Flashcard::STATUS_PUBLISHED
            )
            ->where(
                'id',
                '<',
                $flashcard->id
            )
            ->orderByDesc('id')
            ->first();

        $nextFlashcard = Flashcard::query()
            ->where(
                'status',
                Flashcard::STATUS_PUBLISHED
            )
            ->where(
                'id',
                '>',
                $flashcard->id
            )
            ->orderBy('id')
            ->first();

        $totalFlashcards = Flashcard::query()
            ->where(
                'status',
                Flashcard::STATUS_PUBLISHED
            )
            ->count();

        $currentPosition = Flashcard::query()
            ->where(
                'status',
                Flashcard::STATUS_PUBLISHED
            )
            ->where(
                'id',
                '<=',
                $flashcard->id
            )
            ->count();

        return view('flashcards.study', [
            'flashcard' => $flashcard,
            'progress' => $progress,
            'previousFlashcard' => $previousFlashcard,
            'nextFlashcard' => $nextFlashcard,
            'totalFlashcards' => $totalFlashcards,
            'currentPosition' => $currentPosition,
        ]);
    }
}