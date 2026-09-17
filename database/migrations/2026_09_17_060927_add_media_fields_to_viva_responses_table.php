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
        Schema::table('viva_responses', function (Blueprint $table) {
            $table->string('answer_type')->default('text')->after('answer_text'); // text, audio, video
            $table->string('media_path')->nullable()->after('answer_type');
            $table->string('mime_type')->nullable()->after('media_path');
            $table->unsignedBigInteger('file_size')->nullable()->after('mime_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('viva_responses', function (Blueprint $table) {
            $table->dropColumn(['answer_type', 'media_path', 'mime_type', 'file_size']);
        });
    }
};