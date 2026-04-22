<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CustomPageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:custom_pages,slug',
            'content' => 'required|string',
            'is_active' => 'boolean'
        ]);

        $page = CustomPage::create([
            'title' => $request->title,
            'slug' => Str::slug($request->slug),
            'content' => $request->content,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Page created successfully',
            'page' => $page
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomPage $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomPage $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:custom_pages,slug,' . $page->id,
            'content' => 'required|string',
            'is_active' => 'boolean'
        ]);

        $page->update([
            'title' => $request->title,
            'slug' => Str::slug($request->slug),
            'content' => $request->content,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('admin.website.index')->with('success', 'Page updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomPage $page)
    {
        $page->delete();

        return response()->json([
            'success' => true,
            'message' => 'Page deleted successfully'
        ]);
    }
}
