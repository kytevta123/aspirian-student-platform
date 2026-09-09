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
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relationships
            |--------------------------------------------------------------------------
            */

            $table->foreignId('test_attempt_id')
                ->constrained('test_attempts')
                ->cascadeOnDelete();

            $table->foreignId('test_id')
                ->constrained('tests')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Result Statistics
            |--------------------------------------------------------------------------
            */

            $table->unsignedInteger('total_marks');

            $table->unsignedInteger('obtained_marks');

            $table->decimal('percentage', 5, 2);

            $table->unsignedInteger('correct_answers')
                ->default(0);

            $table->unsignedInteger('wrong_answers')
                ->default(0);

            $table->unsignedInteger('unanswered')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Result Status
            |--------------------------------------------------------------------------
            |
            | passed  = student achieved passing percentage
            | failed  = student did not achieve passing percentage
            |
            */

            $table->string('status', 20);

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Constraints & Indexes
            |--------------------------------------------------------------------------
            */

            $table->unique('test_attempt_id');

            $table->index([
                'test_id',
                'user_id',
            ]);

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_results');
    }
};