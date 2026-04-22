<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteMenu;
use App\Models\WebsiteHero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebsiteController extends Controller
{
    public function index()
    {
        $menus = WebsiteMenu::ordered()->get();
        $hero = WebsiteHero::first();

        // Get all system-generated pages
        $systemPages = [
            ['title' => 'Home', 'url' => '/'],
            ['title' => 'Products', 'url' => '/products'],
            ['title' => 'Shop', 'url' => '/shop'],
            ['title' => 'Categories', 'url' => '/categories'],
            ['title' => 'Blogs', 'url' => '/blogs'],
            ['title' => 'Contact Us', 'url' => '/pages/contact'],
            ['title' => 'About Us', 'url' => '/pages/about'],
            ['title' => 'Terms & Conditions', 'url' => '/pages/terms'],
            ['title' => 'Privacy Policy', 'url' => '/pages/privacy'],
        ];

        // Add custom pages
        $customPages = \App\Models\CustomPage::active()->get()->map(function($page) {
            return [
                'title' => $page->title,
                'url' => route('pages.show', $page->slug)
            ];
        });

        $allPages = array_merge($systemPages, $customPages->toArray());

        return view('admin.website.index', compact('menus', 'hero', 'allPages'));
    }

    public function hero()
    {
        $hero = WebsiteHero::first();
        return view('admin.hero', compact('hero'));
    }

    public function updateMenus(Request $request)
    {
        $request->validate([
            'menus' => 'required|array',
            'menus.*.id' => 'required|integer',
            'menus.*.name' => 'required|string|max:255',
            'menus.*.url' => 'nullable|string|max:255',
            'menus.*.order' => 'required|integer',
            'menus.*.is_active' => 'boolean',
            'menus.*.open_in_new_tab' => 'boolean',
        ]);

        foreach ($request->menus as $menuData) {
            $menu = WebsiteMenu::find($menuData['id']);
            if ($menu) {
                $menu->update([
                    'name' => $menuData['name'],
                    'url' => $menuData['url'],
                    'order' => $menuData['order'],
                    'is_active' => $menuData['is_active'] ?? false,
                    'open_in_new_tab' => $menuData['open_in_new_tab'] ?? false,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Menus updated successfully.');
    }

    public function createMenu(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'open_in_new_tab' => 'boolean',
        ]);

        $maxOrder = WebsiteMenu::max('order') ?? 0;

        WebsiteMenu::create([
            'name' => $request->name,
            'url' => $request->url,
            'order' => $maxOrder + 1,
            'is_active' => $request->is_active ?? true,
            'open_in_new_tab' => $request->open_in_new_tab ?? false,
        ]);

        return redirect()->back()->with('success', 'Menu item created successfully.');
    }

    public function deleteMenu($id)
    {
        $menu = WebsiteMenu::findOrFail($id);
        $menu->delete();

        // Return JSON response for AJAX requests
        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Menu item deleted successfully.']);
        }

        return redirect()->back()->with('success', 'Menu item deleted successfully.');
    }

    public function updateHero(Request $request)
    {
        $request->validate([
            'heading' => 'required|string|max:255',
            'paragraph' => 'nullable|string',
            'button1_text' => 'required|string|max:255',
            'button1_url' => 'required|string|max:255',
            'button2_text' => 'required|string|max:255',
            'button2_url' => 'required|string|max:255',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'boolean',
        ]);

        $hero = WebsiteHero::first();
        if (!$hero) {
            $hero = new WebsiteHero();
        }

        $data = $request->only([
            'heading', 'paragraph', 'button1_text', 'button1_url',
            'button2_text', 'button2_url', 'is_active'
        ]);

        if ($request->hasFile('background_image')) {
            // Delete old image if exists
            if ($hero->background_image && Storage::disk('public')->exists($hero->background_image)) {
                Storage::disk('public')->delete($hero->background_image);
            }

            // Store new image
            $data['background_image'] = $request->file('background_image')->store('hero-images', 'public');
        }

        $hero->fill($data);
        $hero->save();

        return redirect()->back()->with('success', 'Hero section updated successfully.')->with('refresh_frontend', true);
    }

    public function testimonials()
    {
        $testimonials = \App\Models\Testimonial::ordered()->get();
        return view('admin.testimonials', compact('testimonials'));
    }

    public function createTestimonial()
    {
        return view('admin.testimonials.create');
    }

    public function storeTestimonial(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_position' => 'nullable|string|max:255',
            'testimony' => 'required|string|max:1000',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['customer_name', 'customer_position', 'testimony', 'is_active']);

        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->store('testimonials', 'public');
        }

        $maxOrder = \App\Models\Testimonial::max('order') ?? 0;
        $data['order'] = $maxOrder + 1;

        \App\Models\Testimonial::create($data);

        return redirect()->route('admin.testimonials')->with('success', 'Testimonial created successfully.');
    }

    public function editTestimonial($id)
    {
        $testimonial = \App\Models\Testimonial::findOrFail($id);
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function updateTestimonial(Request $request, $id)
    {
        $testimonial = \App\Models\Testimonial::findOrFail($id);

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_position' => 'nullable|string|max:255',
            'testimony' => 'required|string|max:1000',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['customer_name', 'customer_position', 'testimony', 'is_active']);

        if ($request->hasFile('profile_picture')) {
            // Delete old image if exists
            if ($testimonial->profile_picture && Storage::disk('public')->exists($testimonial->profile_picture)) {
                Storage::disk('public')->delete($testimonial->profile_picture);
            }
            $data['profile_picture'] = $request->file('profile_picture')->store('testimonials', 'public');
        }

        $testimonial->update($data);

        return redirect()->route('admin.testimonials')->with('success', 'Testimonial updated successfully.');
    }

    public function deleteTestimonial($id)
    {
        $testimonial = \App\Models\Testimonial::findOrFail($id);

        // Delete profile picture if exists
        if ($testimonial->profile_picture && Storage::disk('public')->exists($testimonial->profile_picture)) {
            Storage::disk('public')->delete($testimonial->profile_picture);
        }

        $testimonial->delete();

        return redirect()->route('admin.testimonials')->with('success', 'Testimonial deleted successfully.');
    }

    public function updateTestimonialsOrder(Request $request)
    {
        $request->validate([
            'testimonials' => 'required|array',
            'testimonials.*.id' => 'required|integer',
            'testimonials.*.order' => 'required|integer',
        ]);

        foreach ($request->testimonials as $testimonialData) {
            $testimonial = \App\Models\Testimonial::find($testimonialData['id']);
            if ($testimonial) {
                $testimonial->update(['order' => $testimonialData['order']]);
            }
        }

        return response()->json(['success' => true]);
    }
}
