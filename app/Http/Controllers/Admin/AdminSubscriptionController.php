<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class AdminSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = SubscriptionPlan::with('category')->get();
        $subscriptions = Subscription::with('user', 'plan')->get();

        return view('admin.subscriptions.index', compact('plans', 'subscriptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.subscriptions.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string',
            'max_products' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        SubscriptionPlan::create($request->all());

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription plan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        $categories = Category::all();

        return view('admin.subscriptions.edit', compact('plan', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string',
            'max_products' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $plan = SubscriptionPlan::findOrFail($id);
        $plan->update($request->all());

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription plan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        $plan->delete();

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription plan deleted successfully.');
    }
}
