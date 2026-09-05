<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->id();

            $table->foreignId('chapter_id')
                ->constrained('chapters')
                ->restrictOnDelete();

            $table->string('title');
            $table->text('description')->nullable();

            $table->unsignedInteger('sort_order')
                ->default(0);

            $table->string('status')
                ->default('active')
                ->index();

            $table->timestamps();
            $table->softDeletes();

            $table->index([
                'chapter_id',
                'sort_order',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};