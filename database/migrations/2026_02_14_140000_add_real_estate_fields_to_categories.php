<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('is_real_estate')->default(false)->after('vehicle_fields');
            $table->json('real_estate_fields')->nullable()->after('is_real_estate');
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn([
                'is_real_estate',
                'real_estate_fields',
            ]);
        });
    }
};
