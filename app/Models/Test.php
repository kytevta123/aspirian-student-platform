<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}