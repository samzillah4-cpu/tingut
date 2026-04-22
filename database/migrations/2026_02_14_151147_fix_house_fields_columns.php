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
        // Rename the typo column - skipped as column may not exist
        // Schema::table('products', function (Blueprint $table) {
        //     $table->renameColumn('houseliving_area', 'house_living_area');
        // });

        // Add missing house columns
        Schema::table('products', function (Blueprint $table) {
            $table->string('house_living_area')->nullable()->after('sale_price');
            $table->string('house_plot_size')->nullable()->after('house_living_area');
            $table->integer('house_year_built')->nullable()->after('house_plot_size');
            $table->string('house_energy_rating')->nullable()->after('house_year_built');
            $table->string('house_ownership_type')->nullable()->after('house_energy_rating');
            $table->integer('house_floor')->nullable()->after('house_ownership_type');
            $table->boolean('house_elevator')->nullable()->default(false)->after('house_floor');
            $table->boolean('house_balcony')->nullable()->default(false)->after('house_elevator');
            $table->string('house_parking')->nullable()->after('house_balcony');
            $table->string('house_heating_type')->nullable()->after('house_parking');
            $table->boolean('house_new_construction')->nullable()->default(false)->after('house_heating_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
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
            ]);
            // $table->renameColumn('house_living_area', 'houseliving_area');
        });
    }
};
