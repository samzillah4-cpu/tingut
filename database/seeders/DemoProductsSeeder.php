<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class DemoProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create demo seller user
        $seller = User::firstOrCreate(
            ['email' => 'demo@seller.com'],
            ['name' => 'Demo Seller', 'password' => bcrypt('password')]
        );

        // Get vehicle category
        $vehicleCategory = Category::where('name', 'Vehicles')->first();

        // Get real estate category
        $realEstateCategory = Category::where('name', 'Real Estate')->first();

        // Vehicle 1 - Toyota RAV4
        Product::create([
            'user_id' => $seller->id,
            'category_id' => $vehicleCategory->id,
            'title' => '2019 Toyota RAV4 Hybrid',
            'description' => 'Excellent condition Toyota RAV4 Hybrid with full service history. Low mileage and well maintained. Features include leather seats, navigation, heated seats, parking sensors, rear camera, and more.',
            'status' => 'active',
            'listing_type' => 'sale',
            'is_for_sale' => true,
            'sale_price' => 289000,
            'vehicle_make' => 'Toyota',
            'vehicle_model' => 'RAV4',
            'vehicle_year' => 2019,
            'vehicle_mileage' => 45000,
            'vehicle_fuel_type' => 'hybrid',
            'vehicle_transmission' => 'automatic',
            'vehicle_color' => 'Pearl White',
            'vehicle_engine_size' => 2.5,
            'vehicle_power' => 219,
            'vehicle_doors' => 5,
            'vehicle_weight' => 1750,
            'vehicle_registration_number' => 'AB 12345',
            'vehicle_vin' => 'JTMWY4DV80A0123456',
            'vehicle_features' => ['navigation', 'leather', 'heated_seats', 'parking_sensors', 'rear_camera', 'bluetooth', 'alloy_wheels'],
            'images' => ['https://images.unsplash.com/photo-1617788138017-80ad40651399?w=800'],
            'location' => 'Oslo'
        ]);

        // Vehicle 2 - BMW X5
        Product::create([
            'user_id' => $seller->id,
            'category_id' => $vehicleCategory->id,
            'title' => '2021 BMW X5 xDrive45e',
            'description' => 'Luxury BMW X5 plug-in hybrid. Premium features and exceptional performance. Includes sunroof, navigation, leather seats, heated seats, parking sensors, rear camera, cruise control, and more.',
            'status' => 'active',
            'listing_type' => 'sale',
            'is_for_sale' => true,
            'sale_price' => 589000,
            'vehicle_make' => 'BMW',
            'vehicle_model' => 'X5',
            'vehicle_year' => 2021,
            'vehicle_mileage' => 25000,
            'vehicle_fuel_type' => 'hybrid',
            'vehicle_transmission' => 'automatic',
            'vehicle_color' => 'Carbon Black',
            'vehicle_engine_size' => 3.0,
            'vehicle_power' => 394,
            'vehicle_doors' => 5,
            'vehicle_weight' => 2510,
            'vehicle_registration_number' => 'CD 67890',
            'vehicle_vin' => '5UXCR6C04L9A1234567',
            'vehicle_features' => ['sunroof', 'navigation', 'leather', 'heated_seats', 'parking_sensors', 'rear_camera', 'cruise_control', 'bluetooth', 'alloy_wheels', 'climate_control', 'electric_windows'],
            'images' => ['https://images.unsplash.com/photo-1556189250-72ba954e96b5?w=800'],
            'location' => 'Bergen'
        ]);

        // Real Estate 1 - Apartment in Oslo
        Product::create([
            'user_id' => $seller->id,
            'category_id' => $realEstateCategory->id,
            'title' => 'Modern Apartment in Oslo Center',
            'description' => 'Beautiful modern apartment in the heart of Oslo. Recently renovated with high-quality finishes. Close to public transport, shops, and restaurants.',
            'status' => 'active',
            'listing_type' => 'sale',
            'is_for_sale' => true,
            'sale_price' => 4500000,
            'house_property_type' => 'apartment',
            'house_rooms' => 3,
            'house_bedrooms' => 2,
            'house_bathrooms' => 1,
            'house_living_area' => 85.5,
            'house_plot_size' => 0,
            'house_year_built' => 2018,
            'house_energy_rating' => 'b',
            'house_ownership_type' => 'borettslag',
            'house_floor' => 4,
            'house_elevator' => true,
            'house_balcony' => true,
            'house_parking' => 'garage',
            'house_heating_type' => 'district_heating',
            'house_new_construction' => false,
            'images' => ['https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800'],
            'location' => 'Oslo'
        ]);

        // Real Estate 2 - House in Bergen
        Product::create([
            'user_id' => $seller->id,
            'category_id' => $realEstateCategory->id,
            'title' => 'Family House in Bergen - Fana',
            'description' => 'Spacious family house in quiet residential area in Fana, Bergen. Large plot with garden, double garage, and modern facilities.',
            'status' => 'active',
            'listing_type' => 'sale',
            'is_for_sale' => true,
            'sale_price' => 7200000,
            'house_property_type' => 'house',
            'house_rooms' => 6,
            'house_bedrooms' => 4,
            'house_bathrooms' => 2,
            'house_living_area' => 220.0,
            'house_plot_size' => 850.0,
            'house_year_built' => 2005,
            'house_energy_rating' => 'c',
            'house_ownership_type' => 'freehold',
            'house_floor' => 0,
            'house_elevator' => false,
            'house_balcony' => true,
            'house_parking' => 'garage',
            'house_heating_type' => 'heat_pump',
            'house_new_construction' => false,
            'images' => ['https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800'],
            'location' => 'Bergen'
        ]);

        $this->command->info('Demo vehicles and real estate products created successfully!');
    }
}
