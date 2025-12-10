<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'is_group',
        'last_message_at',
    ];

    protected $casts = [
        'is_group' => 'boolean',
        'last_message_at' => 'datetime',
    ];

    /**
     * Get the users that belong to this conversation.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'conversation_user')
                    ->withPivot('last_read_at')
                    ->withTimestamps();
    }

    /**
     * Get all messages for this conversation.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get the latest message for this conversation.
     */
    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }

    /**
     * Get unread messages count for a specific user.
     */
    public function unreadMessagesCount($userId)
    {
        $lastReadAt = $this->users()->where('user_id', $userId)->first()?->pivot?->last_read_at;
        
        if (!$lastReadAt) {
            return $this->messages()->count();
        }

        return $this->messages()->where('created_at', '>', $lastReadAt)->count();
    }

    /**
     * Mark conversation as read for a specific user.
     */
    public function markAsReadForUser($userId)
    {
        $this->users()->updateExistingPivot($userId, [
            'last_read_at' => now(),
        ]);
    }

    /**
     * Get the other participant in a two-person conversation.
     */
    public function getOtherParticipant($currentUserId)
    {
        return $this->users()->where('user_id', '!=', $currentUserId)->first();
    }

    /**
     * Scope to get conversations for a specific user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->whereHas('users', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }
}