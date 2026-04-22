<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'proposer_id',
        'offered_product_id',
        'receiver_id',
        'requested_product_id',
        'status',
        'payment_reference',
        'payment_status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            //
        ];
    }

    /**
     * Get the proposer user.
     */
    public function proposer()
    {
        return $this->belongsTo(User::class, 'proposer_id');
    }

    /**
     * Get the offered product.
     */
    public function offeredProduct()
    {
        return $this->belongsTo(Product::class, 'offered_product_id');
    }

    /**
     * Get the receiver user.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Get the requested product.
     */
    public function requestedProduct()
    {
        return $this->belongsTo(Product::class, 'requested_product_id');
    }
}
