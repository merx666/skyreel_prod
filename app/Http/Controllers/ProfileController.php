<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        // Make public: index, show by Profile model, and showUserProfile by User model
        $this->middleware('auth')->except(['index', 'show', 'showUserProfile']);
    }

   /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Profile::with(['user', 'portfolios', 'equipment'])
            ->withCount(['portfolios', 'equipment'])
            // Compute average rating for the profile's user via subquery to avoid nested withAvg limitations
            ->select('profiles.*')
            ->selectSub(
                Review::selectRaw('AVG(rating)')
                    ->whereColumn('reviewee_id', 'profiles.user_id'),
                'avg_rating'
            );

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhere('location', 'like', "%{$search}%")
                ->orWhere('bio', 'like', "%{$search}%");
            });
        }

        // Location filter
        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        // Featured filter
        if ($request->boolean('featured')) {
            $query->where('is_featured', true)
                  ->where('featured_until', '>', now());
        }

        // Sorting
        switch ($request->get('sort', 'newest')) {
            case 'oldest':
                $query->oldest();
                break;
            case 'name':
                // Join users for sorting by name; ensure we keep profiles.* selection for proper model hydration
                $query->join('users', 'profiles.user_id', '=', 'users.id')
                      ->orderBy('users.name');
                break;
            case 'featured':
                $query->orderByDesc('is_featured')
                      ->orderByDesc('featured_until')
                      ->latest();
                break;
            default: // newest
                $query->latest();
                break;
        }

        $profiles = $query->paginate(12);

        // Get unique locations for filter dropdown
        $locations = Profile::whereNotNull('location')
            ->distinct()
            ->pluck('location')
            ->sort()
            ->values();

        return view('profile.index', compact('profiles', 'locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->profile) {
            return redirect()->route('profile.edit', Auth::user()->profile);
        }

        return view('profiles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'location' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'website_url' => 'nullable|url|max:255',
            'tiktok_latest_url' => 'nullable|url|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $profilePictureUrl = null;
        if ($request->hasFile('profile_picture')) {
            $profilePictureUrl = $request->file('profile_picture')->store('profile-pictures', 'public');
        }

        $profile = Profile::create([
            'user_id' => Auth::id(),
            'location' => $request->location,
            'bio' => $request->bio,
            'website_url' => $request->website_url,
            'tiktok_latest_url' => $request->tiktok_latest_url,
            'profile_picture_url' => $profilePictureUrl,
        ]);

        return redirect()->route('profile.show', $profile->user)
            ->with('success', 'Profil został utworzony pomyślnie!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        // Redirect to canonical singular user profile route to avoid duplicate content
        return redirect()->route('profile.show', $profile->user);
    }

    /**
     * Display user profile by user ID.
     */
    public function showUserProfile(User $user)
    {
        $user->load(['profile', 'portfolios.mediaItems', 'equipment', 'reviews']);

        // Use singular view directory 'profile' to match resources/views/profile/*.blade.php
        return view('profile.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        $this->authorize('update', $profile);

        // Use singular view directory 'profile' to match resources/views/profile/*.blade.php
        return view('profile.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        $this->authorize('update', $profile);

        $request->validate([
            'location' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'website_url' => 'nullable|url|max:255',
            'tiktok_latest_url' => 'nullable|url|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'location' => $request->location,
            'bio' => $request->bio,
            'website_url' => $request->website_url,
            'tiktok_latest_url' => $request->tiktok_latest_url,
        ];

        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture
            if ($profile->profile_picture_url) {
                Storage::disk('public')->delete($profile->profile_picture_url);
            }
            
            $data['profile_picture_url'] = $request->file('profile_picture')->store('profile-pictures', 'public');
        }

        $profile->update($data);

        return redirect()->route('profile.show', $profile->user)
            ->with('success', 'Profil został zaktualizowany pomyślnie!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        $this->authorize('delete', $profile);

        // Delete profile picture
        if ($profile->profile_picture_url) {
            Storage::disk('public')->delete($profile->profile_picture_url);
        }

        $profile->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Profil został usunięty pomyślnie!');
    }
}
