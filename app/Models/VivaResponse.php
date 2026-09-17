<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class VivaResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'viva_session_id',
        'question_id',
        'sequence',
        'answer_type',
        'answer_text',
        'media_path',
        'mime_type',
        'file_size',
        'answered_at',
        'duration_seconds',
        'score',
        'ai_feedback',
        'teacher_feedback',
    ];

    protected $casts = [
        'answered_at' => 'datetime',
    ];

    protected $appends = ['media_url'];

    public function getMediaUrlAttribute()
    {
        return $this->media_path ? Storage::disk('public')->url($this->media_path) : null;
    }

    public function session()
    {
        return $this->belongsTo(VivaSession::class, 'viva_session_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}