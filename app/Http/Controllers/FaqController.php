<?php

namespace App\Http\Controllers;

use App\Models\Faq;

class FaqController extends Controller
{
    public function index(string $locale)
    {
        $faqs = Faq::active()->orderBy('sort_order')->get();
        return view('pages.faq', compact('faqs'));
    }
}
