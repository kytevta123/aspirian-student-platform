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
        Schema::create('practicals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->nullable()->constrained('topics')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category')->default('experiment'); // experiment, exercise, project, workshop, simulation, field_work
            $table->text('instructions')->nullable();
            $table->text('materials')->nullable();
            $table->text('safety_instructions')->nullable();
            $table->boolean('supervision_required')->default(false);
            $table->string('difficulty')->default('beginner'); // beginner, intermediate, advanced
            $table->string('status')->default('published'); // draft, published, active, archived
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practicals');
    }
};