@extends('layouts.app')

@section('content')
@php $locale = app()->getLocale(); $isRtl = in_array($locale, config('locales.rtl', [])); @endphp

<x-page-hero :title="__('general.transportation')" :badge="__('general.transportation')" subtitle="Premium transportation services for a seamless travel experience." />

<!-- Services -->
<section class="section-padding">
    <div class="container-custom">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $transportServices = [
                    ['title' => 'Airport Pickup', 'desc' => 'Professional meet and greet with luxury vehicle at any airport.', 'price' => 'From $45', 'image' => 'https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?w=800'],
                    ['title' => 'Private Chauffeur', 'desc' => 'Full-day private chauffeur service with luxury sedan.', 'price' => 'From $200/day', 'image' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0afe?w=800'],
                    ['title' => 'Luxury Limousine', 'desc' => 'Travel in style with our premium limousine fleet.', 'price' => 'From $350', 'image' => 'https://images.unsplash.com/photo-1563720223185-11003d516935?w=800'],
                    ['title' => 'Group Transport', 'desc' => 'Spacious vehicles for group tours and family travel.', 'price' => 'From $150', 'image' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=800'],
                    ['title' => 'Yacht Charter', 'desc' => 'Exclusive yacht charter for coastal exploration.', 'price' => 'From $800', 'image' => 'https://images.unsplash.com/photo-1567899378494-47b22a2ae96a?w=800'],
                    ['title' => 'Helicopter Tour', 'desc' => 'Aerial tours and VIP transfers by helicopter.', 'price' => 'From $500', 'image' => 'https://images.unsplash.com/photo-1474302770737-173ee21bab63?w=800'],
                ];
            @endphp

            @foreach($transportServices as $index => $service)
                <div class="card-luxury" x-data x-intersect="$el.classList.add('animate-slide-up')" style="animation-delay: {{ ($index % 3) * 100 }}ms">
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ $service['image'] }}" alt="{{ $service['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $service['title'] }}</h3>
                        <p class="text-gray-500 mb-4">{{ $service['desc'] }}</p>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <span class="text-lg font-bold text-primary-600">{{ $service['price'] }}</span>
                            <a href="{{ route('contact.index', $locale) }}" class="btn-primary text-sm px-5 py-2.5">{{ __('general.book_now') }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
