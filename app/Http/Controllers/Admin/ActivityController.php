<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::latest()->paginate(15);
        return view('admin.activities.index', compact('activities'));
    }

    public function create() { return view('admin.activities.create'); }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|array', 'title.en' => 'required|string|max:255',
            'description' => 'required|array', 'short_description' => 'nullable|array',
            'price' => 'required|numeric|min:0', 'duration' => 'required|string',
            'category' => 'required|string', 'location' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'meta_title' => 'nullable|array',
            'meta_description' => 'nullable|array',
            'meta_keywords' => 'nullable|array',
        ]);

        $slug = [];
        foreach ($validated['title'] as $locale => $title) { $slug[$locale] = Str::slug($title); }

        $data = array_merge($validated, ['slug' => $slug, 'is_active' => $request->boolean('is_active'), 'is_featured' => $request->boolean('is_featured')]);
        if ($request->hasFile('image')) { $data['image'] = $request->file('image')->store('activities', 'public'); }

        Activity::create($data);
        return redirect()->route('admin.activities.index')->with('success', 'Activity created.');
    }

    public function edit(Activity $activity) { return view('admin.activities.create', compact('activity')); }

    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'title' => 'required|array', 'title.en' => 'required|string|max:255',
            'description' => 'required|array', 'short_description' => 'nullable|array',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string', 'category' => 'required|string',
            'location' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'meta_title' => 'nullable|array',
            'meta_description' => 'nullable|array',
            'meta_keywords' => 'nullable|array',
        ]);

        $slug = [];
        foreach ($validated['title'] as $locale => $title) { $slug[$locale] = Str::slug($title); }
        $data = array_merge($validated, ['slug' => $slug, 'is_active' => $request->boolean('is_active'), 'is_featured' => $request->boolean('is_featured')]);
        if ($request->hasFile('image')) { $data['image'] = $request->file('image')->store('activities', 'public'); }

        $activity->update($data);
        return redirect()->route('admin.activities.index')->with('success', 'Activity updated.');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        return redirect()->route('admin.activities.index')->with('success', 'Activity deleted.');
    }
}
