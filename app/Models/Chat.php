<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    protected $fillable = [
        'visitor_id',
        'user_id',
        'name',
        'email',
        'phone',
        'chat_type',
        'related_user_id',
        'subject',
        'status',
        'last_message_at',
        'typing_user_id',
        'typing_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    /**
     * Get the user who initiated the chat (if registered user).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the related user (customer or admin in the chat).
     */
    public function relatedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'related_user_id');
    }

    /**
     * Get all messages for the chat.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }

    /**
     * Get unread messages count.
     */
    public function getUnreadMessagesCountAttribute(): int
    {
        return $this->messages()->whereNull('read_at')->count();
    }

    /**
     * Scope for active chats.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for chats by type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('chat_type', $type);
    }

    /**
     * Scope for seller chats.
     */
    public function scopeForSeller($query, int $sellerId)
    {
        return $query->where(function ($q) use ($sellerId) {
            $q->where('user_id', $sellerId)
                ->orWhere('related_user_id', $sellerId);
        })->whereIn('chat_type', ['seller_customer', 'seller_admin']);
    }
}
