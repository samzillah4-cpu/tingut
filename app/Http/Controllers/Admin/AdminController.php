<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Exchange;
use App\Models\Product;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get statistics for the admin dashboard
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalExchanges = Exchange::count();
        $totalRentals = Rental::count();
        $totalCategories = Category::count();

        $activeProducts = Product::where('status', 'active')->count();
        $pendingExchanges = Exchange::where('status', 'pending')->count();
        $pendingRentals = Rental::where('status', 'pending')->count();

        $recentUsers = User::latest()->take(5)->get();
        $recentProducts = Product::with('user')->latest()->take(5)->get();
        $recentExchanges = Exchange::with(['offeredProduct', 'requestedProduct', 'proposer'])->latest()->take(5)->get();

        // User role statistics
        $adminCount = User::role('Admin')->count();
        $sellerCount = User::role('Seller')->count();
        $buyerCount = User::role('Customer')->count();

        // Additional statistics for enhanced dashboard
        $completedExchanges = Exchange::where('status', 'completed')->count();
        $rejectedExchanges = Exchange::where('status', 'rejected')->count();
        $completedRentals = Rental::where('status', 'completed')->count();
        $inactiveProducts = Product::where('status', 'inactive')->count();

        // Monthly statistics for the last 12 months
        $monthlyUsers = [];
        $monthlyProducts = [];
        $monthlyExchanges = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyUsers[] = User::whereYear('created_at', $date->year)->whereMonth('created_at', $date->month)->count();
            $monthlyProducts[] = Product::whereYear('created_at', $date->year)->whereMonth('created_at', $date->month)->count();
            $monthlyExchanges[] = Exchange::whereYear('created_at', $date->year)->whereMonth('created_at', $date->month)->count();
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalProducts',
            'totalExchanges',
            'totalRentals',
            'totalCategories',
            'activeProducts',
            'pendingExchanges',
            'pendingRentals',
            'recentUsers',
            'recentProducts',
            'recentExchanges',
            'adminCount',
            'sellerCount',
            'buyerCount',
            'completedExchanges',
            'rejectedExchanges',
            'completedRentals',
            'inactiveProducts',
            'monthlyUsers',
            'monthlyProducts',
            'monthlyExchanges'
        ));
    }

    public function settings()
    {
        $settings = \App\Models\Setting::all()->pluck('value', 'key')->toArray();

        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        // Handle checkbox inputs that might be submitted as arrays (hidden + checkbox)
        $checkboxFields = [
            'facebook_login_enabled',
            'google_login_enabled',
            'email_verification_required',
            'auto_approve_sellers',
            'bankid_enabled',
            'bankid_required_for_login',
            'bankid_required_for_registration',
        ];

        foreach ($checkboxFields as $field) {
            if ($request->has($field)) {
                $value = $request->input($field);
                // If it's an array (from hidden + checkbox), get the checkbox value (usually '1')
                if (is_array($value)) {
                    $request->merge([$field => in_array('1', $value) ? '1' : '0']);
                }
            } else {
                $request->merge([$field => '0']);
            }
        }

        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string|max:20',
            'currency' => 'required|in:USD,EUR,GBP,NOK,SEK,DKK',
            'ecommerce_commission_rate' => 'nullable|numeric|min:0|max:100',
            'maintenance_mode' => 'boolean',
            'registration_enabled' => 'boolean',
            'max_products_per_user' => 'nullable|integer|min:1',
            'max_exchanges_per_user' => 'nullable|integer|min:1',
            'default_user_role' => 'required|in:Customer,Seller',
            'email_verification_required' => 'boolean',
            'auto_approve_sellers' => 'boolean',
            'session_timeout' => 'nullable|integer|min:15|max:1440',
            'site_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:1024',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'facebook_login_enabled' => 'boolean',
            'facebook_app_id' => 'nullable|string|max:255',
            'facebook_app_secret' => 'nullable|string|max:255',
            'google_login_enabled' => 'boolean',
            'google_client_id' => 'nullable|string|max:255',
            'google_client_secret' => 'nullable|string|max:255',
            'smtp_host' => 'nullable|string|max:255',
            'smtp_port' => 'nullable|integer|min:1|max:65535',
            'smtp_encryption' => 'nullable|in:tls,ssl,none',
            'smtp_username' => 'nullable|string|max:255',
            'smtp_password' => 'nullable|string|max:255',
            'from_email' => 'nullable|email',
            'from_name' => 'nullable|string|max:255',
            'topbar_bg_color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'primary_color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'footer_bg_color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'footer_link_color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'footer_copyright_text' => 'nullable|string|max:255',
            'footer_description' => 'nullable|string|max:500',
            'footer_custom_html' => 'nullable|string',
            'custom_chat_enabled' => 'boolean',
            'renting_enabled' => 'boolean',
            'auto_approve_rentals' => 'boolean',
            'rental_commission_rate' => 'nullable|numeric|min:0|max:100',
            'max_rental_duration_days' => 'nullable|integer|min:1|max:365',
            'rental_terms_template' => 'nullable|string|max:2000',
            'rental_deposit_required' => 'boolean',
            'default_deposit_percentage' => 'nullable|numeric|min:0|max:200',
            'rental_payment_upfront' => 'boolean',
            'rental_cancellation_deadline_hours' => 'nullable|integer|min:1|max:168',
            'vipps_environment' => 'nullable|in:test,production',
            'vipps_client_id' => 'nullable|string|max:255',
            'vipps_client_secret' => 'nullable|string|max:255',
            'vipps_subscription_key' => 'nullable|string|max:255',
            'vipps_merchant_serial_number' => 'nullable|string|max:255',
            'vipps_webhook_secret' => 'nullable|string|max:255',
            // Bank ID settings
            'bankid_enabled' => 'boolean',
            'bankid_environment' => 'nullable|in:test,production',
            'bankid_required_for_login' => 'boolean',
            'bankid_required_for_registration' => 'boolean',
            'bankid_client_id' => 'nullable|string|max:255',
            'bankid_client_secret' => 'nullable|string|max:255',
            'bankid_rp_client_id' => 'nullable|string|max:255',
            'bankid_rp_client_secret' => 'nullable|string|max:255',
        ]);

        // Handle file uploads
        if ($request->hasFile('site_logo')) {
            $logoPath = $request->file('site_logo')->store('logos', 'public');
            $validated['site_logo'] = $logoPath;
        }

        if ($request->hasFile('favicon')) {
            $faviconFile = $request->file('favicon');
            $faviconPath = $faviconFile->store('favicons', 'public');

            // Resize favicon to 32x32
            $imagePath = storage_path('app/public/'.$faviconPath);
            $image = imagecreatefromstring(file_get_contents($imagePath));

            if ($image !== false) {
                $resizedImage = imagescale($image, 32, 32);
                imagepng($resizedImage, $imagePath);
                imagedestroy($image);
                imagedestroy($resizedImage);
            }

            $validated['favicon'] = $faviconPath;
        }

        // Handle logo removal
        if ($request->has('remove_logo') && $request->input('remove_logo') == '1') {
            $currentLogo = \App\Models\Setting::where('key', 'site_logo')->first();
            if ($currentLogo && $currentLogo->value) {
                // Delete the file
                \Storage::disk('public')->delete($currentLogo->value);
            }
            $validated['site_logo'] = null;
        }

        // Handle favicon removal
        if ($request->has('remove_favicon') && $request->input('remove_favicon') == '1') {
            $currentFavicon = \App\Models\Setting::where('key', 'favicon')->first();
            if ($currentFavicon && $currentFavicon->value) {
                // Delete the file
                \Storage::disk('public')->delete($currentFavicon->value);
            }
            $validated['favicon'] = null;
        }

        foreach ($validated as $key => $value) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Save any additional settings that aren't in validation but are in the request
        $allSettings = $request->except(['_token', '_method']);
        $validatedKeys = array_keys($validated);

        foreach ($allSettings as $key => $value) {
            if (! in_array($key, $validatedKeys) && ! is_array($value)) {
                \App\Models\Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => is_bool($value) ? ($value ? '1' : '0') : $value]
                );
            }
        }

        // Clear config cache so new settings take effect
        if (app()->environment('production')) {
            \Artisan::call('config:clear');
        }

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }

    public function systemLogs()
    {
        $logFile = storage_path('logs/laravel.log');

        $logs = [];
        if (file_exists($logFile)) {
            // Read the last 1000 lines of the log file
            $lines = $this->tail($logFile, 1000);
            $logs = array_reverse($lines); // Show newest first
        }

        return view('admin.system.logs', compact('logs'));
    }

    public function clearSystemLogs()
    {
        $logFile = storage_path('logs/laravel.log');

        if (file_exists($logFile)) {
            // Clear the log file by writing an empty string
            file_put_contents($logFile, '');
        }

        return response()->json(['success' => true, 'message' => 'System logs cleared successfully']);
    }

    private function tail($filename, $lines = 10)
    {
        $data = file($filename);
        if (! $data) {
            return [];
        }

        $slice = array_slice($data, -$lines);

        return array_map('trim', $slice);
    }
}
