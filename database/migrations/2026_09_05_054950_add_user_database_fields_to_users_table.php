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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');

            $table->string('status')
                ->default('active')
                ->after('password');

            $table->timestamp('last_login_at')
                ->nullable()
                ->after('email_verified_at');

            $table->softDeletes();
            
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropSoftDeletes();
            $table->dropColumn([
                'phone',
                'status',
                'last_login_at',
            ]);
        });
    }
};