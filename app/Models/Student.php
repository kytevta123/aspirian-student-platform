<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = [
        'user_id',
        'date_of_birth',
        'gender',
        'avatar',
        'current_grade_id',
        'current_board_id',
        'current_academic_session_id',
        'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user for this student.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the current grade for this student.
     */
    public function currentGrade()
    {
        return $this->belongsTo(Grade::class, 'current_grade_id');
    }

    /**
     * Get the current board for this student.
     */
    public function currentBoard()
    {
        return $this->belongsTo(Board::class, 'current_board_id');
    }

    /**
     * Get the current academic session for this student.
     */
    public function currentAcademicSession()
    {
        return $this->belongsTo(AcademicSession::class, 'current_academic_session_id');
    }

    /**
     * Get the subjects for this student.
     */
    public function subjects()
    {
        return $this->hasMany(StudentSubject::class);
    }

    /**
     * Get the preferences for this student.
     */
    public function preferences()
    {
        return $this->hasOne(StudentPreference::class);
    }
}
