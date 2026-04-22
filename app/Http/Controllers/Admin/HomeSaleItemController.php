<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSale;
use App\Models\HomeSaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSaleItemController extends Controller
{
    /**
     * Show the form for creating a new item.
     */
    public function create(HomeSale $homeSale)
    {
        return view('admin.home-sales.items.create', compact('homeSale'));
    }

    /**
     * Store a newly created item in storage.
     */
    public function store(Request $request, HomeSale $homeSale)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'condition' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('home-sale-items', 'public');
        }

        // Get the maximum sort order
        $maxSort = $homeSale->items()->max('sort_order') ?? 0;

        $homeSale->items()->create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'condition' => $request->condition,
            'image' => $image,
            'sort_order' => $maxSort + 1,
        ]);

        return redirect()->route('admin.home-sales.show', $homeSale)
            ->with('success', 'Item added successfully.');
    }

    /**
     * Show the form for editing the specified item.
     */
    public function edit(HomeSale $homeSale, HomeSaleItem $item)
    {
        return view('admin.home-sales.items.edit', compact('homeSale', 'item'));
    }

    /**
     * Update the specified item in storage.
     */
    public function update(Request $request, HomeSale $homeSale, HomeSaleItem $item)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'condition' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $item->image;
        if ($request->hasFile('image')) {
            // Delete old image
            if ($image) {
                Storage::disk('public')->delete($image);
            }
            $image = $request->file('image')->store('home-sale-items', 'public');
        }

        $item->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'condition' => $request->condition,
            'image' => $image,
        ]);

        return redirect()->route('admin.home-sales.show', $homeSale)
            ->with('success', 'Item updated successfully.');
    }

    /**
     * Remove the specified item from storage.
     */
    public function destroy(HomeSale $homeSale, HomeSaleItem $item)
    {
        // Delete image
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return redirect()->route('admin.home-sales.show', $homeSale)
            ->with('success', 'Item deleted successfully.');
    }

    /**
     * Toggle the sold status of the item.
     */
    public function toggleSold(HomeSale $homeSale, HomeSaleItem $item)
    {
        $item->update(['is_sold' => !$item->is_sold]);

        $status = $item->is_sold ? 'marked as sold' : 'marked as available';
        return redirect()->route('admin.home-sales.show', $homeSale)
            ->with('success', "Item {$status}.");
    }
}
