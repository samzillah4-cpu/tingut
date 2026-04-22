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
            $table->boolean('is_available_for_rent')->default(false)->after('status');
            $table->decimal('rent_price', 10, 2)->nullable()->after('is_available_for_rent');
            $table->enum('rent_duration_unit', ['day', 'week', 'month'])->nullable()->after('rent_price');
            $table->integer('rent_duration_value')->nullable()->after('rent_duration_unit');
            $table->decimal('rent_deposit', 10, 2)->nullable()->after('rent_duration_value');
            $table->text('rent_terms')->nullable()->after('rent_deposit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'is_available_for_rent',
                'rent_price',
                'rent_duration_unit',
                'rent_duration_value',
                'rent_deposit',
                'rent_terms'
            ]);
        });
    }
};
