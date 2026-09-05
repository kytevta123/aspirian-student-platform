<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            $table->foreignId('board_id')
                ->constrained('boards')
                ->restrictOnDelete();

            $table->foreignId('grade_id')
                ->constrained('grades')
                ->restrictOnDelete();

            $table->foreignId('subject_id')
                ->constrained('subjects')
                ->restrictOnDelete();

            $table->foreignId('academic_session_id')
                ->constrained('academic_sessions')
                ->restrictOnDelete();

            $table->string('title');
            $table->string('publisher')->nullable();
            $table->string('edition')->nullable();

            $table->string('status')
                ->default('active')
                ->index();

            $table->timestamps();
            $table->softDeletes();

            $table->index([
                'board_id',
                'grade_id',
                'subject_id',
                'academic_session_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};