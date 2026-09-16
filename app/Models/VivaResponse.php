<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VivaResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'viva_session_id',
        'question_id',
        'sequence',
        'answer_text',
        'answered_at',
        'duration_seconds',
        'score',
        'ai_feedback',
        'teacher_feedback',
    ];

    protected $casts = [
        'answered_at' => 'datetime',
    ];

    public function session()
    {
        return $this->belongsTo(VivaSession::class, 'viva_session_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}