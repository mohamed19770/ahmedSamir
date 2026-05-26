<?php

namespace App\Http\Controllers;

class TransportController extends Controller
{
    public function index(string $locale)
    {
        return view('pages.transportation');
    }

    public function show(string $locale, string $slug)
    {
        return view('pages.transportation');
    }
}
