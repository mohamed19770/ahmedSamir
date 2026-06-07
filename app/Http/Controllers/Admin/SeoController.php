<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoSetting;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function index()
    {
        $settings = SeoSetting::all();
        return view('admin.seo.index', compact('settings'));
    }

    public function edit(SeoSetting $seoSetting)
    {
        return view('admin.seo.edit', compact('seoSetting'));
    }

    public function update(Request $request, SeoSetting $seoSetting)
    {
        $validated = $request->validate([
            'meta_title' => 'required|array',
            'meta_description' => 'required|array',
            'meta_keywords' => 'nullable|array',
            'meta_keywords.en' => 'nullable|string|max:1000',
            'meta_keywords.ar' => 'nullable|string|max:1000',
            'meta_keywords.hr' => 'nullable|string|max:1000',
            'og_image' => 'nullable|string',
            'canonical_url' => 'nullable|url',
        ]);

        $seoSetting->update($validated);
        return redirect()->route('admin.seo.index')->with('success', 'SEO settings updated.');
    }
}
