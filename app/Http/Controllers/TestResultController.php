<?php

namespace App\Http\Controllers;

use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestResultController extends Controller
{
    public function index(Request $request): View
    {
        $query = TestResult::query()
            ->where('user_id', $request->user()->id)
            ->with('test')
            ->latest();

        $search = trim((string) $request->input('search', ''));

        if ($search !== '') {
            $query->whereHas('test', function ($testQuery) use ($search) {
                $testQuery->where('title', 'like', '%' . $search . '%');
            });
        }

        $status = $request->input('status');

        if (
            is_string($status) &&
            in_array(
                $status,
                TestResult::STATUSES,
                true
            )
        ) {
            $query->where('status', $status);
        }

        $results = $query
            ->paginate(10)
            ->withQueryString();

        return view(
            'tests.results.index',
            [
                'results' => $results,
                'search' => $search,
                'status' => $status,
            ]
        );
    }

    public function show(
        Request $request,
        TestResult $result
    ): View {
        if ($result->user_id !== $request->user()->id) {
            abort(403);
        }

        $result->load([
            'test',
            'testAttempt',
        ]);

        return view(
            'tests.results.show',
            [
                'result' => $result,
            ]
        );
    }
}