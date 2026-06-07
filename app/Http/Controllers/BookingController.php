<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TourismPackage;
use App\Models\Activity;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create(string $locale, string $type, int $id)
    {
        $item = match ($type) {
            'package' => TourismPackage::findOrFail($id),
            'activity' => Activity::findOrFail($id),
            default => abort(404),
        };

        $this->shareSeo('booking', ['robots' => 'noindex, follow']);

        return view('pages.booking.create', compact('type', 'item'));
    }

    public function store(string $locale, Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:package,activity',
            'item_id' => 'required|integer',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:50',
            'guests_count' => 'required|integer|min:1|max:50',
            'check_in_date' => 'required|date|after:today',
            'check_out_date' => 'nullable|date|after:check_in_date',
            'special_requests' => 'nullable|string|max:2000',
        ]);

        $item = match ($validated['type']) {
            'package' => TourismPackage::findOrFail($validated['item_id']),
            'activity' => Activity::findOrFail($validated['item_id']),
        };

        $price = $item->sale_price ?? $item->price;
        $totalPrice = $price * $validated['guests_count'];

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'package_id' => $validated['type'] === 'package' ? $validated['item_id'] : null,
            'activity_id' => $validated['type'] === 'activity' ? $validated['item_id'] : null,
            'guest_name' => $validated['guest_name'],
            'guest_email' => $validated['guest_email'],
            'guest_phone' => $validated['guest_phone'],
            'guests_count' => $validated['guests_count'],
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'special_requests' => $validated['special_requests'],
            'total_price' => $totalPrice,
        ]);

        return redirect()->route('booking.confirmation', [$locale, $booking->booking_number])
            ->with('success', 'Booking confirmed successfully!');
    }

    public function confirmation(string $locale, string $bookingNumber)
    {
        $booking = Booking::where('booking_number', $bookingNumber)->firstOrFail();

        $this->shareSeo('booking', ['robots' => 'noindex, follow']);

        return view('pages.booking.confirmation', compact('booking'));
    }
}
