@extends('layouts.app')

@section('content')
@php $locale = app()->getLocale(); $isRtl = in_array($locale, config('locales.rtl', [])); @endphp

<x-page-hero :title="__('general.book_now')" subtitle="Complete your booking in just a few steps." />

<!-- Booking Form -->
<section class="section-padding">
    <div class="container-custom max-w-4xl">
        <div class="grid lg:grid-cols-3 gap-12">
            <!-- Form -->
            <div class="lg:col-span-2">
                <div class="card-glass p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8">Booking Details</h2>

                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('booking.store', $locale) }}" method="POST" class="space-y-6" x-data="{ guests: 1, totalPrice: {{ $item->sale_price ?? $item->price ?? 0 }} }">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">
                        <input type="hidden" name="item_id" value="{{ $item->id ?? '' }}">

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                                <input type="text" name="guest_name" required value="{{ old('guest_name', auth()->user()->name ?? '') }}" class="input-luxury">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                                <input type="email" name="guest_email" required value="{{ old('guest_email', auth()->user()->email ?? '') }}" class="input-luxury">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Phone *</label>
                                <input type="tel" name="guest_phone" required value="{{ old('guest_phone') }}" class="input-luxury">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Number of Guests *</label>
                                <select name="guests_count" x-model="guests" @change="totalPrice = guests * {{ $item->sale_price ?? $item->price ?? 0 }}" class="input-luxury">
                                    @for($i = 1; $i <= ($item->max_guests ?? 10); $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Check-in Date *</label>
                                <input type="date" name="check_in_date" required value="{{ old('check_in_date') }}" min="{{ date('Y-m-d') }}" class="input-luxury">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Check-out Date</label>
                                <input type="date" name="check_out_date" value="{{ old('check_out_date') }}" class="input-luxury">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Special Requests</label>
                            <textarea name="special_requests" rows="4" class="input-luxury resize-none" placeholder="Any dietary requirements, accessibility needs, or special celebrations...">{{ old('special_requests') }}</textarea>
                        </div>

                        <div class="pt-6 border-t border-gray-200">
                            <div class="flex items-center justify-between mb-6">
                                <span class="text-lg font-semibold text-gray-700">Total Price:</span>
                                <span class="text-3xl font-bold text-primary-600">$<span x-text="totalPrice.toLocaleString()">0</span></span>
                            </div>
                            <button type="submit" class="btn-primary w-full text-lg py-4">
                                Confirm Booking
                                <svg class="w-5 h-5 {{ $isRtl ? 'mr-2 rotate-180' : 'ml-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-28 glass rounded-2xl p-6 shadow-xl">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Booking Summary</h3>
                    @if(isset($item))
                        <img src="{{ $item->image }}" alt="" class="w-full h-40 object-cover rounded-xl mb-4">
                        <h4 class="font-semibold text-gray-900 mb-2">{{ $item->getTranslation('title', $locale) ?? '' }}</h4>
                        @if(isset($item->duration_days))
                            <p class="text-sm text-gray-500 mb-4">{{ $item->duration_days }} {{ __('general.days') }}</p>
                        @endif
                    @endif
                    <div class="space-y-3 text-sm border-t border-gray-200 pt-4">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Price per person</span>
                            <span class="font-semibold">${{ number_format($item->sale_price ?? $item->price ?? 0) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Guests</span>
                            <span class="font-semibold" x-text="guests">1</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
