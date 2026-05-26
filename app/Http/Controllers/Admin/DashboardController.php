<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Inquiry;
use App\Models\TourismPackage;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBookings = Booking::count();
        $revenue = Booking::where('payment_status', 'paid')->sum('total_price');
        $newInquiries = Inquiry::unread()->count();
        $activePackages = TourismPackage::active()->count();
        $recentBookings = Booking::latest()->take(5)->get();
        $recentInquiries = Inquiry::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalBookings', 'revenue', 'newInquiries', 'activePackages',
            'recentBookings', 'recentInquiries'
        ));
    }
}
