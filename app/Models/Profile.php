<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profile_picture_url',
        'location',
        'latitude',
        'longitude',
        'bio',
        'website_url',
        'tiktok_latest_url',
        'is_featured',
        'featured_until',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'featured_until' => 'datetime',
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get portfolios belonging to the profile's user.
     */
    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class, 'user_id', 'user_id');
    }

    /**
     * Get equipment belonging to the profile's user.
     */
    public function equipment(): HasMany
    {
        return $this->hasMany(Equipment::class, 'user_id', 'user_id');
    }

    /**
     * Check if the profile is currently featured.
     */
    public function isFeatured(): bool
    {
        return $this->is_featured && 
               ($this->featured_until === null || $this->featured_until->isFuture());
    }
}