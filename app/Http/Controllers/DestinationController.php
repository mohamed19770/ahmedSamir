<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Faq;
use App\Models\Testimonial;
use App\Models\TourismPackage;
use App\Services\SchemaService;

class DestinationController extends Controller
{
    public function index(string $locale)
    {
        $destinations = Destination::active()->orderBy('sort_order')->paginate(12);

        $this->shareSeo('destinations');
        $this->shareBreadcrumbs([
            ['name' => __('general.home'), 'url' => route('home', $locale)],
            ['name' => __('general.destinations')],
        ]);

        return view('pages.destinations.index', compact('destinations'));
    }

    public function show(string $locale, string $slug, SchemaService $schema)
    {
        $destination = Destination::active()
            ->whereRaw('(slug->>?) = ?', [$locale, $slug])
            ->firstOrFail();

        $packages = TourismPackage::active()
            ->where('destination_id', $destination->id)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $relatedDestinations = Destination::active()
            ->where('id', '!=', $destination->id)
            ->featured()
            ->take(3)
            ->get();

        $faqs = Faq::active()->where('category', 'destinations')->orderBy('sort_order')->take(6)->get();
        $testimonials = Testimonial::active()->featured()->take(3)->get();

        $breadcrumbItems = [
            ['name' => __('general.home'), 'url' => route('home', $locale)],
            ['name' => __('general.destinations'), 'url' => route('destinations.index', $locale)],
            ['name' => $destination->getTranslation('name', $locale)],
        ];

        $this->shareEntitySeo('destination', 'destinations.show', $destination, [
            'og_type' => 'article',
        ], array_filter([
            $schema->touristAttraction($destination, $locale),
            $schema->breadcrumbList($breadcrumbItems),
            $faqs->isNotEmpty() ? $schema->faqPage($faqs, $locale) : null,
        ]), $breadcrumbItems);

        return view('pages.destinations.show', compact(
            'destination', 'packages', 'relatedDestinations', 'faqs', 'testimonials'
        ));
    }
}
