<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Admin');
    }

    /**
     * Display a listing of buyers.
     */
    public function index(Request $request)
    {
        $query = User::role('Customer')->withCount(['proposedExchanges' => function($query) {
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

        $buyers = $query->paginate(15);

        // Handle AJAX requests for live search
        if ($request->ajax()) {
            return view('admin.buyers.partials.table', compact('buyers'))->render();
        }

        return view('admin.buyers.index', compact('buyers'));
    }

    /**
     * Display the specified buyer.
     */
    public function show(User $buyer)
    {
        // Ensure user is a buyer
        if (!$buyer->hasRole('Customer')) {
            abort(404);
        }

        $buyer->load(['proposedExchanges' => function($query) {
            $query->with(['offeredProduct', 'requestedProduct'])->latest();
        }, 'receivedExchanges' => function($query) {
            $query->with(['offeredProduct', 'requestedProduct'])->latest();
        }]);

        return view('admin.buyers.show', compact('buyer'));
    }

    /**
     * Show the form for creating a new buyer.
     */
    public function create()
    {
        return view('admin.buyers.create');
    }

    /**
     * Store a newly created buyer in storage.
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

        $user->assignRole('Customer'); // Assign buyer role

        return redirect()->route('admin.buyers.index')->with('success', 'Buyer created successfully.');
    }

    /**
     * Show the form for editing the specified buyer.
     */
    public function edit(User $buyer)
    {
        // Ensure user is a buyer
        if (!$buyer->hasRole('Customer')) {
            abort(404);
        }

        return view('admin.buyers.edit', compact('buyer'));
    }

    /**
     * Update the specified buyer in storage.
     */
    public function update(Request $request, User $buyer)
    {
        // Ensure user is a buyer
        if (!$buyer->hasRole('Customer')) {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $buyer->id,
            'phone' => 'nullable|string|max:20',
            'location' => 'required|string|max:255',
        ]);

        $buyer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'location' => $request->location,
        ]);

        return redirect()->route('admin.buyers.index')->with('success', 'Buyer updated successfully.');
    }

    /**
     * Remove the specified buyer from storage.
     */
    public function destroy(User $buyer)
    {
        // Ensure user is a buyer
        if (!$buyer->hasRole('Customer')) {
            abort(404);
        }

        $buyer->delete();

        return redirect()->route('admin.buyers.index')->with('success', 'Buyer deleted successfully.');
    }

    /**
     * Bulk delete buyers.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:users,id'
        ]);

        $ids = $request->ids;

        // Ensure all users are buyers
        $buyers = User::whereIn('id', $ids)->whereHas('roles', function($query) {
            $query->where('name', 'Customer');
        })->get();

        if ($buyers->count() !== count($ids)) {
            return redirect()->back()->with('error', 'Some selected users are not buyers.');
        }

        User::whereIn('id', $ids)->delete();

        return redirect()->route('admin.buyers.index')->with('success', count($ids) . ' buyer(s) deleted successfully.');
    }

    /**
     * Login as a specific buyer (admin impersonation).
     */
    public function loginAs(User $buyer)
    {
        // Ensure user is a buyer
        if (!$buyer->hasRole('Customer')) {
            abort(404);
        }

        // Store current admin user ID in session for later restoration
        session(['admin_impersonating' => auth()->id()]);

        // Login as the buyer
        auth()->login($buyer);

        return redirect()->route('buyer.dashboard')->with('success', 'You are now logged in as ' . $buyer->name);
    }

    /**
     * Export buyers data in various formats.
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');

        // Get the same query as the index method to respect current filters/search
        $query = User::role('Customer')->withCount(['proposedExchanges' => function($query) {
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

        $buyers = $query->get();

        switch ($format) {
            case 'pdf':
                return $this->exportToPdf($buyers, $request->get('search'));
            case 'xlsx':
                return $this->exportToExcel($buyers);
            case 'csv':
            default:
                return $this->exportToCsv($buyers);
        }
    }

    private function exportToCsv($buyers)
    {
        $filename = 'buyers_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($buyers) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, ['ID', 'Name', 'Email', 'Exchanges Count', 'Joined Date']);

            // CSV data
            foreach ($buyers as $buyer) {
                fputcsv($file, [
                    $buyer->id,
                    $buyer->name,
                    $buyer->email,
                    ($buyer->proposed_exchanges_count ?? 0) + ($buyer->received_exchanges_count ?? 0),
                    $buyer->created_at->format('M d, Y')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportToExcel($buyers)
    {
        // For Excel export, we'll use a simple CSV approach since we don't have a full Excel library
        // In a production app, you'd use something like Laravel Excel or PhpSpreadsheet
        return $this->exportToCsv($buyers)->header('Content-Type', 'application/vnd.ms-excel')
                                          ->header('Content-Disposition', 'attachment; filename="buyers_' . date('Y-m-d_H-i-s') . '.xlsx"');
    }

    private function exportToPdf($buyers, $searchTerm = null)
    {
        $title = 'Buyers Report';
        if ($searchTerm) {
            $title .= ' (Filtered: "' . $searchTerm . '")';
        }

        $html = '
        <html>
        <head>
            <style>
                @page {
                    margin: 1in;
                    header: page-header;
                    footer: page-footer;
                }
                .page-header {
                    position: fixed;
                    top: 0;
                    left: 0;
                    right: 0;
                    height: 80px;
                    text-align: center;
                    border-bottom: 2px solid #1a6969;
                    padding: 10px;
                }
                .page-footer {
                    position: fixed;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    height: 50px;
                    text-align: center;
                    border-top: 1px solid #ddd;
                    padding: 10px;
                    font-size: 12px;
                    color: #666;
                }
                body {
                    font-family: "DejaVu Sans", Arial, sans-serif;
                    font-size: 12px;
                    line-height: 1.4;
                    margin: 100px 0 60px 0;
                }
                h1 {
                    color: #1a6969;
                    text-align: center;
                    margin-bottom: 30px;
                    font-size: 24px;
                    border-bottom: 2px solid #1a6969;
                    padding-bottom: 10px;
                }
                .meta {
                    background: #f8f9fa;
                    padding: 15px;
                    margin-bottom: 20px;
                    border-radius: 5px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                    font-size: 11px;
                }
                th, td {
                    padding: 8px 6px;
                    text-align: left;
                    border: 1px solid #ddd;
                }
                th {
                    background: linear-gradient(135deg, #1a6969, #0e4a4d);
                    color: white;
                    font-weight: bold;
                    text-transform: uppercase;
                    font-size: 10px;
                }
                tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
                tr:hover {
                    background-color: #f5f5f5;
                }
                .total {
                    background-color: #e9ecef;
                    font-weight: bold;
                    font-size: 12px;
                }
                .company-info {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .company-name {
                    font-size: 18px;
                    font-weight: bold;
                    color: #1a6969;
                }
                .report-title {
                    font-size: 16px;
                    margin: 10px 0;
                }
            </style>
        </head>
        <body>
            <div class="page-header">
                <div class="company-info">
                    <div class="company-name">TingUt.no</div>
                    <div class="report-title">' . $title . '</div>
                    <div>Generated on: ' . date('M d, Y H:i:s') . '</div>
                </div>
            </div>

            <div class="page-footer">
                <div>Page {PAGE_NUM} of {PAGE_COUNT}</div>
                <div>Bytte2.no - Buyers Management System</div>
            </div>

            <div class="meta">
                <strong>Report Details:</strong><br>
                Total Buyers: ' . $buyers->count() . '<br>
                ' . ($searchTerm ? 'Search Filter: ' . $searchTerm . '<br>' : '') . '
                Generated by: ' . auth()->user()->name . '<br>
                Date: ' . date('M d, Y H:i:s') . '
            </div>

            <table>
                <thead>
                    <tr>
                        <th style="width: 8%;">ID</th>
                        <th style="width: 25%;">Name</th>
                        <th style="width: 30%;">Email</th>
                        <th style="width: 15%;">Phone</th>
                        <th style="width: 15%;">Location</th>
                        <th style="width: 12%;">Exchanges</th>
                        <th style="width: 15%;">Joined Date</th>
                    </tr>
                </thead>
                <tbody>';

        $totalExchanges = 0;

        foreach ($buyers as $buyer) {
            $exchangesCount = ($buyer->proposed_exchanges_count ?? 0) + ($buyer->received_exchanges_count ?? 0);
            $totalExchanges += $exchangesCount;

            $html .= '
                    <tr>
                        <td>' . $buyer->id . '</td>
                        <td>' . htmlspecialchars($buyer->name) . '</td>
                        <td>' . htmlspecialchars($buyer->email) . '</td>
                        <td>' . ($buyer->phone ?: 'N/A') . '</td>
                        <td>' . ($buyer->location ?: 'Not specified') . '</td>
                        <td style="text-align: center;">' . $exchangesCount . '</td>
                        <td>' . $buyer->created_at->format('M d, Y') . '</td>
                    </tr>';
        }

        // Add totals row
        $html .= '
                    <tr class="total">
                        <td colspan="5"><strong>TOTAL BUYERS: ' . $buyers->count() . '</strong></td>
                        <td style="text-align: center;"><strong>' . $totalExchanges . '</strong></td>
                        <td></td>
                    </tr>';

        $html .= '
                </tbody>
            </table>

            <div style="margin-top: 30px; padding: 15px; background: #f8f9fa; border-radius: 5px;">
                <h3 style="margin: 0 0 10px 0; color: #1a6969;">Summary</h3>
                <p style="margin: 5px 0;"><strong>Total Buyers:</strong> ' . $buyers->count() . '</p>
                <p style="margin: 5px 0;"><strong>Total Exchanges:</strong> ' . $totalExchanges . '</p>
                <p style="margin: 5px 0;"><strong>Average Exchanges per Buyer:</strong> ' . ($buyers->count() > 0 ? round($totalExchanges / $buyers->count(), 2) : 0) . '</p>
                <p style="margin: 5px 0;"><strong>Report Generated:</strong> ' . date('M d, Y H:i:s') . '</p>
            </div>
        </body>
        </html>';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)
            ->setPaper('a4', 'landscape')
            ->setOptions(['defaultFont' => 'DejaVu Sans']);

        $filename = 'buyers_' . date('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($filename);
    }
}
