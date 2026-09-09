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
        Schema::table('test_attempts', function (Blueprint $table) {
            $table->timestamp('submitted_at')
                ->nullable()
                ->after('expires_at');

            $table->index([
                'test_id',
                'user_id',
                'status',
                'submitted_at',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_attempts', function (Blueprint $table) {
            $table->dropIndex([
                'test_id',
                'user_id',
                'status',
                'submitted_at',
            ]);

            $table->dropColumn('submitted_at');
        });
    }
};