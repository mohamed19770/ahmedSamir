<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Services\SchemaService;
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

        $this->shareSeo('blog');
        $this->shareBreadcrumbs([
            ['name' => __('general.home'), 'url' => route('home', $locale)],
            ['name' => __('general.blog')],
        ]);

        return view('pages.blog.index', compact('posts'));
    }

    public function show(string $locale, string $slug, SchemaService $schema)
    {
        $post = BlogPost::published()
            ->with('author')
            ->whereRaw('(slug->>?) = ?', [$locale, $slug])
            ->firstOrFail();

        $post->increment('views_count');

        $relatedPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->when($post->category, fn ($q) => $q->where('category', $post->category))
            ->take(3)
            ->get();

        $breadcrumbItems = [
            ['name' => __('general.home'), 'url' => route('home', $locale)],
            ['name' => __('general.blog'), 'url' => route('blog.index', $locale)],
            ['name' => $post->getTranslation('title', $locale)],
        ];

        $this->shareEntitySeo('blog-post', 'blog.show', $post, [
            'og_type' => 'article',
        ], [
            $schema->article($post, $locale),
            $schema->breadcrumbList($breadcrumbItems),
        ], $breadcrumbItems);

        return view('pages.blog.show', compact('post', 'relatedPosts'));
    }
}
