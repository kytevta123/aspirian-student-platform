<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('writing_templates', function (Blueprint $table) {
            $table->id();

            $table->string('type', 50);

            $table->string('title');

            $table->text('prompt');

            $table->text('instructions')
                ->nullable();

            $table->text('model_answer')
                ->nullable();

            $table->foreignId('grade_id')
                ->constrained('grades')
                ->restrictOnDelete();

            $table->foreignId('subject_id')
                ->constrained('subjects')
                ->restrictOnDelete();

            $table->foreignId('chapter_id')
                ->nullable()
                ->constrained('chapters')
                ->restrictOnDelete();

            $table->foreignId('topic_id')
                ->nullable()
                ->constrained('topics')
                ->restrictOnDelete();

            $table->foreignId('board_id')
                ->constrained('boards')
                ->restrictOnDelete();

            $table->foreignId('academic_session_id')
                ->constrained('academic_sessions')
                ->restrictOnDelete();

            $table->string('language', 30);

            $table->string('difficulty', 20);

            $table->unsignedInteger('marks')
                ->nullable();

            $table->unsignedInteger('minimum_words')
                ->nullable();

            $table->unsignedInteger('maximum_words')
                ->nullable();

            $table->foreignId('writing_rubric_id')
                ->nullable()
                ->constrained('writing_rubrics')
                ->nullOnDelete();

            $table->unsignedBigInteger('source_id')
                ->nullable();

            $table->string('status', 20)
                ->default('draft')
                ->index();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('published_at')
                ->nullable();

            $table->timestamps();

            $table->index([
                'grade_id',
                'subject_id',
                'status',
            ]);

            $table->index([
                'board_id',
                'academic_session_id',
            ]);

            $table->index([
                'chapter_id',
                'topic_id',
            ]);

            $table->index('source_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('writing_templates');
    }
};