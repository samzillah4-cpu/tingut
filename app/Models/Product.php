<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'short_description',
        'long_description',
        'images',
        'location',
        'status',
        'listing_type',
        'exchange_categories',
        'is_available_for_rent',
        'rent_price',
        'rent_duration_unit',
        'rent_duration_value',
        'rent_deposit',
        'rent_terms',
        'is_for_sale',
        'sale_price',
        'is_giveaway',
        'vehicle_make',
        'vehicle_model',
        'vehicle_year',
        'vehicle_mileage',
        'vehicle_fuel_type',
        'vehicle_transmission',
        'vehicle_color',
        'vehicle_engine_size',
        'vehicle_power',
        'vehicle_doors',
        'vehicle_weight',
        'vehicle_registration_number',
        'vehicle_vin',
        'vehicle_features',
        // House fields
        'house_property_type',
        'house_rooms',
        'house_bedrooms',
        'house_bathrooms',
        'house_living_area',
        'house_plot_size',
        'house_year_built',
        'house_energy_rating',
        'house_ownership_type',
        'house_floor',
        'house_elevator',
        'house_balcony',
        'house_parking',
        'house_heating_type',
        'house_new_construction',
        'house_shared_bathroom',
        'house_facilities',
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
            'exchange_categories' => 'array',
            'is_available_for_rent' => 'boolean',
            'rent_price' => 'decimal:2',
            'rent_deposit' => 'decimal:2',
            'is_for_sale' => 'boolean',
            'sale_price' => 'decimal:2',
            'is_giveaway' => 'boolean',
            'vehicle_engine_size' => 'decimal:1',
            'vehicle_features' => 'array',
            'house_living_area' => 'decimal:2',
            'house_plot_size' => 'decimal:2',
            'house_elevator' => 'boolean',
            'house_balcony' => 'boolean',
            'house_new_construction' => 'boolean',
            'house_shared_bathroom' => 'boolean',
            'house_facilities' => 'array',
        ];
    }

    /**
     * Get the user that owns the product.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the exchanges where this product is offered.
     */
    public function offeredExchanges()
    {
        return $this->hasMany(Exchange::class, 'offered_product_id');
    }

    /**
     * Get the exchanges where this product is requested.
     */
    public function requestedExchanges()
    {
        return $this->hasMany(Exchange::class, 'requested_product_id');
    }

    /**
     * Get all exchanges related to this product (both offered and requested).
     */
    public function exchanges()
    {
        return Exchange::where(function($query) {
            $query->where('offered_product_id', $this->id)
                  ->orWhere('requested_product_id', $this->id);
        });
    }

    /**
     * Get the rentals for this product.
     */
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    /**
     * Get active rentals for this product.
     */
    public function activeRentals()
    {
        return $this->rentals()->whereIn('status', ['approved', 'active']);
    }

    /**
     * Get the giveaway requests for this product.
     */
    public function giveawayRequests()
    {
        return $this->hasMany(GiveawayRequest::class);
    }
}
