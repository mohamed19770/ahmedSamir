<?php

namespace App\Http\Controllers;

class TransportController extends Controller
{
    public function index(string $locale)
    {
        $this->shareSeo('transportation');
        $this->shareBreadcrumbs([
            ['name' => __('general.home'), 'url' => route('home', $locale)],
            ['name' => __('general.transportation')],
        ]);

        return view('pages.transportation');
    }

    public function show(string $locale, string $slug)
    {
        $this->shareSeo('transportation');
        $this->shareBreadcrumbs([
            ['name' => __('general.home'), 'url' => route('home', $locale)],
            ['name' => __('general.transportation')],
        ]);

        return view('pages.transportation');
    }
}
