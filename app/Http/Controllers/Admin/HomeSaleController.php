<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSale;
use App\Models\HomeSaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $homeSales = HomeSale::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.home-sales.index', compact('homeSales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.home-sales.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'sale_date_from' => 'required|date|after_or_equal:today',
            'sale_date_to' => 'required|date|after_or_equal:sale_date_from',
            'location' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'item_names.*' => 'nullable|string|max:255',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('home-sales', 'public');
                $images[] = $path;
            }
        }

        $homeSale = HomeSale::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'images' => $images,
            'sale_date_from' => $request->sale_date_from,
            'sale_date_to' => $request->sale_date_to,
            'location' => $request->location,
            'address' => $request->address,
            'city' => $request->city,
            'status' => $request->status ?? 'active',
            'is_featured' => $request->is_featured ?? false,
        ]);

        // Handle new items
        if ($request->has('item_names')) {
            foreach ($request->item_names as $index => $name) {
                if (!empty($name)) {
                    $imagePath = null;
                    if ($request->hasFile('item_images') && isset($request->file('item_images')[$index])) {
                        $imagePath = $request->file('item_images')[$index]->store('home-sale-items', 'public');
                    }

                    $homeSale->items()->create([
                        'name' => $name,
                        'description' => $request->item_descriptions[$index] ?? null,
                        'price' => $request->item_prices[$index] ?? null,
                        'category' => $request->item_categories[$index] ?? null,
                        'condition' => $request->item_conditions[$index] ?? null,
                        'image' => $imagePath,
                        'sort_order' => $index,
                    ]);
                }
            }
        }

        return redirect()->route('admin.home-sales.index')
            ->with('success', 'Home Sale created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HomeSale $homeSale)
    {
        $homeSale->load('items');
        return view('admin.home-sales.show', compact('homeSale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomeSale $homeSale)
    {
        $homeSale->load('items');
        return view('admin.home-sales.edit', compact('homeSale'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HomeSale $homeSale)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'sale_date_from' => 'required|date',
            'sale_date_to' => 'required|date|after_or_equal:sale_date_from',
            'location' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $images = $homeSale->images ?? [];
        if ($request->hasFile('images')) {
            // Delete old images
            foreach ($images as $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
            // Upload new images
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('home-sales', 'public');
                $images[] = $path;
            }
        }

        $homeSale->update([
            'title' => $request->title,
            'description' => $request->description,
            'images' => $images,
            'sale_date_from' => $request->sale_date_from,
            'sale_date_to' => $request->sale_date_to,
            'location' => $request->location,
            'address' => $request->address,
            'city' => $request->city,
            'status' => $request->status ?? 'active',
            'is_featured' => $request->is_featured ?? false,
        ]);

        // Handle existing items update
        if ($request->has('existing_item_ids')) {
            foreach ($request->existing_item_ids as $index => $itemId) {
                $item = HomeSaleItem::find($itemId);
                if ($item) {
                    $imagePath = $item->image;

                    // Handle image update for existing items
                    if ($request->hasFile('existing_item_images') && isset($request->file('existing_item_images')[$index])) {
                        // Delete old image
                        if ($imagePath) {
                            Storage::disk('public')->delete($imagePath);
                        }
                        $imagePath = $request->file('existing_item_images')[$index]->store('home-sale-items', 'public');
                    }

                    $item->update([
                        'name' => $request->existing_item_names[$index],
                        'description' => $request->existing_item_descriptions[$index] ?? null,
                        'price' => $request->existing_item_prices[$index] ?? null,
                        'category' => $request->existing_item_categories[$index] ?? null,
                        'condition' => $request->existing_item_conditions[$index] ?? null,
                        'image' => $imagePath,
                    ]);
                }
            }
        }

        // Handle deleted items
        if ($request->has('delete_item_ids')) {
            foreach ($request->delete_item_ids as $itemId) {
                $item = HomeSaleItem::find($itemId);
                if ($item) {
                    // Delete item image
                    if ($item->image) {
                        Storage::disk('public')->delete($item->image);
                    }
                    $item->delete();
                }
            }
        }

        // Handle new items
        if ($request->has('item_names')) {
            foreach ($request->item_names as $index => $name) {
                if (!empty($name)) {
                    $imagePath = null;
                    if ($request->hasFile('item_images') && isset($request->file('item_images')[$index])) {
                        $imagePath = $request->file('item_images')[$index]->store('home-sale-items', 'public');
                    }

                    $homeSale->items()->create([
                        'name' => $name,
                        'description' => $request->item_descriptions[$index] ?? null,
                        'price' => $request->item_prices[$index] ?? null,
                        'category' => $request->item_categories[$index] ?? null,
                        'condition' => $request->item_conditions[$index] ?? null,
                        'image' => $imagePath,
                        'sort_order' => $homeSale->items()->count(),
                    ]);
                }
            }
        }

        return redirect()->route('admin.home-sales.index')
            ->with('success', 'Home Sale updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomeSale $homeSale)
    {
        // Delete all item images
        foreach ($homeSale->items as $item) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
        }

        // Delete home sale images
        if ($homeSale->images) {
            foreach ($homeSale->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $homeSale->delete();

        return redirect()->route('admin.home-sales.index')
            ->with('success', 'Home Sale deleted successfully.');
    }
}
