<?php

namespace App\Http\Controllers;

use App\Models\TourismPackage;
use App\Models\Activity;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(string $locale, Request $request)
    {
        $query = $request->get('q', $request->get('destination', ''));

        $packages = collect();
        $activities = collect();

        if ($query) {
            $packages = TourismPackage::active()
                ->whereRaw("(title->>?) ILIKE ?", [$locale, "%{$query}%"])
                ->orWhereRaw("(description->>?) ILIKE ?", [$locale, "%{$query}%"])
                ->take(12)->get();

            $activities = Activity::active()
                ->whereRaw("(title->>?) ILIKE ?", [$locale, "%{$query}%"])
                ->orWhereRaw("(description->>?) ILIKE ?", [$locale, "%{$query}%"])
                ->take(12)->get();
        }

        return view('pages.search', compact('packages', 'activities', 'query'));
    }
}
