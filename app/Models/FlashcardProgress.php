<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FlashcardProgress extends Model
{
    use HasFactory;

    public const STATUS_KNOWN = 'known';
    public const STATUS_NEED_REVISION = 'need_revision';

    public const STATUSES = [
        self::STATUS_KNOWN,
        self::STATUS_NEED_REVISION,
    ];

    protected $fillable = [
        'user_id',
        'flashcard_id',
        'status',
        'studied_at',
    ];

    protected $attributes = [
        'status' => self::STATUS_NEED_REVISION,
    ];

    protected function casts(): array
    {
        return [
            'studied_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function flashcard(): BelongsTo
    {
        return $this->belongsTo(Flashcard::class);
    }
}