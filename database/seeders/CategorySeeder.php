<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices and gadgets',
                'image' => 'categories/3IYXtjsvvwanSnltg29cHPcMFh2PLG0Ep4J3FtAg.jpg',
                'is_vehicle' => false,
                'vehicle_fields' => null,
            ],
            [
                'name' => 'Clothing',
                'description' => 'Clothes, shoes, and accessories',
                'image' => 'categories/7nOiHQBclupf6aUqWg1270s6jUu8yazOS5YiB7kj.jpg',
                'is_vehicle' => false,
                'vehicle_fields' => null,
            ],
            [
                'name' => 'Books',
                'description' => 'Books, magazines, and educational materials',
                'image' => 'categories/HfIxysAe7GH5zAddttW2ej2TlsRoXIIDU843D9Eb.jpg',
                'is_vehicle' => false,
                'vehicle_fields' => null,
            ],
            [
                'name' => 'Home & Garden',
                'description' => 'Furniture, appliances, and garden tools',
                'image' => 'categories/hwkbHV0FIT2gxXFF7CWBn9MQccr4YjgfTcAdDM07.jpg',
                'is_vehicle' => false,
                'vehicle_fields' => null,
            ],
            [
                'name' => 'Sports & Outdoors',
                'description' => 'Sports equipment and outdoor gear',
                'image' => 'categories/I4Ftl8aNLb2cPQloytXvx2PzVxh8ExFeGZu4lbMF.jpg',
                'is_vehicle' => false,
                'vehicle_fields' => null,
            ],
            [
                'name' => 'Vehicles',
                'description' => 'Cars, bikes, and vehicle parts',
                'image' => 'categories/IazXWn4JEoUShN14mPDjx0LxWFmS0IVr4C23Gzm5.jpg',
                'is_vehicle' => true,
                'vehicle_fields' => [
                    'make' => ['type' => 'text', 'label' => 'Make', 'required' => true],
                    'model' => ['type' => 'text', 'label' => 'Model', 'required' => true],
                    'year' => ['type' => 'number', 'label' => 'Year', 'required' => true],
                    'mileage' => ['type' => 'number', 'label' => 'Mileage (km)', 'required' => true],
                    'fuel_type' => ['type' => 'select', 'label' => 'Fuel Type', 'required' => true, 'options' => ['petrol' => 'Petrol', 'diesel' => 'Diesel', 'electric' => 'Electric', 'hybrid' => 'Hybrid', 'lng' => 'LNG', 'cng' => 'CNG', 'other' => 'Other']],
                    'transmission' => ['type' => 'select', 'label' => 'Transmission', 'required' => true, 'options' => ['manual' => 'Manual', 'automatic' => 'Automatic', 'semi_auto' => 'Semi-Automatic']],
                    'color' => ['type' => 'text', 'label' => 'Color', 'required' => false],
                    'engine_size' => ['type' => 'decimal', 'label' => 'Engine Size (L)', 'required' => false],
                    'power' => ['type' => 'number', 'label' => 'Power (HP)', 'required' => false],
                    'doors' => ['type' => 'number', 'label' => 'Number of Doors', 'required' => false],
                    'weight' => ['type' => 'number', 'label' => 'Weight (kg)', 'required' => false],
                    'registration_number' => ['type' => 'text', 'label' => 'Registration Number', 'required' => false],
                    'vin' => ['type' => 'text', 'label' => 'VIN Number', 'required' => false],
                    'features' => ['type' => 'multiselect', 'label' => 'Features', 'required' => false, 'options' => ['sunroof' => 'Sunroof', 'leather' => 'Leather Seats', 'navigation' => 'Navigation', 'parking_sensors' => 'Parking Sensors', 'rear_camera' => 'Rear Camera', 'heated_seats' => 'Heated Seats', 'cruise_control' => 'Cruise Control', 'bluetooth' => 'Bluetooth', 'usb' => 'USB', 'aux' => 'AUX', 'cd_player' => 'CD Player', 'alloy_wheels' => 'Alloy Wheels', 'spoiler' => 'Spoiler', 'tow_bar' => 'Tow Bar', 'roof_rack' => 'Roof Rack', 'abs' => 'ABS', 'airbags' => 'Airbags', 'esp' => 'ESP', 'climate_control' => 'Climate Control', 'electric_windows' => 'Electric Windows', 'electric_mirrors' => 'Electric Mirrors']],
                ],
            ],
            [
                'name' => 'Collectibles',
                'description' => 'Antiques, coins, and collectible items',
                'image' => 'categories/j19XrWrSN0NkmQvIYNEWOIoVM4kGjKyHWddHEIKK.jpg',
                'is_vehicle' => false,
                'vehicle_fields' => null,
            ],
            [
                'name' => 'Services',
                'description' => 'Professional services and skills',
                'image' => 'categories/Qg4VZv1iRDZ4iKqFYLttnRPBd9k5HOGpbehy8SmK.jpg',
                'is_vehicle' => false,
                'vehicle_fields' => null,
            ],
            [
                'name' => 'Real Estate',
                'description' => 'Houses, apartments, and properties for sale or rent',
                'image' => 'categories/Qg4VZv1iRDZ4iKqFYLttnRPBd9k5HOGpbehy8SmK.jpg',
                'is_vehicle' => false,
                'vehicle_fields' => null,
                'is_real_estate' => true,
                'real_estate_fields' => [
                    'property_type' => ['type' => 'select', 'label' => 'Property Type', 'required' => true, 'options' => ['apartment' => 'Apartment', 'house' => 'House', 'villa' => 'Villa', 'townhouse' => 'Townhouse', 'cottage' => 'Cottage', 'farm' => 'Farm', 'plot' => 'Building Plot', 'commercial' => 'Commercial Property', 'other' => 'Other']],
                    'rooms' => ['type' => 'number', 'label' => 'Number of Rooms', 'required' => false],
                    'bedrooms' => ['type' => 'number', 'label' => 'Bedrooms', 'required' => false],
                    'bathrooms' => ['type' => 'number', 'label' => 'Bathrooms', 'required' => false],
                    'living_area' => ['type' => 'decimal', 'label' => 'Living Area (m²)', 'required' => false],
                    'plot_size' => ['type' => 'decimal', 'label' => 'Plot Size (m²)', 'required' => false],
                    'year_built' => ['type' => 'number', 'label' => 'Year Built', 'required' => false],
                    'energy_rating' => ['type' => 'select', 'label' => 'Energy Rating', 'required' => false, 'options' => ['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D', 'e' => 'E', 'f' => 'F', 'g' => 'G', 'unknown' => 'Unknown']],
                    'ownership_type' => ['type' => 'select', 'label' => 'Ownership Type', 'required' => false, 'options' => ['borettslag' => 'Borettslag (Cooperative)', 'sameie' => 'Sameie (Joint Ownership)', 'freehold' => 'Freehold (Selveier)', 'leasehold' => 'Leasehold (Leie)']],
                    'floor' => ['type' => 'number', 'label' => 'Floor', 'required' => false],
                    'elevator' => ['type' => 'boolean', 'label' => 'Elevator', 'required' => false],
                    'balcony' => ['type' => 'boolean', 'label' => 'Balcony', 'required' => false],
                    'parking' => ['type' => 'select', 'label' => 'Parking', 'required' => false, 'options' => ['none' => 'No Parking', 'garage' => 'Garage', 'parking_space' => 'Parking Space', 'street' => 'Street Parking', 'carport' => 'Carport']],
                    'heating_type' => ['type' => 'select', 'label' => 'Heating Type', 'required' => false, 'options' => ['electric' => 'Electric', 'oil' => 'Oil', 'gas' => 'Gas', 'district_heating' => 'District Heating', 'wood' => 'Wood/ Pellet', 'heat_pump' => 'Heat Pump', 'other' => 'Other']],
                    'new_construction' => ['type' => 'boolean', 'label' => 'New Construction', 'required' => false],
                ],
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
