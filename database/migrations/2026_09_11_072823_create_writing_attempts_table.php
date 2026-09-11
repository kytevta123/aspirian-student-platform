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
        Schema::create('writing_attempts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('writing_template_id')
                ->constrained('writing_templates')
                ->cascadeOnDelete();

            $table->foreignId('student_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->unsignedInteger('attempt_number');

            $table->longText('content');

            $table->unsignedInteger('word_count')
                ->default(0);

            $table->unsignedInteger('character_count')
                ->default(0);

            $table->string('status', 20)
                ->default('draft')
                ->index();

            $table->text('self_review')
                ->nullable();

            $table->foreignId('improved_from_attempt_id')
                ->nullable()
                ->constrained('writing_attempts')
                ->nullOnDelete();

            $table->timestamp('started_at')
                ->nullable();

            $table->timestamp('submitted_at')
                ->nullable();

            $table->timestamp('reviewed_at')
                ->nullable();

            $table->timestamps();

            $table->index([
                'writing_template_id',
                'student_id',
                'status',
            ]);

            $table->index([
                'student_id',
                'created_at',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('writing_attempts');
    }
};