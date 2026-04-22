<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class SubscriptionPlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories
        $vehiclesCategory = Category::where('name', 'Vehicles')->orWhere('is_vehicle', true)->first();
        $realEstateCategory = Category::where('name', 'Real Estate')->orWhere('is_real_estate', true)->first();
        $homeSalesCategory = Category::where('name', 'Home Sales')->first(); // Assuming it exists

        // General plans
        \App\Models\SubscriptionPlan::create([
            'name' => 'Basic Plan',
            'description' => 'Perfect for new sellers starting their trading journey.',
            'price' => 9.99,
            'duration' => 'monthly',
            'max_products' => 10,
            'is_active' => true,
        ]);

        \App\Models\SubscriptionPlan::create([
            'name' => 'Pro Plan',
            'description' => 'Ideal for active traders with more products to offer.',
            'price' => 19.99,
            'duration' => 'monthly',
            'max_products' => 50,
            'is_active' => true,
        ]);

        \App\Models\SubscriptionPlan::create([
            'name' => 'Premium Plan',
            'description' => 'Unlimited products for professional sellers.',
            'price' => 39.99,
            'duration' => 'monthly',
            'max_products' => 0, // Unlimited
            'is_active' => true,
        ]);

        // Category-specific plans
        if ($vehiclesCategory) {
            \App\Models\SubscriptionPlan::create([
                'name' => 'Vehicle Seller Basic',
                'description' => 'Basic plan for vehicle sellers.',
                'price' => 49.99,
                'duration' => 'monthly',
                'max_products' => 5,
                'is_active' => true,
                'category_id' => $vehiclesCategory->id,
            ]);

            \App\Models\SubscriptionPlan::create([
                'name' => 'Vehicle Seller Pro',
                'description' => 'Pro plan for active vehicle dealers.',
                'price' => 99.99,
                'duration' => 'monthly',
                'max_products' => 20,
                'is_active' => true,
                'category_id' => $vehiclesCategory->id,
            ]);
        }

        if ($realEstateCategory) {
            \App\Models\SubscriptionPlan::create([
                'name' => 'Real Estate Basic',
                'description' => 'Basic plan for real estate listings.',
                'price' => 149.99,
                'duration' => 'monthly',
                'max_products' => 10,
                'is_active' => true,
                'category_id' => $realEstateCategory->id,
            ]);

            \App\Models\SubscriptionPlan::create([
                'name' => 'Real Estate Pro',
                'description' => 'Pro plan for real estate agents.',
                'price' => 299.99,
                'duration' => 'monthly',
                'max_products' => 50,
                'is_active' => true,
                'category_id' => $realEstateCategory->id,
            ]);
        }

        if ($homeSalesCategory) {
            \App\Models\SubscriptionPlan::create([
                'name' => 'Home Sales Plan',
                'description' => 'Plan for home and garden product sales.',
                'price' => 79.99,
                'duration' => 'monthly',
                'max_products' => 25,
                'is_active' => true,
                'category_id' => $homeSalesCategory->id,
            ]);
        }

        // Yearly plans
        \App\Models\SubscriptionPlan::create([
            'name' => 'Yearly Basic',
            'description' => 'Annual subscription for cost savings.',
            'price' => 99.99,
            'duration' => 'yearly',
            'max_products' => 10,
            'is_active' => true,
        ]);

        \App\Models\SubscriptionPlan::create([
            'name' => 'Yearly Pro',
            'description' => 'Annual pro subscription with significant savings.',
            'price' => 199.99,
            'duration' => 'yearly',
            'max_products' => 50,
            'is_active' => true,
        ]);

        \App\Models\SubscriptionPlan::create([
            'name' => 'Yearly Premium',
            'description' => 'Unlimited products with maximum savings.',
            'price' => 399.99,
            'duration' => 'yearly',
            'max_products' => 0, // Unlimited
            'is_active' => true,
        ]);
    }
}
