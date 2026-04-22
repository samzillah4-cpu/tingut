<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
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
        $query = Product::with(['user', 'category']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by listing type
        if ($request->filled('listing_type')) {
            $query->where('listing_type', $request->listing_type);
        }

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

        $products = $query->paginate(15);
        $categories = Category::all();

        // Handle AJAX requests for live search
        if ($request->ajax()) {
            return view('admin.products.partials.table', compact('products'))->render();
        }

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:active,inactive',
            'listing_type' => 'required|in:sale,exchange,giveaway',
            'exchange_categories' => 'nullable|array',
            'exchange_categories.*' => 'exists:categories,id',
            'images' => 'nullable|array|max:5',
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
            'vehicle_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
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
            'house_year_built' => 'nullable|integer|min:1800|max:' . (date('Y') + 1),
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

        $data = $request->only(['title', 'description', 'category_id', 'user_id', 'status', 'listing_type', 'exchange_categories', 'is_available_for_rent', 'rent_price', 'rent_duration_unit', 'rent_duration_value', 'rent_deposit', 'rent_terms', 'is_for_sale', 'sale_price', 'vehicle_make', 'vehicle_model', 'vehicle_year', 'vehicle_mileage', 'vehicle_fuel_type', 'vehicle_transmission', 'vehicle_color', 'vehicle_engine_size', 'vehicle_power', 'vehicle_doors', 'vehicle_weight', 'vehicle_registration_number', 'vehicle_vin', 'vehicle_features', 'house_property_type', 'house_rooms', 'house_bedrooms', 'house_bathrooms', 'house_living_area', 'house_plot_size', 'house_year_built', 'house_energy_rating', 'house_ownership_type', 'house_floor', 'house_elevator', 'house_balcony', 'house_parking', 'house_heating_type', 'house_new_construction', 'house_shared_bathroom', 'house_facilities']);

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('products', 'public');
            }
            $data['images'] = $imagePaths;
        }

        $product = Product::create($data);

        // Update product count cache or any related records
        // This ensures all related data is updated when a product is created
        \Cache::forget('products_count');
        \Cache::forget('categories_with_counts');

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product created successfully.',
                'product' => $product
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['user', 'category']);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load(['user', 'category']);
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:active,inactive',
            'listing_type' => 'required|in:sale,exchange,giveaway',
            'exchange_categories' => 'nullable|array',
            'exchange_categories.*' => 'exists:categories,id',
            'images' => 'nullable|array|max:5',
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
            'vehicle_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
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
            'house_year_built' => 'nullable|integer|min:1800|max:' . (date('Y') + 1),
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

        $data = $request->only(['title', 'description', 'category_id', 'user_id', 'status', 'listing_type', 'exchange_categories', 'is_available_for_rent', 'rent_price', 'rent_duration_unit', 'rent_duration_value', 'rent_deposit', 'rent_terms', 'is_for_sale', 'sale_price', 'vehicle_make', 'vehicle_model', 'vehicle_year', 'vehicle_mileage', 'vehicle_fuel_type', 'vehicle_transmission', 'vehicle_color', 'vehicle_engine_size', 'vehicle_power', 'vehicle_doors', 'vehicle_weight', 'vehicle_registration_number', 'vehicle_vin', 'vehicle_features', 'house_property_type', 'house_rooms', 'house_bedrooms', 'house_bathrooms', 'house_living_area', 'house_plot_size', 'house_year_built', 'house_energy_rating', 'house_ownership_type', 'house_floor', 'house_elevator', 'house_balcony', 'house_parking', 'house_heating_type', 'house_new_construction', 'house_shared_bathroom', 'house_facilities']);

        if ($request->hasFile('images')) {
            // Delete old images
            if ($product->images) {
                foreach ($product->images as $oldImage) {
                    if (\Storage::disk('public')->exists($oldImage)) {
                        \Storage::disk('public')->delete($oldImage);
                    }
                }
            }

            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('products', 'public');
            }
            $data['images'] = $imagePaths;
        } else {
            // Keep existing images if no new images uploaded
            if ($product->images) {
                $data['images'] = $product->images;
            }
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete images
        if ($product->images) {
            foreach ($product->images as $image) {
                if (\Storage::disk('public')->exists($image)) {
                    \Storage::disk('public')->delete($image);
                }
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    /**
     * Export products data in various formats.
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');

        // Get the same query as the index method to respect current filters/search
        $query = Product::with(['user', 'category']);

        // Apply the same filters as in index method
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('listing_type')) {
            $query->where('listing_type', $request->listing_type);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->get();

        switch ($format) {
            case 'pdf':
                return $this->exportToPdf($products, $request->get('search'));
            case 'xlsx':
                return $this->exportToExcel($products);
            case 'csv':
            default:
                return $this->exportToCsv($products);
        }
    }

    private function exportToCsv($products)
    {
        $filename = 'products_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, ['ID', 'Name', 'Description', 'Category', 'User', 'Status', 'Images Count', 'Created Date']);

            // CSV data
            foreach ($products as $product) {
                fputcsv($file, [
                    $product->id,
                    $product->title,
                    $product->description,
                    $product->category->name,
                    $product->user->name,
                    $product->status,
                    count($product->images ?? []),
                    $product->created_at->format('M d, Y')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportToExcel($products)
    {
        // For Excel export, we'll use a simple CSV approach since we don't have a full Excel library
        // In a production app, you'd use something like Laravel Excel or PhpSpreadsheet
        return $this->exportToCsv($products)->header('Content-Type', 'application/vnd.ms-excel')
                                          ->header('Content-Disposition', 'attachment; filename="products_' . date('Y-m-d_H-i-s') . '.xlsx"');
    }

    private function exportToPdf($products, $searchTerm = null)
    {
        // Get dynamic settings from database
        $settings = \App\Models\Setting::all()->pluck('value', 'key')->toArray();

        $siteName = $settings['site_name'] ?? 'TingUt.no';
        $siteDescription = $settings['site_description'] ?? 'Barter Trading Platform';
        $contactEmail = $settings['contact_email'] ?? 'admin@tingut.no';
        $contactPhone = $settings['contact_phone'] ?? '';

        $title = 'Products Report';
        if ($searchTerm) {
            $title .= ' (Filtered: "' . $searchTerm . '")';
        }

        $html = '
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #217372; padding-bottom: 20px; }
                .site-name { font-size: 24px; font-weight: bold; color: #217372; margin: 0; }
                .site-description { font-size: 14px; color: #666; margin: 5px 0; }
                .meta { color: #666; margin-bottom: 20px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { padding: 8px; text-align: left; border: 1px solid #ddd; font-size: 12px; }
                th { background-color: #217372; color: white; font-weight: bold; }
                tr:nth-child(even) { background-color: #f9f9f9; }
                .total { background-color: #e9ecef; font-weight: bold; }
                .description { max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
                .footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid #ddd; font-size: 11px; color: #666; text-align: center; }
                .contact-info { margin-bottom: 10px; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1 class="site-name">' . htmlspecialchars($siteName) . '</h1>
                <p class="site-description">' . htmlspecialchars($siteDescription) . '</p>
            </div>

            <h2 style="color: #217372; margin-bottom: 10px;">' . $title . '</h2>
            <div class="meta">
                <p><strong>Generated on:</strong> ' . date('M d, Y H:i:s') . '</p>
                <p><strong>Total Products:</strong> ' . $products->count() . '</p>
                ' . ($searchTerm ? '<p><strong>Search Filter:</strong> ' . $searchTerm . '</p>' : '') . '
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Images</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($products as $product) {
            $html .= '
                    <tr>
                        <td>' . $product->id . '</td>
                        <td>' . htmlspecialchars($product->title) . '</td>
                        <td class="description">' . htmlspecialchars(substr($product->description, 0, 100)) . (strlen($product->description) > 100 ? '...' : '') . '</td>
                        <td>' . htmlspecialchars($product->category->name) . '</td>
                        <td>' . htmlspecialchars($product->user->name) . '</td>
                        <td>' . ucfirst($product->status) . '</td>
                        <td>' . count($product->images ?? []) . '</td>
                        <td>' . $product->created_at->format('M d, Y') . '</td>
                    </tr>';
        }

        $html .= '
                </tbody>
            </table>

            <div class="footer">
                <div class="contact-info">
                    <strong>Contact Information:</strong><br>
                    Email: ' . htmlspecialchars($contactEmail) . '
                    ' . ($contactPhone ? '<br>Phone: ' . htmlspecialchars($contactPhone) : '') . '
                </div>
                <div>
                    &copy; ' . date('Y') . ' ' . htmlspecialchars($siteName) . '. All rights reserved.
                </div>
            </div>
        </body>
        </html>';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
        $filename = 'products_' . date('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Handle bulk actions for products.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:products,id',
        ]);

        $action = $request->action;
        $ids = $request->ids;

        switch ($action) {
            case 'activate':
                Product::whereIn('id', $ids)->update(['status' => 'active']);
                $message = 'Selected products have been activated successfully.';
                break;

            case 'deactivate':
                Product::whereIn('id', $ids)->update(['status' => 'inactive']);
                $message = 'Selected products have been deactivated successfully.';
                break;

            case 'delete':
                $products = Product::whereIn('id', $ids)->get();

                // Delete associated images
                foreach ($products as $product) {
                    if ($product->images) {
                        foreach ($product->images as $image) {
                            if (\Storage::disk('public')->exists($image)) {
                                \Storage::disk('public')->delete($image);
                            }
                        }
                    }
                }

                Product::whereIn('id', $ids)->delete();
                $message = 'Selected products have been deleted successfully.';
                break;
        }

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }
}
