<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(string $locale, Request $request)
    {
        $query = BlogPost::published()->with('author');

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        $posts = $query->latest('published_at')->paginate(9);

        return view('pages.blog.index', compact('posts'));
    }

    public function show(string $locale, string $slug)
    {
        $post = BlogPost::published()
            ->with('author')
            ->whereRaw("(slug->>?) = ?", [$locale, $slug])
            ->firstOrFail();

        $post->increment('views_count');

        return view('pages.blog.show', compact('post'));
    }
}
