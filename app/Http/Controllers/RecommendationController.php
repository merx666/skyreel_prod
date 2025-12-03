<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecommendationController extends Controller
{
    /**
     * Wyświetla rekomendowanych operatorów na podstawie lokalizacji klienta
     */
    public function index(Request $request)
    {
        // Pobierz lokalizację z zapytania lub z profilu użytkownika
        $location = $request->input('location');
        
        if (!$location && auth()->check() && auth()->user() && auth()->user()->profile) {
            $location = auth()->user()->profile->location;
        }
        
        // Pobierz operatorów z podobną lokalizacją
        $operators = User::where('role', 'operator')
            ->whereHas('profile', function($query) use ($location) {
                if ($location) {
                    // Wyszukaj operatorów z tą samą lub podobną lokalizacją
                    $query->where('location', 'like', '%' . $location . '%');
                }
                
                // Wyróżnieni operatorzy mają pierwszeństwo
                $query->orderByRaw('is_featured DESC');
            })
            ->with(['profile', 'portfolios' => function($query) {
                $query->with(['mediaItems' => function($query) {
                    $query->limit(3);
                }]);
                $query->limit(1);
            }])
            ->withCount('reviews')
            ->withAvg('reviewsAsReviewee', 'rating')
            ->paginate(12);
            
        return view('recommendations.index', [
            'operators' => $operators,
            'location' => $location
        ]);
    }
}