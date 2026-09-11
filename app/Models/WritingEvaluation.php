<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WritingEvaluation extends Model
{
    use HasFactory;

    public const EVALUATOR_TEACHER = 'teacher';

    public const EVALUATOR_AI = 'ai';

    public const EVALUATOR_SYSTEM = 'system';

    public const EVALUATOR_TYPES = [
        self::EVALUATOR_TEACHER,
        self::EVALUATOR_AI,
        self::EVALUATOR_SYSTEM,
    ];

    public const STATUS_PENDING = 'pending';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_REVISED = 'revised';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_COMPLETED,
        self::STATUS_REVISED,
    ];

    protected $fillable = [
        'writing_attempt_id',
        'evaluator_type',
        'evaluator_id',
        'content_score',
        'grammar_score',
        'vocabulary_score',
        'organization_score',
        'spelling_score',
        'relevance_score',
        'overall_score',
        'feedback',
        'strengths',
        'improvements',
        'status',
        'evaluated_at',
    ];

    protected $attributes = [
        'status' => self::STATUS_PENDING,
    ];

    protected function casts(): array
    {
        return [
            'content_score' => 'integer',
            'grammar_score' => 'integer',
            'vocabulary_score' => 'integer',
            'organization_score' => 'integer',
            'spelling_score' => 'integer',
            'relevance_score' => 'integer',
            'overall_score' => 'integer',
            'evaluated_at' => 'datetime',
        ];
    }

    public function writingAttempt(): BelongsTo
    {
        return $this->belongsTo(
            WritingAttempt::class
        );
    }

    public function evaluator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'evaluator_id'
        );
    }

    public function isTeacherEvaluation(): bool
    {
        return $this->evaluator_type === self::EVALUATOR_TEACHER;
    }

    public function isAiEvaluation(): bool
    {
        return $this->evaluator_type === self::EVALUATOR_AI;
    }

    public function isSystemEvaluation(): bool
    {
        return $this->evaluator_type === self::EVALUATOR_SYSTEM;
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isRevised(): bool
    {
        return $this->status === self::STATUS_REVISED;
    }
}