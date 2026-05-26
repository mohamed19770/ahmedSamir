<?php

namespace App\Http\Controllers;

class VisaController extends Controller
{
    public function index(string $locale)
    {
        return view('pages.visa');
    }
}
