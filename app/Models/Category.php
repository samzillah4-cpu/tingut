<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'image',
        'is_vehicle',
        'vehicle_fields',
        'is_real_estate',
        'real_estate_fields',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_vehicle' => 'boolean',
            'vehicle_fields' => 'array',
            'is_real_estate' => 'boolean',
            'real_estate_fields' => 'array',
        ];
    }

    /**
     * Get the products for the category.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Check if this category requires subscription for sellers.
     */
    public function requiresSubscription()
    {
        return in_array($this->name, ['Home Sales', 'Vehicles', 'Real Estate']) ||
               $this->is_vehicle ||
               $this->is_real_estate;
    }

    /**
     * Get subscription plans for this category.
     */
    public function subscriptionPlans()
    {
        return $this->hasMany(SubscriptionPlan::class);
    }
}
