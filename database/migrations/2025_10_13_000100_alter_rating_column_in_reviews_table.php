<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Change reviews.rating to unsigned tinyint (1-255). Validation will enforce 1-5.
     */
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            // MySQL 8: change to tinyint unsigned
            DB::statement('ALTER TABLE reviews MODIFY rating TINYINT UNSIGNED NOT NULL');
        } else {
            // SQLite / others: skip type change as SQLite lacks MODIFY support.
            // Validation at application level enforces 1-5 range.
        }
    }

    /**
     * Revert reviews.rating to unsigned integer.
     */
    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE reviews MODIFY rating INT UNSIGNED NOT NULL');
        } else {
            // No-op for SQLite / others
        }
    }
};