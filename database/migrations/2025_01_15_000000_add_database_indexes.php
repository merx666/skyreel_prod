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
        // Indeksy dla tabeli job_listings - pomijamy, już istnieją
        // Schema::table('job_listings', function (Blueprint $table) {
        //     $table->index(['status', 'created_at']); // już istnieje
        //     $table->index(['is_featured', 'featured_until']); // już istnieje
        //     $table->index(['location']); // już istnieje
        //     $table->index(['budget']); // już istnieje
        // });

        // Indeksy dla tabeli portfolios - pomijamy user_id+created_at i slug, już istnieją
        // Schema::table('portfolios', function (Blueprint $table) {
        //     $table->index(['user_id', 'created_at']); // już istnieje
        //     $table->index(['slug']); // już istnieje
        // });

        // Indeksy dla tabeli profiles - pomijamy is_featured+featured_until i location, już istnieją
        // Schema::table('profiles', function (Blueprint $table) {
        //     $table->index(['is_featured', 'featured_until']); // już istnieje
        //     $table->index(['location']); // już istnieje
        // });

        // Indeksy dla tabeli media_items - pomijamy portfolio_id+type, już istnieje
        // Schema::table('media_items', function (Blueprint $table) {
        //     $table->index(['portfolio_id', 'type']); // już istnieje
        // });

        // Indeksy dla tabeli job_proposals
        // Indeksy dla tabeli job_proposals - pomijamy, już istnieją
        // Schema::table('job_proposals', function (Blueprint $table) {
        //     $table->index(['job_listing_id', 'status']); // już istnieje
        //     $table->index(['operator_id', 'created_at']); // już istnieje
        // });

        // Indeksy dla tabeli reviews - pomijamy, już istnieją
        // Schema::table('reviews', function (Blueprint $table) {
        //     $table->index(['reviewee_id', 'rating']); // już istnieje
        //     $table->index(['job_listing_id']); // już istnieje
        // });

        // Indeksy dla tabeli payments - pomijamy, już istnieją
        // Schema::table('payments', function (Blueprint $table) {
        //     $table->index(['user_id', 'created_at']); // już istnieje
        //     // $table->index(['payable_type', 'payable_id']); // już istnieje
        // });

        // Indeksy dla tabeli equipment - pomijamy, tabela nie istnieje jeszcze
        // Schema::table('equipment', function (Blueprint $table) {
        //     $table->index(['user_id', 'type']);
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Usuwanie indeksów dla tabeli job_listings - pomijamy, nie dodawaliśmy
        // Schema::table('job_listings', function (Blueprint $table) {
        //     $table->dropIndex(['status', 'created_at']);
        //     $table->dropIndex(['is_featured', 'featured_until']);
        //     $table->dropIndex(['location']);
        //     $table->dropIndex(['budget']);
        // });

        // Usuwanie indeksów dla tabeli portfolios - pomijamy, nie dodawaliśmy
        // Schema::table('portfolios', function (Blueprint $table) {
        //     $table->dropIndex(['user_id', 'created_at']);
        //     $table->dropIndex(['slug']);
        // });

        // Usuwanie indeksów dla tabeli profiles - pomijamy, nie dodawaliśmy
        // Schema::table('profiles', function (Blueprint $table) {
        //     $table->dropIndex(['is_featured', 'featured_until']);
        //     $table->dropIndex(['location']);
        // });

        // Usuwanie indeksów dla tabeli media_items - pomijamy, nie dodawaliśmy
        // Schema::table('media_items', function (Blueprint $table) {
        //     $table->dropIndex(['portfolio_id', 'type']);
        // });

        // Usuwanie indeksów dla tabeli job_proposals - pomijamy, nie dodawaliśmy
        // Schema::table('job_proposals', function (Blueprint $table) {
        //     $table->dropIndex(['job_listing_id', 'status']); // nie dodawaliśmy
        //     $table->dropIndex(['operator_id', 'created_at']); // nie dodawaliśmy
        // });

        // Usuwanie indeksów dla tabeli reviews - pomijamy, nie dodawaliśmy
        // Schema::table('reviews', function (Blueprint $table) {
        //     $table->dropIndex(['reviewee_id', 'rating']); // nie dodawaliśmy
        //     $table->dropIndex(['job_listing_id']); // nie dodawaliśmy
        // });

        // Usuwanie indeksów dla tabeli payments - pomijamy, nie dodawaliśmy
        // Schema::table('payments', function (Blueprint $table) {
        //     $table->dropIndex(['user_id', 'created_at']); // nie dodawaliśmy
        //     // $table->dropIndex(['payable_type', 'payable_id']); // nie dodawaliśmy
        // });

        // Usuwanie indeksów dla tabeli equipment - pomijamy, nie dodawaliśmy
        // Schema::table('equipment', function (Blueprint $table) {
        //     $table->dropIndex(['user_id', 'type']);
        // });
    }
};