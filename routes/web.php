<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\PublicHomeController::class, 'index'])->name('home');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('user.home');

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('Admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('Seller')) {
        return redirect()->route('seller.dashboard');
    } elseif ($user->hasRole('Customer')) {
        return redirect()->route('buyer.dashboard');
    }

    // Default fallback
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart routes
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [\App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cart}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [\App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/api/cart/count', [\App\Http\Controllers\CartController::class, 'count'])->name('api.cart.count');

    // Checkout routes
    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/vipps/{order_ids}', [\App\Http\Controllers\CheckoutController::class, 'vipps'])->name('checkout.vipps');
    Route::get('/checkout/vipps/success/{order_ids}', [\App\Http\Controllers\CheckoutController::class, 'vippsSuccess'])->name('checkout.vipps.success');

    // Orders
    Route::get('/orders', function () {
        $orders = \App\Models\Order::with(['product', 'seller'])
            ->where('buyer_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    })->name('orders.index');
    Route::get('/orders/{order}', function (\App\Models\Order $order) {
        if ($order->buyer_id !== auth()->id()) {
            abort(403);
        }

        return view('orders.show', compact('order'));
    })->name('orders.show');
});

Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/settings', [\App\Http\Controllers\Admin\AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [\App\Http\Controllers\Admin\AdminController::class, 'updateSettings'])->name('settings.update');

    // System management
    Route::get('/system/logs', [\App\Http\Controllers\Admin\AdminController::class, 'systemLogs'])->name('system.logs');
    Route::post('/system/logs/clear', [\App\Http\Controllers\Admin\AdminController::class, 'clearSystemLogs'])->name('system.clear-logs');

    // Website management
    Route::get('/website', [\App\Http\Controllers\Admin\WebsiteController::class, 'index'])->name('website.index');
    Route::post('/website/menus', [\App\Http\Controllers\Admin\WebsiteController::class, 'updateMenus'])->name('website.menus.update');
    Route::post('/website/menus/create', [\App\Http\Controllers\Admin\WebsiteController::class, 'createMenu'])->name('website.menus.create');
    Route::delete('/website/menus/{id}', [\App\Http\Controllers\Admin\WebsiteController::class, 'deleteMenu'])->name('website.menus.delete');
    Route::get('/hero', [\App\Http\Controllers\Admin\WebsiteController::class, 'hero'])->name('hero');
    Route::post('/hero', [\App\Http\Controllers\Admin\WebsiteController::class, 'updateHero'])->name('hero.update');

    // Testimonials management
    Route::get('/testimonials', [\App\Http\Controllers\Admin\WebsiteController::class, 'testimonials'])->name('testimonials');
    Route::get('/testimonials/create', [\App\Http\Controllers\Admin\WebsiteController::class, 'createTestimonial'])->name('testimonials.create');
    Route::post('/testimonials', [\App\Http\Controllers\Admin\WebsiteController::class, 'storeTestimonial'])->name('testimonials.store');
    Route::get('/testimonials/{id}/edit', [\App\Http\Controllers\Admin\WebsiteController::class, 'editTestimonial'])->name('testimonials.edit');
    Route::put('/testimonials/{id}', [\App\Http\Controllers\Admin\WebsiteController::class, 'updateTestimonial'])->name('testimonials.update');
    Route::delete('/testimonials/{id}', [\App\Http\Controllers\Admin\WebsiteController::class, 'deleteTestimonial'])->name('testimonials.delete');
    Route::post('/testimonials/order', [\App\Http\Controllers\Admin\WebsiteController::class, 'updateTestimonialsOrder'])->name('testimonials.order');

    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::get('categories-export', [\App\Http\Controllers\Admin\CategoryController::class, 'export'])->name('categories.export');
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::post('products/bulk', [\App\Http\Controllers\Admin\ProductController::class, 'bulkAction'])->name('products.bulk');
    Route::get('products-export', [\App\Http\Controllers\Admin\ProductController::class, 'export'])->name('products.export');
    Route::resource('exchanges', \App\Http\Controllers\Admin\ExchangeController::class);
    Route::get('exchanges-export-pdf', [\App\Http\Controllers\Admin\ExchangeController::class, 'exportPdf'])->name('exchanges.export-pdf');
    Route::resource('rentals', \App\Http\Controllers\Admin\RentalController::class);
    Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class);
    Route::resource('buyers', \App\Http\Controllers\Admin\BuyerController::class);
    Route::get('buyers-export', [\App\Http\Controllers\Admin\BuyerController::class, 'export'])->name('buyers.export');
    Route::get('/buyers/{buyer}/login-as', [\App\Http\Controllers\Admin\BuyerController::class, 'loginAs'])->name('buyers.login-as');
    Route::delete('/buyers/bulk-delete', [\App\Http\Controllers\Admin\BuyerController::class, 'bulkDelete'])->name('buyers.bulk-delete');
    Route::resource('sellers', \App\Http\Controllers\Admin\SellerController::class);
    Route::get('sellers/{seller}/export-pdf', [\App\Http\Controllers\Admin\SellerController::class, 'exportPdf'])->name('sellers.export-pdf');
    Route::get('sellers-export', [\App\Http\Controllers\Admin\SellerController::class, 'export'])->name('sellers.export');
    Route::get('/sellers/{seller}/login-as', [\App\Http\Controllers\Admin\SellerController::class, 'loginAs'])->name('sellers.login-as');
    Route::delete('/sellers/bulk-delete', [\App\Http\Controllers\Admin\SellerController::class, 'bulkDelete'])->name('sellers.bulk-delete');
    Route::resource('pages', \App\Http\Controllers\Admin\CustomPageController::class)->except(['index', 'create', 'show']);
    Route::resource('subscriptions', \App\Http\Controllers\Admin\AdminSubscriptionController::class);
    Route::resource('home-sales', \App\Http\Controllers\Admin\HomeSaleController::class);

    // Home Sale Items routes
    Route::get('/home-sales/{homeSale}/items/create', [\App\Http\Controllers\Admin\HomeSaleItemController::class, 'create'])->name('home-sales.items.create');
    Route::post('/home-sales/{homeSale}/items', [\App\Http\Controllers\Admin\HomeSaleItemController::class, 'store'])->name('home-sales.items.store');
    Route::get('/home-sales/{homeSale}/items/{item}/edit', [\App\Http\Controllers\Admin\HomeSaleItemController::class, 'edit'])->name('home-sales.items.edit');
    Route::put('/home-sales/{homeSale}/items/{item}', [\App\Http\Controllers\Admin\HomeSaleItemController::class, 'update'])->name('home-sales.items.update');
    Route::delete('/home-sales/{homeSale}/items/{item}', [\App\Http\Controllers\Admin\HomeSaleItemController::class, 'destroy'])->name('home-sales.items.destroy');
    Route::post('/home-sales/{homeSale}/items/{item}/toggle-sold', [\App\Http\Controllers\Admin\HomeSaleItemController::class, 'toggleSold'])->name('home-sales.items.toggle-sold');

    // Live Chat routes
    Route::get('/chats', [\App\Http\Controllers\ChatController::class, 'adminIndex'])->name('chats.index');
    Route::get('/chats/{chat}', [\App\Http\Controllers\ChatController::class, 'adminShow'])->name('chats.show');
    Route::post('/chats/{chat}/reply', [\App\Http\Controllers\ChatController::class, 'adminReply'])->name('chats.reply');
    Route::post('/chats/{chat}/typing', [\App\Http\Controllers\ChatController::class, 'setTyping'])->name('chats.typing');
    Route::get('/chats/{chat}/typing', [\App\Http\Controllers\ChatController::class, 'getTyping'])->name('chats.typing.get');
    Route::post('/chats/{chat}/upload', [\App\Http\Controllers\ChatController::class, 'uploadFile'])->name('chats.upload');
    Route::delete('/chats/{chat}/messages/{message}', [\App\Http\Controllers\ChatController::class, 'destroyMessage'])->name('chats.messages.destroy');
});

