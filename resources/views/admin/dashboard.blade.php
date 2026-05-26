@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    @php
        $statsCards = [
            ['label' => 'Total Bookings', 'value' => $totalBookings ?? 0, 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'color' => 'primary', 'change' => '+12%'],
            ['label' => 'Revenue', 'value' => '$' . number_format($revenue ?? 0), 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'green', 'change' => '+8%'],
            ['label' => 'New Inquiries', 'value' => $newInquiries ?? 0, 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'color' => 'gold', 'change' => '+5%'],
            ['label' => 'Active Packages', 'value' => $activePackages ?? 0, 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10', 'color' => 'secondary', 'change' => '+2'],
        ];
    @endphp

    @foreach($statsCards as $card)
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-{{ $card['color'] }}-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-{{ $card['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-full">{{ $card['change'] }}</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $card['value'] }}</h3>
            <p class="text-sm text-gray-500">{{ $card['label'] }}</p>
        </div>
    @endforeach
</div>

<!-- Recent Bookings & Inquiries -->
<div class="grid lg:grid-cols-2 gap-6">
    <!-- Recent Bookings -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between p-6 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-900">Recent Bookings</h2>
            <a href="{{ route('admin.bookings.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">View All</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($recentBookings ?? [] as $booking)
                <div class="flex items-center justify-between p-4 hover:bg-gray-50 transition-colors">
                    <div>
                        <p class="font-medium text-gray-900">{{ $booking->guest_name }}</p>
                        <p class="text-sm text-gray-500">#{{ $booking->booking_number }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-medium
                        {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
            @empty
                <div class="p-8 text-center text-gray-400">
                    <p>No recent bookings</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Inquiries -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between p-6 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-900">Recent Inquiries</h2>
            <a href="{{ route('admin.inquiries.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">View All</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($recentInquiries ?? [] as $inquiry)
                <div class="flex items-center justify-between p-4 hover:bg-gray-50 transition-colors">
                    <div>
                        <p class="font-medium text-gray-900">{{ $inquiry->name }}</p>
                        <p class="text-sm text-gray-500">{{ Str::limit($inquiry->subject, 40) }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-medium
                        {{ $inquiry->status === 'new' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $inquiry->status === 'read' ? 'bg-gray-100 text-gray-700' : '' }}
                        {{ $inquiry->status === 'replied' ? 'bg-green-100 text-green-700' : '' }}">
                        {{ ucfirst($inquiry->status) }}
                    </span>
                </div>
            @empty
                <div class="p-8 text-center text-gray-400">
                    <p>No recent inquiries</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
