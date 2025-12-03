<?php

namespace App\Http\Controllers;

use App\Models\MediaItem;
use App\Models\Portfolio;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class TikTokViewController extends Controller
{
    /**
     * Wyświetla widok portfolio w stylu TikTok z przewijaniem pionowym
     */
    public function index(Request $request)
    {
        // Pobierz wyróżnione profile i ich portfolio
        $featuredProfiles = Profile::where('is_featured', true)
            ->where('featured_until', '>', now())
            ->with(['user', 'user.portfolios.mediaItems'])
            ->get();
            
        // Pobierz wszystkie media z wyróżnionych portfolio
        $mediaItems = MediaItem::whereHas('portfolio', function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->whereHas('profile', function ($p) {
                        $p->where('is_featured', true)
                            ->where('featured_until', '>', now());
                    });
                });
            })
            ->with(['portfolio', 'portfolio.user', 'portfolio.user.profile'])
            ->inRandomOrder()
            ->take(20)
            ->get();
            
        return view('portfolios.tiktok', compact('mediaItems'));
    }
}