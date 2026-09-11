<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flashcard_progress', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('flashcard_id')
                ->constrained('flashcards')
                ->cascadeOnDelete();

            $table->string('status', 30)
                ->default('need_revision');

            $table->timestamp('studied_at')->nullable();

            $table->timestamps();

            $table->unique([
                'user_id',
                'flashcard_id',
            ]);

            $table->index([
                'user_id',
                'status',
            ]);

            $table->index([
                'flashcard_id',
                'status',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flashcard_progress');
    }
};