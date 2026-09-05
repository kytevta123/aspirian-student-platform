<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('topic_id')
                ->constrained('topics')
                ->restrictOnDelete();

            $table->string('question_type');

            $table->text('question_text');

            $table->json('options')->nullable();

            $table->text('answer')->nullable();

            $table->text('explanation')->nullable();

            $table->unsignedInteger('marks')
                ->default(1);

            $table->string('difficulty')
                ->default('medium')
                ->index();

            $table->string('status')
                ->default('draft')
                ->index();

            $table->timestamps();
            $table->softDeletes();

            $table->index(
                ['topic_id', 'question_type'],
                'questions_topic_type_index'
            );

            $table->index(
                ['question_type', 'difficulty'],
                'questions_type_difficulty_index'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};