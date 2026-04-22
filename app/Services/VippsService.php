<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VippsService
{
    protected $clientId;
    protected $clientSecret;
    protected $subscriptionKey;
    protected $merchantSerialNumber;
    protected $environment;
    protected $baseUrl;

    public function __construct()
    {
        $this->clientId = Setting::where('key', 'vipps_client_id')->value('value');
        $this->clientSecret = Setting::where('key', 'vipps_client_secret')->value('value');
        $this->subscriptionKey = Setting::where('key', 'vipps_subscription_key')->value('value');
        $this->merchantSerialNumber = Setting::where('key', 'vipps_merchant_serial_number')->value('value');
        $this->environment = Setting::where('key', 'vipps_environment')->value('value') ?? 'test';

        $this->baseUrl = $this->environment === 'production'
            ? 'https://api.vipps.no'
            : 'https://apitest.vipps.no';
    }

    /**
     * Get access token for Vipps API
     */
    public function getAccessToken()
    {
        try {
            $response = Http::withHeaders([
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'Ocp-Apim-Subscription-Key' => $this->subscriptionKey,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->post("{$this->baseUrl}/accessToken/get", [
                'grant_type' => 'client_credentials',
                'scope' => 'name_phone_number address birthDate',
            ]);

            if ($response->successful()) {
                return $response->json()['access_token'];
            }

            Log::error('Vipps access token error', [
                'response' => $response->body(),
                'status' => $response->status()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Vipps access token exception', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Initiate payment
     */
    public function initiatePayment($orderId, $amount, $description, $callbackUrl, $returnUrl)
    {
        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            return null;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$accessToken}",
                'Ocp-Apim-Subscription-Key' => $this->subscriptionKey,
                'Content-Type' => 'application/json',
                'Merchant-Serial-Number' => $this->merchantSerialNumber,
            ])->post("{$this->baseUrl}/ecomm/v2/payments", [
                'merchantInfo' => [
                    'merchantSerialNumber' => $this->merchantSerialNumber,
                ],
                'customerInfo' => [
                    // Customer info can be added here if available
                ],
                'transaction' => [
                    'orderId' => $orderId,
                    'amount' => $amount * 100, // Convert to øre
                    'transactionText' => $description,
                ],
                'transactionLog' => [
                    'callbackUrl' => $callbackUrl,
                    'returnUrl' => $returnUrl,
                ],
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Vipps payment initiation error', [
                'order_id' => $orderId,
                'response' => $response->body(),
                'status' => $response->status()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Vipps payment initiation exception', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Check payment status
     */
    public function getPaymentStatus($orderId)
    {
        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            return null;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$accessToken}",
                'Ocp-Apim-Subscription-Key' => $this->subscriptionKey,
                'Merchant-Serial-Number' => $this->merchantSerialNumber,
            ])->get("{$this->baseUrl}/ecomm/v2/payments/{$orderId}/status");

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Vipps payment status error', [
                'order_id' => $orderId,
                'response' => $response->body(),
                'status' => $response->status()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Vipps payment status exception', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Cancel payment
     */
    public function cancelPayment($orderId)
    {
        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$accessToken}",
                'Ocp-Apim-Subscription-Key' => $this->subscriptionKey,
                'Merchant-Serial-Number' => $this->merchantSerialNumber,
            ])->put("{$this->baseUrl}/ecomm/v2/payments/{$orderId}/cancel");

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Vipps payment cancel exception', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
