<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BankIdService
{
    /**
     * BankID API endpoints (production and test)
     */
    private const PRODUCTION_URL = 'https://api.bankid.no';
    private const TEST_URL = 'https://api-test.bankid.no';

    /**
     * Get the BankID API base URL based on settings.
     */
    private function getApiUrl(): string
    {
        $environment = Setting::get('bankid_environment', 'test');
        return $environment === 'production' ? self::PRODUCTION_URL : self::TEST_URL;
    }

    /**
     * Check if BankID is enabled in settings.
     */
    public function isEnabled(): bool
    {
        return Setting::get('bankid_enabled', false) == true;
    }

    /**
     * Check if BankID is required for login.
     */
    public function isRequiredForLogin(): bool
    {
        return Setting::get('bankid_required_for_login', false) == true;
    }

    /**
     * Check if BankID is required for registration.
     */
    public function isRequiredForRegistration(): bool
    {
        return Setting::get('bankid_required_for_registration', false) == true;
    }

    /**
     * Initiate BankID authentication.
     */
    public function initiateAuthentication(Request $request, ?string $nationalId = null): array
    {
        if (!$this->isEnabled()) {
            return [
                'success' => false,
                'error' => 'BankID is not enabled',
            ];
        }

        try {
            $baseUrl = $this->getApiUrl();
            $clientId = Setting::get('bankid_client_id', '');
            $clientSecret = Setting::get('bankid_client_secret', '');

            // Create a unique order reference
            $orderRef = Str::uuid()->toString();

            // Store the order reference in session for later verification
            $request->session()->put('bankid_order_ref', $orderRef);
            $request->session()->put('bankid_national_id', $nationalId);

            // For demo purposes, we'll simulate the BankID flow
            // In production, this would call the actual BankID API
            return [
                'success' => true,
                'order_ref' => $orderRef,
                'autoStartToken' => Str::random(32),
                'message' => 'BankID authentication initiated. Please open your BankID app.',
            ];

            // Production code would look like this:
            /*
            $response = Http::withBasicAuth($clientId, $clientSecret)
                ->post($baseUrl . '/rp/v5/auth', [
                    'orderRef' => $orderRef,
                    'nationalId' => $nationalId,
                    'redirectUri' => url('/auth/bankid/callback'),
                ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'order_ref' => $orderRef,
                    'autoStartToken' => $response->json('autoStartToken'),
                ];
            }

            return [
                'success' => false,
                'error' => $response->json('errorMessage', 'Authentication failed'),
            ];
            */
        } catch (\Exception $e) {
            Log::error('BankID authentication error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Failed to initiate BankID authentication',
            ];
        }
    }

    /**
     * Collect BankID authentication status.
     */
    public function collectAuthentication(Request $request): array
    {
        $orderRef = $request->session()->get('bankid_order_ref');

        if (!$orderRef) {
            return [
                'success' => false,
                'error' => 'No pending BankID authentication',
            ];
        }

        try {
            // For demo purposes, we'll simulate a successful authentication
            // In production, this would call the actual BankID API
            return [
                'success' => true,
                'status' => 'complete',
            ];

            // Production code would look like this:
            /*
            $baseUrl = $this->getApiUrl();
            $clientId = Setting::get('bankid_client_id', '');
            $clientSecret = Setting::get('bankid_client_secret', '');

            $response = Http::withBasicAuth($clientId, $clientSecret)
                ->post($baseUrl . '/rp/v5/collect', [
                    'orderRef' => $orderRef,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'status' => $data['status'],
                    'completionData' => $data['completionData'] ?? null,
                ];
            }

            return [
                'success' => false,
                'error' => 'Failed to collect BankID status',
            ];
            */
        } catch (\Exception $e) {
            Log::error('BankID collect error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Failed to check BankID status',
            ];
        }
    }

    /**
     * Verify and complete BankID authentication.
     */
    public function verifyAuthentication(Request $request): ?User
    {
        $nationalId = $request->session()->get('bankid_national_id');

        // For demo purposes, we'll allow any user to be verified
        // In production, this would verify the BankID signature
        if ($nationalId) {
            // Find user by national ID or create a demo verification
            $user = User::where('national_id_number', $nationalId)->first();

            if ($user) {
                $user->markAsBankIdVerified(
                    $request->session()->get('bankid_order_ref'),
                    $nationalId
                );
                return $user;
            }
        }

        // Demo: Return a mock verified user for testing
        // In production, this would validate the BankID completion data
        return null;
    }

    /**
     * Cancel BankID authentication.
     */
    public function cancelAuthentication(Request $request): bool
    {
        try {
            $orderRef = $request->session()->get('bankid_order_ref');

            if ($orderRef) {
                // In production, call BankID cancel API
                // For demo, just clear the session
                $request->session()->forget(['bankid_order_ref', 'bankid_national_id']);
            }

            return true;
        } catch (\Exception $e) {
            Log::error('BankID cancel error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Verify a user with BankID.
     */
    public function verifyUser(User $user, string $bankidUuid): bool
    {
        try {
            $user->update([
                'bankid_uuid' => $bankidUuid,
                'bankid_status' => 'verified',
                'bankid_verified_at' => now(),
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('BankID user verification error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get BankID settings for display.
     */
    public function getSettings(): array
    {
        return [
            'bankid_enabled' => Setting::get('bankid_enabled', false),
            'bankid_environment' => Setting::get('bankid_environment', 'test'),
            'bankid_required_for_login' => Setting::get('bankid_required_for_login', false),
            'bankid_required_for_registration' => Setting::get('bankid_required_for_registration', false),
            'bankid_client_id' => Setting::get('bankid_client_id', ''),
            'bankid_client_secret' => Setting::get('bankid_client_secret', ''),
            'bankid_rp_client_id' => Setting::get('bankid_rp_client_id', ''),
            'bankid_rp_client_secret' => Setting::get('bankid_rp_client_secret', ''),
        ];
    }
}
