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
        Schema::create('flashcards', function (Blueprint $table) {
            $table->id();

            $table->foreignId('topic_id')
                ->constrained('topics')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('front');

            $table->text('back');

            $table->string('difficulty', 20)
                ->default('medium');

            $table->string('status', 20)
                ->default('draft');

            $table->timestamps();

            $table->index([
                'topic_id',
                'status',
            ]);

            $table->index([
                'user_id',
                'status',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flashcards');
    }
};