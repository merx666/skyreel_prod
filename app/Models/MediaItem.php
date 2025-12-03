<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'portfolio_id',
        'type',
        'source_url',
        'thumbnail_url',
        'title',
        'description',
    ];

    protected $casts = [
        'type' => 'string',
    ];

    /**
     * Get the portfolio that owns the media item.
     */
    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }

    /**
     * Check if the media item is a video.
     */
    public function isVideo(): bool
    {
        return $this->type === 'video';
    }

    /**
     * Check if the media item is an image.
     */
    public function isImage(): bool
    {
        return $this->type === 'image';
    }

    /**
     * Get YouTube video ID from URL.
     */
    public function getYouTubeVideoId(): ?string
    {
        if (!$this->isVideo()) {
            return null;
        }

        $src = $this->source_url ?? '';
        if (!is_string($src) || $src === '') {
            return null;
        }

        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $src, $matches);

        return isset($matches[1]) && is_string($matches[1]) ? $matches[1] : null;
    }

    /**
     * Get YouTube thumbnail URL.
     */
    public function getYouTubeThumbnail(): ?string
    {
        $videoId = $this->getYouTubeVideoId();
        
        return $videoId ? "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg" : null;
    }
}