<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(string $locale, Request $request)
    {
        $query = Gallery::active();

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        $galleries = $query->orderBy('sort_order')->get();

        return view('pages.gallery', compact('galleries'));
    }
}
