<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(string $locale, Request $request)
    {
        $query = Activity::active();

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        $activities = $query->orderBy('sort_order')->paginate(12);

        return view('pages.activities.index', compact('activities'));
    }

    public function show(string $locale, string $slug)
    {
        $activity = Activity::active()
            ->whereRaw("(slug->>?) = ?", [$locale, $slug])
            ->firstOrFail();

        return view('pages.activities.show', compact('activity'));
    }
}
