<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class PublicCategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index()
    {
        $categories = Category::withCount(['products' => function ($query) {
            $query->where('status', 'active');
        }])->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Display the specified category with its products.
     */
    public function show(Category $category, Request $request)
    {
        $query = $category->products()
            ->with('user')
            ->where('status', 'active');

        // Listing type filter (applies to all categories)
        if ($request->filled('listing_type')) {
            $query->where('listing_type', $request->listing_type);
        }

        // Price filters (applies to all categories)
        if ($request->filled('min_price')) {
            $query->where('sale_price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('sale_price', '<=', $request->max_price);
        }

        // Location filter (applies to all categories)
        if ($request->filled('location')) {
            $query->where('location', 'like', '%'.$request->location.'%');
        }

        // Real estate specific filters
        if ($category->is_real_estate) {
            // Property type filter
            if ($request->filled('property_type')) {
                $query->where('house_property_type', $request->property_type);
            }

            // Bedrooms filter
            if ($request->filled('min_bedrooms')) {
                $query->where('house_bedrooms', '>=', $request->min_bedrooms);
            }
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'latest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'price_low':
                $query->whereNotNull('sale_price')->orderBy('sale_price', 'asc');
                break;
            case 'price_high':
                $query->whereNotNull('sale_price')->orderBy('sale_price', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }
}
