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
        Schema::create('viva_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('viva_session_id')->constrained('viva_sessions')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->unsignedInteger('sequence')->default(1);
            $table->text('answer_text')->nullable();
            $table->timestamp('answered_at')->nullable();
            $table->unsignedInteger('duration_seconds')->nullable();
            $table->unsignedInteger('score')->nullable();
            $table->text('ai_feedback')->nullable();
            $table->text('teacher_feedback')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('viva_responses');
    }
};