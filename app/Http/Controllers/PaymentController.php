<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Setting;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mrdulal\LaravelVipps\Facades\Vipps;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Configure Vipps with settings from database
        $this->configureVipps();
    }

    private function configureVipps()
    {
        $settings = Setting::whereIn('key', [
            'vipps_environment',
            'vipps_client_id',
            'vipps_client_secret',
            'vipps_subscription_key',
            'vipps_merchant_serial_number',
        ])->pluck('value', 'key')->toArray();

        config([
            'vipps.environment' => $settings['vipps_environment'] ?? 'test',
            'vipps.client_id' => $settings['vipps_client_id'] ?? null,
            'vipps.client_secret' => $settings['vipps_client_secret'] ?? null,
            'vipps.subscription_key' => $settings['vipps_subscription_key'] ?? null,
            'vipps.merchant_serial_number' => $settings['vipps_merchant_serial_number'] ?? null,
        ]);
    }

    /**
     * Process subscription payment
     */
    public function processPayment(Request $request, SubscriptionPlan $plan)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,vipps',
        ]);

        $user = Auth::user();

        // Check if user already has an active subscription for this plan
        $existingSubscription = Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->where('subscription_plan_id', $plan->id)
            ->first();

        if ($existingSubscription) {
            return back()->with('error', 'You already have an active subscription for this plan.');
        }

        $paymentMethod = $request->payment_method;

        if ($paymentMethod === 'cash') {
            return $this->processCashPayment($user, $plan);
        } elseif ($paymentMethod === 'vipps') {
            return $this->processVippsPayment($user, $plan);
        }

        return back()->with('error', 'Invalid payment method selected.');
    }

    /**
     * Process cash payment (admin approval required)
     */
    private function processCashPayment($user, SubscriptionPlan $plan)
    {
        // Create subscription
        $subscription = Subscription::create([
            'user_id' => $user->id,
            'subscription_plan_id' => $plan->id,
            'start_date' => now(),
            'end_date' => $this->calculateEndDate($plan),
            'status' => 'pending', // Waiting for admin approval
        ]);

        // Create payment record
        Payment::create([
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'payment_method' => 'cash',
            'amount' => $plan->price,
            'currency' => 'NOK',
            'status' => 'pending',
            'payment_data' => [
                'notes' => 'Cash payment - awaiting admin approval',
                'plan_name' => $plan->name,
            ],
        ]);

        return redirect()->route('subscriptions')->with('success',
            'Cash payment request submitted successfully! Your subscription will be activated once payment is confirmed by an administrator.');
    }

    /**
     * Process Vipps payment
     */
    private function processVippsPayment($user, SubscriptionPlan $plan)
    {
        try {
            // Create subscription first
            $subscription = Subscription::create([
                'user_id' => $user->id,
                'subscription_plan_id' => $plan->id,
                'start_date' => now(),
                'end_date' => $this->calculateEndDate($plan),
                'status' => 'pending',
            ]);

            // Create Vipps payment
            $vippsPayment = Vipps::ePayment()->create([
                'amount' => (int) ($plan->price * 100), // Convert to øre
                'currency' => 'NOK',
                'reference' => 'sub-'.$subscription->id.'-'.time(),
                'description' => 'Subscription: '.$plan->name,
                'returnUrl' => route('payment.vipps.success', ['subscription' => $subscription->id]),
                'callbackUrl' => route('payment.vipps.callback', ['subscription' => $subscription->id]),
            ]);

            // Create payment record
            Payment::create([
                'user_id' => $user->id,
                'subscription_id' => $subscription->id,
                'payment_method' => 'vipps',
                'transaction_id' => $vippsPayment['reference'],
                'amount' => $plan->price,
                'currency' => 'NOK',
                'status' => 'pending',
                'payment_data' => [
                    'vipps_reference' => $vippsPayment['reference'],
                    'vipps_payment_url' => $vippsPayment['url'],
                    'plan_name' => $plan->name,
                ],
            ]);

            return response()->json([
                'success' => true,
                'payment_url' => $vippsPayment['url'],
                'subscription_id' => $subscription->id,
            ]);

        } catch (\Exception $e) {
            // Clean up failed subscription
            if (isset($subscription)) {
                $subscription->delete();
            }

            return response()->json([
                'error' => 'Payment initialization failed: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle Vipps webhook for payment confirmation
     */
    public function handleVippsWebhook(Request $request)
    {
        $payload = $request->getContent();

        try {
            $event = json_decode($payload, true);

            if ($event['eventType'] === 'payment.completed') {
                $reference = $event['reference'];

                // Find and update payment
                $payment = Payment::where('transaction_id', $reference)->first();

                if ($payment && $payment->isPending()) {
                    $payment->markAsCompleted($reference);

                    // Activate subscription
                    $subscription = $payment->subscription;
                    $subscription->update(['status' => 'active']);

                    // Send notification
                    $subscription->user->notify(new \App\Notifications\SubscriptionActivated($subscription));
                }
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            \Log::error('Vipps webhook error: '.$e->getMessage());

            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }

    /**
     * Handle Vipps payment success redirect
     */
    public function vippsPaymentSuccess(Request $request, Subscription $subscription)
    {
        // Check if user owns this subscription
        if ($subscription->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check payment status
        $payment = Payment::where('subscription_id', $subscription->id)
            ->where('payment_method', 'vipps')
            ->first();

        if ($payment && $payment->isCompleted()) {
            return redirect()->route('subscriptions')->with('success', 'Payment successful! Your subscription is now active.');
        } elseif ($payment && $payment->isPending()) {
            return redirect()->route('subscriptions')->with('info', 'Payment is being processed. Please wait for confirmation.');
        } else {
            return redirect()->route('subscriptions')->with('error', 'Payment failed or was cancelled.');
        }
    }

    /**
     * Handle Vipps payment callback
     */
    public function vippsPaymentCallback(Request $request, Subscription $subscription)
    {
        try {
            $reference = $request->input('reference');

            // Find payment by reference
            $payment = Payment::where('transaction_id', $reference)->first();

            if ($payment && $payment->isPending()) {
                // Verify payment status with Vipps
                $vippsPayment = Vipps::ePayment()->details($reference);

                if ($vippsPayment['state'] === 'AUTHORIZED') {
                    $payment->markAsCompleted($reference);

                    // Activate subscription
                    $subscription->update(['status' => 'active']);
                }
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            \Log::error('Vipps callback error: '.$e->getMessage());

            return response()->json(['error' => 'Callback processing failed'], 500);
        }
    }

    /**
     * Create Vipps payment (for AJAX)
     */
    public function createVippsPayment(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
        ]);

        $user = Auth::user();
        $plan = SubscriptionPlan::findOrFail($request->plan_id);

        // Check if user already has an active subscription
        if ($user->hasActiveSubscription()) {
            return response()->json(['error' => 'You already have an active subscription.'], 400);
        }

        try {
            // Create subscription first
            $subscription = Subscription::create([
                'user_id' => $user->id,
                'subscription_plan_id' => $plan->id,
                'start_date' => now(),
                'end_date' => $this->calculateEndDate($plan),
                'status' => 'pending',
            ]);

            // Create Vipps payment
            $vippsPayment = Vipps::ePayment()->create([
                'amount' => (int) ($plan->price * 100), // Convert to øre
                'currency' => 'NOK',
                'reference' => 'sub-'.$subscription->id.'-'.time(),
                'description' => 'Subscription: '.$plan->name,
                'returnUrl' => route('payment.vipps.success', ['subscription' => $subscription->id]),
                'callbackUrl' => route('payment.vipps.callback', ['subscription' => $subscription->id]),
            ]);

            // Create payment record
            Payment::create([
                'user_id' => $user->id,
                'subscription_id' => $subscription->id,
                'payment_method' => 'vipps',
                'transaction_id' => $vippsPayment['reference'],
                'amount' => $plan->price,
                'currency' => 'NOK',
                'status' => 'pending',
                'payment_data' => [
                    'vipps_reference' => $vippsPayment['reference'],
                    'vipps_payment_url' => $vippsPayment['url'],
                    'plan_name' => $plan->name,
                ],
            ]);

            return response()->json([
                'success' => true,
                'payment_url' => $vippsPayment['url'],
            ]);

        } catch (\Exception $e) {
            // Clean up failed subscription
            if (isset($subscription)) {
                $subscription->delete();
            }

            return response()->json([
                'error' => 'Payment initialization failed: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Admin: Approve cash payment
     */
    public function approveCashPayment(Payment $payment)
    {
        if ($payment->payment_method !== 'cash' || $payment->isCompleted()) {
            return back()->with('error', 'Invalid payment or already processed.');
        }

        $payment->markAsCompleted('cash-'.now()->timestamp);

        // Activate subscription
        $subscription = $payment->subscription;
        $subscription->update(['status' => 'active']);

        return back()->with('success', 'Cash payment approved and subscription activated.');
    }

    /**
     * Admin: Reject cash payment
     */
    public function rejectCashPayment(Payment $payment)
    {
        if ($payment->payment_method !== 'cash' || ! $payment->isPending()) {
            return back()->with('error', 'Invalid payment status.');
        }

        $payment->markAsFailed();

        // Cancel subscription
        $subscription = $payment->subscription;
        $subscription->update(['status' => 'cancelled']);

        return back()->with('success', 'Cash payment rejected and subscription cancelled.');
    }

    /**
     * Calculate subscription end date based on plan duration
     */
    private function calculateEndDate(SubscriptionPlan $plan): \Carbon\Carbon
    {
        $startDate = now();

        if ($plan->duration === 'monthly') {
            return $startDate->addMonth();
        } elseif ($plan->duration === 'yearly') {
            return $startDate->addYear();
        }

        // Default to monthly if duration is not recognized
        return $startDate->addMonth();
    }
}
