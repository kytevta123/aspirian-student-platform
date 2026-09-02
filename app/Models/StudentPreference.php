<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentPreference extends Model
{
    protected $table = 'student_preferences';

    protected $fillable = [
        'student_id',
        'language',
        'daily_study_minutes',
        'notification_preferences',
    ];

    protected $casts = [
        'daily_study_minutes' => 'integer',
        'notification_preferences' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the student for this preference.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
