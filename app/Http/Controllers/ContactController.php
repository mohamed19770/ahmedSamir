<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(string $locale)
    {
        $this->shareSeo('contact');
        $this->shareBreadcrumbs([
            ['name' => __('general.home'), 'url' => route('home', $locale)],
            ['name' => __('general.contact')],
        ]);

        return view('pages.contact');
    }

    public function store(string $locale, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
            'type' => 'nullable|in:general,booking,visa,transport,custom',
        ]);

        $validated['type'] = $validated['type'] ?? 'general';
        $validated['status'] = 'new';

        Inquiry::create($validated);

        return back()->with('success', 'Your message has been sent successfully. We will get back to you soon!');
    }
}
