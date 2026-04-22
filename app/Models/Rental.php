<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'renter_id',
        'product_id',
        'start_date',
        'end_date',
        'total_price',
        'deposit_amount',
        'status',
        'notes',
        'approved_at',
        'started_at',
        'completed_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'total_price' => 'decimal:2',
            'deposit_amount' => 'decimal:2',
            'approved_at' => 'datetime',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * Get the renter that owns the rental.
     */
    public function renter()
    {
        return $this->belongsTo(User::class, 'renter_id');
    }

    /**
     * Get the product that is being rented.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the owner of the product being rented.
     */
    public function owner()
    {
        return $this->product->user();
    }

    /**
     * Check if the rental is active.
     */
    public function isActive()
    {
        return in_array($this->status, ['approved', 'active']);
    }

    /**
     * Check if the rental is completed.
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if the rental is pending.
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }
}
