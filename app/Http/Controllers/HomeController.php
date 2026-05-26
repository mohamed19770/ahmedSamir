<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\TourismPackage;
use App\Models\Activity;
use App\Models\Testimonial;
use App\Models\BlogPost;
use App\Models\Partner;
use App\Models\Slider;

class HomeController extends Controller
{
    public function index(string $locale)
    {
        $sliders = Slider::active()->orderBy('sort_order')->get();
        $destinations = Destination::active()->featured()->orderBy('sort_order')->take(6)->get();
        $packages = TourismPackage::active()->featured()->with('destination')->orderBy('sort_order')->take(6)->get();
        $activities = Activity::active()->featured()->orderBy('sort_order')->take(6)->get();
        $testimonials = Testimonial::active()->featured()->orderBy('sort_order')->take(6)->get();
        $posts = BlogPost::published()->latest('published_at')->take(3)->get();
        $partners = Partner::active()->orderBy('sort_order')->get();

        return view('pages.home', compact(
            'sliders', 'destinations', 'packages', 'activities',
            'testimonials', 'posts', 'partners'
        ));
    }
}
