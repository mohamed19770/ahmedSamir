<?php

namespace App\Http\Controllers;

class VisaController extends Controller
{
    public function index(string $locale)
    {
        $this->shareSeo('visa');
        $this->shareBreadcrumbs([
            ['name' => __('general.home'), 'url' => route('home', $locale)],
            ['name' => __('general.visa')],
        ]);

        return view('pages.visa');
    }
}
