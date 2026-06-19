<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index() { return view('admin.gallery.index', ['galleries' => Gallery::latest()->paginate(20)]); }
    public function create() { return view('admin.gallery.create'); }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|array', 'description' => 'nullable|array',
            'category' => 'nullable|string', 'image' => 'required|image|max:10240',
        ]);
        $validated['image'] = $request->file('image')->store('gallery', 'public');
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['is_featured'] = $request->boolean('is_featured');
        Gallery::create($validated);
        return redirect()->route('admin.gallery.index')->with('success', 'Image uploaded.');
    }

    public function edit(Gallery $gallery) { return view('admin.gallery.create', compact('gallery')); }
    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'nullable|array',
            'description' => 'nullable|array',
            'category' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:10240',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', $gallery->is_active);
        $validated['is_featured'] = $request->boolean('is_featured', $gallery->is_featured);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('gallery', 'public');
        }

        $gallery->update($validated);

        return redirect()->route('admin.gallery.index')->with('success', 'Updated.');
    }
    public function destroy(Gallery $gallery) { $gallery->delete(); return redirect()->route('admin.gallery.index')->with('success', 'Deleted.'); }
}
