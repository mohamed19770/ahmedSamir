<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\TourismPackage;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(string $locale, Request $request)
    {
        $query = $request->get('q', $request->get('destination', ''));

        $packages = collect();
        $activities = collect();

        if ($query) {
            $like = '%'.$query.'%';

            $packages = TourismPackage::active()
                ->where(function ($builder) use ($locale, $like) {
                    $builder->whereRaw('(title->>?) LIKE ?', [$locale, $like])
                        ->orWhereRaw('(description->>?) LIKE ?', [$locale, $like]);
                })
                ->take(12)->get();

            $activities = Activity::active()
                ->where(function ($builder) use ($locale, $like) {
                    $builder->whereRaw('(title->>?) LIKE ?', [$locale, $like])
                        ->orWhereRaw('(description->>?) LIKE ?', [$locale, $like]);
                })
                ->take(12)->get();
        }

        $this->shareSeo('search', [
            'robots' => 'noindex, follow',
        ]);

        return view('pages.search', compact('packages', 'activities', 'query'));
    }
}
