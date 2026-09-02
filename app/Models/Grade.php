<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use SoftDeletes;

    protected $table = 'grades';

    protected $fillable = [
        'name',
        'code',
        'level',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'level' => 'integer',
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the grade subjects for this grade.
     */
    public function gradeSubjects()
    {
        return $this->hasMany(GradeSubject::class);
    }
}
