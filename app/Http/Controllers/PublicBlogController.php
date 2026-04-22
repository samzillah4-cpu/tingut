<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;

class PublicBlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::published()->latest()->paginate(12);

        return view('blogs.index', compact('blogs'));
    }

    public function show(Blog $blog)
    {
        // Only show published blogs
        if (!$blog->is_published) {
            abort(404);
        }

        // Get related blogs (same logic as in the slider)
        $relatedBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->latest()
            ->take(3)
            ->get();

        // Get approved comments for this blog
        $comments = $blog->comments()->with('user')->get();

        return view('blogs.show', compact('blog', 'relatedBlogs', 'comments'));
    }

    public function storeComment(Request $request, Blog $blog)
    {
        // Only allow comments on published blogs
        if (!$blog->is_published) {
            abort(404);
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'blog_id' => $blog->id,
            'content' => $request->content,
            'is_approved' => true, // Auto-approve for now, can be changed later
        ]);

        return redirect()->back()->with('success', 'Comment added successfully!');
    }
}
