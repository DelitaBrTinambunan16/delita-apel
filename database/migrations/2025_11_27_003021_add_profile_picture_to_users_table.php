<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     * NOTE: profile_picture column already exists in create_users_table migration.
     * This migration is a no-op (kept for reference).
     */
    public function up(): void
    {
        // Profile picture column already exists in 0001_01_01_000000_create_users_table.php
        // No action needed.
    }

    public function down(): void
    {
        // No action needed.
    }
};
