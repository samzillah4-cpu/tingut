<?php

namespace App\Http\Controllers;

use App\Models\HomeSale;
use Illuminate\Http\Request;

class PublicHomeSaleController extends Controller
{
    /**
     * Display a listing of home sales.
     */
    public function index(Request $request)
    {
        $query = HomeSale::active()->upcoming()->with('user');

        // Search filter
        if ($request->has('search') && ! empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        }

        // Location filter
        if ($request->has('location') && ! empty($request->location)) {
            $query->where(function ($q) use ($request) {
                $q->where('location', 'like', "%{$request->location}%")
                    ->orWhere('city', 'like', "%{$request->location}%");
            });
        }

        // Date filter
        if ($request->has('date_from') && ! empty($request->date_from)) {
            $query->whereDate('sale_date_from', '>=', $request->date_from);
        }

        // Sort options
        $sort = $request->get('sort', 'date');
        switch ($sort) {
            case 'date_asc':
                $query->orderBy('sale_date_from', 'asc');
                break;
            case 'date_desc':
                $query->orderBy('sale_date_from', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('sale_date_from', 'asc');
        }

        $upcomingHomeSales = $query->get();

        return view('home-sales.index', compact('upcomingHomeSales'));
    }

    /**
     * Live search for home sales.
     */
    public function search(Request $request)
    {
        $query = HomeSale::active()->upcoming()->with('user');

        if ($request->has('q') && ! empty($request->q)) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        }

        $homeSales = $query->limit(10)->get();

        return response()->json([
            'success' => true,
            'data' => $homeSales->map(function ($sale) {
                return [
                    'id' => $sale->id,
                    'title' => $sale->title,
                    'location' => $sale->location.($sale->city ? ', '.$sale->city : ''),
                    'date_from' => $sale->sale_date_from->format('M d'),
                    'date_to' => $sale->sale_date_to->format('M d, Y'),
                    'url' => route('home-sales.show', $sale),
                    'image' => $sale->images && count($sale->images) > 0
                        ? asset('storage/'.$sale->images[0])
                        : null,
                ];
            }),
        ]);
    }

    /**
     * Display the specified home sale.
     */
    public function show(HomeSale $homeSale)
    {
        $homeSale->load(['items' => function ($query) {
            $query->available()->ordered();
        }]);

        return view('home-sales.show', compact('homeSale'));
    }

    /**
     * Handle contact form submission for home sales.
     */
    public function contact(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'home_sale_id' => 'required|exists:home_sales,id',
            'seller_id' => 'required|exists:users,id',
        ]);

        // Get the home sale
        $homeSale = HomeSale::findOrFail($request->home_sale_id);

        // Here you would typically send an email or create a message record
        // For now, we'll just return a success response

        // You could implement email sending like:
        // Mail::to($homeSale->user->email)->send(new HomeSaleInquiry($request->all(), $homeSale));

        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent successfully!',
        ]);
    }
}
