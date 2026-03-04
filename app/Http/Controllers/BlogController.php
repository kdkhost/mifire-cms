<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Display paginated list of published blog posts.
     */
    public function index(Request $request): View
    {
        $query = BlogPost::published()->recent()->with(['category', 'user']);

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        $posts = $query->paginate(9)->withQueryString();

        $categories = Category::active()
            ->byType('blog')
            ->withCount(['blogPosts' => fn ($q) => $q->published()])
            ->orderBy('sort_order')
            ->get();

        return view('site.blog.index', compact('posts', 'categories'));
    }

    /**
     * Display a single blog post.
     */
    public function show(string $slug): View
    {
        $post = BlogPost::published()
            ->with(['category', 'user'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views count
        $post->increment('views_count');

        $relatedPosts = BlogPost::published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->recent()
            ->take(3)
            ->get();

        return view('site.blog.show', compact('post', 'relatedPosts'));
    }

    /**
     * Display blog posts filtered by category.
     */
    public function category(string $slug): View
    {
        $category = Category::active()
            ->byType('blog')
            ->where('slug', $slug)
            ->firstOrFail();

        $posts = BlogPost::published()
            ->where('category_id', $category->id)
            ->recent()
            ->with('user')
            ->paginate(9);

        $categories = Category::active()
            ->byType('blog')
            ->withCount(['blogPosts' => fn ($q) => $q->published()])
            ->orderBy('sort_order')
            ->get();

        return view('site.blog.category', compact('category', 'posts', 'categories'));
    }
}