Route::middleware(['auth', 'role:Seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\SellerController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/stats', [\App\Http\Controllers\SellerController::class, 'dashboardStats'])->name('dashboard.stats');
    Route::get('/dashboard/widgets', [\App\Http\Controllers\SellerController::class, 'dashboardWidgets'])->name('dashboard.widgets');
    Route::get('/products', [\App\Http\Controllers\SellerController::class, 'productsIndex'])->name('products.index');
    Route::get('/products/create', [\App\Http\Controllers\SellerController::class, 'productsCreate'])->name('products.create');
    Route::post('/products', [\App\Http\Controllers\SellerController::class, 'productsStore'])->name('products.store');
    Route::get('/products/{product}', [\App\Http\Controllers\SellerController::class, 'productsShow'])->name('products.show');
    Route::get('/products/{product}/edit', [\App\Http\Controllers\SellerController::class, 'productsEdit'])->name('products.edit');
    Route::patch('/products/{product}', [\App\Http\Controllers\SellerController::class, 'productsUpdate'])->name('products.update');
    Route::delete('/products/{product}', [\App\Http\Controllers\SellerController::class, 'productsDestroy'])->name('products.destroy');
    Route::get('/exchanges', [\App\Http\Controllers\SellerController::class, 'exchangesIndex'])->name('exchanges.index');
    Route::get('/exchanges/{exchange}', [\App\Http\Controllers\SellerController::class, 'exchangesShow'])->name('exchanges.show');
    Route::patch('/exchanges/{exchange}', [\App\Http\Controllers\SellerController::class, 'exchangesUpdate'])->name('exchanges.update');
    Route::get('/rentals', [\App\Http\Controllers\SellerController::class, 'rentalsIndex'])->name('rentals.index');
    Route::get('/rentals/{rental}', [\App\Http\Controllers\SellerController::class, 'rentalsShow'])->name('rentals.show');
    Route::patch('/rentals/{rental}', [\App\Http\Controllers\SellerController::class, 'rentalsUpdate'])->name('rentals.update');
    Route::get('/account', [\App\Http\Controllers\SellerController::class, 'accountEdit'])->name('account.edit');
    Route::patch('/account', [\App\Http\Controllers\SellerController::class, 'accountUpdate'])->name('account.update');

    // Seller Chat routes
    Route::get('/chats', [App\Http\Controllers\SellerController::class, 'chatsIndex'])->name('chats.index');
    Route::get('/chats/{chat}', [App\Http\Controllers\SellerController::class, 'chatsShow'])->name('chats.show');
    Route::post('/chats', [App\Http\Controllers\SellerController::class, 'chatsStore'])->name('chats.store');
    Route::get('/chats/admin/new', [App\Http\Controllers\SellerController::class, 'chatWithAdmin'])->name('chats.admin');
    Route::get('/api/chats/unread-count', [App\Http\Controllers\SellerController::class, 'unreadChatsCount'])->name('chats.unread-count');
    Route::get('/api/chats/notifications', [App\Http\Controllers\SellerController::class, 'newMessageNotifications'])->name('chats.notifications');
    Route::post('/chats/{chat}/typing', [App\Http\Controllers\ChatController::class, 'setTyping'])->name('chats.typing');
    Route::get('/chats/{chat}/typing', [App\Http\Controllers\ChatController::class, 'getTyping'])->name('chats.typing.get');
    Route::post('/chats/{chat}/upload', [App\Http\Controllers\ChatController::class, 'uploadFile'])->name('chats.upload');
    Route::delete('/chats/{chat}/messages/{message}', [App\Http\Controllers\ChatController::class, 'destroyMessage'])->name('chats.messages.destroy');
});

