<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WritingAttempt extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_SUBMITTED = 'submitted';

    public const STATUS_REVIEWED = 'reviewed';

    public const STATUSES = [
        self::STATUS_DRAFT,
        self::STATUS_SUBMITTED,
        self::STATUS_REVIEWED,
    ];

    protected $fillable = [
        'writing_template_id',
        'student_id',
        'attempt_number',
        'content',
        'word_count',
        'character_count',
        'status',
        'self_review',
        'improved_from_attempt_id',
        'started_at',
        'submitted_at',
        'reviewed_at',
    ];

    protected $attributes = [
        'status' => self::STATUS_DRAFT,
        'word_count' => 0,
        'character_count' => 0,
    ];

    protected function casts(): array
    {
        return [
            'attempt_number' => 'integer',
            'word_count' => 'integer',
            'character_count' => 'integer',
            'started_at' => 'datetime',
            'submitted_at' => 'datetime',
            'reviewed_at' => 'datetime',
        ];
    }

    public function writingTemplate(): BelongsTo
    {
        return $this->belongsTo(
            WritingTemplate::class
        );
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'student_id'
        );
    }

    public function improvedFromAttempt(): BelongsTo
    {
        return $this->belongsTo(
            self::class,
            'improved_from_attempt_id'
        );
    }

    public function improvedAttempts(): HasMany
    {
        return $this->hasMany(
            self::class,
            'improved_from_attempt_id'
        );
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(
            WritingEvaluation::class
        );
    }

    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function isSubmitted(): bool
    {
        return $this->status === self::STATUS_SUBMITTED;
    }

    public function isReviewed(): bool
    {
        return $this->status === self::STATUS_REVIEWED;
    }

    public function hasImprovedFromAttempt(): bool
    {
        return $this->improved_from_attempt_id !== null;
    }
}