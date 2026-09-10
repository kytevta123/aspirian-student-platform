<?php

namespace App\Http\Controllers;

use App\Services\RevisionQueueService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RevisionQueueController extends Controller
{
    public function index(
        Request $request,
        RevisionQueueService $revisionQueueService
    ): View {
        $queue = $revisionQueueService->buildForUser(
            $request->user()->id
        );

        return view('revision.index', [
            'queue' => $queue,
        ]);
    }
}