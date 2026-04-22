<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GiveawayRequest extends Model
{
    protected $fillable = [
        'product_id',
        'requester_id',
        'personal_details',
        'location',
        'reason',
        'status',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'approved_at' => 'datetime',
        ];
    }

    /**
     * Get the product that owns the giveaway request.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user who requested the giveaway.
     */
    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    /**
     * Check if a user has already requested this product.
     */
    public static function hasUserRequested(int $productId, int $userId): bool
    {
        return static::where('product_id', $productId)
            ->where('requester_id', $userId)
            ->exists();
    }

    /**
     * Get the request if a user has already requested this product.
     */
    public static function getUserRequest(int $productId, int $userId): ?GiveawayRequest
    {
        return static::where('product_id', $productId)
            ->where('requester_id', $userId)
            ->first();
    }

    /**
     * Get all pending requests for a product.
     */
    public static function getPendingRequestsForProduct(int $productId)
    {
        return static::where('product_id', $productId)
            ->where('status', 'pending')
            ->with('requester')
            ->get();
    }

    /**
     * Get the approved request for a product.
     */
    public static function getApprovedRequestForProduct(int $productId): ?GiveawayRequest
    {
        return static::where('product_id', $productId)
            ->where('status', 'approved')
            ->first();
    }
}
