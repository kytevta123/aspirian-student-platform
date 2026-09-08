<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    public const TYPE_MCQ = 'mcq';

    public const TYPE_SHORT = 'short';

    public const TYPE_LONG = 'long';

    public const TYPES = [
        self::TYPE_MCQ,
        self::TYPE_SHORT,
        self::TYPE_LONG,
    ];

        protected $fillable = [
        'topic_id',
        'question_type',
        'question_text',
        'normalized_text',
        'options',
        'answer',
        'explanation',
        'marks',
        'difficulty',
        'status',
    ];

    protected $attributes = [
        'marks' => 1,
        'difficulty' => 'medium',
        'status' => 'draft',
    ];

    protected $casts = [
        'options' => 'array',
        'marks' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(QuestionRevision::class);
    }
}