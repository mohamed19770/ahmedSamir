<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Faq;
use App\Models\Testimonial;
use App\Models\TourismPackage;
use App\Models\Activity;
use App\Models\BlogPost;
use App\Models\Partner;
use App\Models\Slider;
use App\Services\SchemaService;

class HomeController extends Controller
{
    public function index(string $locale, SchemaService $schema)
    {
        $sliders = Slider::active()->orderBy('sort_order')->get();
        $destinations = Destination::active()->featured()->orderBy('sort_order')->take(6)->get();
        $packages = TourismPackage::active()->featured()->with('destination')->orderBy('sort_order')->take(6)->get();
        $activities = Activity::active()->featured()->orderBy('sort_order')->take(6)->get();
        $testimonials = Testimonial::active()->featured()->orderBy('sort_order')->take(6)->get();
        $posts = BlogPost::published()->latest('published_at')->take(3)->get();
        $partners = Partner::active()->orderBy('sort_order')->get();
        $faqs = Faq::active()->where('category', 'home')->orderBy('sort_order')->take(6)->get();

        $this->shareSeo('home');

        $this->shareSchemas(
            $schema->breadcrumbList([
                ['name' => __('general.home'), 'url' => route('home', $locale)],
            ]),
            $faqs->isNotEmpty() ? $schema->faqPage($faqs, $locale) : null
        );

        return view('pages.home', compact(
            'sliders', 'destinations', 'packages', 'activities',
            'testimonials', 'posts', 'partners', 'faqs'
        ));
    }
}
