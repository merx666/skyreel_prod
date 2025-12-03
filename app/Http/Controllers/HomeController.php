<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Portfolio;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        try {
            // Cache statystyk na 10 minut
            $stats = Cache::remember('homepage_stats', 600, function () {
                return [
                    'operators' => User::where('role', 'operator')->count(),
                    'portfolios' => Portfolio::count(),
                    'jobs' => Job::count(),
                    'completed' => Job::where('status', 'completed')->count(),
                ];
            });

            // Wyróżnione portfolio z relacjami (cache na 5 minut)
            $featuredPortfolios = Cache::remember('featured_portfolios', 300, function () {
                return Portfolio::with(['user.profile', 'mediaItems'])
                    ->featured()
                    ->latest()
                    ->take(6)
                    ->get();
            });

            // Jeśli brak wyróżnionych, pokaż najnowsze
            if ($featuredPortfolios->isEmpty()) {
                $featuredPortfolios = Portfolio::with(['user.profile', 'mediaItems'])
                    ->whereHas('user', function($query) {
                        $query->where('role', 'operator');
                    })
                    ->latest()
                    ->take(6)
                    ->get();
            }

            // Wyróżnione zlecenia (cache na 5 minut)
            $featuredJobs = Cache::remember('featured_jobs', 300, function () {
                return Job::with(['client.profile'])
                    ->featured()
                    ->open()
                    ->latest()
                    ->take(6)
                    ->get();
            });

            // Najnowsze zlecenia jeśli brak wyróżnionych
            $recentJobs = Job::with(['client.profile'])
                ->open()
                ->latest()
                ->take(6)
                ->get();

            return view('home', compact('featuredPortfolios', 'featuredJobs', 'recentJobs', 'stats'));
        } catch (\Exception $e) {
            Log::error('HomeController error: ' . $e->getMessage());
            return view('home', [
                'featuredPortfolios' => collect(),
                'featuredJobs' => collect(),
                'recentJobs' => collect(),
                'stats' => ['operators' => 0, 'portfolios' => 0, 'jobs' => 0, 'completed' => 0]
            ]);
        }
    }
}