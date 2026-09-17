<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\VivaSession;
use App\Models\VivaResponse;
use Illuminate\Http\Request;

class VivaController extends Controller
{
    /**
     * List subjects/topics available for viva practice (placeholder — adjust as needed).
     */
    public function index()
    {
        return response()->json([
            'message' => 'Viva module ready. Use POST /viva/start to begin a session.',
        ]);
    }

    /**
     * Start a new viva session for the authenticated student.
     */
    public function start(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'nullable|exists:subjects,id',
            'topic_id' => 'nullable|exists:topics,id',
        ]);

        $session = VivaSession::create([
            'student_id' => auth()->id(),
            'subject_id' => $validated['subject_id'] ?? null,
            'topic_id' => $validated['topic_id'] ?? null,
            'session_type' => 'practice',
            'status' => 'in_progress',
            'started_at' => now(),
        ]);

        return response()->json($session, 201);
    }

    /**
     * Get the current/next question for the viva session.
     */
    public function show(VivaSession $vivaSession)
    {
        $question = Question::query()
            ->when($vivaSession->topic_id, fn($q) => $q->where('topic_id', $vivaSession->topic_id))
            ->when($vivaSession->subject_id, fn($q) => $q->where('subject_id', $vivaSession->subject_id))
            ->inRandomOrder()
            ->first();

        return response()->json([
            'session' => $vivaSession,
            'question' => $question,
            'answered_count' => $vivaSession->responses()->count(),
        ]);
    }

        /**
     * Submit an answer for the current question (text, audio, or video).
     */
    public function submitAnswer(Request $request, VivaSession $vivaSession)
    {
        $validated = $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer_type' => 'required|in:text,audio,video',
            'answer_text' => 'nullable|string',
            'media' => 'nullable|file|mimes:mp3,wav,webm,ogg,mp4,mov,m4a,aac|max:20480', // 20MB max
            'duration_seconds' => 'nullable|integer',
        ]);

        $mediaPath = null;
        $mimeType = null;
        $fileSize = null;

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $mediaPath = $file->store('viva-responses', 'public');
            $mimeType = $file->getMimeType();
            $fileSize = $file->getSize();
        }

        $response = VivaResponse::create([
            'viva_session_id' => $vivaSession->id,
            'question_id' => $validated['question_id'],
            'sequence' => $vivaSession->responses()->count() + 1,
            'answer_type' => $validated['answer_type'],
            'answer_text' => $validated['answer_text'] ?? null,
            'media_path' => $mediaPath,
            'mime_type' => $mimeType,
            'file_size' => $fileSize,
            'answered_at' => now(),
            'duration_seconds' => $validated['duration_seconds'] ?? null,
        ]);

        return response()->json($response, 201);
    }

    /**
     * Complete the viva session.
     */
    public function complete(VivaSession $vivaSession)
    {
        $vivaSession->update([
            'status' => 'completed',
            'ended_at' => now(),
        ]);

        return response()->json($vivaSession);
    }

    /**
     * Get the final result/feedback for a completed session.
     */
    public function result(VivaSession $vivaSession)
    {
        return response()->json(
            $vivaSession->load('responses.question')
        );
    }

    /**
     * List past viva sessions for the authenticated student.
     */
    public function history()
    {
        $sessions = VivaSession::where('student_id', auth()->id())
            ->latest()
            ->paginate(10);

        return response()->json($sessions);
    }
}