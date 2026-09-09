<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_attempt_answers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('test_attempt_id')
                ->constrained('test_attempts')
                ->cascadeOnDelete();

            $table->foreignId('question_id')
                ->constrained('questions')
                ->cascadeOnDelete();

            $table->text('answer')
                ->nullable();

            $table->timestamp('answered_at')
                ->nullable();

            $table->timestamps();

            $table->unique([
                'test_attempt_id',
                'question_id',
            ]);

            $table->index([
                'test_attempt_id',
                'answered_at',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_attempt_answers');
    }
};