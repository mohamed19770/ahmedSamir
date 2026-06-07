<?php

namespace App\Http\Controllers;

class CareerController extends Controller
{
    public function index(string $locale)
    {
        $this->shareSeo('careers');
        $this->shareBreadcrumbs([
            ['name' => __('general.home'), 'url' => route('home', $locale)],
            ['name' => __('general.careers')],
        ]);

        return view('pages.careers');
    }
}
