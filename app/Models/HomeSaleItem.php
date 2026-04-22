<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSaleItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'home_sale_id',
        'name',
        'description',
        'price',
        'category',
        'condition',
        'image',
        'is_sold',
        'sort_order',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_sold' => 'boolean',
        ];
    }

    /**
     * Get the home sale that owns the item.
     */
    public function homeSale()
    {
        return $this->belongsTo(HomeSale::class);
    }

    /**
     * Scope for available items.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_sold', false);
    }

    /**
     * Scope ordered by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}
