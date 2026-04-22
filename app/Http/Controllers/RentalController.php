<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RentalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create a rental request for a product.
     */
    public function create(Request $request, Product $product)
    {
        // Check if product is available for rent
        if (!$product->is_available_for_rent) {
            return back()->with('error', 'This product is not available for rent.');
        }

        // Check if user is not the owner
        if ($product->user_id === Auth::id()) {
            return back()->with('error', 'You cannot rent your own product.');
        }

        // Check if dates are provided
        $request->validate([
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        // Calculate rental duration and price
        $duration = $startDate->diffInDays($endDate) + 1; // Include both start and end dates

        // Calculate total price based on duration unit
        $totalPrice = $this->calculateRentalPrice($product, $startDate, $endDate);

        // Check for conflicting rentals
        $conflictingRental = Rental::where('product_id', $product->id)
            ->whereIn('status', ['pending', 'approved', 'active'])
            ->where(function($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                      ->orWhereBetween('end_date', [$startDate, $endDate])
                      ->orWhere(function($q) use ($startDate, $endDate) {
                          $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                      });
            })->exists();

        if ($conflictingRental) {
            return back()->with('error', 'This product is not available for the selected dates.');
        }

        // Create rental request
        $rental = Rental::create([
            'renter_id' => Auth::id(),
            'product_id' => $product->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_price' => $totalPrice,
            'deposit_amount' => $product->rent_deposit,
            'status' => 'pending',
        ]);

        // TODO: Send notification to product owner

        return redirect()->route('products.show', $product)
            ->with('success', 'Rental request submitted successfully.');
    }

    /**
     * Display rental requests for the authenticated user (as renter).
     */
    public function myRentals(Request $request)
    {
        $query = Auth::user()->rentals()->with('product.user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $rentals = $query->paginate(15);

        return view('rentals.my-rentals', compact('rentals'));
    }

    /**
     * Display rental requests for products owned by the authenticated user (as owner).
     */
    public function rentalRequests(Request $request)
    {
        $query = Rental::whereHas('product', function($query) {
            $query->where('user_id', Auth::id());
        })->with(['product', 'renter']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $rentals = $query->paginate(15);

        return view('rentals.requests', compact('rentals'));
    }

    /**
     * Show a specific rental.
     */
    public function show(Rental $rental)
    {
        // Check if user is involved in this rental
        if ($rental->renter_id !== Auth::id() && $rental->product->user_id !== Auth::id()) {
            abort(403);
        }

        $rental->load(['product.user', 'renter']);

        return view('rentals.show', compact('rental'));
    }

    /**
     * Update rental status (approve/reject/cancel/complete).
     */
    public function update(Request $request, Rental $rental)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,cancelled,completed,active',
        ]);

        $newStatus = $request->status;
        $oldStatus = $rental->status;

        // Authorization checks
        if (Auth::id() === $rental->renter_id) {
            // Renter can only cancel pending rentals
            if (!in_array($newStatus, ['cancelled']) || $oldStatus !== 'pending') {
                abort(403);
            }
        } elseif (Auth::id() === $rental->product->user_id) {
            // Owner can approve/reject pending, or complete active rentals
            if (!in_array($newStatus, ['approved', 'rejected', 'completed'])) {
                abort(403);
            }
            if ($newStatus === 'completed' && !in_array($oldStatus, ['active', 'approved'])) {
                abort(403);
            }
        } else {
            abort(403);
        }

        $rental->update(['status' => $newStatus]);

        // Set timestamps based on status
        if ($newStatus === 'approved' && !$rental->approved_at) {
            $rental->update(['approved_at' => now()]);
        } elseif ($newStatus === 'active' && !$rental->started_at) {
            $rental->update(['started_at' => now()]);
        } elseif ($newStatus === 'completed' && !$rental->completed_at) {
            $rental->update(['completed_at' => now()]);
        }

        // TODO: Send notifications based on status change

        return redirect()->back()->with('success', 'Rental status updated successfully.');
    }

    /**
     * Calculate rental price based on duration.
     */
    private function calculateRentalPrice(Product $product, Carbon $startDate, Carbon $endDate)
    {
        $days = $startDate->diffInDays($endDate) + 1;

        switch ($product->rent_duration_unit) {
            case 'day':
                return $product->rent_price * $days;
            case 'week':
                $weeks = ceil($days / 7);
                return $product->rent_price * $weeks;
            case 'month':
                $months = ceil($days / 30);
                return $product->rent_price * $months;
            default:
                return $product->rent_price * $days; // Default to daily
        }
    }
}
