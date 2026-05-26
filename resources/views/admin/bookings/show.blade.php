@extends('layouts.admin')

@section('title', 'Booking #' . $booking->booking_number)

@section('content')
<div class="max-w-4xl">
    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Booking Details</h2>
            <dl class="space-y-3">
                <div class="flex justify-between"><dt class="text-gray-500">Number</dt><dd class="font-semibold text-primary-600">{{ $booking->booking_number }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Guest</dt><dd class="font-medium">{{ $booking->guest_name }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Email</dt><dd>{{ $booking->guest_email }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Phone</dt><dd>{{ $booking->guest_phone }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Guests</dt><dd>{{ $booking->guests_count }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Check-in</dt><dd>{{ $booking->check_in_date?->format('M d, Y') }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Total</dt><dd class="text-xl font-bold">${{ number_format($booking->total_price, 2) }}</dd></div>
            </dl>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Update Status</h2>
            <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST" class="space-y-4">
                @csrf @method('PATCH')
                <select name="status" class="input-luxury">
                    @foreach(['pending', 'confirmed', 'completed', 'cancelled'] as $status)
                        <option value="{{ $status }}" {{ $booking->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-primary w-full">Update Status</button>
            </form>

            @if($booking->special_requests)
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <h3 class="font-semibold text-gray-900 mb-2">Special Requests</h3>
                    <p class="text-gray-600">{{ $booking->special_requests }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
