<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WritingRubricItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'writing_rubric_id',
        'criterion',
        'description',
        'maximum_marks',
        'sort_order',
    ];

    protected $attributes = [
        'sort_order' => 0,
    ];

    public function writingRubric(): BelongsTo
    {
        return $this->belongsTo(
            WritingRubric::class
        );
    }
}