<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Services\SchemaService;

class FaqController extends Controller
{
    public function index(string $locale, SchemaService $schema)
    {
        $faqs = Faq::active()->orderBy('sort_order')->get();

        $this->shareSeo('faq');
        $this->shareBreadcrumbs([
            ['name' => __('general.home'), 'url' => route('home', $locale)],
            ['name' => __('general.faq')],
        ]);

        $this->shareSchemas($schema->faqPage($faqs, $locale));

        return view('pages.faq', compact('faqs'));
    }
}
