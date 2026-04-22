<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add is_vehicle field to categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('is_vehicle')->default(false)->after('image');
            $table->json('vehicle_fields')->nullable()->after('is_vehicle');
        });

        // Add vehicle-specific fields to products table
        Schema::table('products', function (Blueprint $table) {
            $table->string('vehicle_make')->nullable()->after('sale_price');
            $table->string('vehicle_model')->nullable()->after('vehicle_make');
            $table->integer('vehicle_year')->nullable()->after('vehicle_model');
            $table->integer('vehicle_mileage')->nullable()->after('vehicle_year');
            $table->enum('vehicle_fuel_type', ['petrol', 'diesel', 'electric', 'hybrid', 'lng', 'cng', 'other'])->nullable()->after('vehicle_mileage');
            $table->enum('vehicle_transmission', ['manual', 'automatic', 'semi_auto'])->nullable()->after('vehicle_fuel_type');
            $table->string('vehicle_color')->nullable()->after('vehicle_transmission');
            $table->decimal('vehicle_engine_size', 4, 1)->nullable()->after('vehicle_color');
            $table->integer('vehicle_power')->nullable()->after('vehicle_engine_size');
            $table->tinyInteger('vehicle_doors')->nullable()->after('vehicle_power');
            $table->integer('vehicle_weight')->nullable()->after('vehicle_doors');
            $table->string('vehicle_registration_number')->nullable()->after('vehicle_weight');
            $table->string('vehicle_vin')->nullable()->after('vehicle_registration_number');
            $table->json('vehicle_features')->nullable()->after('vehicle_vin');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
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
            ]);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn([
                'is_vehicle',
                'vehicle_fields',
            ]);
        });
    }
};
