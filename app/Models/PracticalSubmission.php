<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PracticalSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'practical_id',
        'student_id',
        'attempt_number',
        'status',
        'safety_acknowledged_at',
        'report_text',
        'media_path',
        'mime_type',
        'file_size',
        'score',
        'teacher_feedback',
        'started_at',
        'submitted_at',
        'reviewed_at',
    ];

    protected $casts = [
        'safety_acknowledged_at' => 'datetime',
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    protected $appends = ['media_url'];

    public function getMediaUrlAttribute()
    {
        return $this->media_path ? Storage::disk('public')->url($this->media_path) : null;
    }

    public function practical()
    {
        return $this->belongsTo(Practical::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}