<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Drop wrong FK to jobs (queue table) if exists
            try {
                $table->dropForeign(['job_id']);
            } catch (\Throwable $e) {
                // ignore if not present
            }

            // Add correct FK to job_listings
            $table->foreign('job_id')
                  ->references('id')
                  ->on('job_listings')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            try {
                $table->dropForeign(['job_id']);
            } catch (\Throwable $e) {
                // ignore
            }

            // Restore FK to jobs table (Laravel queue jobs)
            $table->foreign('job_id')
                  ->references('id')
                  ->on('jobs')
                  ->onDelete('cascade');
        });
    }
};