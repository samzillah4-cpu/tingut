<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSale extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'images',
        'sale_date_from',
        'sale_date_to',
        'available_items',
        'location',
        'address',
        'city',
        'status',
        'is_featured',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'images' => 'array',
            'sale_date_from' => 'date',
            'sale_date_to' => 'date',
            'is_featured' => 'boolean',
        ];
    }

    /**
     * Get the user that owns the home sale.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items for the home sale.
     */
    public function items()
    {
        return $this->hasMany(HomeSaleItem::class)->ordered();
    }

    /**
     * Get available items for the home sale.
     */
    public function availableItems()
    {
        return $this->hasMany(HomeSaleItem::class)->available()->ordered();
    }

    /**
     * Scope for active home sales.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for upcoming home sales (sale_date_from is in the future or today).
     */
    public function scopeUpcoming($query)
    {
        return $query->where('sale_date_from', '>=', now()->toDateString());
    }

    /**
     * Scope for featured home sales.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope ordered by sale date.
     */
    public function scopeOrderedBySaleDate($query)
    {
        return $query->orderBy('sale_date_from', 'asc');
    }

    /**
     * Check if the home sale is upcoming.
     */
    public function isUpcoming(): bool
    {
        return $this->sale_date_from >= now()->toDateString();
    }

    /**
     * Get formatted date range.
     */
    public function getDateRangeAttribute(): string
    {
        return $this->sale_date_from->format('M d, Y') . ' - ' . $this->sale_date_to->format('M d, Y');
    }
}
