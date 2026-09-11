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
        Schema::create('writing_evaluations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('writing_attempt_id')
                ->constrained('writing_attempts')
                ->cascadeOnDelete();

            $table->string('evaluator_type', 20);

            $table->foreignId('evaluator_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->unsignedInteger('content_score')
                ->nullable();

            $table->unsignedInteger('grammar_score')
                ->nullable();

            $table->unsignedInteger('vocabulary_score')
                ->nullable();

            $table->unsignedInteger('organization_score')
                ->nullable();

            $table->unsignedInteger('spelling_score')
                ->nullable();

            $table->unsignedInteger('relevance_score')
                ->nullable();

            $table->unsignedInteger('overall_score')
                ->nullable();

            $table->text('feedback')
                ->nullable();

            $table->text('strengths')
                ->nullable();

            $table->text('improvements')
                ->nullable();

            $table->string('status', 20)
                ->default('pending')
                ->index();

            $table->timestamp('evaluated_at')
                ->nullable();

            $table->timestamps();

            $table->index(
                [
                    'writing_attempt_id',
                    'evaluator_type',
                    'status',
                ],
                'we_attempt_evaluator_status_idx'
            );

            $table->index('evaluator_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('writing_evaluations');
    }
};