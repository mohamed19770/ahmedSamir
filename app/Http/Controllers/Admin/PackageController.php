<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TourismPackage;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function index()
    {
        $packages = TourismPackage::with('destination')->latest()->paginate(15);
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        $destinations = Destination::active()->get();
        return view('admin.packages.create', compact('destinations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|array',
            'title.en' => 'required|string|max:255',
            'description' => 'required|array',
            'short_description' => 'nullable|array',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'duration_nights' => 'required|integer|min:0',
            'category' => 'required|string',
            'max_guests' => 'nullable|integer|min:1',
            'image' => 'nullable|image|max:5120',
        ]);

        $slug = [];
        foreach ($validated['title'] as $locale => $title) {
            $slug[$locale] = Str::slug($title);
        }

        $data = array_merge($validated, [
            'slug' => $slug,
            'is_active' => $request->boolean('is_active'),
            'is_featured' => $request->boolean('is_featured'),
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('packages', 'public');
        }

        TourismPackage::create($data);

        return redirect()->route('admin.packages.index')->with('success', 'Package created successfully.');
    }

    public function edit(TourismPackage $package)
    {
        $destinations = Destination::active()->get();
        return view('admin.packages.create', compact('package', 'destinations'));
    }

    public function update(Request $request, TourismPackage $package)
    {
        $validated = $request->validate([
            'title' => 'required|array',
            'title.en' => 'required|string|max:255',
            'description' => 'required|array',
            'short_description' => 'nullable|array',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'duration_nights' => 'required|integer|min:0',
            'category' => 'required|string',
            'max_guests' => 'nullable|integer|min:1',
            'image' => 'nullable|image|max:5120',
        ]);

        $slug = [];
        foreach ($validated['title'] as $locale => $title) {
            $slug[$locale] = Str::slug($title);
        }

        $data = array_merge($validated, [
            'slug' => $slug,
            'is_active' => $request->boolean('is_active'),
            'is_featured' => $request->boolean('is_featured'),
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('packages', 'public');
        }

        $package->update($data);

        return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully.');
    }

    public function destroy(TourismPackage $package)
    {
        $package->delete();
        return redirect()->route('admin.packages.index')->with('success', 'Package deleted successfully.');
    }
}
