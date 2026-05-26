<?php

namespace App\Http\Controllers;

class CareerController extends Controller
{
    public function index(string $locale)
    {
        return view('pages.careers');
    }
}
