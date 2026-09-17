<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Practical extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'title',
        'description',
        'category',
        'instructions',
        'materials',
        'safety_instructions',
        'supervision_required',
        'difficulty',
        'status',
    ];

    protected $casts = [
        'supervision_required' => 'boolean',
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function submissions()
    {
        return $this->hasMany(PracticalSubmission::class);
    }
}