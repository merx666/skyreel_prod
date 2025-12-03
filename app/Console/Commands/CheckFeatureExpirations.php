<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Profile;
use App\Notifications\FeatureExpiringNotification;
use Carbon\Carbon;

class CheckFeatureExpirations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-feature-expirations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sprawdza wygasające wyróżnienia profili i wysyła powiadomienia';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Sprawdzanie wygasających wyróżnień profili...');
        
        // Znajdź profile, których wyróżnienie wygasa za 3 dni
        $threeDaysFromNow = Carbon::now()->addDays(3);
        $expiringProfiles = Profile::where('is_featured', true)
            ->whereDate('featured_until', $threeDaysFromNow->toDateString())
            ->get();
            
        $this->info("Znaleziono {$expiringProfiles->count()} profili wygasających za 3 dni.");
        
        foreach ($expiringProfiles as $profile) {
            $user = $profile->user;
            $user->notify(new FeatureExpiringNotification($profile, 3));
            $this->info("Wysłano powiadomienie do użytkownika: {$user->name} (ID: {$user->id})");
        }
        
        // Znajdź profile, których wyróżnienie wygasa za 1 dzień
        $oneDayFromNow = Carbon::now()->addDay();
        $expiringProfiles = Profile::where('is_featured', true)
            ->whereDate('featured_until', $oneDayFromNow->toDateString())
            ->get();
            
        $this->info("Znaleziono {$expiringProfiles->count()} profili wygasających za 1 dzień.");
        
        foreach ($expiringProfiles as $profile) {
            $user = $profile->user;
            $user->notify(new FeatureExpiringNotification($profile, 1));
            $this->info("Wysłano powiadomienie do użytkownika: {$user->name} (ID: {$user->id})");
        }
        
        $this->info('Zakończono sprawdzanie wygasających wyróżnień.');
    }
}