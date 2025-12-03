<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Scout\Searchable;

class Job extends Model
{
    use HasFactory, Searchable;

    protected $table = 'job_listings';

    protected $fillable = [
        'client_id',
        'title',
        'description',
        'location',
        'budget',
        'status',
        'is_featured',
        'featured_until',
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'is_featured' => 'boolean',
        'featured_until' => 'datetime',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function proposals(): HasMany
    {
        return $this->hasMany(JobProposal::class, 'job_listing_id');
    }

    public function acceptedProposal(): HasOne
    {
        return $this->hasOne(JobProposal::class, 'job_listing_id')->where('status', 'accepted');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'job_listing_id');
    }

    /**
     * Check if the given user already has a proposal for this job.
     */
    public function hasProposalFrom(User $user): bool
    {
        return $this->proposals()->where('operator_id', $user->id)->exists();
    }

    /**
     * Determine if the job has an accepted proposal.
     */
    public function getAcceptedProposal(): ?JobProposal
    {
        return $this->acceptedProposal()->first();
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
                    ->where(function ($q) {
                        $q->whereNull('featured_until')
                          ->orWhere('featured_until', '>', now());
                    });
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'open' => 'text-green-600',
            'in_progress' => 'text-blue-600',
            'completed' => 'text-gray-600',
            'closed' => 'text-red-600',
            default => 'text-gray-600',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'open' => 'Otwarte',
            'in_progress' => 'W trakcie',
            'completed' => 'Zakończone',
            'closed' => 'Zamknięte',
            default => 'Nieznany',
        };
    }

    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }

    public function canReceiveProposals(): bool
    {
        return $this->isOpen();
    }

    public function hasAcceptedProposal(): bool
    {
        return $this->proposals()->where('status', 'accepted')->exists();
    }

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'budget' => $this->budget,
            'status' => $this->status,
            'client_name' => $this->client?->name,
        ];
    }

    /**
     * Determine if the model should be searchable.
     */
    public function shouldBeSearchable(): bool
    {
        return $this->status === 'open';
    }
}