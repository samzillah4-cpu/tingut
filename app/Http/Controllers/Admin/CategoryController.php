<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
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
        $query = Category::withCount('products');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $categories = $query->paginate(15);

        // Handle AJAX requests for live search
        if ($request->ajax()) {
            return view('admin.categories.partials.table', compact('categories'))->render();
        }

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'description']);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $data['image'] = $imagePath;
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load(['products' => function($query) {
            $query->with('user')->latest()->take(10);
        }]);
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'description']);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image && \Storage::disk('public')->exists($category->image)) {
                \Storage::disk('public')->delete($category->image);
            }
            $imagePath = $request->file('image')->store('categories', 'public');
            $data['image'] = $imagePath;
        } else {
            // Keep existing image if no new image uploaded
            if ($category->image) {
                $data['image'] = $category->image;
            }
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Check if category has products
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')->with('error', 'Cannot delete category with existing products.');
        }

        // Delete image if exists
        if ($category->image && \Storage::disk('public')->exists($category->image)) {
            \Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }

    /**
     * Export categories data in various formats.
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');

        // Get the same query as the index method to respect current filters/search
        $query = Category::withCount('products');

        // Apply the same search filter as in index method
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $categories = $query->get();

        switch ($format) {
            case 'pdf':
                return $this->exportToPdf($categories, $request->get('search'));
            case 'xlsx':
                return $this->exportToExcel($categories);
            case 'csv':
            default:
                return $this->exportToCsv($categories);
        }
    }

    private function exportToCsv($categories)
    {
        $filename = 'categories_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($categories) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, ['ID', 'Name', 'Description', 'Products Count', 'Created Date']);

            // CSV data
            foreach ($categories as $category) {
                fputcsv($file, [
                    $category->id,
                    $category->name,
                    $category->description,
                    $category->products_count,
                    $category->created_at->format('M d, Y')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportToExcel($categories)
    {
        // For Excel export, we'll use a simple CSV approach since we don't have a full Excel library
        // In a production app, you'd use something like Laravel Excel or PhpSpreadsheet
        return $this->exportToCsv($categories)->header('Content-Type', 'application/vnd.ms-excel')
                                            ->header('Content-Disposition', 'attachment; filename="categories_' . date('Y-m-d_H-i-s') . '.xlsx"');
    }

    private function exportToPdf($categories, $searchTerm = null)
    {
        // For PDF export, we'll create a simple HTML-based PDF
        // In a production app, you'd use something like DomPDF or TCPDF

        $title = 'Categories Report';
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
                .description { max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
            </style>
        </head>
        <body>
            <h1>' . $title . '</h1>
            <div class="meta">
                <p><strong>Generated on:</strong> ' . date('M d, Y H:i:s') . '</p>
                <p><strong>Total Categories:</strong> ' . $categories->count() . '</p>
                ' . ($searchTerm ? '<p><strong>Search Filter:</strong> ' . $searchTerm . '</p>' : '') . '
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Products</th>
                        <th>Created Date</th>
                    </tr>
                </thead>
                <tbody>';

        $totalProducts = 0;

        foreach ($categories as $category) {
            $totalProducts += $category->products_count;

            $html .= '
                    <tr>
                        <td>' . $category->id . '</td>
                        <td>' . htmlspecialchars($category->name) . '</td>
                        <td class="description">' . htmlspecialchars(substr($category->description ?? '', 0, 100)) . (strlen($category->description ?? '') > 100 ? '...' : '') . '</td>
                        <td>' . $category->products_count . '</td>
                        <td>' . $category->created_at->format('M d, Y') . '</td>
                    </tr>';
        }

        // Add totals row
        $html .= '
                    <tr class="total">
                        <td colspan="3"><strong>TOTALS</strong></td>
                        <td><strong>' . $totalProducts . '</strong></td>
                        <td></td>
                    </tr>';

        $html .= '
                </tbody>
            </table>
        </body>
        </html>';

        $filename = 'categories_' . date('Y-m-d_H-i-s') . '.pdf';
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        // For now, return HTML as PDF content (in production, use a proper PDF library)
        return response($html, 200, $headers);
    }
}
