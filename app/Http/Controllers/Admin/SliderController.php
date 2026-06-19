<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index() { return view('admin.sliders.index', ['sliders' => Slider::orderBy('sort_order')->get()]); }
    public function create()
    {
        return view('admin.sliders.create', ['slider' => null]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|array', 'subtitle' => 'nullable|array',
            'description' => 'nullable|array', 'button_text' => 'nullable|array',
            'button_url' => 'nullable|string', 'image' => 'nullable|image|max:10240',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = Slider::max('sort_order') + 1;
        if ($request->hasFile('image')) { $validated['image'] = $request->file('image')->store('sliders', 'public'); }
        Slider::create($validated);
        return redirect()->route('admin.sliders.index')->with('success', 'Slider created.');
    }

    public function edit(Slider $slider) { return view('admin.sliders.create', compact('slider')); }
    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'title' => 'sometimes|array',
            'subtitle' => 'nullable|array',
            'description' => 'nullable|array',
            'button_text' => 'nullable|array',
            'button_url' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:10240',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'sometimes|integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active', $slider->is_active);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('sliders', 'public');
        }

        $slider->update($validated);

        return redirect()->route('admin.sliders.index')->with('success', 'Updated.');
    }
    public function destroy(Slider $slider) { $slider->delete(); return redirect()->route('admin.sliders.index')->with('success', 'Deleted.'); }
}
