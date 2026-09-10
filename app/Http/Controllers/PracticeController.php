<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PracticeController extends Controller
{
    /**
     * Display the practice topic selection page.
     */
    public function index(Request $request): View
    {
        $topics = Topic::query()
            ->where('status', 'active')
            ->whereHas('questions', function ($questionQuery) {
                $questionQuery
                    ->where('status', 'published');
            })
            ->withCount([
                'questions' => function ($questionQuery) {
                    $questionQuery
                        ->where('status', 'published');
                },
            ])
            ->with([
                'chapter.book.subject',
            ])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('practice.index', [
            'topics' => $topics,
        ]);
    }
}