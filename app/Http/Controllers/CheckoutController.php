<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show checkout page.
     */
    public function index()
    {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum('total');

        return view('checkout.index', compact('cartItems', 'total'));
    }

    /**
     * Process checkout.
     */
    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:vipps,cash',
        ]);

        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum('total');

        // Get commission rate
        $commissionRate = Setting::where('key', 'ecommerce_commission_rate')->value('value') ?? 0;
        $commissionRate = (float) $commissionRate / 100;

        DB::beginTransaction();
        try {
            $orders = [];

            foreach ($cartItems as $cartItem) {
                $commissionAmount = $cartItem->total * $commissionRate;

                $order = Order::create([
                    'buyer_id' => Auth::id(),
                    'seller_id' => $cartItem->product->user_id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $cartItem->product->sale_price,
                    'total_amount' => $cartItem->total,
                    'commission_amount' => $commissionAmount,
                    'payment_method' => $request->payment_method,
                    'status' => $request->payment_method === 'cash' ? 'pending' : 'pending',
                ]);

                $orders[] = $order;
            }

            // Clear cart
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            if ($request->payment_method === 'vipps') {
                // Redirect to Vipps payment processing
                return redirect()->route('checkout.vipps', ['order_ids' => collect($orders)->pluck('id')->implode(',')]);
            } else {
                // Send order confirmation email for cash payment
                $orderModels = Order::with('product')->whereIn('id', collect($orders)->pluck('id'))->get();
                $totalAmount = $orderModels->sum('total_amount');

                Mail::to(Auth::user()->email)->send(new OrderConfirmation($orderModels, $totalAmount));

                return redirect()->route('orders.index')->with('success', 'Order placed successfully. Please pay cash upon delivery.');
            }

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', 'Failed to process order. Please try again.');
        }
    }

    /**
     * Handle Vipps payment.
     */
    public function vipps(Request $request)
    {
        $orderIds = explode(',', $request->order_ids);
        $orders = Order::whereIn('id', $orderIds)->get();

        if ($orders->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Orders not found.');
        }

        $totalAmount = $orders->sum('total_amount');

        // Use Vipps service
        $vippsService = app(\App\Services\VippsService::class);

        $orderId = 'order_'.time().'_'.auth()->id();

        $callbackUrl = route('checkout.vipps.callback', ['order_ids' => implode(',', $orderIds)]);
        $returnUrl = route('checkout.vipps.success', ['order_ids' => implode(',', $orderIds)]);

        $paymentResponse = $vippsService->initiatePayment(
            $orderId,
            $totalAmount,
            'Order payment',
            $callbackUrl,
            $returnUrl
        );

        if ($paymentResponse && isset($paymentResponse['url'])) {
            return redirect($paymentResponse['url']);
        }

        return redirect()->route('checkout.index')->with('error', 'Failed to initiate Vipps payment. Please try again.');
    }

    /**
     * Handle Vipps payment success.
     */
    public function vippsSuccess(Request $request)
    {
        $orderIds = explode(',', $request->order_ids);

        // Check payment status
        $vippsService = app(\App\Services\VippsService::class);
        $orderId = 'order_'.time().'_'.auth()->id(); // This should be stored and retrieved properly

        $status = $vippsService->getPaymentStatus($orderId);

        if ($status && isset($status['transactionInfo']['status']) && $status['transactionInfo']['status'] === 'RESERVED') {
            Order::whereIn('id', $orderIds)->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            // Send order confirmation email
            $orders = Order::with('product')->whereIn('id', $orderIds)->get();
            $total = $orders->sum('total_amount');

            Mail::to(Auth::user()->email)->send(new OrderConfirmation($orders, $total));

            return redirect()->route('orders.index')->with('success', 'Payment completed successfully.');
        }

        return redirect()->route('checkout.index')->with('error', 'Payment was not completed. Please try again.');
    }

    /**
     * Handle Vipps payment callback.
     */
    public function vippsCallback(Request $request, $orderIds)
    {
        $orderIds = explode(',', $orderIds);

        // Verify payment status
        $vippsService = app(\App\Services\VippsService::class);
        $orderId = $request->input('orderId'); // From Vipps callback

        $status = $vippsService->getPaymentStatus($orderId);

        if ($status && isset($status['transactionInfo']['status'])) {
            $paymentStatus = $status['transactionInfo']['status'];

            if ($paymentStatus === 'RESERVED' || $paymentStatus === 'CAPTURED') {
                Order::whereIn('id', $orderIds)->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                ]);
            } elseif ($paymentStatus === 'CANCELLED' || $paymentStatus === 'REJECTED') {
                Order::whereIn('id', $orderIds)->update([
                    'status' => 'cancelled',
                ]);
            }
        }

        return response()->json(['received' => true]);
    }
}
