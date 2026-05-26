<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with('author')->latest()->paginate(15);
        return view('admin.blog.index', compact('posts'));
    }

    public function create() { return view('admin.blog.create'); }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|array', 'title.en' => 'required|string|max:255',
            'content' => 'required|array', 'excerpt' => 'nullable|array',
            'category' => 'required|string', 'image' => 'nullable|image|max:5120',
        ]);

        $slug = [];
        foreach ($validated['title'] as $locale => $title) { $slug[$locale] = Str::slug($title); }

        $data = array_merge($validated, [
            'slug' => $slug, 'author_id' => auth()->id(),
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') ? now() : null,
        ]);

        if ($request->hasFile('image')) { $data['image'] = $request->file('image')->store('blog', 'public'); }

        BlogPost::create($data);
        return redirect()->route('admin.blog.index')->with('success', 'Post created.');
    }

    public function edit(BlogPost $blog) { return view('admin.blog.create', ['post' => $blog]); }

    public function update(Request $request, BlogPost $blog)
    {
        $validated = $request->validate([
            'title' => 'required|array', 'title.en' => 'required|string|max:255',
            'content' => 'required|array', 'excerpt' => 'nullable|array', 'category' => 'required|string',
        ]);

        $slug = [];
        foreach ($validated['title'] as $locale => $title) { $slug[$locale] = Str::slug($title); }
        $data = array_merge($validated, ['slug' => $slug, 'is_published' => $request->boolean('is_published')]);
        if ($request->boolean('is_published') && !$blog->published_at) { $data['published_at'] = now(); }
        if ($request->hasFile('image')) { $data['image'] = $request->file('image')->store('blog', 'public'); }

        $blog->update($data);
        return redirect()->route('admin.blog.index')->with('success', 'Post updated.');
    }

    public function destroy(BlogPost $blog)
    {
        $blog->delete();
        return redirect()->route('admin.blog.index')->with('success', 'Post deleted.');
    }
}
