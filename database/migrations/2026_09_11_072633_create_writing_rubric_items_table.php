<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('writing_rubric_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('writing_rubric_id')
                ->constrained('writing_rubrics')
                ->cascadeOnDelete();

            $table->string('criterion', 100);

            $table->text('description')
                ->nullable();

            $table->unsignedInteger('maximum_marks');

            $table->unsignedInteger('sort_order')
                ->default(0);

            $table->timestamps();

            $table->unique([
                'writing_rubric_id',
                'sort_order',
            ]);

            $table->index([
                'writing_rubric_id',
                'sort_order',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('writing_rubric_items');
    }
};