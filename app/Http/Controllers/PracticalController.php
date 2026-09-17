<?php

namespace App\Http\Controllers;

use App\Models\Practical;
use App\Models\PracticalSubmission;
use Illuminate\Http\Request;

class PracticalController extends Controller
{
    /**
     * List available practical activities.
     */
    public function index(Request $request)
    {
        $practicals = Practical::where('status', 'published')
            ->when($request->topic_id, fn($q) => $q->where('topic_id', $request->topic_id))
            ->latest()
            ->paginate(10);

        return response()->json($practicals);
    }

    /**
     * Show a single practical activity's details.
     */
    public function show(Practical $practical)
    {
        return response()->json($practical);
    }

    /**
     * Start (or resume) the authenticated student's attempt at a practical.
     */
    public function start(Practical $practical)
    {
        $submission = PracticalSubmission::firstOrCreate(
            [
                'practical_id' => $practical->id,
                'student_id' => auth()->id(),
                'status' => 'in_progress',
            ],
            [
                'attempt_number' => PracticalSubmission::where('practical_id', $practical->id)
                    ->where('student_id', auth()->id())
                    ->count() + 1,
                'started_at' => now(),
            ]
        );

        return response()->json($submission, 201);
    }

    /**
     * Acknowledge safety instructions for a submission.
     */
    public function acknowledgeSafety(PracticalSubmission $submission)
    {
        $submission->update(['safety_acknowledged_at' => now()]);

        return response()->json($submission);
    }

    /**
     * Submit the practical report (text + optional file/image/video/code).
     */
    public function submit(Request $request, PracticalSubmission $submission)
    {
        $validated = $request->validate([
            'report_text' => 'nullable|string',
            'media' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,mp4,mov,webm,zip,txt,php,py,js,java,c,cpp|max:20480',
        ]);

        $mediaPath = $submission->media_path;
        $mimeType = $submission->mime_type;
        $fileSize = $submission->file_size;

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $mediaPath = $file->store('practical-submissions', 'public');
            $mimeType = $file->getMimeType();
            $fileSize = $file->getSize();
        }

        $submission->update([
            'report_text' => $validated['report_text'] ?? $submission->report_text,
            'media_path' => $mediaPath,
            'mime_type' => $mimeType,
            'file_size' => $fileSize,
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        return response()->json($submission);
    }

    /**
     * Show a student's submission (with practical details).
     */
    public function showSubmission(PracticalSubmission $submission)
    {
        return response()->json($submission->load('practical'));
    }

    /**
     * List the authenticated student's past submissions.
     */
    public function history()
    {
        $submissions = PracticalSubmission::where('student_id', auth()->id())
            ->with('practical')
            ->latest()
            ->paginate(10);

        return response()->json($submissions);
    }
}