<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
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
        SubscriptionPlan::create([
            'name' => 'Basic Plan',
            'description' => 'Basic subscription for general use',
            'price' => 99.00,
            'duration' => 'monthly',
            'max_products' => 10,
            'is_active' => true,
        ]);

        // Category-specific plans
        if ($vehiclesCategory) {
            SubscriptionPlan::create([
                'name' => 'Vehicle Seller Plan',
                'description' => 'Special plan for selling vehicles',
                'price' => 199.00,
                'duration' => 'monthly',
                'max_products' => 5,
                'is_active' => true,
                'category_id' => $vehiclesCategory->id,
            ]);
        }

        if ($realEstateCategory) {
            SubscriptionPlan::create([
                'name' => 'Real Estate Agent Plan',
                'description' => 'Plan for real estate listings',
                'price' => 299.00,
                'duration' => 'monthly',
                'max_products' => 20,
                'is_active' => true,
                'category_id' => $realEstateCategory->id,
            ]);
        }

        if ($homeSalesCategory) {
            SubscriptionPlan::create([
                'name' => 'Home Sales Plan',
                'description' => 'Plan for home and garden sales',
                'price' => 149.00,
                'duration' => 'monthly',
                'max_products' => 15,
                'is_active' => true,
                'category_id' => $homeSalesCategory->id,
            ]);
        }
    }
}
