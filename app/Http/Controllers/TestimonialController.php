<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index(string $locale)
    {
        $testimonials = Testimonial::active()->orderBy('sort_order')->paginate(12);
        return view('pages.testimonials', compact('testimonials'));
    }
}
