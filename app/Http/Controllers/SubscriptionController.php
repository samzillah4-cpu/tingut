<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request, SubscriptionPlan $plan)
    {
        // Check if user is authenticated
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to subscribe to a plan.');
        }

        $user = Auth::user();

        // Check if user already has an active subscription for this plan's category
        $existingSubscription = Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->where('subscription_plan_id', $plan->id)
            ->first();

        if ($existingSubscription) {
            return redirect()->route('subscriptions')->with('error', 'You already have an active subscription for this plan.');
        }

        // For sellers, show a simplified checkout within the admin panel
        if ($user->hasRole('Seller')) {
            return view('seller.subscription-checkout', compact('plan'));
        }

        // For regular users, use the public checkout
        return view('subscription.checkout', compact('plan'));
    }

    public function processSubscription(Request $request, SubscriptionPlan $plan)
    {
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

        // Validate payment method
        $request->validate([
            'payment_method' => 'required|in:cash,vipps',
        ]);

        // For cash payment, create subscription directly
        if ($request->payment_method === 'cash') {
            $subscription = Subscription::create([
                'user_id' => $user->id,
                'subscription_plan_id' => $plan->id,
                'start_date' => now(),
                'end_date' => now()->addDays($this->getDurationInDays($plan->duration)),
                'status' => 'active', // Activate immediately for cash payment
            ]);

            // Create payment record
            \App\Models\Payment::create([
                'user_id' => $user->id,
                'subscription_id' => $subscription->id,
                'amount' => $plan->price,
                'payment_method' => 'cash',
                'status' => 'pending', // Wait for admin approval
                'transaction_id' => 'CASH-'.$subscription->id.'-'.time(),
            ]);

            return redirect()->route('subscriptions')->with('success', 'Your subscription has been activated! Please complete the cash payment with an administrator.');
        }

        // For Vipps payment, redirect to payment processing
        return redirect()->route('payment.vipps.create', ['plan' => $plan->id]);
    }

    private function getDurationInDays($duration)
    {
        return match (strtolower($duration)) {
            'monthly' => 30,
            'quarterly' => 90,
            'yearly' => 365,
            default => 30,
        };
    }

    public function cancel(Request $request, Subscription $subscription)
    {
        // Check if user owns this subscription
        if ($subscription->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Cancel subscription
        $subscription->update([
            'status' => 'cancelled',
            'end_date' => now(), // End immediately
        ]);

        return redirect()->route('subscriptions')->with('success', 'Your subscription has been cancelled successfully. You can now choose a new plan below.');
    }

    public function userSubscriptions()
    {
        $user = Auth::user();

        // Check user role and redirect accordingly
        if ($user->hasRole('Seller')) {
            return $this->sellerSubscriptions();
        }

        $subscriptions = Subscription::where('user_id', $user->id)
            ->with('plan')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.subscriptions', compact('subscriptions'));
    }

    public function sellerSubscriptions()
    {
        $user = Auth::user();

        // Get current active subscription
        $activeSubscription = $user->activeSubscription();

        // Get subscription history
        $subscriptionHistory = Subscription::where('user_id', $user->id)
            ->with('plan')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get available plans for sellers
        $availablePlans = SubscriptionPlan::active()->ordered()->get();

        return view('seller.subscriptions', compact('activeSubscription', 'subscriptionHistory', 'availablePlans'));
    }
}
