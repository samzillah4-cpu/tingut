<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\Exchange;
use App\Models\Product;
use App\Models\Rental;
use App\Models\Subscription;
use App\Models\User;
use App\Notifications\NewChatMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SellerController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Seller');
    }

    /**
     * Display the seller dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Basic statistics
        $productsCount = $user->products()->count();
        $activeProductsCount = $user->products()->where('status', 'active')->count();
        $inactiveProductsCount = $user->products()->where('status', 'inactive')->count();
        $draftProductsCount = $user->products()->where('status', 'draft')->count();

        // Exchange statistics
        $totalExchangesCount = Exchange::whereHas('requestedProduct', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        $pendingExchangesCount = Exchange::whereHas('requestedProduct', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'pending')->count();

        $acceptedExchangesCount = Exchange::whereHas('requestedProduct', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'accepted')->count();

        $rejectedExchangesCount = Exchange::whereHas('requestedProduct', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'rejected')->count();

        $completedExchangesCount = Exchange::whereHas('requestedProduct', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'completed')->count();

        // Recent data
        $recentProducts = $user->products()->with('category')->latest()->take(6)->get();
        $recentExchanges = Exchange::whereHas('requestedProduct', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['proposer', 'offeredProduct', 'requestedProduct'])->latest()->take(5)->get();

        // Messages count
        $unreadMessagesCount = $user->receivedMessages()->where('is_read', false)->count();
        $totalMessagesCount = $user->receivedMessages()->count();

        // Subscription status
        $activeSubscription = $user->subscriptions()->where('status', 'active')->where('end_date', '>', now())->first();
        $subscriptionStatus = $activeSubscription ? 'Active' : 'Inactive';
        $subscriptionPlan = $activeSubscription ? $activeSubscription->plan->name : 'No Plan';
        $subscriptionEndDate = $activeSubscription ? $activeSubscription->end_date->format('M d, Y') : null;

        // Monthly statistics (current month)
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $monthlyProductsCount = $user->products()->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)->count();

        $monthlyExchangesCount = Exchange::whereHas('requestedProduct', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)->count();

        // Seller location data
        $sellerLocation = $user->location ?? 'Not specified';
        $locationProductsCount = $user->products()->count(); // Total products as location indicator

        // Top performing products (by exchange proposals)
        $topProducts = $user->products()->withCount(['requestedExchanges' => function ($query) {
            $query->where('status', '!=', 'rejected');
        }])->orderBy('requested_exchanges_count', 'desc')->take(5)->get();

        // Recent notifications - commented out due to missing notifications table
        $recentNotifications = collect(); // Empty collection for now

        return view('seller.dashboard', compact(
            'productsCount',
            'activeProductsCount',
            'inactiveProductsCount',
            'draftProductsCount',
            'totalExchangesCount',
            'pendingExchangesCount',
            'acceptedExchangesCount',
            'rejectedExchangesCount',
            'completedExchangesCount',
            'recentProducts',
            'recentExchanges',
            'unreadMessagesCount',
            'totalMessagesCount',
            'subscriptionStatus',
            'subscriptionPlan',
            'subscriptionEndDate',
            'monthlyProductsCount',
            'monthlyExchangesCount',
            'sellerLocation',
            'locationProductsCount',
            'topProducts',
            'recentNotifications'
        ));
    }

    /**
     * Get real-time dashboard stats (API endpoint)
     */
    public function dashboardStats()
    {
        $user = Auth::user();

        $stats = [
            'products_count' => $user->products()->count(),
            'active_products_count' => $user->products()->where('status', 'active')->count(),
            'inactive_products_count' => $user->products()->where('status', 'inactive')->count(),
            'draft_products_count' => $user->products()->where('status', 'draft')->count(),
            'pending_exchanges_count' => Exchange::whereHas('requestedProduct', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('status', 'pending')->count(),
            'total_exchanges_count' => Exchange::whereHas('requestedProduct', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->count(),
            'unread_messages_count' => $user->receivedMessages()->where('is_read', false)->count(),
            'subscription_status' => $user->subscriptions()->where('status', 'active')->where('end_date', '>', now())->exists() ? 'Active' : 'Inactive',
            'subscription_plan' => null,
            'subscription_end_date' => null,
        ];

        $activeSubscription = $user->subscriptions()->where('status', 'active')->where('end_date', '>', now())->first();
        if ($activeSubscription) {
            $stats['subscription_plan'] = $activeSubscription->plan->name;
            $stats['subscription_end_date'] = $activeSubscription->end_date->format('M d, Y');
        }

        return response()->json($stats);
    }

    /**
     * Get real-time dashboard widgets data (API endpoint)
     */
    public function dashboardWidgets()
    {
        $user = Auth::user();

        // Recent exchanges
        $recentExchanges = Exchange::whereHas('requestedProduct', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['proposer', 'offeredProduct', 'requestedProduct'])->latest()->take(3)->get();

        // Format exchanges for JSON response
        $exchangesData = $recentExchanges->map(function ($exchange) {
            return [
                'id' => $exchange->id,
                'proposer_name' => $exchange->proposer->name,
                'offered_product_title' => $exchange->offeredProduct->title,
                'requested_product_title' => $exchange->requestedProduct->title,
                'status' => $exchange->status,
                'created_at' => $exchange->created_at->format('M d, Y'),
            ];
        });

        // Recent giveaway requests (if model exists)
        $recentGiveaways = [];
        if (class_exists('\App\Models\GiveawayRequest')) {
            $giveaways = \App\Models\GiveawayRequest::whereHas('product', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['requester', 'product'])->latest()->take(3)->get();

            $recentGiveaways = $giveaways->map(function ($request) {
                return [
                    'id' => $request->id,
                    'requester_name' => $request->requester->name,
                    'product_title' => $request->product->title,
                    'status' => $request->status,
                    'created_at' => $request->created_at->format('M d, Y'),
                ];
            });
        }

        return response()->json([
            'exchanges' => $exchangesData,
            'giveaways' => $recentGiveaways,
        ]);
    }

    /**
     * Display a listing of the seller's products.
     */
    public function productsIndex(Request $request)
    {
        $user = Auth::user();

        $query = $user->products()->with('category');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->paginate(15);

        return view('seller.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function productsCreate()
    {
        $categories = Category::all();

        return view('seller.products.create', compact('categories'));
    }

    /**
     * Store a newly created product.
     */
    public function productsStore(Request $request)
    {
        $user = Auth::user();
        $category = Category::find($request->category_id);

        // Check if category requires subscription
        if ($category && $category->requiresSubscription()) {
            // Check if user has active subscription for this category
            if (! $user->hasActiveSubscriptionForCategory($category)) {
                return redirect()->back()->with('error', 'You need an active subscription for this category to publish products. Please subscribe to a plan for '.$category->name.'.');
            }
        } else {
            // For non-restricted categories, check general subscription
            $activeSubscription = $user->subscriptions()->where('status', 'active')->where('end_date', '>', now())->first();
            if (! $activeSubscription) {
                return redirect()->back()->with('error', 'You need an active subscription to publish products. Please contact admin to subscribe.');
            }
        }

        // Check product limit
        $currentProductsCount = $user->products()->count();
        if ($activeSubscription->plan->max_products > 0 && $currentProductsCount >= $activeSubscription->plan->max_products) {
            return redirect()->back()->with('error', 'You have reached the maximum number of products allowed by your subscription plan.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'listing_type' => 'required|in:sale,exchange,giveaway',
            'exchange_categories' => 'nullable|array',
            'exchange_categories.*' => 'exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available_for_rent' => 'boolean',
            'rent_price' => 'nullable|numeric|min:0',
            'rent_duration_unit' => 'nullable|in:day,week,month',
            'rent_duration_value' => 'nullable|integer|min:1',
            'rent_deposit' => 'nullable|numeric|min:0',
            'rent_terms' => 'nullable|string|max:2000',
            'is_for_sale' => 'boolean',
            'sale_price' => 'nullable|numeric|min:0',
            // Vehicle fields
            'vehicle_make' => 'nullable|string|max:100',
            'vehicle_model' => 'nullable|string|max:100',
            'vehicle_year' => 'nullable|integer|min:1900|max:'.(date('Y') + 1),
            'vehicle_mileage' => 'nullable|integer|min:0',
            'vehicle_fuel_type' => 'nullable|in:petrol,diesel,electric,hybrid,lng,cng,other',
            'vehicle_transmission' => 'nullable|in:manual,automatic,semi_auto',
            'vehicle_color' => 'nullable|string|max:50',
            'vehicle_engine_size' => 'nullable|numeric|min:0|max:99.9',
            'vehicle_power' => 'nullable|integer|min:0',
            'vehicle_doors' => 'nullable|integer|min:1|max:10',
            'vehicle_weight' => 'nullable|integer|min:0',
            'vehicle_registration_number' => 'nullable|string|max:20',
            'vehicle_vin' => 'nullable|string|max:17',
            'vehicle_features' => 'nullable|array',
            // House fields
            'house_property_type' => 'nullable|string|max:100',
            'house_rooms' => 'nullable|integer|min:0',
            'house_bedrooms' => 'nullable|integer|min:0',
            'house_bathrooms' => 'nullable|integer|min:0',
            'house_living_area' => 'nullable|numeric|min:0',
            'house_plot_size' => 'nullable|numeric|min:0',
            'house_year_built' => 'nullable|integer|min:1800|max:'.(date('Y') + 1),
            'house_energy_rating' => 'nullable|string|max:10',
            'house_ownership_type' => 'nullable|string|max:50',
            'house_floor' => 'nullable|integer|min:0',
            'house_elevator' => 'nullable|boolean',
            'house_balcony' => 'nullable|boolean',
            'house_parking' => 'nullable|string|max:50',
            'house_heating_type' => 'nullable|string|max:50',
            'house_new_construction' => 'nullable|boolean',
            'house_shared_bathroom' => 'nullable|boolean',
            'house_facilities' => 'nullable|array',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
        }

        // Use description field, or fall back to short_description/long_description
        $description = $request->description;
        if (empty($description)) {
            $description = $request->short_description;
        }
        if (empty($description)) {
            $description = $request->long_description;
        }

        $product = Auth::user()->products()->create([
            'title' => $request->title,
            'description' => $description,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'category_id' => $request->category_id,
            'listing_type' => $request->listing_type,
            'exchange_categories' => $request->exchange_categories,
            'images' => $images,
            'status' => 'active',
            'is_available_for_rent' => $request->boolean('is_available_for_rent'),
            'rent_price' => $request->rent_price,
            'rent_duration_unit' => $request->rent_duration_unit,
            'rent_duration_value' => $request->rent_duration_value,
            'rent_deposit' => $request->rent_deposit,
            'rent_terms' => $request->rent_terms,
            'is_for_sale' => $request->boolean('is_for_sale'),
            'sale_price' => $request->sale_price,
            // Vehicle fields
            'vehicle_make' => $request->vehicle_make,
            'vehicle_model' => $request->vehicle_model,
            'vehicle_year' => $request->vehicle_year,
            'vehicle_mileage' => $request->vehicle_mileage,
            'vehicle_fuel_type' => $request->vehicle_fuel_type,
            'vehicle_transmission' => $request->vehicle_transmission,
            'vehicle_color' => $request->vehicle_color,
            'vehicle_engine_size' => $request->vehicle_engine_size,
            'vehicle_power' => $request->vehicle_power,
            'vehicle_doors' => $request->vehicle_doors,
            'vehicle_weight' => $request->vehicle_weight,
            'vehicle_registration_number' => $request->vehicle_registration_number,
            'vehicle_vin' => $request->vehicle_vin,
            'vehicle_features' => $request->vehicle_features,
            // House fields
            'house_property_type' => $request->house_property_type,
            'house_rooms' => $request->house_rooms,
            'house_bedrooms' => $request->house_bedrooms,
            'house_bathrooms' => $request->house_bathrooms,
            'house_living_area' => $request->house_living_area,
            'house_plot_size' => $request->house_plot_size,
            'house_year_built' => $request->house_year_built,
            'house_energy_rating' => $request->house_energy_rating,
            'house_ownership_type' => $request->house_ownership_type,
            'house_floor' => $request->house_floor,
            'house_elevator' => $request->house_elevator,
            'house_balcony' => $request->house_balcony,
            'house_parking' => $request->house_parking,
            'house_heating_type' => $request->house_heating_type,
            'house_new_construction' => $request->house_new_construction,
            'house_shared_bathroom' => $request->house_shared_bathroom,
            'house_facilities' => $request->house_facilities,
        ]);

        // Clear cache for products to ensure real-time update on frontend
        $this->clearProductsCache();

        // Trigger notification for admins
        $notificationService = app(\App\Services\NotificationService::class);
        $notificationService->notifyProductCreated($product);

        return redirect()->route('seller.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     */
    public function productsShow(Product $product)
    {
        // Ensure the product belongs to the authenticated seller
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        $product->load(['category', 'requestedExchanges.proposer', 'requestedExchanges.offeredProduct', 'giveawayRequests.requester']);

        return view('seller.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function productsEdit(Product $product)
    {
        // Ensure the product belongs to the authenticated seller
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::all();

        return view('seller.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product.
     */
    public function productsUpdate(Request $request, Product $product)
    {
        // Ensure the product belongs to the authenticated seller
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        $user = Auth::user();

        // Check if user has active subscription
        $activeSubscription = $user->subscriptions()->where('status', 'active')->where('end_date', '>', now())->first();
        if (! $activeSubscription) {
            return redirect()->back()->with('error', 'You need an active subscription to update products. Please contact admin to subscribe.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'listing_type' => 'required|in:sale,exchange,giveaway',
            'exchange_categories' => 'nullable|array',
            'exchange_categories.*' => 'exists:categories,id',
            'status' => 'required|in:active,inactive',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available_for_rent' => 'boolean',
            'rent_price' => 'nullable|numeric|min:0',
            'rent_duration_unit' => 'nullable|in:day,week,month',
            'rent_duration_value' => 'nullable|integer|min:1',
            'rent_deposit' => 'nullable|numeric|min:0',
            'rent_terms' => 'nullable|string|max:2000',
            'is_for_sale' => 'boolean',
            'sale_price' => 'nullable|numeric|min:0',
            // Vehicle fields
            'vehicle_make' => 'nullable|string|max:100',
            'vehicle_model' => 'nullable|string|max:100',
            'vehicle_year' => 'nullable|integer|min:1900|max:'.(date('Y') + 1),
            'vehicle_mileage' => 'nullable|integer|min:0',
            'vehicle_fuel_type' => 'nullable|in:petrol,diesel,electric,hybrid,lng,cng,other',
            'vehicle_transmission' => 'nullable|in:manual,automatic,semi_auto',
            'vehicle_color' => 'nullable|string|max:50',
            'vehicle_engine_size' => 'nullable|numeric|min:0|max:99.9',
            'vehicle_power' => 'nullable|integer|min:0',
            'vehicle_doors' => 'nullable|integer|min:1|max:10',
            'vehicle_weight' => 'nullable|integer|min:0',
            'vehicle_registration_number' => 'nullable|string|max:20',
            'vehicle_vin' => 'nullable|string|max:17',
            'vehicle_features' => 'nullable|array',
            // House fields
            'house_property_type' => 'nullable|string|max:100',
            'house_rooms' => 'nullable|integer|min:0',
            'house_bedrooms' => 'nullable|integer|min:0',
            'house_bathrooms' => 'nullable|integer|min:0',
            'house_living_area' => 'nullable|numeric|min:0',
            'house_plot_size' => 'nullable|numeric|min:0',
            'house_year_built' => 'nullable|integer|min:1800|max:'.(date('Y') + 1),
            'house_energy_rating' => 'nullable|string|max:10',
            'house_ownership_type' => 'nullable|string|max:50',
            'house_floor' => 'nullable|integer|min:0',
            'house_elevator' => 'nullable|boolean',
            'house_balcony' => 'nullable|boolean',
            'house_parking' => 'nullable|string|max:50',
            'house_heating_type' => 'nullable|string|max:50',
            'house_new_construction' => 'nullable|boolean',
            'house_shared_bathroom' => 'nullable|boolean',
            'house_facilities' => 'nullable|array',
        ]);

        $images = $product->images ?? [];
        if ($request->hasFile('images')) {
            // Delete old images if new ones uploaded
            foreach ($images as $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
        }

        // Use description field, or fall back to short_description/long_description
        $description = $request->description;
        if (empty($description)) {
            $description = $request->short_description;
        }
        if (empty($description)) {
            $description = $request->long_description;
        }

        $product->update([
            'title' => $request->title,
            'description' => $description,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'category_id' => $request->category_id,
            'listing_type' => $request->listing_type,
            'exchange_categories' => $request->exchange_categories,
            'images' => $images,
            'status' => $request->status,
            'is_available_for_rent' => $request->boolean('is_available_for_rent'),
            'rent_price' => $request->rent_price,
            'rent_duration_unit' => $request->rent_duration_unit,
            'rent_duration_value' => $request->rent_duration_value,
            'rent_deposit' => $request->rent_deposit,
            'rent_terms' => $request->rent_terms,
            'is_for_sale' => $request->boolean('is_for_sale'),
            'sale_price' => $request->sale_price,
            // Vehicle fields
            'vehicle_make' => $request->vehicle_make,
            'vehicle_model' => $request->vehicle_model,
            'vehicle_year' => $request->vehicle_year,
            'vehicle_mileage' => $request->vehicle_mileage,
            'vehicle_fuel_type' => $request->vehicle_fuel_type,
            'vehicle_transmission' => $request->vehicle_transmission,
            'vehicle_color' => $request->vehicle_color,
            'vehicle_engine_size' => $request->vehicle_engine_size,
            'vehicle_power' => $request->vehicle_power,
            'vehicle_doors' => $request->vehicle_doors,
            'vehicle_weight' => $request->vehicle_weight,
            'vehicle_registration_number' => $request->vehicle_registration_number,
            'vehicle_vin' => $request->vehicle_vin,
            'vehicle_features' => $request->vehicle_features,
            // House fields
            'house_property_type' => $request->house_property_type,
            'house_rooms' => $request->house_rooms,
            'house_bedrooms' => $request->house_bedrooms,
            'house_bathrooms' => $request->house_bathrooms,
            'house_living_area' => $request->house_living_area,
            'house_plot_size' => $request->house_plot_size,
            'house_year_built' => $request->house_year_built,
            'house_energy_rating' => $request->house_energy_rating,
            'house_ownership_type' => $request->house_ownership_type,
            'house_floor' => $request->house_floor,
            'house_elevator' => $request->house_elevator,
            'house_balcony' => $request->house_balcony,
            'house_parking' => $request->house_parking,
            'house_heating_type' => $request->house_heating_type,
            'house_new_construction' => $request->house_new_construction,
            'house_shared_bathroom' => $request->house_shared_bathroom,
            'house_facilities' => $request->house_facilities,
        ]);

        // Clear cache for products to ensure real-time update on frontend
        $this->clearProductsCache();

        return redirect()->route('seller.dashboard')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product.
     */
    public function productsDestroy(Product $product)
    {
        // Ensure the product belongs to the authenticated seller
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        // Delete images
        if ($product->images) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        // Clear cache for products to ensure real-time update on frontend
        $this->clearProductsCache();

        return redirect()->route('seller.products.index')->with('success', 'Product deleted successfully.');
    }

    /**
     * Display a listing of exchange proposals for the seller's products.
     */
    public function exchangesIndex(Request $request)
    {
        $user = Auth::user();

        $query = Exchange::whereHas('requestedProduct', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['proposer', 'offeredProduct', 'requestedProduct']);

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $exchanges = $query->paginate(15);

        return view('seller.exchanges.index', compact('exchanges'));
    }

    /**
     * Display the specified exchange.
     */
    public function exchangesShow(Exchange $exchange)
    {
        // Ensure the exchange is for the seller's product
        if ($exchange->requestedProduct->user_id !== Auth::id()) {
            abort(403);
        }

        $exchange->load(['proposer', 'offeredProduct', 'requestedProduct']);

        return view('seller.exchanges.show', compact('exchange'));
    }

    /**
     * Update exchange status (accept/reject).
     */
    public function exchangesUpdate(Request $request, Exchange $exchange)
    {
        // Ensure the exchange is for the seller's product
        if ($exchange->requestedProduct->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $oldStatus = $exchange->status;
        $exchange->update(['status' => $request->status]);

        // Trigger notifications based on status change
        $notificationService = app(\App\Services\NotificationService::class);

        if ($request->status === 'accepted' && $oldStatus !== 'accepted') {
            $notificationService->notifyExchangeAccepted($exchange);
        } elseif ($request->status === 'rejected' && $oldStatus !== 'rejected') {
            $notificationService->notifyExchangeRejected($exchange);
        }

        return redirect()->route('seller.exchanges.index')->with('success', 'Exchange updated successfully.');
    }

    /**
     * Display a listing of rental requests for the seller's products.
     */
    public function rentalsIndex(Request $request)
    {
        $user = Auth::user();

        $query = Rental::whereHas('product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['product', 'renter']);

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $rentals = $query->paginate(15);

        return view('seller.rentals.index', compact('rentals'));
    }

    /**
     * Display the specified rental.
     */
    public function rentalsShow(Rental $rental)
    {
        // Ensure the rental is for the seller's product
        if ($rental->product->user_id !== Auth::id()) {
            abort(403);
        }

        $rental->load(['product', 'renter']);

        return view('seller.rentals.show', compact('rental'));
    }

    /**
     * Update rental status (approve/reject/complete).
     */
    public function rentalsUpdate(Request $request, Rental $rental)
    {
        // Ensure the rental is for the seller's product
        if ($rental->product->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:approved,rejected,completed,active',
        ]);

        $oldStatus = $rental->status;
        $rental->update(['status' => $request->status]);

        // Set timestamps based on status
        if ($request->status === 'approved' && ! $rental->approved_at) {
            $rental->update(['approved_at' => now()]);
        } elseif ($request->status === 'active' && ! $rental->started_at) {
            $rental->update(['started_at' => now()]);
        } elseif ($request->status === 'completed' && ! $rental->completed_at) {
            $rental->update(['completed_at' => now()]);
        }

        // TODO: Send notifications based on status change

        return redirect()->route('seller.rentals.index')->with('success', 'Rental updated successfully.');
    }

    /**
     * Show the seller account management page.
     */
    public function accountEdit()
    {
        $user = Auth::user();

        return view('seller.account.edit', compact('user'));
    }

    /**
     * Update the seller account.
     */
    public function accountUpdate(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        ]);

        $user->update($request->only(['name', 'email']));

        return redirect()->route('seller.account.edit')->with('success', 'Account updated successfully.');
    }

    /**
     * Clear cache for products to ensure real-time updates on frontend.
     */
    private function clearProductsCache()
    {
        // Clear all product-related cache keys
        $cacheKeys = [
            'products_index',
            'products_exchanges',
            'products_giveaways',
            'products_shop',
            'seller_products_'.Auth::id(),
        ];

        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }
    }

    // ==================== CHAT METHODS ====================

    /**
     * Display all chats for the seller.
     */
    public function chatsIndex(Request $request)
    {
        $user = Auth::user();

        $query = Chat::where(function ($q) use ($user) {
            $q->where('user_id', $user->id)
                ->orWhere('related_user_id', $user->id);
        })->whereIn('chat_type', ['seller_customer', 'seller_admin'])
            ->with(['user', 'relatedUser', 'messages'])
            ->orderBy('last_message_at', 'desc');

        // Filter by type
        if ($request->filled('type')) {
            $query->where('chat_type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $chats = $query->paginate(15);

        // Get customer chats and admin chats counts
        $customerChatsCount = Chat::where('related_user_id', $user->id)
            ->where('chat_type', 'seller_customer')
            ->where('status', 'active')
            ->count();

        $adminChat = Chat::where(function ($q) use ($user) {
            $q->where('user_id', $user->id)
                ->orWhere('related_user_id', $user->id);
        })->where('chat_type', 'seller_admin')
            ->where('status', 'active')
            ->first();

        return view('seller.chats.index', compact('chats', 'customerChatsCount', 'adminChat'));
    }

    /**
     * Display a specific chat.
     */
    public function chatsShow(Chat $chat)
    {
        $user = Auth::user();

        // Ensure the seller is part of this chat
        if ($chat->user_id !== $user->id && $chat->related_user_id !== $user->id) {
            abort(403);
        }

        $chat->load(['user', 'relatedUser', 'messages']);

        // Mark messages as read
        $chat->messages()->where('user_id', '!=', $user->id)->whereNull('read_at')->update(['read_at' => now()]);

        return view('seller.chats.show', compact('chat'));
    }

    /**
     * Send a message in a chat.
     */
    public function chatsStore(Request $request)
    {
        $request->validate([
            'chat_id' => 'nullable|exists:chats,id',
            'message' => 'required|string|max:5000',
            'chat_type' => 'nullable|in:seller_customer,seller_admin',
            'related_user_id' => 'nullable|exists:users,id',
            'subject' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        // If chat_id is provided, reply to existing chat
        if ($request->filled('chat_id')) {
            $chat = Chat::findOrFail($request->chat_id);

            // Ensure the seller is part of this chat
            if ($chat->user_id !== $user->id && $chat->related_user_id !== $user->id) {
                abort(403);
            }

            $message = $chat->messages()->create([
                'user_id' => $user->id,
                'sender_type' => $user->hasRole('Admin') ? 'admin' : 'seller',
                'message' => $request->message,
            ]);

            $chat->update(['last_message_at' => now()]);

            // Notify the recipient
            $recipientId = $chat->user_id === $user->id ? $chat->related_user_id : $chat->user_id;
            if ($recipientId) {
                $recipient = User::find($recipientId);
                if ($recipient) {
                    $recipient->notify(new NewChatMessageNotification($message, $chat));
                }
            }

            return redirect()->route('seller.chats.show', $chat)->with('success', 'Message sent successfully.');
        }

        // Create new chat
        if ($request->filled('related_user_id') && $request->filled('chat_type')) {
            $relatedUser = User::findOrFail($request->related_user_id);

            // Check if chat already exists
            $existingChat = Chat::where(function ($q) use ($user, $relatedUser) {
                $q->where(function ($sq) use ($user, $relatedUser) {
                    $sq->where('user_id', $user->id)
                        ->where('related_user_id', $relatedUser->id);
                })->orWhere(function ($sq) use ($user, $relatedUser) {
                    $sq->where('user_id', $relatedUser->id)
                        ->where('related_user_id', $user->id);
                });
            })->where('chat_type', $request->chat_type)
                ->where('status', 'active')
                ->first();

            if ($existingChat) {
                // Reply to existing chat
                $message = $existingChat->messages()->create([
                    'user_id' => $user->id,
                    'sender_type' => $user->hasRole('Admin') ? 'admin' : 'seller',
                    'message' => $request->message,
                ]);

                $existingChat->update(['last_message_at' => now()]);

                return redirect()->route('seller.chats.show', $existingChat)->with('success', 'Message sent successfully.');
            }

            // Create new chat
            $chat = Chat::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'visitor_id' => 'seller_'.$user->id, // Required field for backwards compatibility
                'chat_type' => $request->chat_type,
                'related_user_id' => $request->related_user_id,
                'subject' => $request->subject,
                'status' => 'active',
                'last_message_at' => now(),
            ]);

            $message = $chat->messages()->create([
                'user_id' => $user->id,
                'sender_type' => $user->hasRole('Admin') ? 'admin' : 'seller',
                'message' => $request->message,
            ]);

            // Notify the recipient
            $relatedUser->notify(new NewChatMessageNotification($message, $chat));

            return redirect()->route('seller.chats.show', $chat)->with('success', 'Chat started successfully.');
        }

        return redirect()->back()->with('error', 'Unable to send message.');
    }

    /**
     * Get or create chat with admin.
     */
    public function chatWithAdmin()
    {
        $user = Auth::user();

        // Find or create chat with admin
        $admin = User::role('Admin')->first();

        if (! $admin) {
            return redirect()->back()->with('error', 'No admin available to chat.');
        }

        $existingChat = Chat::where(function ($q) use ($user, $admin) {
            $q->where(function ($sq) use ($user, $admin) {
                $sq->where('user_id', $user->id)
                    ->where('related_user_id', $admin->id);
            })->orWhere(function ($sq) use ($user, $admin) {
                $sq->where('user_id', $admin->id)
                    ->where('related_user_id', $user->id);
            });
        })->where('chat_type', 'seller_admin')
            ->where('status', 'active')
            ->with(['user', 'relatedUser', 'messages'])
            ->first();

        if (! $existingChat) {
            $existingChat = Chat::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'visitor_id' => 'seller_'.$user->id, // Required field for backwards compatibility
                'chat_type' => 'seller_admin',
                'related_user_id' => $admin->id,
                'subject' => 'Support Chat',
                'status' => 'active',
                'last_message_at' => now(),
            ]);

            $existingChat->load(['user', 'relatedUser', 'messages']);
        }

        // Mark messages as read
        $existingChat->messages()->where('user_id', '!=', $user->id)->whereNull('read_at')->update(['read_at' => now()]);

        return view('seller.chats.show', compact('existingChat'));
    }

    /**
     * Get unread chats count (API endpoint for real-time updates).
     */
    public function unreadChatsCount()
    {
        $user = Auth::user();

        $count = ChatMessage::whereHas('chat', function ($query) use ($user) {
            $query->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhere('related_user_id', $user->id);
            });
        })->where('user_id', '!=', $user->id)
            ->whereNull('read_at')
            ->count();

        // Get chats with new messages for tooltip
        $recentChats = Chat::where(function ($q) use ($user) {
            $q->where('user_id', $user->id)
                ->orWhere('related_user_id', $user->id);
        })->whereIn('chat_type', ['seller_customer', 'seller_admin'])
            ->where('last_message_at', '>', now()->subHours(24))
            ->with(['user', 'relatedUser'])
            ->latest('last_message_at')
            ->take(5)
            ->get();

        $chatsWithNewMessages = $recentChats->map(function ($chat) {
            $otherUser = $chat->user_id === Auth::id() ? $chat->relatedUser : $chat->user;
            $unreadCount = $chat->messages()->where('user_id', '!=', Auth::id())->whereNull('read_at')->count();

            return [
                'id' => $chat->id,
                'user_name' => $otherUser ? $otherUser->name : 'Unknown',
                'chat_type' => $chat->chat_type,
                'last_message_at' => $chat->last_message_at->diffForHumans(),
                'unread_count' => $unreadCount,
                'subject' => $chat->subject,
            ];
        });

        return response()->json([
            'count' => $count,
            'chats' => $chatsWithNewMessages,
        ]);
    }

    /**
     * Get new message notifications for tooltip display (API endpoint).
     */
    public function newMessageNotifications()
    {
        $user = Auth::user();

        // Get chats with unread messages
        $unreadChats = Chat::where(function ($q) use ($user) {
            $q->where('user_id', $user->id)
                ->orWhere('related_user_id', $user->id);
        })->whereIn('chat_type', ['seller_customer', 'seller_admin'])
            ->where('last_message_at', '>', now()->subHours(24))
            ->with(['user', 'relatedUser', 'messages' => function ($query) use ($user) {
                $query->where('user_id', '!=', $user->id)
                    ->whereNull('read_at')
                    ->latest();
            }])
            ->latest('last_message_at')
            ->take(5)
            ->get();

        $notifications = $unreadChats->map(function ($chat) {
            $otherUser = $chat->user_id === Auth::id() ? $chat->relatedUser : $chat->user;
            $lastMessage = $chat->messages->first();
            $unreadCount = $chat->messages->count();

            return [
                'id' => $chat->id,
                'type' => 'new_message',
                'title' => 'New Message',
                'message' => $lastMessage ? 'From '.($otherUser ? $otherUser->name : 'Unknown').': '.Str::limit($lastMessage->message, 50) : 'New chat message',
                'user_name' => $otherUser ? $otherUser->name : 'Unknown',
                'chat_type' => $chat->chat_type,
                'unread_count' => $unreadCount,
                'created_at' => $chat->last_message_at->toIsoString(),
                'url' => route('seller.chats.show', $chat),
            ];
        });

        return response()->json([
            'notifications' => $notifications,
            'count' => $notifications->sum('unread_count'),
        ]);
    }
}
