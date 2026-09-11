<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WritingTemplate extends Model
{
    use HasFactory;

    public const TYPE_ESSAY = 'essay';

    public const TYPE_PARAGRAPH = 'paragraph';

    public const TYPE_LETTER = 'letter';

    public const TYPE_APPLICATION = 'application';

    public const TYPE_STORY = 'story';

    public const TYPE_DIALOGUE = 'dialogue';

    public const TYPE_SUMMARY = 'summary';

    public const TYPE_REPORT = 'report';

    public const TYPE_NOTICE = 'notice';

    public const TYPE_SPEECH = 'speech';

    public const TYPE_DESCRIPTIVE = 'descriptive';

    public const TYPE_CREATIVE = 'creative';

    public const TYPE_COMPREHENSION = 'comprehension';

    public const TYPE_SHORT_ANSWER = 'short_answer';

    public const TYPE_LONG_ANSWER = 'long_answer';

    public const TYPES = [
        self::TYPE_ESSAY,
        self::TYPE_PARAGRAPH,
        self::TYPE_LETTER,
        self::TYPE_APPLICATION,
        self::TYPE_STORY,
        self::TYPE_DIALOGUE,
        self::TYPE_SUMMARY,
        self::TYPE_REPORT,
        self::TYPE_NOTICE,
        self::TYPE_SPEECH,
        self::TYPE_DESCRIPTIVE,
        self::TYPE_CREATIVE,
        self::TYPE_COMPREHENSION,
        self::TYPE_SHORT_ANSWER,
        self::TYPE_LONG_ANSWER,
    ];

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
        'type',
        'title',
        'prompt',
        'instructions',
        'model_answer',
        'grade_id',
        'subject_id',
        'chapter_id',
        'topic_id',
        'board_id',
        'academic_session_id',
        'language',
        'difficulty',
        'marks',
        'minimum_words',
        'maximum_words',
        'writing_rubric_id',
        'source_id',
        'status',
        'created_by',
        'reviewed_by',
        'published_at',
    ];

    protected $attributes = [
        'status' => self::STATUS_DRAFT,
    ];

    protected function casts(): array
    {
        return [
            'marks' => 'integer',
            'minimum_words' => 'integer',
            'maximum_words' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    public function academicSession(): BelongsTo
    {
        return $this->belongsTo(
            AcademicSession::class
        );
    }

    public function writingRubric(): BelongsTo
    {
        return $this->belongsTo(
            WritingRubric::class
        );
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'reviewed_by'
        );
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(
            WritingAttempt::class
        );
    }

    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    public function isArchived(): bool
    {
        return $this->status === self::STATUS_ARCHIVED;
    }

    public function hasRubric(): bool
    {
        return $this->writing_rubric_id !== null;
    }
}