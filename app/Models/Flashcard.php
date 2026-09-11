<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Flashcard extends Model
{
    use HasFactory;

    public const DIFFICULTY_EASY = 'easy';
    public const DIFFICULTY_MEDIUM = 'medium';
    public const DIFFICULTY_HARD = 'hard';

    public const DIFFICULTIES = [
        self::DIFFICULTY_EASY,
        self::DIFFICULTY_MEDIUM,
        self::DIFFICULTY_HARD,
    ];

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_ARCHIVED = 'archived';

    public const STATUSES = [
        self::STATUS_DRAFT,
        self::STATUS_PUBLISHED,
        self::STATUS_ARCHIVED,
    ];

    protected $fillable = [
        'topic_id',
        'user_id',
        'front',
        'back',
        'difficulty',
        'status',
    ];

    protected $attributes = [
        'difficulty' => self::DIFFICULTY_MEDIUM,
        'status' => self::STATUS_DRAFT,
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function progresses(): HasMany
    {
        return $this->hasMany(FlashcardProgress::class);
    }
}