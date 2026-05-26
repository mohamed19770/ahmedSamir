<?php

namespace App\Http\Controllers;

class HotelController extends Controller
{
    public function index(string $locale)
    {
        return view('pages.hotels');
    }

    public function show(string $locale, string $slug)
    {
        return view('pages.hotels');
    }
}
