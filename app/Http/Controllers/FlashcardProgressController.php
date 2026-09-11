<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use App\Models\FlashcardProgress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FlashcardProgressController extends Controller
{
    /**
     * Mark a flashcard as known or needing revision.
     */
    public function store(
        Request $request,
        Flashcard $flashcard
    ): RedirectResponse {
        abort_unless(
            $flashcard->status === Flashcard::STATUS_PUBLISHED,
            404
        );

        $validated = $request->validate([
            'status' => [
                'required',
                'string',
                'in:' . implode(
                    ',',
                    FlashcardProgress::STATUSES
                ),
            ],
        ]);

        FlashcardProgress::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'flashcard_id' => $flashcard->id,
            ],
            [
                'status' => $validated['status'],
                'studied_at' => now(),
            ]
        );

        return redirect()
            ->route(
                'flashcards.study',
                $flashcard
            )
            ->with(
                'status',
                'Flashcard progress saved successfully.'
            );
    }
}