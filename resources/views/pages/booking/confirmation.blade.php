@extends('layouts.app')

@section('content')
@php $locale = app()->getLocale(); @endphp

<section class="pt-32 pb-20">
    <div class="container-custom max-w-2xl text-center">
        <div class="bg-white rounded-3xl shadow-xl p-12 border border-gray-100">
            <div class="w-20 h-20 mx-auto mb-8 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-4">Booking Confirmed!</h1>
            <p class="text-gray-500 text-lg mb-8">Your booking has been successfully submitted. We'll contact you shortly with confirmation details.</p>

            <div class="bg-gray-50 rounded-2xl p-6 text-left mb-8">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="text-sm text-gray-500">Booking Number</span>
                        <p class="font-bold text-primary-600 text-lg">{{ $booking->booking_number }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Status</span>
                        <p class="font-semibold text-gray-900 capitalize">{{ $booking->status }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Guest</span>
                        <p class="font-semibold text-gray-900">{{ $booking->guest_name }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Total</span>
                        <p class="font-bold text-gray-900">${{ number_format($booking->total_price, 2) }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Check-in</span>
                        <p class="font-semibold text-gray-900">{{ $booking->check_in_date?->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Guests</span>
                        <p class="font-semibold text-gray-900">{{ $booking->guests_count }}</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('home', $locale) }}" class="btn-primary">Back to Home</a>
                <a href="{{ route('packages.index', $locale) }}" class="btn-secondary">Browse Packages</a>
            </div>
        </div>
    </div>
</section>
@endsection
