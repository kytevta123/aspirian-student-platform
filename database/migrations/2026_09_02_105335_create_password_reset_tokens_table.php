<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // The password_reset_tokens table already exists
        // in the database and is managed by the existing schema.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Intentionally left empty because the table
        // existed before this migration was registered.
    }
};