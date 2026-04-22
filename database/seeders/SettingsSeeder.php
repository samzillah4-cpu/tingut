<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Site Settings
            [
                'key' => 'site_name',
                'value' => 'TingUt.no',
            ],
            [
                'key' => 'site_description',
                'value' => 'Garage Sale Platform - Buy, Exchange, or Give Away',
            ],
            [
                'key' => 'listing_fee',
                'value' => '10.00', // Fee in NOK for garage sale listings
            ],
            // Live Chat Settings
            [
                'key' => 'custom_chat_enabled',
                'value' => 'true',
            ],
            // Vipps Test Credentials (from Vipps Developer Portal)
            [
                'key' => 'vipps_environment',
                'value' => 'test',
            ],
            [
                'key' => 'vipps_client_id',
                'value' => 'fb492121-a9b4-4a42-8a6d-7b9a2b4e5c8f', // Test Client ID
            ],
            [
                'key' => 'vipps_client_secret',
                'value' => 'test-secret-key-for-vipps-integration', // Test Client Secret
            ],
            [
                'key' => 'vipps_subscription_key',
                'value' => 'test-subscription-key-12345', // Test Subscription Key
            ],
            [
                'key' => 'vipps_merchant_serial_number',
                'value' => '123456', // Test Merchant Serial Number
            ],
            [
                'key' => 'vipps_webhook_secret',
                'value' => 'test-webhook-secret-abcdef', // Test Webhook Secret
            ],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}
