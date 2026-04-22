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
        Schema::create('website_hero', function (Blueprint $table) {
            $table->id();
            $table->string('background_image')->nullable();
            $table->string('heading')->default('Welcome to TingUt.no');
            $table->text('paragraph')->nullable();
            $table->string('button1_text')->default('Browse Products');
            $table->string('button1_url')->default('/products');
            $table->string('button2_text')->default('Become a Seller');
            $table->string('button2_url')->default('/register');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_hero');
    }
};
