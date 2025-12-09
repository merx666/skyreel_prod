<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $emails = [
            'michal.kowalski@example.com',
            'anna.nowak@example.com',
            'piotr.wisniewski@example.com',
            'kontakt@firmabc.pl',
            'info@eventstudio.pl',
        ];

        foreach ($emails as $email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                // Cascading Delete should handle profile, portfolios, etc.
                // But relying on DB cascade might not be enough if logic is in code (e.g. file deletion).
                // For now, standard Eloquent delete should trigger model events if any.
                $user->delete();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reverse intentionally - we don't want to restore fake data.
    }
};
