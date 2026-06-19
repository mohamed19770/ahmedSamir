<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'status' => 'nullable|in:new,read,replied,closed',
            'type' => 'nullable|in:general,booking,visa,transport,custom',
        ]);

        $query = Inquiry::latest();
        if ($request->filled('status')) { $query->byStatus($request->status); }
        if ($request->filled('type')) { $query->byType($request->type); }

        $inquiries = $query->paginate(20);
        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function show(Inquiry $inquiry)
    {
        if ($inquiry->status === 'new') { $inquiry->update(['status' => 'read']); }
        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function reply(Request $request, Inquiry $inquiry)
    {
        $inquiry->update(['status' => 'replied', 'replied_at' => now()]);
        return back()->with('success', 'Inquiry marked as replied.');
    }

    public function updateStatus(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate(['status' => 'required|in:new,read,replied,closed']);
        $inquiry->update($validated);
        return back()->with('success', 'Status updated.');
    }
}
