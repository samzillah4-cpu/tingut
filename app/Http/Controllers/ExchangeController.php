<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mrdulal\LaravelVipps\Facades\Vipps;

class ExchangeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Process payment for exchange completion
     */
    public function processPayment(Request $request, Exchange $exchange)
    {
        // Ensure user is involved in the exchange
        if ($exchange->proposer_id !== Auth::id() && $exchange->receiver_id !== Auth::id()) {
            abort(403);
        }

        // Check if exchange is accepted
        if ($exchange->status !== 'accepted') {
            return back()->with('error', 'Exchange must be accepted before payment.');
        }

        $request->validate([
            'payment_method' => 'required|in:vipps',
        ]);

        try {
            // Get Vipps configuration from settings
            $vippsConfig = $this->getVippsConfig();

            // Initialize Vipps with settings
            $this->configureVipps($vippsConfig);

            // Calculate payment amount (you might want to add a fee or use a fixed amount)
            $amount = 1000; // 10.00 NOK in øre (adjust as needed)

            // Create payment request
            $payment = Vipps::ePayment()->create([
                'amount' => [
                    'currency' => 'NOK',
                    'value' => $amount,
                ],
                'reference' => 'exchange-' . $exchange->id . '-' . time(),
                'description' => 'Exchange completion payment for ' . $exchange->offeredProduct->title,
                'customer' => [
                    'phoneNumber' => Auth::user()->phone ?? '',
                ],
                'returnUrl' => route('exchange.payment.success', $exchange),
                'callbackUrl' => route('exchange.payment.callback', $exchange),
            ]);

            // Store payment reference in exchange
            $exchange->update([
                'payment_reference' => $payment['reference'],
                'payment_status' => 'pending',
            ]);

            return redirect($payment['checkoutUrl']);

        } catch (\Exception $e) {
            return back()->with('error', 'Payment initialization failed: ' . $e->getMessage());
        }
    }

    /**
     * Handle successful payment return
     */
    public function paymentSuccess(Exchange $exchange)
    {
        // Check payment status
        $vippsConfig = $this->getVippsConfig();
        $this->configureVipps($vippsConfig);

        try {
            $payment = Vipps::ePayment()->get($exchange->payment_reference);

            if ($payment['state'] === 'AUTHORIZED') {
                // Capture the payment
                Vipps::ePayment()->capture($exchange->payment_reference, [
                    'amount' => $payment['amount'],
                ]);

                // Update exchange status
                $exchange->update([
                    'status' => 'completed',
                    'payment_status' => 'completed',
                ]);

                return redirect()->route('buyer.exchanges.show', $exchange)
                    ->with('success', 'Payment successful! Exchange completed.');
            }

            return redirect()->route('buyer.exchanges.show', $exchange)
                ->with('warning', 'Payment is being processed. Please wait.');

        } catch (\Exception $e) {
            return redirect()->route('buyer.exchanges.show', $exchange)
                ->with('error', 'Payment verification failed: ' . $e->getMessage());
        }
    }

    /**
     * Handle Vipps payment callback
     */
    public function paymentCallback(Request $request, Exchange $exchange)
    {
        // Verify webhook signature if needed
        // Process the callback data

        $data = $request->all();

        if (isset($data['state']) && $data['state'] === 'AUTHORIZED') {
            $exchange->update([
                'status' => 'completed',
                'payment_status' => 'completed',
            ]);
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Get Vipps configuration from database settings
     */
    private function getVippsConfig()
    {
        return [
            'client_id' => Setting::where('key', 'vipps_client_id')->value('value'),
            'client_secret' => Setting::where('key', 'vipps_client_secret')->value('value'),
            'subscription_key' => Setting::where('key', 'vipps_subscription_key')->value('value'),
            'merchant_serial_number' => Setting::where('key', 'vipps_merchant_serial_number')->value('value'),
            'environment' => Setting::where('key', 'vipps_environment')->value('value') ?? 'test',
        ];
    }

    /**
     * Configure Vipps with settings
     */
    private function configureVipps($config)
    {
        config([
            'vipps.environment' => $config['environment'],
            'vipps.client_id' => $config['client_id'],
            'vipps.client_secret' => $config['client_secret'],
            'vipps.subscription_key' => $config['subscription_key'],
            'vipps.merchant_serial_number' => $config['merchant_serial_number'],
        ]);
    }
}
