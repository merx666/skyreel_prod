<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\MediaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;

class PortfolioController extends BaseController
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $portfolios = Portfolio::with(['user.profile', 'mediaItems'])
            ->whereHas('user', function($query) {
                $query->where('role', 'operator');
            })
            ->withCount('mediaItems')
            ->latest()
            ->paginate(12);
        
        return view('portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        return view('portfolios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        $portfolio = auth()->user()->portfolios()->create([
            'title' => $request->title,
            'description' => $request->description,
            'slug' => Str::slug($request->title),
        ]);

        return redirect()->route('portfolios.show', $portfolio)
            ->with('success', 'Portfolio zostało utworzone pomyślnie!');
    }

    public function show(Portfolio $portfolio)
    {
        $portfolio->load(['mediaItems', 'user.profile']);
        
        return view('portfolios.show', compact('portfolio'));
    }

    public function edit(Portfolio $portfolio)
    {
        $this->authorize('update', $portfolio);
        
        $portfolio->load('mediaItems');
        
        return view('portfolios.edit', compact('portfolio'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $this->authorize('update', $portfolio);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        $portfolio->update([
            'title' => $request->title,
            'description' => $request->description,
            'slug' => Str::slug($request->title),
        ]);

        return redirect()->route('portfolios.show', $portfolio)
            ->with('success', 'Portfolio zostało zaktualizowane pomyślnie!');
    }

    public function destroy(Portfolio $portfolio)
    {
        $this->authorize('delete', $portfolio);
        
        $portfolio->delete();

        return redirect('/portfolios')
            ->with('success', 'Portfolio zostało usunięte pomyślnie!');
    }

    public function addMedia(Request $request, Portfolio $portfolio)
    {
        $this->authorize('update', $portfolio);

        $request->validate([
            'type' => 'required|in:video,image',
            'source_url' => 'required|url',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $mediaData = [
            'type' => $request->type,
            'source_url' => $request->source_url,
            'title' => $request->title,
            'description' => $request->description,
        ];

        // Jeśli to wideo YouTube, pobierz metadane
        if ($request->type === 'video' && $this->isYouTubeUrl($request->source_url)) {
            $youtubeData = $this->getYouTubeMetadata($request->source_url);
            
            if ($youtubeData) {
                $mediaData['title'] = $mediaData['title'] ?: $youtubeData['title'];
                $mediaData['description'] = $mediaData['description'] ?: $youtubeData['description'];
                $mediaData['thumbnail_url'] = $youtubeData['thumbnail_url'];
                $mediaData['source_url'] = $youtubeData['embed_url'];
            }
        }

        $portfolio->mediaItems()->create($mediaData);

        return redirect()->route('portfolios.edit', $portfolio)
            ->with('success', 'Media zostało dodane pomyślnie!');
    }

    public function removeMedia(Portfolio $portfolio, MediaItem $mediaItem)
    {
        $this->authorize('update', $portfolio);
        
        if ($mediaItem->portfolio_id !== $portfolio->id) {
            abort(403);
        }

        $mediaItem->delete();

        return redirect()->route('portfolios.edit', $portfolio)
            ->with('success', 'Media zostało usunięte pomyślnie!');
    }

    private function isYouTubeUrl($url)
    {
        return preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url);
    }

    private function getYouTubeMetadata($url)
    {
        try {
            // Wyciągnij ID wideo z URL
            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches);
            
            if (!isset($matches[1])) {
                return null;
            }

            $videoId = $matches[1];

            // Użyj oEmbed API YouTube
            $response = Http::get('https://www.youtube.com/oembed', [
                'url' => "https://www.youtube.com/watch?v={$videoId}",
                'format' => 'json'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'title' => $data['title'] ?? '',
                    'description' => $data['author_name'] ?? '',
                    'thumbnail_url' => $data['thumbnail_url'] ?? "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg",
                    'embed_url' => "https://www.youtube.com/embed/{$videoId}",
                ];
            }

            // Fallback - podstawowe dane
            return [
                'title' => '',
                'description' => '',
                'thumbnail_url' => "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg",
                'embed_url' => "https://www.youtube.com/embed/{$videoId}",
            ];

        } catch (\Exception $e) {
            return null;
        }
    }
}