// Public routes for browsing
Route::get('/products', [\App\Http\Controllers\PublicProductController::class, 'index'])->name('products.index');
Route::get('/home-sales', [\App\Http\Controllers\PublicHomeSaleController::class, 'index'])->name('home-sales.index');
Route::get('/home-sales/search', [\App\Http\Controllers\PublicHomeSaleController::class, 'search'])->name('home-sales.search');
Route::get('/home-sales/{homeSale}', [\App\Http\Controllers\PublicHomeSaleController::class, 'show'])->name('home-sales.show');
Route::post('/home-sales/contact', [\App\Http\Controllers\PublicHomeSaleController::class, 'contact'])->name('home-sales.contact');
Route::get('/exchanges', [\App\Http\Controllers\PublicProductController::class, 'exchanges'])->name('exchanges.index');
Route::get('/giveaways', [\App\Http\Controllers\PublicProductController::class, 'giveaways'])->name('giveaways.index');
Route::get('/products/{product}', [\App\Http\Controllers\PublicProductController::class, 'show'])->name('products.show');
Route::get('/shop', [\App\Http\Controllers\PublicProductController::class, 'shop'])->name('shop');
Route::post('/contact-seller', [\App\Http\Controllers\PublicProductController::class, 'contactSeller'])->name('products.contact');
Route::post('/products/{product}/rent', [\App\Http\Controllers\PublicProductController::class, 'requestRental'])->name('products.rent')->middleware('auth');

