<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PublicProductController extends Controller
{
    /**
     * Display the shop page with products for sale.
     */
    public function shop(Request $request)
    {
        // Optimized query with selective field loading
        $query = Product::where('status', 'active')
            ->where('is_for_sale', true)
            ->with([
                'user:id,name,email,location',
                'category:id,name'
            ])
            ->select([
                'id', 'title', 'images', 'sale_price', 'user_id', 'category_id',
                'status', 'created_at', 'short_description'
            ]);

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Search with fulltext index if available
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Optimized sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('sale_price', 'asc')->orderBy('id', 'desc');
                break;
            case 'price_high':
                $query->orderBy('sale_price', 'desc')->orderBy('id', 'desc');
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(24)->withQueryString();

        // Optimize memory usage
        $products->getCollection()->transform(function ($product) {
            // Ensure only needed data is loaded
            return $product;
        });
        $categories = Category::withCount(['products' => function($query) {
            $query->where('status', 'active')->where('is_for_sale', true);
        }])
        ->select(['id', 'name'])
        ->get();

        return view('shop.index', compact('products', 'categories'));
    }

    /**
     * Display a listing of products for sale (Garage Sale).
     */
    public function index(Request $request)
    {
        $query = Product::with(['user', 'category'])->where('status', 'active');

        // Filter by listing type
        $listingType = $request->get('listing_type', 'sale');
        if ($listingType && $listingType !== '') {
            $query->where('listing_type', $listingType);
        } else {
            // Default to sale if no type specified
            $query->where('listing_type', 'sale');
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('category', function($categoryQuery) use ($search) {
                      $categoryQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(24);

        // Get categories with count based on current listing type filter
        $categoriesQuery = Category::withCount(['products' => function($query) use ($listingType) {
            $query->where('status', 'active');
            if ($listingType && $listingType !== '') {
                $query->where('listing_type', $listingType);
            } else {
                $query->where('listing_type', 'sale');
            }
        }]);
        $categories = $categoriesQuery->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Display a listing of products for exchange.
     */
    public function exchanges(Request $request)
    {
        $query = Product::with(['user', 'category'])->where('status', 'active')->where('listing_type', 'exchange');

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('category', function($categoryQuery) use ($search) {
                      $categoryQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(24);
        $categories = Category::withCount(['products' => function($query) {
            $query->where('status', 'active')->where('listing_type', 'exchange');
        }])->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Display a listing of products for giveaway.
     */
    public function giveaways(Request $request)
    {
        $query = Product::with(['user', 'category'])->where('status', 'active')->where('listing_type', 'giveaway');

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('category', function($categoryQuery) use ($search) {
                      $categoryQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'type_sale':
                // Show sale products first, then others
                $query->orderByRaw("CASE WHEN listing_type = 'sale' THEN 1 WHEN listing_type = 'exchange' THEN 2 WHEN listing_type = 'giveaway' THEN 3 ELSE 4 END")
                      ->latest();
                break;
            case 'type_exchange':
                // Show exchange products first, then others
                $query->orderByRaw("CASE WHEN listing_type = 'exchange' THEN 1 WHEN listing_type = 'sale' THEN 2 WHEN listing_type = 'giveaway' THEN 3 ELSE 4 END")
                      ->latest();
                break;
            case 'type_giveaway':
                // Show giveaway products first, then others
                $query->orderByRaw("CASE WHEN listing_type = 'giveaway' THEN 1 WHEN listing_type = 'sale' THEN 2 WHEN listing_type = 'exchange' THEN 3 ELSE 4 END")
                      ->latest();
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(24);
        $categories = Category::withCount(['products' => function($query) {
            $query->where('status', 'active')->where('listing_type', 'giveaway');
        }])->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        // Only show active products
        if ($product->status !== 'active') {
            abort(404);
        }

        // Load product with optimized relationships
        $product->load([
            'user:id,name,email,location',
            'category:id,name'
        ]);

        // Get related products with optimized query
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->with(['user:id,name', 'category:id,name'])
            ->select(['id', 'title', 'images', 'sale_price', 'user_id', 'category_id', 'status', 'created_at'])
            ->latest()
            ->take(4)
            ->get();

        // Check if current user has already requested this giveaway
        $userGiveawayRequest = null;
        if (Auth::check()) {
            $userGiveawayRequest = \App\Models\GiveawayRequest::getUserRequest($product->id, Auth::id());
        }

        return view('products.show', compact('product', 'relatedProducts', 'userGiveawayRequest'));
    }

    /**
     * Display products by a specific seller.
     */
    public function sellerProducts(User $user)
    {
        $products = Product::with(['category'])
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->latest()
            ->paginate(50);

        $categories = Category::all();

        return view('products.seller', compact('products', 'user', 'categories'));
    }

    /**
     * Display products by a specific location.
     */
    public function locationProducts(Request $request, $location)
    {
        $query = Product::with(['user', 'category'])
            ->whereHas('user', function($q) use ($location) {
                $q->where('location', $location);
            })
            ->where('status', 'active');

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->paginate(50);
        $categories = Category::all();

        return view('products.location', compact('products', 'location', 'categories'));
    }

    /**
     * AJAX search for products, categories, sellers, and blogs.
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([
                'products' => [],
                'categories' => [],
                'sellers' => [],
                'blogs' => []
            ]);
        }

        // Search products
        $products = Product::with(['category', 'user'])
            ->where('status', 'active')
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->limit(5)
            ->get()
            ->map(function($product) {
                // Get first image from images array
                $imageUrl = null;
                if ($product->images && is_array($product->images) && count($product->images) > 0) {
                    $imageUrl = asset('storage/' . $product->images[0]);
                }

                return [
                    'id' => $product->id,
                    'title' => $product->title,
                    'sale_price' => $product->sale_price ? number_format($product->sale_price, 0, ',', ' ') . ' kr' : null,
                    'image' => $imageUrl,
                    'category' => $product->category ? ['name' => $product->category->name] : null,
                    'url' => route('products.show', $product->id),
                ];
            });

        // Search categories
        $categories = Category::where('name', 'like', "%{$query}%")
            ->limit(3)
            ->get()
            ->map(function($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'url' => route('categories.show', $category->id),
                ];
            });

        // Search sellers
        $sellers = User::where('name', 'like', "%{$query}%")
            ->whereHas('products', function($q) {
                $q->where('status', 'active');
            })
            ->withCount(['products' => function($q) {
                $q->where('status', 'active');
            }])
            ->having('products_count', '>', 0)
            ->limit(3)
            ->get()
            ->map(function($seller) {
                return [
                    'id' => $seller->id,
                    'name' => $seller->name,
                    'avatar' => $seller->profile_picture ? asset('storage/' . $seller->profile_picture) : null,
                    'products_count' => $seller->products_count,
                    'url' => route('sellers.products', $seller->id),
                ];
            });

        // Search blogs (if they exist - placeholder for now)
        $blogs = []; // Will be populated if blog functionality exists

        return response()->json([
            'products' => $products,
            'categories' => $categories,
            'sellers' => $sellers,
            'blogs' => $blogs
        ]);
    }

    /**
     * Handle rental request submission.
     */
    public function requestRental(Request $request, Product $product)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to request a rental.'
            ], 401);
        }

        // Check if product is available for rent
        if (!$product->is_available_for_rent) {
            return response()->json([
                'success' => false,
                'message' => 'This product is not available for rent.'
            ], 400);
        }

        // Check if user is not the owner
        if ($product->user_id === Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot rent your own product.'
            ], 400);
        }

        $request->validate([
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        // Calculate rental duration and price
        $days = $startDate->diffInDays($endDate) + 1;
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
            return response()->json([
                'success' => false,
                'message' => 'This product is not available for the selected dates.'
            ], 400);
        }

        try {
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

            return response()->json([
                'success' => true,
                'message' => 'Rental request submitted successfully.',
                'rental_id' => $rental->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit rental request. Please try again.'
            ], 500);
        }
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

    /**
     * Handle contact seller form submission.
     */
    public function contactSeller(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'seller_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $product = Product::findOrFail($request->product_id);
        $buyer = auth()->user();
        $seller = User::findOrFail($request->seller_id);

        // Create message in database
        try {
            $message = \App\Models\Message::create([
                'sender_id' => $buyer->id,
                'receiver_id' => $request->seller_id,
                'product_id' => $request->product_id,
                'subject' => $request->subject,
                'message' => $request->message,
                'is_read' => false,
            ]);

            // Also create or update a Chat record for real-time messaging
            $chat = null;

            // Check if chat already exists between buyer and seller
            $existingChat = \App\Models\Chat::where(function($q) use ($buyer, $seller) {
                $q->where(function($sq) use ($buyer, $seller) {
                    $sq->where('user_id', $buyer->id)
                       ->where('related_user_id', $seller->id);
                })->orWhere(function($sq) use ($buyer, $seller) {
                    $sq->where('user_id', $seller->id)
                       ->where('related_user_id', $buyer->id);
                });
            })->where('chat_type', 'seller_customer')
              ->where('status', 'active')
              ->first();

            if ($existingChat) {
                // Add message to existing chat
                $chatMessage = $existingChat->messages()->create([
                    'user_id' => $buyer->id,
                    'sender_type' => 'buyer',
                    'message' => $request->message,
                ]);

                $existingChat->update(['last_message_at' => now()]);
                $chat = $existingChat;
            } else {
                // Create new chat
                $chat = \App\Models\Chat::create([
                    'user_id' => $buyer->id,
                    'name' => $buyer->name,
                    'email' => $buyer->email,
                    'visitor_id' => 'buyer_' . $buyer->id,
                    'chat_type' => 'seller_customer',
                    'related_user_id' => $seller->id,
                    'subject' => $request->subject,
                    'status' => 'active',
                    'last_message_at' => now(),
                ]);

                // Add first message to chat
                $chatMessage = $chat->messages()->create([
                    'user_id' => $buyer->id,
                    'sender_type' => 'buyer',
                    'message' => $request->message,
                ]);
            }

            // Trigger notification for the seller
            $notificationService = app(\App\Services\NotificationService::class);
            $notificationService->notifyMessageReceived($message);

            // Also send a notification via the notification system for the chat
            \App\Notifications\NewChatMessageNotification::dispatch($chatMessage, $chat);

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully!',
                'chat_id' => $chat->id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message. Please try again.'
            ], 500);
        }
    }
}
