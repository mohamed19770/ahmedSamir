<?php

namespace App\Http\Controllers;

use App\Models\TourismPackage;
use App\Models\Faq;
use App\Models\Testimonial;
use App\Services\SchemaService;
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

        $this->shareSeo('tours', [
            'canonical' => route('tours.index', $locale),
        ]);
        $this->shareBreadcrumbs([
            ['name' => __('general.home'), 'url' => route('home', $locale)],
            ['name' => __('general.tours')],
        ]);

        return view('pages.packages.index', compact('packages'));
    }

    public function show(string $locale, string $slug, SchemaService $schema)
    {
        $package = TourismPackage::active()
            ->with('destination')
            ->whereRaw('(slug->>?) = ?', [$locale, $slug])
            ->firstOrFail();

        $relatedPackages = TourismPackage::active()
            ->where('id', '!=', $package->id)
            ->when($package->destination_id, fn ($q) => $q->where('destination_id', $package->destination_id))
            ->take(3)
            ->get();

        $faqs = Faq::active()->where('category', 'tours')->orderBy('sort_order')->take(6)->get();
        $testimonials = Testimonial::active()->featured()->take(3)->get();

        $canonicalUrl = route('tours.show', [$locale, $package->getTranslation('slug', $locale)]);

        $breadcrumbItems = [
            ['name' => __('general.home'), 'url' => route('home', $locale)],
            ['name' => __('general.tours'), 'url' => route('tours.index', $locale)],
            ['name' => $package->getTranslation('title', $locale)],
        ];

        $this->shareEntitySeo('package', 'tours.show', $package, [
            'canonical' => $canonicalUrl,
            'og_type' => 'product',
        ], array_filter([
            $schema->touristTrip($package, $locale),
            $schema->breadcrumbList($breadcrumbItems),
            $testimonials->isNotEmpty() ? [
                '@context' => 'https://schema.org',
                '@type' => 'Product',
                'name' => $package->getTranslation('title', $locale),
                'review' => $schema->reviews($testimonials, $locale),
            ] : null,
            $faqs->isNotEmpty() ? $schema->faqPage($faqs, $locale) : null,
        ]), $breadcrumbItems);

        return view('pages.packages.show', compact('package', 'relatedPackages', 'faqs', 'testimonials'));
    }
}
