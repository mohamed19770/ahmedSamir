<?php

namespace App\Http\Controllers;

class HotelController extends Controller
{
    public function index(string $locale)
    {
        $this->shareSeo('hotels');
        $this->shareBreadcrumbs([
            ['name' => __('general.home'), 'url' => route('home', $locale)],
            ['name' => __('general.hotels')],
        ]);

        return view('pages.hotels');
    }

    public function show(string $locale, string $slug)
    {
        $this->shareSeo('hotels');
        $this->shareBreadcrumbs([
            ['name' => __('general.home'), 'url' => route('home', $locale)],
            ['name' => __('general.hotels')],
        ]);

        return view('pages.hotels');
    }
}
