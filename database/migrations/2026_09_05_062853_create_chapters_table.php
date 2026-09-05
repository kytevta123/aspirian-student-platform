<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();

            $table->foreignId('book_id')
                ->constrained('books')
                ->restrictOnDelete();

            $table->unsignedInteger('chapter_number');
            $table->string('title');
            $table->text('description')->nullable();

            $table->unsignedInteger('sort_order')
                ->default(0);

            $table->string('status')
                ->default('active')
                ->index();

            $table->timestamps();
            $table->softDeletes();

            $table->unique([
                'book_id',
                'chapter_number',
            ]);

            $table->index([
                'book_id',
                'sort_order',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chapters');
    }
};