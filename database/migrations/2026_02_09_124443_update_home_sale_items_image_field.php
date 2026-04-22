<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_sale_items', function (Blueprint $table) {
            // Change image from json to string
            $table->text('image')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('home_sale_items', function (Blueprint $table) {
            $table->json('image')->nullable()->change();
        });
    }
};
