<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Board extends Model
{
    use SoftDeletes;

    protected $table = 'boards';

    protected $fillable = [
        'education_system_id',
        'name',
        'code',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the education system for this board.
     */
    public function educationSystem()
    {
        return $this->belongsTo(EducationSystem::class);
    }

    /**
     * Get the grade subjects for this board.
     */
    public function gradeSubjects()
    {
        return $this->hasMany(GradeSubject::class);
    }
}
