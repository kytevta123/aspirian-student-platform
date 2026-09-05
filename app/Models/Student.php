<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function currentGrade(): BelongsTo
    {
        return $this->belongsTo(
            Grade::class,
            'current_grade_id'
        );
    }

    public function currentBoard(): BelongsTo
    {
        return $this->belongsTo(
            Board::class,
            'current_board_id'
        );
    }

    public function currentAcademicSession(): BelongsTo
    {
        return $this->belongsTo(
            AcademicSession::class,
            'current_academic_session_id'
        );
    }

    public function studentSubjects(): HasMany
    {
        return $this->hasMany(StudentSubject::class);
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(
            Subject::class,
            'student_subjects'
        )->withTimestamps();
    }

    public function classEnrollments(): HasMany
    {
        return $this->hasMany(
            StudentClassEnrollment::class
        );
    }
}