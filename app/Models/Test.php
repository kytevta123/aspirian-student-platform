<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Test extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_PUBLISHED = 'published';

    public const STATUS_ARCHIVED = 'archived';

    public const STATUSES = [
        self::STATUS_DRAFT,
        self::STATUS_PUBLISHED,
        self::STATUS_ARCHIVED,
    ];

    protected $fillable = [
        'title',
        'instructions',
        'duration',
        'marks',
        'status',
        'published_at',
    ];

    protected $attributes = [
        'duration' => 60,
        'marks' => 0,
        'status' => self::STATUS_DRAFT,
    ];

    protected function casts(): array
    {
        return [
            'duration' => 'integer',
            'marks' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'test_questions')
            ->withPivot(['sort_order', 'marks'])
            ->withTimestamps()
            ->orderBy('test_questions.sort_order');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(TestAttempt::class);
    }

    public function addQuestionsFromTopic(Topic $topic): int
    {
        $questions = Question::query()
            ->where('topic_id', $topic->id)
            ->orderBy('id')
            ->get();

        if ($questions->isEmpty()) {
            return 0;
        }

        $nextSortOrder = (int) (
            $this->questions()
                ->max('test_questions.sort_order') ?? 0
        );

        $attachedCount = 0;

        foreach ($questions as $question) {
            if (
                $this->questions()
                    ->where('questions.id', $question->id)
                    ->exists()
            ) {
                continue;
            }

            $nextSortOrder++;

            $this->questions()->attach($question->id, [
                'sort_order' => $nextSortOrder,
                'marks' => $question->marks,
            ]);

            $attachedCount++;
        }

        return $attachedCount;
    }

    public function addQuestionsByDifficulty(string $difficulty): int
    {
        $questions = Question::query()
            ->where('difficulty', $difficulty)
            ->orderBy('id')
            ->get();

        if ($questions->isEmpty()) {
            return 0;
        }

        $nextSortOrder = (int) (
            $this->questions()
                ->max('test_questions.sort_order') ?? 0
        );

        $attachedCount = 0;

        foreach ($questions as $question) {
            if (
                $this->questions()
                    ->where('questions.id', $question->id)
                    ->exists()
            ) {
                continue;
            }

            $nextSortOrder++;

            $this->questions()->attach($question->id, [
                'sort_order' => $nextSortOrder,
                'marks' => $question->marks,
            ]);

            $attachedCount++;
        }

        return $attachedCount;
    }
}