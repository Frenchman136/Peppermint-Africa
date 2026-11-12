<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('category');
        $page = (int) $request->query('page', 1);

        $categories = Post::published()->whereNotNull('category')->distinct()->orderBy('category')->pluck('category');

        // The hero post shows only on the first, unfiltered page
        $featured = null;
        if (! $category && $page <= 1) {
            $featured = Post::published()->where('is_featured', true)->orderByDesc('published_at')->first()
                ?? Post::published()->orderByDesc('published_at')->first();
        }

        $posts = Post::published()
            ->when($category, fn ($q) => $q->where('category', $category))
            ->when($featured, fn ($q) => $q->where('id', '!=', $featured->id))
            ->orderByDesc('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('pages.blog', compact('posts', 'featured', 'categories', 'category'));
    }

    public function show(Post $post): View
    {
        abort_unless(Post::published()->whereKey($post->id)->exists(), 404);

        $related = Post::published()
            ->where('id', '!=', $post->id)
            ->orderByRaw('CASE WHEN category = ? THEN 0 ELSE 1 END', [$post->category])
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('pages.blog-show', ['post' => $post, 'related' => $related]);
    }
}
