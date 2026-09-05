<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'phone')) {
                $table->string('phone')
                    ->nullable()
                    ->after('email');
            }

            if (! Schema::hasColumn('users', 'status')) {
                $table->string('status')
                    ->default('active')
                    ->after('password');
            }

            if (! Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')
                    ->nullable()
                    ->after('email_verified_at');
            }

            if (! Schema::hasColumn('users', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        if (
            Schema::hasColumn('users', 'status') &&
            ! Schema::hasIndex('users', ['status'])
        ) {
            Schema::table('users', function (Blueprint $table) {
                $table->index('status');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasIndex('users', ['status'])) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropIndex(['status']);
            });
        }

        Schema::table('users', function (Blueprint $table) {
            $columns = [];

            foreach ([
                'phone',
                'status',
                'last_login_at',
                'deleted_at',
            ] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $columns[] = $column;
                }
            }

            if (! empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};