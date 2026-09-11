<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WritingRubric extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'grade_id',
        'subject_id',
        'writing_type',
        'status',
    ];

    protected $attributes = [
        'status' => 'active',
    ];

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(
            WritingRubricItem::class
        )->orderBy('sort_order');
    }

    public function writingTemplates(): HasMany
    {
        return $this->hasMany(
            WritingTemplate::class
        );
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}