<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_class_enrollments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained('students')
                ->restrictOnDelete();

            $table->foreignId('school_class_id')
                ->constrained('school_classes')
                ->restrictOnDelete();

            $table->foreignId('academic_session_id')
                ->constrained('academic_sessions')
                ->restrictOnDelete();

            $table->string('status')
                ->default('active')
                ->index();

            $table->date('enrolled_at')
                ->nullable();

            $table->date('ended_at')
                ->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(
                [
                    'student_id',
                    'academic_session_id',
                ],
                'student_session_unique'
            );

            $table->index(
                [
                    'school_class_id',
                    'academic_session_id',
                ],
                'class_session_index'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_class_enrollments');
    }
};