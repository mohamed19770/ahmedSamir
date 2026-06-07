<?php

namespace App\Http\Controllers;

class AboutController extends Controller
{
    public function index(string $locale)
    {
        $this->shareSeo('about');
        $this->shareBreadcrumbs([
            ['name' => __('general.home'), 'url' => route('home', $locale)],
            ['name' => __('general.about')],
        ]);

        return view('pages.about');
    }
}
