<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Admin');
    }

    /**
     * Display a listing of sellers.
     */
    public function index(Request $request)
    {
        $query = User::role('Seller')->with(['subscriptions.plan'])->withCount(['products', 'proposedExchanges' => function($query) {
            $query->where('status', 'completed');
        }, 'receivedExchanges' => function($query) {
            $query->where('status', 'completed');
        }]);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $sellers = $query->paginate(15);

        // Handle AJAX requests for live search
        if ($request->ajax()) {
            return view('admin.sellers.partials.table', compact('sellers'))->render();
        }

        return view('admin.sellers.index', compact('sellers'));
    }

    /**
     * Show the form for creating a new seller.
     */
    public function create()
    {
        return view('admin.sellers.create');
    }

    /**
     * Store a newly created seller in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'location' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'location' => $request->location,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole('Seller'); // Assign seller role

        return redirect()->route('admin.sellers.index')->with('success', 'Seller created successfully.');
    }

    /**
     * Display the specified seller.
     */
    public function show(User $seller)
    {
        // Ensure user is a seller
        if (!$seller->hasRole('Seller')) {
            abort(404);
        }

        $seller->load(['products' => function($query) {
            $query->with('category')->latest();
        }]);

        return view('admin.sellers.show', compact('seller'));
    }

    /**
     * Export seller details to PDF.
     */
    public function exportPdf(User $seller)
    {
        // Ensure user is a seller
        if (!$seller->hasRole('Seller')) {
            abort(404);
        }

        // Load all necessary relationships
        $seller->load([
            'products' => function($query) {
                $query->with('category')->latest();
            },
            'subscriptions.plan'
        ]);

        // Get dynamic settings
        $settings = \App\Models\Setting::all()->pluck('value', 'key')->toArray();
        $siteName = $settings['site_name'] ?? 'TingUt.no';
        $siteDescription = $settings['site_description'] ?? 'Barter Trading Platform';
        $contactEmail = $settings['contact_email'] ?? 'admin@tingut.no';
        $contactPhone = $settings['contact_phone'] ?? '';

        // Get subscription info
        $activeSubscription = $seller->subscriptions()->where('status', 'active')->where('end_date', '>', now())->first();

        // Get exchange stats
        $proposedExchanges = $seller->proposedExchanges;
        $receivedExchanges = $seller->receivedExchanges;
        $totalExchanges = $proposedExchanges->count() + $receivedExchanges->count();
        $completedExchanges = $proposedExchanges->where('status', 'completed')->count() + $receivedExchanges->where('status', 'completed')->count();
        $pendingExchanges = $proposedExchanges->where('status', 'pending')->count() + $receivedExchanges->where('status', 'pending')->count();

        $html = '
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; margin: 15px; color: #333; font-size: 12px; line-height: 1.4; }
                .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #1a6969; padding-bottom: 15px; }
                .site-name { font-size: 20px; font-weight: bold; color: #1a6969; margin: 0; }
                .site-description { font-size: 11px; color: #666; margin: 3px 0; }
                .report-title { font-size: 16px; color: #333; margin: 15px 0 5px 0; font-weight: bold; }
                .report-meta { font-size: 10px; color: #666; margin-bottom: 15px; }
                .seller-info { background: #f8f9fa; padding: 12px; border-radius: 6px; margin: 15px 0; }
                .info-section { margin-bottom: 15px; }
                .info-title { font-size: 14px; font-weight: bold; color: #1a6969; margin-bottom: 8px; border-bottom: 1px solid #1a6969; padding-bottom: 3px; }
                .info-grid { display: table; width: 100%; margin-bottom: 10px; }
                .info-row { display: table-row; }
                .info-label { display: table-cell; font-weight: bold; width: 120px; padding: 3px 0; font-size: 11px; }
                .info-value { display: table-cell; padding: 3px 0; font-size: 11px; }
                .stats-grid { display: flex; gap: 10px; margin: 15px 0; }
                .stat-box { flex: 1; background: #e9ecef; padding: 10px; border-radius: 6px; text-align: center; }
                .stat-number { font-size: 18px; font-weight: bold; color: #1a6969; }
                .stat-label { font-size: 10px; color: #666; margin-top: 3px; }
                table { width: 100%; border-collapse: collapse; margin: 15px 0; font-size: 10px; }
                th, td { padding: 6px; text-align: left; border: 1px solid #ddd; }
                th { background-color: #1a6969; color: white; font-weight: bold; font-size: 10px; }
                tr:nth-child(even) { background-color: #f9f9f9; }
                .subscription-active { background: #d4edda; border: 1px solid #28a745; }
                .subscription-inactive { background: #f8d7da; border: 1px solid #dc3545; }
                .badge { padding: 2px 6px; border-radius: 3px; font-size: 9px; font-weight: bold; }
                .badge-success { background: #28a745; color: white; }
                .badge-warning { background: #ffc107; color: black; }
                .badge-danger { background: #dc3545; color: white; }
                .badge-info { background: #17a2b8; color: white; }
                .footer { margin-top: 30px; padding-top: 15px; border-top: 1px solid #ddd; font-size: 9px; color: #666; text-align: center; }
                .contact-info { margin-bottom: 8px; }
                .section-break { page-break-before: always; }
                .subscription-details { padding: 10px; border-radius: 4px; margin: 8px 0; }
                .subscription-title { font-size: 13px; margin: 0 0 8px 0; font-weight: bold; }
                .subscription-text { font-size: 10px; margin: 4px 0; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1 class="site-name">' . htmlspecialchars($siteName) . '</h1>
                <p class="site-description">' . htmlspecialchars($siteDescription) . '</p>
                <h2 style="color: #333; margin-top: 20px;">Seller Details Report</h2>
                <p style="color: #666;">Generated on ' . date('M d, Y H:i:s') . '</p>
            </div>

            <div class="seller-info">
                <div class="info-title">Seller Information</div>
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">Full Name:</div>
                        <div class="info-value">' . htmlspecialchars($seller->name) . '</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Email:</div>
                        <div class="info-value">' . htmlspecialchars($seller->email) . '</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Location:</div>
                        <div class="info-value">' . htmlspecialchars($seller->location ?: 'Not specified') . '</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Role:</div>
                        <div class="info-value">' . htmlspecialchars($seller->getRoleNames()->first()) . '</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Member Since:</div>
                        <div class="info-value">' . $seller->created_at->format('M d, Y H:i') . '</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Last Updated:</div>
                        <div class="info-value">' . $seller->updated_at->format('M d, Y H:i') . '</div>
                    </div>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-box">
                    <div class="stat-number">' . $seller->products->count() . '</div>
                    <div class="stat-label">Total Products</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">' . $seller->products->where('status', 'active')->count() . '</div>
                    <div class="stat-label">Active Products</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">' . $totalExchanges . '</div>
                    <div class="stat-label">Total Exchanges</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">' . $completedExchanges . '</div>
                    <div class="stat-label">Completed Exchanges</div>
                </div>
            </div>

            <div class="info-section">
                <div class="info-title">Subscription Status</div>';

        if ($activeSubscription) {
            $html .= '
                <div class="subscription-active subscription-details">
                    <div class="subscription-title" style="color: #155724;">Active Subscription</div>
                    <div class="info-grid">
                        <div class="info-row">
                            <div class="info-label">Plan:</div>
                            <div class="info-value">' . htmlspecialchars($activeSubscription->plan->name) . '</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Price:</div>
                            <div class="info-value">$' . $activeSubscription->plan->price . '/' . $activeSubscription->plan->duration . '</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Products:</div>
                            <div class="info-value">' . ($activeSubscription->plan->max_products == 0 ? 'Unlimited' : $activeSubscription->plan->max_products) . '</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Start:</div>
                            <div class="info-value">' . $activeSubscription->start_date->format('M d, Y') . '</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">End:</div>
                            <div class="info-value">' . $activeSubscription->end_date->format('M d, Y') . ' (' . ($activeSubscription->end_date->isPast() ? 'Expired' : $activeSubscription->end_date->diffForHumans()) . ')</div>
                        </div>
                    </div>
                    <div class="subscription-text" style="font-style: italic;">' . htmlspecialchars($activeSubscription->plan->description) . '</div>
                </div>';
        } else {
            $html .= '
                <div class="subscription-inactive subscription-details">
                    <div class="subscription-title" style="color: #721c24;">No Active Subscription</div>
                    <div class="subscription-text">This seller does not have an active subscription plan.</div>
                </div>';
        }

        $html .= '
            </div>';

        if ($seller->products->count() > 0) {
            $html .= '
            <div class="section-break"></div>
            <div class="info-section">
                <div class="info-title">Products (' . $seller->products->count() . ')</div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach ($seller->products as $product) {
                $html .= '
                        <tr>
                            <td>' . $product->id . '</td>
                            <td style="max-width: 150px; word-wrap: break-word;">' . htmlspecialchars($product->title) . '</td>
                            <td>' . htmlspecialchars($product->category->name ?? 'N/A') . '</td>
                            <td><span class="badge badge-' . ($product->status === 'active' ? 'success' : 'danger') . '">' . ucfirst($product->status) . '</span></td>
                            <td>' . $product->created_at->format('M d, Y') . '</td>
                        </tr>';
            }

            $html .= '
                    </tbody>
                </table>
            </div>';
        }

        if ($totalExchanges > 0) {
            $allExchanges = $proposedExchanges->merge($receivedExchanges)->sortByDesc('created_at');

            $html .= '
            <div class="section-break"></div>
            <div class="info-section">
                <div class="info-title">Exchange History (' . $totalExchanges . ')</div>
                <table>
                    <thead>
                        <tr>
                            <th>Offered</th>
                            <th>Requested</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach ($allExchanges as $exchange) {
                $html .= '
                        <tr>
                            <td style="max-width: 120px; word-wrap: break-word;">' . htmlspecialchars($exchange->offeredProduct ? $exchange->offeredProduct->title : 'Product removed') . '</td>
                            <td style="max-width: 120px; word-wrap: break-word;">' . htmlspecialchars($exchange->requestedProduct ? $exchange->requestedProduct->title : 'Product removed') . '</td>
                            <td>' . ($exchange->proposer_id === $seller->id ? 'Proposer' : 'Receiver') . '</td>
                            <td><span class="badge badge-' .
                                ($exchange->status === 'completed' ? 'success' :
                                ($exchange->status === 'pending' ? 'warning' :
                                ($exchange->status === 'accepted' ? 'info' : 'danger'))) . '">' . ucfirst($exchange->status) . '</span></td>
                            <td>' . $exchange->created_at->format('M d, Y') . '</td>
                        </tr>';
            }

            $html .= '
                    </tbody>
                </table>
            </div>';
        }

        $html .= '
            <div class="footer">
                <div class="contact-info">
                    <strong>Contact Information:</strong><br>
                    Email: ' . htmlspecialchars($contactEmail) . '
                    ' . ($contactPhone ? '<br>Phone: ' . htmlspecialchars($contactPhone) : '') . '
                </div>
                <div>
                    &copy; ' . date('Y') . ' ' . htmlspecialchars($siteName) . '. All rights reserved.<br>
                    <strong>Report Generated:</strong> ' . date('M d, Y H:i:s') . '
                </div>
            </div>
        </body>
        </html>';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
        $pdf->setPaper('a4', 'portrait');
        $filename = 'seller_' . $seller->id . '_' . date('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Show the form for editing the specified seller.
     */
    public function edit(User $seller)
    {
        // Ensure user is a seller
        if (!$seller->hasRole('Seller')) {
            abort(404);
        }

        $subscriptionPlans = \App\Models\SubscriptionPlan::where('is_active', true)->get();
        $activeSubscription = $seller->subscriptions()->where('status', 'active')->where('end_date', '>', now())->first();

        return view('admin.sellers.edit', compact('seller', 'subscriptionPlans', 'activeSubscription'));
    }

    /**
     * Update the specified seller in storage.
     */
    public function update(Request $request, User $seller)
    {
        // Ensure user is a seller
        if (!$seller->hasRole('Seller')) {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $seller->id,
            'phone' => 'nullable|string|max:20',
            'location' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'subscription_plan_id' => 'nullable|exists:subscription_plans,id',
        ]);

        $seller->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'location' => $request->location,
        ]);

        // Update password if provided
        if ($request->filled('password')) {
            $seller->update([
                'password' => bcrypt($request->password),
            ]);
        }

        // Handle subscription assignment
        if ($request->filled('subscription_plan_id')) {
            $plan = \App\Models\SubscriptionPlan::find($request->subscription_plan_id);

            // Cancel any existing active subscription
            $seller->subscriptions()->where('status', 'active')->update(['status' => 'cancelled']);

            // Create new subscription
            $startDate = now();
            $endDate = $plan->duration === 'yearly' ? $startDate->copy()->addYear() : $startDate->copy()->addMonth();

            \App\Models\Subscription::create([
                'user_id' => $seller->id,
                'subscription_plan_id' => $plan->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'active',
            ]);
        }

        return redirect()->route('admin.sellers.show', $seller)->with('success', 'Seller updated successfully.');
    }

    /**
     * Remove the specified seller from storage.
     */
    public function destroy(User $seller)
    {
        // Ensure user is a seller
        if (!$seller->hasRole('Seller')) {
            abort(404);
        }

        // Get counts for confirmation message
        $productCount = $seller->products()->count();
        $exchangeCount = $seller->proposedExchanges()->count() + $seller->receivedExchanges()->count();

        // Delete all associated products and their images
        foreach ($seller->products as $product) {
            // Delete product images from storage
            if ($product->images) {
                foreach ($product->images as $image) {
                    $imagePath = storage_path('app/public/' . $image);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
            }
            $product->delete();
        }

        // Delete the seller account
        $seller->delete();

        return redirect()->route('admin.sellers.index')->with('success',
            "Seller '{$seller->name}' and all associated data ({$productCount} products, {$exchangeCount} exchanges) have been deleted successfully.");
    }

    /**
     * Bulk delete multiple sellers.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:users,id'
        ]);

        $ids = $request->ids;
        $deletedCount = 0;
        $totalProducts = 0;
        $totalExchanges = 0;

        foreach ($ids as $id) {
            $seller = User::find($id);

            // Ensure user is a seller
            if ($seller && $seller->hasRole('Seller')) {
                // Get counts
                $productCount = $seller->products()->count();
                $exchangeCount = $seller->proposedExchanges()->count() + $seller->receivedExchanges()->count();

                $totalProducts += $productCount;
                $totalExchanges += $exchangeCount;

                // Delete all associated products and their images
                foreach ($seller->products as $product) {
                    // Delete product images from storage
                    if ($product->images) {
                        foreach ($product->images as $image) {
                            $imagePath = storage_path('app/public/' . $image);
                            if (file_exists($imagePath)) {
                                unlink($imagePath);
                            }
                        }
                    }
                    $product->delete();
                }

                // Delete the seller account
                $seller->delete();
                $deletedCount++;
            }
        }

        return redirect()->route('admin.sellers.index')->with('success',
            "{$deletedCount} seller(s) and all associated data ({$totalProducts} products, {$totalExchanges} exchanges) have been deleted successfully.");
    }

    /**
     * Login as a specific seller (admin impersonation).
     */
    public function loginAs(User $seller)
    {
        // Ensure user is a seller
        if (!$seller->hasRole('Seller')) {
            abort(404);
        }

        // Store current admin user ID in session for later restoration
        session(['admin_impersonating' => auth()->id()]);

        // Login as the seller
        auth()->login($seller);

        return redirect()->route('seller.dashboard')->with('success', 'You are now logged in as ' . $seller->name);
    }

    /**
     * Export sellers data in various formats.
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');

        // Get the same query as the index method to respect current filters/search
        $query = User::role('Seller')->withCount(['products', 'proposedExchanges' => function($query) {
            $query->where('status', 'completed');
        }, 'receivedExchanges' => function($query) {
            $query->where('status', 'completed');
        }]);

        // Apply the same search filter as in index method
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $sellers = $query->get();

        switch ($format) {
            case 'pdf':
                return $this->exportToPdf($sellers, $request->get('search'));
            case 'xlsx':
                return $this->exportToExcel($sellers);
            case 'csv':
            default:
                return $this->exportToCsv($sellers);
        }
    }

    private function exportToCsv($sellers)
    {
        $filename = 'sellers_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($sellers) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, ['ID', 'Name', 'Email', 'Products Count', 'Exchanges Count', 'Joined Date']);

            // CSV data
            foreach ($sellers as $seller) {
                fputcsv($file, [
                    $seller->id,
                    $seller->name,
                    $seller->email,
                    $seller->products_count,
                    ($seller->proposed_exchanges_count ?? 0) + ($seller->received_exchanges_count ?? 0),
                    $seller->created_at->format('M d, Y')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportToExcel($sellers)
    {
        // For Excel export, we'll use a simple CSV approach since we don't have a full Excel library
        // In a production app, you'd use something like Laravel Excel or PhpSpreadsheet
        return $this->exportToCsv($sellers)->header('Content-Type', 'application/vnd.ms-excel')
                                          ->header('Content-Disposition', 'attachment; filename="sellers_' . date('Y-m-d_H-i-s') . '.xlsx"');
    }

    private function exportToPdf($sellers, $searchTerm = null)
    {
        // For PDF export, we'll create a simple HTML-based PDF
        // In a production app, you'd use something like DomPDF or TCPDF

        $title = 'Sellers Report';
        if ($searchTerm) {
            $title .= ' (Filtered: "' . $searchTerm . '")';
        }

        $html = '
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                h1 { color: #1a6969; border-bottom: 2px solid #1a6969; padding-bottom: 10px; }
                .meta { color: #666; margin-bottom: 20px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
                th { background-color: #f8f9fa; font-weight: bold; }
                tr:nth-child(even) { background-color: #f9f9f9; }
                .total { background-color: #e9ecef; font-weight: bold; }
            </style>
        </head>
        <body>
            <h1>' . $title . '</h1>
            <div class="meta">
                <p><strong>Generated on:</strong> ' . date('M d, Y H:i:s') . '</p>
                <p><strong>Total Sellers:</strong> ' . $sellers->count() . '</p>
                ' . ($searchTerm ? '<p><strong>Search Filter:</strong> ' . $searchTerm . '</p>' : '') . '
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Products</th>
                        <th>Exchanges</th>
                        <th>Joined Date</th>
                    </tr>
                </thead>
                <tbody>';

        $totalProducts = 0;
        $totalExchanges = 0;

        foreach ($sellers as $seller) {
            $productsCount = $seller->products_count;
            $exchangesCount = ($seller->proposed_exchanges_count ?? 0) + ($seller->received_exchanges_count ?? 0);

            $totalProducts += $productsCount;
            $totalExchanges += $exchangesCount;

            $html .= '
                    <tr>
                        <td>' . $seller->id . '</td>
                        <td>' . htmlspecialchars($seller->name) . '</td>
                        <td>' . htmlspecialchars($seller->email) . '</td>
                        <td>' . $productsCount . '</td>
                        <td>' . $exchangesCount . '</td>
                        <td>' . $seller->created_at->format('M d, Y') . '</td>
                    </tr>';
        }

        // Add totals row
        $html .= '
                    <tr class="total">
                        <td colspan="3"><strong>TOTALS</strong></td>
                        <td><strong>' . $totalProducts . '</strong></td>
                        <td><strong>' . $totalExchanges . '</strong></td>
                        <td></td>
                    </tr>';

        $html .= '
                </tbody>
            </table>
        </body>
        </html>';

        $filename = 'sellers_' . date('Y-m-d_H-i-s') . '.pdf';
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        // For now, return HTML as PDF content (in production, use a proper PDF library)
        return response($html, 200, $headers);
    }
}
