<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->text('normalized_text')
                ->nullable()
                ->after('question_text');

            $table->index(
                'normalized_text',
                'questions_normalized_text_index'
            );
        });
    }

    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropIndex(
                'questions_normalized_text_index'
            );

            $table->dropColumn('normalized_text');
        });
    }
};