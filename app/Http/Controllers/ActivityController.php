<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Faq;
use App\Models\TourismPackage;
use App\Services\SchemaService;
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

        $this->shareSeo('activities');
        $this->shareBreadcrumbs([
            ['name' => __('general.home'), 'url' => route('home', $locale)],
            ['name' => __('general.activities')],
        ]);

        return view('pages.activities.index', compact('activities'));
    }

    public function show(string $locale, string $slug, SchemaService $schema)
    {
        $activity = Activity::active()
            ->whereRaw('(slug->>?) = ?', [$locale, $slug])
            ->firstOrFail();

        $faqs = Faq::active()->where('category', 'activities')->orderBy('sort_order')->take(6)->get();

        $breadcrumbItems = [
            ['name' => __('general.home'), 'url' => route('home', $locale)],
            ['name' => __('general.activities'), 'url' => route('activities.index', $locale)],
            ['name' => $activity->getTranslation('title', $locale)],
        ];

        $this->shareEntitySeo('activity', 'activities.show', $activity, [
            'og_type' => 'product',
        ], array_filter([
            $schema->touristTrip($activity, $locale),
            $schema->breadcrumbList($breadcrumbItems),
            $faqs->isNotEmpty() ? $schema->faqPage($faqs, $locale) : null,
        ]), $breadcrumbItems);

        return view('pages.activities.show', compact('activity', 'faqs'));
    }
}
