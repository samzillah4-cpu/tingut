<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Get the user that owns the notification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark the notification as read.
     */
    public function markAsRead(): void
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    /**
     * Mark the notification as unread.
     */
    public function markAsUnread(): void
    {
        $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    /**
     * Scope for unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope for read notifications.
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Get notification icon based on type.
     */
    public function getIconAttribute(): string
    {
        return match($this->type) {
            'message_received' => 'fas fa-envelope',
            'exchange_proposed' => 'fas fa-exchange-alt',
            'exchange_accepted' => 'fas fa-check-circle',
            'exchange_rejected' => 'fas fa-times-circle',
            'exchange_completed' => 'fas fa-star',
            'product_liked' => 'fas fa-heart',
            'subscription_expiring' => 'fas fa-clock',
            'subscription_expired' => 'fas fa-exclamation-triangle',
            'admin_message' => 'fas fa-bullhorn',
            default => 'fas fa-bell',
        };
    }

    /**
     * Get notification color based on type.
     */
    public function getColorAttribute(): string
    {
        return match($this->type) {
            'message_received' => 'primary',
            'exchange_proposed' => 'info',
            'exchange_accepted' => 'success',
            'exchange_rejected' => 'danger',
            'exchange_completed' => 'warning',
            'product_liked' => 'danger',
            'subscription_expiring' => 'warning',
            'subscription_expired' => 'danger',
            'admin_message' => 'primary',
            default => 'secondary',
        };
    }
}
