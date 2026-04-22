<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exchange;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExchangeController extends Controller
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
        $query = Exchange::with(['proposer', 'receiver', 'offeredProduct', 'requestedProduct']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by proposer or receiver name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('proposer', function($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%");
                })->orWhereHas('receiver', function($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%");
                });
            });
        }

        $exchanges = $query->paginate(15);

        return view('admin.exchanges.index', compact('exchanges'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $products = Product::with('user')->get();
        return view('admin.exchanges.create', compact('users', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'proposer_id' => 'required|exists:users,id',
            'offered_product_id' => 'required|exists:products,id',
            'receiver_id' => 'required|exists:users,id|different:proposer_id',
            'requested_product_id' => 'required|exists:products,id|different:offered_product_id',
            'status' => 'required|in:pending,accepted,rejected,completed',
        ]);

        // Ensure offered product belongs to proposer
        $offeredProduct = Product::find($request->offered_product_id);
        if ($offeredProduct->user_id != $request->proposer_id) {
            return back()->withErrors(['offered_product_id' => 'Offered product must belong to the proposer.']);
        }

        // Ensure requested product belongs to receiver
        $requestedProduct = Product::find($request->requested_product_id);
        if ($requestedProduct->user_id != $request->receiver_id) {
            return back()->withErrors(['requested_product_id' => 'Requested product must belong to the receiver.']);
        }

        Exchange::create($request->only(['proposer_id', 'offered_product_id', 'receiver_id', 'requested_product_id', 'status']));

        return redirect()->route('admin.exchanges.index')->with('success', 'Exchange created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Exchange $exchange)
    {
        $exchange->load(['proposer', 'receiver', 'offeredProduct.category', 'requestedProduct.category']);
        return view('admin.exchanges.show', compact('exchange'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exchange $exchange)
    {
        $exchange->load(['proposer', 'receiver', 'offeredProduct', 'requestedProduct']);
        return view('admin.exchanges.edit', compact('exchange'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exchange $exchange)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected,completed',
        ]);

        $exchange->update($request->only(['status']));

        return redirect()->route('admin.exchanges.index')->with('success', 'Exchange updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exchange $exchange)
    {
        $exchange->delete();

        return redirect()->route('admin.exchanges.index')->with('success', 'Exchange deleted successfully.');
    }

    /**
     * Export exchanges to PDF.
     */
    public function exportPdf(Request $request)
    {
        // Get the same query as the index method to respect current filters
        $query = Exchange::with(['proposer', 'receiver', 'offeredProduct.category', 'requestedProduct.category']);

        // Apply the same filters as in index method
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('proposer', function($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%");
                })->orWhereHas('receiver', function($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%");
                });
            });
        }

        $exchanges = $query->get();

        // Get dynamic settings
        $settings = \App\Models\Setting::all()->pluck('value', 'key')->toArray();
        $siteName = $settings['site_name'] ?? 'TingUt.no';
        $siteDescription = $settings['site_description'] ?? 'Barter Trading Platform';
        $contactEmail = $settings['contact_email'] ?? 'admin@tingut.no';
        $contactPhone = $settings['contact_phone'] ?? '';

        // Calculate statistics
        $totalExchanges = $exchanges->count();
        $pendingExchanges = $exchanges->where('status', 'pending')->count();
        $acceptedExchanges = $exchanges->where('status', 'accepted')->count();
        $completedExchanges = $exchanges->where('status', 'completed')->count();
        $rejectedExchanges = $exchanges->where('status', 'rejected')->count();

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
                .stats-section { background: #f8f9fa; padding: 12px; border-radius: 6px; margin: 15px 0; }
                .stats-title { font-size: 14px; font-weight: bold; color: #1a6969; margin-bottom: 10px; }
                .stats-grid { display: flex; gap: 15px; margin-bottom: 10px; }
                .stat-box { flex: 1; background: #e9ecef; padding: 8px; border-radius: 4px; text-align: center; }
                .stat-number { font-size: 16px; font-weight: bold; color: #1a6969; }
                .stat-label { font-size: 9px; color: #666; margin-top: 2px; }
                table { width: 100%; border-collapse: collapse; margin: 15px 0; font-size: 10px; }
                th, td { padding: 6px; text-align: left; border: 1px solid #ddd; }
                th { background-color: #1a6969; color: white; font-weight: bold; font-size: 10px; }
                tr:nth-child(even) { background-color: #f9f9f9; }
                .badge { padding: 2px 6px; border-radius: 3px; font-size: 9px; font-weight: bold; }
                .badge-success { background: #28a745; color: white; }
                .badge-warning { background: #ffc107; color: black; }
                .badge-danger { background: #dc3545; color: white; }
                .badge-info { background: #17a2b8; color: white; }
                .badge-secondary { background: #6c757d; color: white; }
                .footer { margin-top: 30px; padding-top: 15px; border-top: 1px solid #ddd; font-size: 9px; color: #666; text-align: center; }
                .contact-info { margin-bottom: 8px; }
                .section-break { page-break-before: always; }
                .exchange-details { margin: 6px 0; }
                .product-info { font-size: 9px; color: #666; margin-top: 2px; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1 class="site-name">' . htmlspecialchars($siteName) . '</h1>
                <p class="site-description">' . htmlspecialchars($siteDescription) . '</p>
                <h2 class="report-title">Exchange Report</h2>
                <p class="report-meta">Generated on ' . date('M d, Y H:i:s') . '</p>
            </div>

            <div class="stats-section">
                <div class="stats-title">Exchange Statistics</div>
                <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div><strong>Total Exchanges:</strong> ' . $totalExchanges . '</div>
                        <div><strong>Pending:</strong> ' . $pendingExchanges . '</div>
                        <div><strong>Accepted:</strong> ' . $acceptedExchanges . '</div>
                        <div><strong>Completed:</strong> ' . $completedExchanges . '</div>
                        <div><strong>Rejected:</strong> ' . $rejectedExchanges . '</div>
                    </div>
                </div>
            </div>';

        if ($exchanges->count() > 0) {
            $html .= '
            <div class="stats-section">
                <div class="stats-title">Exchange Details</div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Proposer ID</th>
                            <th>Offered Product ID</th>
                            <th>Receiver ID</th>
                            <th>Requested Product ID</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach ($exchanges as $exchange) {
                $html .= '
                        <tr>
                            <td>' . $exchange->id . '</td>
                            <td>' . $exchange->proposer_id . '</td>
                            <td>' . $exchange->offered_product_id . '</td>
                            <td>' . $exchange->receiver_id . '</td>
                            <td>' . $exchange->requested_product_id . '</td>
                            <td><span class="badge badge-' .
                                ($exchange->status === 'completed' ? 'success' :
                                ($exchange->status === 'pending' ? 'warning' :
                                ($exchange->status === 'accepted' ? 'info' :
                                ($exchange->status === 'rejected' ? 'danger' : 'secondary')))) . '">' . ucfirst($exchange->status) . '</span></td>
                            <td>' . $exchange->created_at->format('M d, Y H:i:s') . '</td>
                            <td>' . $exchange->updated_at->format('M d, Y H:i:s') . '</td>
                        </tr>';
            }

            $html .= '
                    </tbody>
                </table>
            </div>';
        } else {
            $html .= '
            <div class="stats-section">
                <div style="text-align: center; padding: 20px;">
                    <div style="font-size: 14px; color: #666; margin-bottom: 10px;">No exchanges found</div>
                    <div style="font-size: 10px; color: #999;">' . ($request->filled('status') || $request->filled('search') ? 'Try adjusting your filters' : 'No exchanges have been created yet') . '</div>
                </div>
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

        $filename = 'exchanges_report_' . date('Y-m-d_H-i-s') . '.pdf';
        if ($request->filled('status')) {
            $filename = 'exchanges_' . $request->status . '_' . date('Y-m-d_H-i-s') . '.pdf';
        }

        return $pdf->download($filename);
    }
}
