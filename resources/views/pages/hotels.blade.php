@extends('layouts.app')

@section('meta_title', __('general.hotels') . ' - ' . __('general.site_name'))

@section('content')
@php $locale = app()->getLocale(); $isRtl = in_array($locale, config('locales.rtl', [])); @endphp

<!-- Hero -->
<section class="relative pt-32 pb-20 bg-gradient-to-br from-primary-900 to-dark-900">
    <div class="absolute inset-0 opacity-20">
        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1920" alt="" class="w-full h-full object-cover">
    </div>
    <div class="absolute inset-0 bg-gradient-to-b from-primary-900/80 to-dark-900/90"></div>
    <div class="container-custom relative z-10">
        <span class="inline-block px-4 py-1.5 bg-white/10 text-white/90 rounded-full text-sm font-semibold mb-6 backdrop-blur-sm border border-white/20">{{ __('general.hotels') }}</span>
        <h1 class="text-5xl lg:text-6xl font-bold text-white mb-4">{{ __('general.hotels') }}</h1>
        <p class="text-xl text-white/70 max-w-2xl">Luxurious accommodations handpicked for the perfect stay.</p>
    </div>
</section>

<!-- Hotels -->
<section class="section-padding">
    <div class="container-custom">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $demoHotels = [
                    ['name' => 'The Royal Palm Resort', 'location' => 'Maldives', 'stars' => 5, 'price' => 450, 'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800'],
                    ['name' => 'Azure Beach Hotel', 'location' => 'Santorini, Greece', 'stars' => 5, 'price' => 380, 'image' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=800'],
                    ['name' => 'Desert Oasis Resort', 'location' => 'Dubai, UAE', 'stars' => 5, 'price' => 520, 'image' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=800'],
                    ['name' => 'Mountain Lodge Retreat', 'location' => 'Swiss Alps', 'stars' => 4, 'price' => 290, 'image' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800'],
                    ['name' => 'Tropical Paradise Inn', 'location' => 'Bali, Indonesia', 'stars' => 4, 'price' => 180, 'image' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800'],
                    ['name' => 'Historic Palace Hotel', 'location' => 'Istanbul, Turkey', 'stars' => 5, 'price' => 350, 'image' => 'https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=800'],
                ];
            @endphp

            @foreach($demoHotels as $index => $hotel)
                <div class="card-luxury" x-data x-intersect="$el.classList.add('animate-slide-up')" style="animation-delay: {{ ($index % 3) * 100 }}ms">
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ $hotel['image'] }}" alt="{{ $hotel['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
                        <div class="absolute top-4 {{ $isRtl ? 'right-4' : 'left-4' }} flex items-center gap-0.5">
                            @for($s = 0; $s < $hotel['stars']; $s++)
                                <svg class="w-4 h-4 text-gold-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $hotel['name'] }}</h3>
                        <p class="text-gray-500 mb-4 flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            {{ $hotel['location'] }}
                        </p>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div>
                                <span class="text-sm text-gray-500">{{ __('general.price_from') }}</span>
                                <span class="text-2xl font-bold text-primary-600">${{ $hotel['price'] }}</span>
                                <span class="text-sm text-gray-400">/night</span>
                            </div>
                            <a href="#" class="btn-primary text-sm px-5 py-2.5">{{ __('general.book_now') }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
