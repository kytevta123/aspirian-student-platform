<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_classes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('school_id')
                ->constrained('schools')
                ->restrictOnDelete();

            $table->foreignId('grade_id')
                ->constrained('grades')
                ->restrictOnDelete();

            $table->foreignId('academic_session_id')
                ->constrained('academic_sessions')
                ->restrictOnDelete();

            $table->string('name');
            $table->string('status')
                ->default('active')
                ->index();

            $table->timestamps();
            $table->softDeletes();

            $table->unique([
                'school_id',
                'academic_session_id',
                'name',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_classes');
    }
};