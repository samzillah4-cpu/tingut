<?php

namespace App\Http\Controllers;

use App\Models\GiveawayRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GiveawayRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new giveaway request.
     */
    public function store(Request $request, Product $product)
    {
        // Check if product is a giveaway (either by listing_type or is_giveaway flag)
        if ($product->listing_type !== 'giveaway' && !$product->is_giveaway) {
            abort(404);
        }

        // Check if user is not the owner
        if ($product->user_id === Auth::id()) {
            return response()->json([
                'success' => false,
                'error' => 'You cannot request your own giveaway item.'
            ], 403);
        }

        // Check if user already requested this item
        $existingRequest = GiveawayRequest::where('product_id', $product->id)
            ->where('requester_id', Auth::id())
            ->first();

        if ($existingRequest) {
            return response()->json([
                'success' => false,
                'error' => 'You have already requested this item.'
            ], 409);
        }

        // Check if product is still available (active and not already approved for someone else)
        $existingApprovedRequest = GiveawayRequest::where('product_id', $product->id)
            ->where('status', 'approved')
            ->first();

        if ($existingApprovedRequest) {
            return response()->json([
                'success' => false,
                'error' => 'This item has already been claimed.'
            ], 409);
        }

        // Get personal details from request if provided
        $personalDetails = $request->input('personal_details', '');
        $location = $request->input('location', '');
        $reason = $request->input('reason', '');

        // For now, just create a basic request. Can expand later with more details
        $giveawayRequest = GiveawayRequest::create([
            'product_id' => $product->id,
            'requester_id' => Auth::id(),
            'personal_details' => $personalDetails,
            'location' => $location,
            'reason' => $reason,
            'status' => 'pending',
        ]);

        // Notify the seller
        $notificationService = app(\App\Services\NotificationService::class);
        $notificationService->notifyGiveawayRequested($giveawayRequest);

        return response()->json([
            'success' => true,
            'message' => 'Giveaway request submitted successfully!',
            'product_name' => $product->title
        ]);
    }

    /**
     * Update the status of a giveaway request.
     */
    public function update(Request $request, GiveawayRequest $giveawayRequest)
    {
        // Check if user owns the product
        if ($giveawayRequest->product->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $previousStatus = $giveawayRequest->status;
        $newStatus = $request->status;

        if ($newStatus === 'approved') {
            // When approving a request, reject all other pending requests for this product
            GiveawayRequest::where('product_id', $giveawayRequest->product_id)
                ->where('id', '!=', $giveawayRequest->id)
                ->where('status', 'pending')
                ->update(['status' => 'rejected']);

            // Update the approved request
            $giveawayRequest->update([
                'status' => 'approved',
                'approved_at' => now()
            ]);

            // Mark product as inactive so it won't appear in listings
            $giveawayRequest->product->update(['status' => 'inactive']);

            // Send notification to the approved requester
            $notificationService = app(\App\Services\NotificationService::class);
            $notificationService->notifyGiveawayApproved($giveawayRequest);

            // Notify other requesters that their request was rejected
            $rejectedRequests = GiveawayRequest::where('product_id', $giveawayRequest->product_id)
                ->where('id', '!=', $giveawayRequest->id)
                ->where('status', 'rejected')
                ->get();

            foreach ($rejectedRequests as $rejectedRequest) {
                $notificationService->notifyGiveawayRejected($rejectedRequest);
            }
        } elseif ($newStatus === 'rejected') {
            // Just reject this specific request
            $giveawayRequest->update(['status' => 'rejected']);

            // Send notification to the rejected requester
            $notificationService = app(\App\Services\NotificationService::class);
            $notificationService->notifyGiveawayRejected($giveawayRequest);
        }

        return redirect()->back()->with('success', 'Request updated successfully.');
    }
}
