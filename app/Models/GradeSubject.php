<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeSubject extends Model
{
    protected $table = 'grade_subjects';

    protected $fillable = [
        'grade_id',
        'subject_id',
        'board_id',
        'academic_session_id',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the grade for this grade subject.
     */
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    /**
     * Get the subject for this grade subject.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the board for this grade subject.
     */
    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    /**
     * Get the academic session for this grade subject.
     */
    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class);
    }
}