// Visitor public chat routes (no auth required)
Route::post('/visitor/chat', [\App\Http\Controllers\ChatController::class, 'visitorStore'])->name('visitor.chat.store');
Route::get('/visitor/chat/{chat}', [\App\Http\Controllers\ChatController::class, 'visitorShow'])->name('visitor.chat.show');
Route::get('/visitor/chat/{chat}/messages', [\App\Http\Controllers\ChatController::class, 'visitorMessages'])->name('visitor.chat.messages');
Route::post('/visitor/chat/{chat}/messages', [\App\Http\Controllers\ChatController::class, 'visitorSendMessage'])->name('visitor.chat.send');
Route::post('/visitor/chat/{chat}/typing', [\App\Http\Controllers\ChatController::class, 'setTyping'])->name('visitor.chat.typing');
Route::get('/visitor/chat/{chat}/typing', [\App\Http\Controllers\ChatController::class, 'getTyping'])->name('visitor.chat.typing.get');

// Messaging routes
Route::middleware('auth')->group(function () {
    Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'inbox'])->name('messages.inbox');
    Route::get('/messages/sent', [\App\Http\Controllers\MessageController::class, 'sent'])->name('messages.sent');
    Route::get('/messages/create', [\App\Http\Controllers\MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages', [\App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{message}', [\App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{message}/read', [\App\Http\Controllers\MessageController::class, 'markAsRead'])->name('messages.mark-read');
    Route::get('/messages/unread-count', [\App\Http\Controllers\MessageController::class, 'unreadCount'])->name('messages.unread-count');
});
Route::get('/sellers/{user}/products', [\App\Http\Controllers\PublicProductController::class, 'sellerProducts'])->name('sellers.products');
Route::get('/location/{location}/products', [\App\Http\Controllers\PublicProductController::class, 'locationProducts'])->name('products.location');
Route::get('/api/search', [\App\Http\Controllers\PublicProductController::class, 'search'])->name('api.search');
Route::get('/pages/{page}', [\App\Http\Controllers\PageController::class, 'show'])->name('pages.show');
Route::get('/privacy-policy', function () {
    return view('pages.privacy-policy');
})->name('privacy-policy');
Route::get('/contact', [\App\Http\Controllers\PageController::class, 'showContact'])->name('contact');
Route::post('/contact', [\App\Http\Controllers\PageController::class, 'submitContact'])->name('contact.submit');
Route::get('/categories', [\App\Http\Controllers\PublicCategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [\App\Http\Controllers\PublicCategoryController::class, 'show'])->name('categories.show');
Route::get('/blogs', [\App\Http\Controllers\PublicBlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{blog}', [\App\Http\Controllers\PublicBlogController::class, 'show'])->name('blogs.show');
Route::post('/blogs/{blog}/comments', [\App\Http\Controllers\PublicBlogController::class, 'storeComment'])->name('blogs.comments.store')->middleware('auth');

// Authenticated buyer routes
Route::middleware(['auth'])->prefix('buyer')->name('buyer.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\BuyerController::class, 'dashboard'])->name('dashboard');
    Route::get('/exchanges', [\App\Http\Controllers\BuyerController::class, 'exchangesIndex'])->name('exchanges.index');
    Route::get('/exchanges/create', [\App\Http\Controllers\BuyerController::class, 'exchangesCreate'])->name('exchanges.create');
    Route::post('/exchanges', [\App\Http\Controllers\BuyerController::class, 'exchangesStore'])->name('exchanges.store');
    Route::get('/exchanges/{exchange}', [\App\Http\Controllers\BuyerController::class, 'exchangesShow'])->name('exchanges.show');
    Route::patch('/exchanges/{exchange}', [\App\Http\Controllers\BuyerController::class, 'exchangesUpdate'])->name('exchanges.update');
    Route::get('/rentals', [\App\Http\Controllers\RentalController::class, 'myRentals'])->name('rentals.index');
    Route::get('/rentals/{rental}', [\App\Http\Controllers\RentalController::class, 'show'])->name('rentals.show');
    Route::patch('/rentals/{rental}', [\App\Http\Controllers\RentalController::class, 'update'])->name('rentals.update');
    Route::get('/account', [\App\Http\Controllers\BuyerController::class, 'accountEdit'])->name('account.edit');
    Route::patch('/account', [\App\Http\Controllers\BuyerController::class, 'accountUpdate'])->name('account.update');

    // Buyer Chat routes
    Route::get('/chats', [App\Http\Controllers\BuyerController::class, 'chatsIndex'])->name('chats.index');
    Route::get('/chats/{chat}', [App\Http\Controllers\BuyerController::class, 'chatsShow'])->name('chats.show');
    Route::post('/chats', [App\Http\Controllers\BuyerController::class, 'chatsStore'])->name('chats.store');
    Route::get('/chats/admin/new', [App\Http\Controllers\BuyerController::class, 'chatWithAdmin'])->name('chats.admin');
    Route::get('/api/chats/unread-count', [App\Http\Controllers\BuyerController::class, 'unreadChatsCount'])->name('chats.unread-count');
    Route::post('/chats/{chat}/typing', [App\Http\Controllers\ChatController::class, 'setTyping'])->name('chats.typing');
    Route::get('/chats/{chat}/typing', [App\Http\Controllers\ChatController::class, 'getTyping'])->name('chats.typing.get');
    Route::post('/chats/{chat}/upload', [App\Http\Controllers\ChatController::class, 'uploadFile'])->name('chats.upload');
    Route::delete('/chats/{chat}/messages/{message}', [App\Http\Controllers\ChatController::class, 'destroyMessage'])->name('chats.messages.destroy');
});

// Exchange payment routes
Route::middleware(['auth'])->group(function () {
    Route::post('/exchanges/{exchange}/payment', [\App\Http\Controllers\ExchangeController::class, 'processPayment'])->name('exchange.payment.process');
    Route::get('/exchanges/{exchange}/payment/success', [\App\Http\Controllers\ExchangeController::class, 'paymentSuccess'])->name('exchange.payment.success');
    Route::post('/exchanges/{exchange}/payment/callback', [\App\Http\Controllers\ExchangeController::class, 'paymentCallback'])->name('exchange.payment.callback');
});

// Giveaway request routes
Route::middleware(['auth'])->group(function () {
    Route::post('/products/{product}/giveaway-request', [\App\Http\Controllers\GiveawayRequestController::class, 'store'])->name('giveaway.request.store');
    Route::patch('/giveaway-requests/{giveawayRequest}', [\App\Http\Controllers\GiveawayRequestController::class, 'update'])->name('giveaway.request.update');
});

Route::get('login/facebook', [App\Http\Controllers\Auth\SocialLoginController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [App\Http\Controllers\Auth\SocialLoginController::class, 'handleFacebookCallback']);

Route::get('login/google', [App\Http\Controllers\Auth\SocialLoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [App\Http\Controllers\Auth\SocialLoginController::class, 'handleGoogleCallback']);

// Subscription routes
Route::middleware('auth')->group(function () {
    Route::get('/subscribe/{plan}', [App\Http\Controllers\SubscriptionController::class, 'subscribe'])->name('subscribe');
    Route::post('/subscribe/{plan}', [App\Http\Controllers\SubscriptionController::class, 'processSubscription'])->name('subscribe.process');
    Route::get('/subscriptions', [App\Http\Controllers\SubscriptionController::class, 'userSubscriptions'])->name('subscriptions');
    Route::post('/subscriptions/{subscription}/cancel', [App\Http\Controllers\SubscriptionController::class, 'cancel'])->name('subscriptions.cancel');

    // Payment routes
    Route::post('/payment/process/{plan}', [App\Http\Controllers\PaymentController::class, 'processPayment'])->name('payment.process');
    Route::match(['GET', 'POST'], '/payment/vipps/create', [App\Http\Controllers\PaymentController::class, 'createVippsPayment'])->name('payment.vipps.create');
    Route::get('/payment/vipps/success/{subscription}', [App\Http\Controllers\PaymentController::class, 'vippsPaymentSuccess'])->name('payment.vipps.success');
    Route::post('/payment/vipps/callback/{subscription}', [App\Http\Controllers\PaymentController::class, 'vippsPaymentCallback'])->name('payment.vipps.callback');
});

// Admin payment routes
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::post('/admin/payments/{payment}/approve', [App\Http\Controllers\PaymentController::class, 'approveCashPayment'])->name('admin.payments.approve');
    Route::post('/admin/payments/{payment}/reject', [App\Http\Controllers\PaymentController::class, 'rejectCashPayment'])->name('admin.payments.reject');
});

// Vipps webhook (no auth required)
Route::post('/payment/vipps/webhook', [App\Http\Controllers\PaymentController::class, 'handleVippsWebhook'])->name('payment.vipps.webhook');
Route::post('/checkout/vipps/callback/{order_ids}', [\App\Http\Controllers\CheckoutController::class, 'vippsCallback'])->name('checkout.vipps.callback');

// Notification routes
Route::middleware('auth')->group(function () {
    Route::get('/api/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('api.notifications');
    Route::post('/api/notifications/{notification}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('api.notifications.read');
    Route::post('/api/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('api.notifications.mark-all-read');
    Route::get('/api/notifications/unread-count', [App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('api.notifications.unread-count');
    Route::delete('/api/notifications/{notification}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('api.notifications.destroy');
});

// Language routes
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');
Route::get('/api/language/current', [LanguageController::class, 'current'])->name('api.language.current')->withoutMiddleware(['auth']);
Route::post('/api/language/translate', [LanguageController::class, 'translate'])->name('api.language.translate')->withoutMiddleware(['auth', \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// Development OTP testing route (only available in local environment)
if (app()->environment('local')) {
    Route::get('/dev/otp-codes', function () {
        $otps = \App\Models\Otp::latest()->take(10)->get();

        return view('dev.otp-codes', compact('otps'));
    })->name('dev.otp-codes');
}

require __DIR__.'/auth.php';
