<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->enum('house_property_type', ['apartment', 'house', 'townhouse', 'condo', 'villa', 'cottage', 'other'])->nullable()->after('vehicle_features');
            $table->integer('house_rooms')->nullable()->after('house_property_type');
            $table->integer('house_bedrooms')->nullable()->after('house_rooms');
            $table->integer('house_bathrooms')->nullable()->after('house_bedrooms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['house_property_type', 'house_rooms', 'house_bedrooms', 'house_bathrooms']);
        });
    }
};
