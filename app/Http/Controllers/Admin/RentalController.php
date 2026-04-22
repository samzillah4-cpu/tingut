<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RentalController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Rental::with(['renter', 'product.user']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by renter or product owner name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('renter', function($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%");
                })->orWhereHas('product.user', function($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%");
                });
            });
        }

        $rentals = $query->paginate(15);

        return view('admin.rentals.index', compact('rentals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $products = Product::where('is_available_for_rent', true)->with('user')->get();
        return view('admin.rentals.create', compact('users', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'renter_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:pending,approved,rejected,active,completed,cancelled',
        ]);

        // Check if product is available for rent
        $product = Product::find($request->product_id);
        if (!$product->is_available_for_rent) {
            return back()->withErrors(['product_id' => 'This product is not available for rent.']);
        }

        // Check if renter is not the owner
        if ($product->user_id == $request->renter_id) {
            return back()->withErrors(['renter_id' => 'User cannot rent their own product.']);
        }

        // Calculate total price
        $startDate = \Carbon\Carbon::parse($request->start_date);
        $endDate = \Carbon\Carbon::parse($request->end_date);
        $totalPrice = $this->calculateRentalPrice($product, $startDate, $endDate);

        Rental::create([
            'renter_id' => $request->renter_id,
            'product_id' => $request->product_id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_price' => $totalPrice,
            'deposit_amount' => $product->rent_deposit,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.rentals.index')->with('success', 'Rental created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rental $rental)
    {
        $rental->load(['renter', 'product.user', 'product.category']);
        return view('admin.rentals.show', compact('rental'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rental $rental)
    {
        $rental->load(['renter', 'product']);
        return view('admin.rentals.edit', compact('rental'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rental $rental)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,active,completed,cancelled',
        ]);

        $oldStatus = $rental->status;
        $rental->update(['status' => $request->status]);

        // Set timestamps based on status
        if ($request->status === 'approved' && !$rental->approved_at) {
            $rental->update(['approved_at' => now()]);
        } elseif ($request->status === 'active' && !$rental->started_at) {
            $rental->update(['started_at' => now()]);
        } elseif ($request->status === 'completed' && !$rental->completed_at) {
            $rental->update(['completed_at' => now()]);
        }

        return redirect()->route('admin.rentals.index')->with('success', 'Rental updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rental $rental)
    {
        $rental->delete();

        return redirect()->route('admin.rentals.index')->with('success', 'Rental deleted successfully.');
    }

    /**
     * Calculate rental price based on duration.
     */
    private function calculateRentalPrice(Product $product, \Carbon\Carbon $startDate, \Carbon\Carbon $endDate)
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
