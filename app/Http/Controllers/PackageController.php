<?php

namespace App\Http\Controllers;

use App\Models\TourismPackage;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index(string $locale, Request $request)
    {
        $query = TourismPackage::active()->with('destination');

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('destination')) {
            $query->where('destination_id', $request->destination);
        }

        $packages = $query->orderBy('sort_order')->paginate(12);

        return view('pages.packages.index', compact('packages'));
    }

    public function show(string $locale, string $slug)
    {
        $package = TourismPackage::active()
            ->with('destination')
            ->whereRaw("(slug->>?) = ?", [$locale, $slug])
            ->firstOrFail();

        return view('pages.packages.show', compact('package'));
    }
}
