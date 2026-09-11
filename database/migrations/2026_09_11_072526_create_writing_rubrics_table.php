<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('writing_rubrics', function (Blueprint $table) {
            $table->id();

            $table->string('title');

            $table->text('description')
                ->nullable();

            $table->foreignId('grade_id')
                ->nullable()
                ->constrained('grades')
                ->restrictOnDelete();

            $table->foreignId('subject_id')
                ->nullable()
                ->constrained('subjects')
                ->restrictOnDelete();

            $table->string('writing_type', 50);

            $table->string('status', 20)
                ->default('active')
                ->index();

            $table->timestamps();

            $table->index([
                'grade_id',
                'subject_id',
                'writing_type',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('writing_rubrics');
    }
};