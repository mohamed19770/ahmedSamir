@extends('layouts.admin')

@section('title', 'Bookings')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <div class="flex items-center gap-3">
            @foreach(['all', 'pending', 'confirmed', 'completed', 'cancelled'] as $status)
                <a href="{{ route('admin.bookings.index', $status === 'all' ? [] : ['status' => $status]) }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ (request('status') ?? 'all') === $status ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition-colors capitalize">
                    {{ $status }}
                </a>
            @endforeach
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-6 py-3 text-sm font-semibold text-gray-600">Booking #</th>
                    <th class="text-left px-6 py-3 text-sm font-semibold text-gray-600">Guest</th>
                    <th class="text-left px-6 py-3 text-sm font-semibold text-gray-600">Date</th>
                    <th class="text-left px-6 py-3 text-sm font-semibold text-gray-600">Total</th>
                    <th class="text-left px-6 py-3 text-sm font-semibold text-gray-600">Status</th>
                    <th class="text-right px-6 py-3 text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($bookings as $booking)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-mono text-sm text-primary-600 font-semibold">{{ $booking->booking_number }}</td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-900">{{ $booking->guest_name }}</p>
                            <p class="text-sm text-gray-500">{{ $booking->guest_email }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $booking->check_in_date?->format('M d, Y') }}</td>
                        <td class="px-6 py-4 font-semibold">${{ number_format($booking->total_price, 2) }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $booking->status === 'completed' ? 'bg-blue-100 text-blue-700' : '' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.bookings.show', $booking) }}" class="text-primary-600 hover:text-primary-700 font-medium text-sm">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">No bookings found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($bookings->hasPages())
        <div class="p-4 border-t border-gray-100">{{ $bookings->links() }}</div>
    @endif
</div>
@endsection
