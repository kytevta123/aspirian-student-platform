<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestResult extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Result Statuses
    |--------------------------------------------------------------------------
    */

    public const STATUS_PASSED = 'passed';

    public const STATUS_FAILED = 'failed';

    public const STATUSES = [
        self::STATUS_PASSED,
        self::STATUS_FAILED,
    ];

    /*
    |--------------------------------------------------------------------------
    | Mass Assignment
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'test_attempt_id',
        'test_id',
        'user_id',
        'total_marks',
        'obtained_marks',
        'percentage',
        'correct_answers',
        'wrong_answers',
        'unanswered',
        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'total_marks' => 'integer',
            'obtained_marks' => 'integer',
            'percentage' => 'decimal:2',
            'correct_answers' => 'integer',
            'wrong_answers' => 'integer',
            'unanswered' => 'integer',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function testAttempt(): BelongsTo
    {
        return $this->belongsTo(
            TestAttempt::class
        );
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(
            Test::class
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Result Helpers
    |--------------------------------------------------------------------------
    */

    public function isPassed(): bool
    {
        return $this->status === self::STATUS_PASSED;
    }

    public function isFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }
}