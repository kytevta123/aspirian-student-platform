<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TestAttempt extends Model
{
    use HasFactory;

    public const STATUS_IN_PROGRESS = 'in_progress';

    public const STATUS_SUBMITTED = 'submitted';

    public const STATUS_EXPIRED = 'expired';

    public const STATUSES = [
        self::STATUS_IN_PROGRESS,
        self::STATUS_SUBMITTED,
        self::STATUS_EXPIRED,
    ];

    protected $fillable = [
        'test_id',
        'user_id',
        'started_at',
        'expires_at',
        'submitted_at',
        'status',
    ];

    protected $attributes = [
        'status' => self::STATUS_IN_PROGRESS,
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'expires_at' => 'datetime',
            'submitted_at' => 'datetime',
        ];
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(
            TestAttemptAnswer::class
        );
    }

    public function result(): HasOne
    {
        return $this->hasOne(
            TestResult::class
        );
    }

    public function isInProgress(): bool
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    public function isSubmitted(): bool
    {
        return $this->status === self::STATUS_SUBMITTED;
    }

    public function isExpired(): bool
    {
        if ($this->status === self::STATUS_EXPIRED) {
            return true;
        }

        if (! $this->expires_at) {
            return false;
        }

        return now()->greaterThanOrEqualTo(
            $this->expires_at
        );
    }

    public function remainingSeconds(): int
    {
        if (! $this->expires_at) {
            return 0;
        }

        return max(
            0,
            now()->diffInSeconds(
                $this->expires_at,
                false
            )
        );
    }

    public function markAsExpired(): bool
    {
        if (
            $this->status !==
            self::STATUS_IN_PROGRESS
        ) {
            return false;
        }

        $this->status =
            self::STATUS_EXPIRED;

        return $this->save();
    }

    public function markAsSubmitted(): bool
    {
        if (
            $this->status !==
            self::STATUS_IN_PROGRESS
        ) {
            return false;
        }

        $this->status =
            self::STATUS_SUBMITTED;

        $this->submitted_at = now();

        return $this->save();
    }
}