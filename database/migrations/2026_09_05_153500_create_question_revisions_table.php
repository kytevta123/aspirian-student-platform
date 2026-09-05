<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('question_revisions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('question_id')
                ->constrained('questions')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->json('question_data');

            $table->timestamps();

            $table->index(
                ['question_id', 'created_at'],
                'question_revisions_question_created_index'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_revisions');
    }
};