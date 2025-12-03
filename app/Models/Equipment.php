<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Equipment extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'brand',
        'model',
        'description',
        'image_url',
    ];

    protected $casts = [
        'type' => 'string',
    ];

    /**
     * Get the user that owns the equipment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the equipment type display name.
     */
    public function getTypeDisplayAttribute(): string
    {
        return match($this->type) {
            'drone' => __('Dron'),
            'camera' => __('Kamera'),
            'lens' => __('Obiektyw'),
            'accessory' => __('Akcesoria'),
            default => $this->type,
        };
    }
}
