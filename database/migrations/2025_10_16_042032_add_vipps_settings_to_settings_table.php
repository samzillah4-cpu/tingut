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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('vipps_environment')->default('test');
            $table->string('vipps_client_id')->nullable();
            $table->string('vipps_client_secret')->nullable();
            $table->string('vipps_subscription_key')->nullable();
            $table->string('vipps_merchant_serial_number')->nullable();
            $table->string('vipps_webhook_secret')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'vipps_environment',
                'vipps_client_id',
                'vipps_client_secret',
                'vipps_subscription_key',
                'vipps_merchant_serial_number',
                'vipps_webhook_secret'
            ]);
        });
    }
};
