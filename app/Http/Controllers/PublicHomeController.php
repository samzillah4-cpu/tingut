<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\HomeSale;
use App\Models\Product;

class PublicHomeController extends Controller
{
    /**
     * Display the public home page.
     */
    public function index()
    {
        // Fetch upcoming home sales with eager loading
        $upcomingHomeSales = HomeSale::active()
            ->upcoming()
            ->orderedBySaleDate()
            ->with(['user:id,name,email'])
            ->take(10)
            ->get();

        // Fetch featured home sales with eager loading
        $featuredHomeSales = HomeSale::active()
            ->featured()
            ->upcoming()
            ->orderedBySaleDate()
            ->with(['user:id,name,email'])
            ->take(10)
            ->get();

        // Fetch featured products with optimized eager loading
        $featuredProducts = Product::where('status', 'active')
            ->with(['user:id,name,email,location', 'category:id,name'])
            ->select(['id', 'title', 'images', 'sale_price', 'user_id', 'category_id', 'status', 'created_at'])
            ->latest()
            ->take(8)
            ->get();

        // Fetch categories with cached counts
        $categories = Category::withCount(['products' => function ($query) {
            $query->where('status', 'active');
        }])
        ->select(['id', 'name', 'description', 'image'])
        ->get();

        // Fetch latest blogs with optimized fields
        $latestBlogs = Blog::published()
            ->select(['id', 'title', 'slug', 'content', 'image', 'published_at'])
            ->latest('published_at')
            ->take(3)
            ->get();

        return response()->view('index', compact(
            'upcomingHomeSales',
            'featuredHomeSales',
            'featuredProducts',
            'categories',
            'latestBlogs'
        ))->header('Cache-Control', 'public, max-age=300'); // Cache for 5 minutes
    }
}
