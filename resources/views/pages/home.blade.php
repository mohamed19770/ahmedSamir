@extends('layouts.app')

@section('meta_title', __('general.site_name') . ' - ' . __('general.tagline'))
@section('meta_description', __('home.hero_subtitle'))

@section('content')
@php $locale = app()->getLocale(); $isRtl = in_array($locale, config('locales.rtl', [])); @endphp

<!-- Hero Section -->
<section class="relative h-screen min-h-[700px] flex items-center overflow-hidden">
    <!-- Background -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1506929562872-bb421503ef21?w=1920&q=80"
             alt="Luxury Travel" class="w-full h-full object-cover" loading="eager">
        <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-black/30"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
    </div>

    <!-- Floating Elements -->
    <div class="absolute top-1/4 {{ $isRtl ? 'left-10' : 'right-10' }} w-72 h-72 bg-primary-500/20 rounded-full blur-3xl floating"></div>
    <div class="absolute bottom-1/4 {{ $isRtl ? 'right-10' : 'left-10' }} w-96 h-96 bg-secondary-500/10 rounded-full blur-3xl floating-slow"></div>

    <!-- Content -->
    <div class="container-custom relative z-10">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md rounded-full border border-white/20 mb-8 animate-fade-in">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                <span class="text-white/90 text-sm font-medium">{{ __('general.tagline') }}</span>
            </div>

            <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6 animate-slide-up">
                {{ __('home.hero_title') }}
            </h1>

            <p class="text-xl text-white/80 leading-relaxed mb-10 max-w-xl animate-slide-up animate-delay-200">
                {{ __('home.hero_subtitle') }}
            </p>

            <div class="flex flex-wrap gap-4 animate-slide-up animate-delay-300">
                <a href="{{ route('packages.index', $locale) }}" class="btn-primary text-lg px-10 py-4">
                    {{ __('home.hero_cta') }}
                    <svg class="w-5 h-5 {{ $isRtl ? 'mr-2 rotate-180' : 'ml-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                <a href="#" class="inline-flex items-center gap-3 px-8 py-4 text-white border-2 border-white/30 rounded-xl hover:bg-white/10 transition-all duration-300 font-semibold text-lg">
                    <span class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5 text-white {{ $isRtl ? '' : 'ml-0.5' }}" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </span>
                    {{ __('home.hero_cta_secondary') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce-slow">
        <div class="w-8 h-12 border-2 border-white/40 rounded-full flex justify-center pt-2">
            <div class="w-1.5 h-3 bg-white/60 rounded-full animate-pulse"></div>
        </div>
    </div>
</section>

<!-- Search Section -->
<section class="relative -mt-24 z-20 pb-12">
    <div class="container-custom">
        <div class="glass rounded-3xl p-8 shadow-2xl">
            <form action="{{ route('search', $locale) }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('home.search_destination') }}</label>
                    <div class="relative">
                        <svg class="absolute {{ $isRtl ? 'right-4' : 'left-4' }} top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                        <input type="text" name="destination" placeholder="{{ __('home.search_destination') }}" class="input-luxury {{ $isRtl ? 'pr-12' : 'pl-12' }}">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('home.search_date') }}</label>
                    <input type="date" name="date" class="input-luxury">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('home.search_guests') }}</label>
                    <select name="guests" class="input-luxury">
                        @for($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}">{{ $i }} {{ __('general.guests') }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn-primary w-full py-4">
                        <svg class="w-5 h-5 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        {{ __('home.search_btn') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Featured Destinations -->
<section class="section-padding bg-gray-50/50">
    <div class="container-custom">
        <div class="text-center mb-16" x-data x-intersect="$el.classList.add('animate-slide-up')">
            <span class="inline-block px-4 py-1.5 bg-primary-100 text-primary-700 rounded-full text-sm font-semibold mb-4">{{ __('general.featured') }}</span>
            <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">{{ __('home.destinations_title') }}</h2>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto">{{ __('home.destinations_subtitle') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($destinations ?? [] as $index => $destination)
                <a href="#" class="card-luxury group" x-data x-intersect="$el.classList.add('animate-slide-up')" style="animation-delay: {{ $index * 100 }}ms">
                    <div class="relative h-72 overflow-hidden">
                        <img src="{{ $destination->image ?? 'https://images.unsplash.com/photo-1539768942893-daf53e736b68?w=800' }}"
                             alt="{{ $destination->getTranslation('name', $locale) ?? 'Destination' }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                        <div class="gradient-overlay"></div>
                        <div class="absolute bottom-6 {{ $isRtl ? 'right-6' : 'left-6' }}">
                            <h3 class="text-2xl font-bold text-white mb-1">{{ $destination->getTranslation('name', $locale) ?? 'Beautiful Destination' }}</h3>
                            <p class="text-white/80 text-sm">{{ $destination->country ?? '12 Tours Available' }}</p>
                        </div>
                    </div>
                </a>
            @empty
                @for($i = 0; $i < 3; $i++)
                    @php
                        $demoDestinations = [
                            ['name' => 'Santorini, Greece', 'image' => 'https://images.unsplash.com/photo-1613395877344-13d4a8e0d49e?w=800', 'tours' => '8 Tours'],
                            ['name' => 'Bali, Indonesia', 'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800', 'tours' => '12 Tours'],
                            ['name' => 'Dubai, UAE', 'image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=800', 'tours' => '15 Tours'],
                        ];
                    @endphp
                    <a href="#" class="card-luxury group" x-data x-intersect="$el.classList.add('animate-slide-up')" style="animation-delay: {{ $i * 100 }}ms">
                        <div class="relative h-72 overflow-hidden">
                            <img src="{{ $demoDestinations[$i]['image'] }}" alt="{{ $demoDestinations[$i]['name'] }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                            <div class="gradient-overlay"></div>
                            <div class="absolute bottom-6 {{ $isRtl ? 'right-6' : 'left-6' }}">
                                <h3 class="text-2xl font-bold text-white mb-1">{{ $demoDestinations[$i]['name'] }}</h3>
                                <p class="text-white/80 text-sm">{{ $demoDestinations[$i]['tours'] }}</p>
                            </div>
                        </div>
                    </a>
                @endfor
            @endforelse
        </div>
    </div>
</section>

<!-- Popular Packages -->
<section class="section-padding">
    <div class="container-custom">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-16">
            <div x-data x-intersect="$el.classList.add('animate-slide-up')">
                <span class="inline-block px-4 py-1.5 bg-gold-100 text-gold-700 rounded-full text-sm font-semibold mb-4">{{ __('general.popular') }}</span>
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">{{ __('home.packages_title') }}</h2>
                <p class="text-xl text-gray-500 max-w-xl">{{ __('home.packages_subtitle') }}</p>
            </div>
            <a href="{{ route('packages.index', $locale) }}" class="btn-secondary mt-6 md:mt-0">
                {{ __('general.view_all') }}
                <svg class="w-4 h-4 {{ $isRtl ? 'mr-2 rotate-180' : 'ml-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($packages ?? [] as $index => $package)
                <div class="card-luxury" x-data x-intersect="$el.classList.add('animate-slide-up')" style="animation-delay: {{ $index * 100 }}ms">
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ $package->image ?? 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800' }}"
                             alt="{{ $package->getTranslation('title', $locale) }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
                        @if($package->sale_price)
                            <div class="absolute top-4 {{ $isRtl ? 'left-4' : 'right-4' }} bg-red-500 text-white px-3 py-1 rounded-lg text-sm font-bold">SALE</div>
                        @endif
                        <div class="absolute top-4 {{ $isRtl ? 'right-4' : 'left-4' }} bg-white/90 backdrop-blur-sm px-3 py-1 rounded-lg text-sm font-semibold text-gray-700">
                            {{ $package->duration_days }} {{ __('general.days') }}
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-primary-600 transition-colors">
                            {{ $package->getTranslation('title', $locale) }}
                        </h3>
                        <p class="text-gray-500 mb-4 line-clamp-2">{{ $package->getTranslation('short_description', $locale) }}</p>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div>
                                <span class="text-sm text-gray-500">{{ __('general.price_from') }}</span>
                                <span class="text-2xl font-bold text-primary-600">${{ number_format($package->sale_price ?? $package->price) }}</span>
                            </div>
                            <a href="{{ route('packages.show', [$locale, $package->getTranslation('slug', $locale)]) }}" class="btn-primary text-sm px-5 py-2.5">
                                {{ __('general.book_now') }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                @for($i = 0; $i < 3; $i++)
                    @php
                        $demoPackages = [
                            ['title' => 'Desert Safari Adventure', 'desc' => 'Experience the thrill of desert safari with luxury camping under the stars.', 'days' => 3, 'price' => 599, 'image' => 'https://images.unsplash.com/photo-1451337516015-6b6e9a44a8a3?w=800'],
                            ['title' => 'Nile Cruise Experience', 'desc' => 'Sail the ancient Nile in pure luxury with guided historical tours.', 'days' => 5, 'price' => 1299, 'image' => 'https://images.unsplash.com/photo-1539650116574-75c0c6d73f6e?w=800'],
                            ['title' => 'Tropical Beach Getaway', 'desc' => 'Relax on pristine beaches with crystal clear waters and white sand.', 'days' => 7, 'price' => 1899, 'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800'],
                        ];
                    @endphp
                    <div class="card-luxury" x-data x-intersect="$el.classList.add('animate-slide-up')" style="animation-delay: {{ $i * 100 }}ms">
                        <div class="relative h-56 overflow-hidden">
                            <img src="{{ $demoPackages[$i]['image'] }}" alt="{{ $demoPackages[$i]['title'] }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
                            <div class="absolute top-4 {{ $isRtl ? 'right-4' : 'left-4' }} bg-white/90 backdrop-blur-sm px-3 py-1 rounded-lg text-sm font-semibold text-gray-700">
                                {{ $demoPackages[$i]['days'] }} {{ __('general.days') }}
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $demoPackages[$i]['title'] }}</h3>
                            <p class="text-gray-500 mb-4 line-clamp-2">{{ $demoPackages[$i]['desc'] }}</p>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div>
                                    <span class="text-sm text-gray-500">{{ __('general.price_from') }}</span>
                                    <span class="text-2xl font-bold text-primary-600">${{ number_format($demoPackages[$i]['price']) }}</span>
                                </div>
                                <a href="#" class="btn-primary text-sm px-5 py-2.5">{{ __('general.book_now') }}</a>
                            </div>
                        </div>
                    </div>
                @endfor
            @endforelse
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="section-padding bg-gradient-to-br from-primary-900 via-primary-800 to-dark-900 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 {{ $isRtl ? 'left-0' : 'right-0' }} w-96 h-96 bg-primary-400 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 {{ $isRtl ? 'right-0' : 'left-0' }} w-80 h-80 bg-secondary-400 rounded-full blur-3xl"></div>
    </div>

    <div class="container-custom relative z-10">
        <div class="text-center mb-16" x-data x-intersect="$el.classList.add('animate-slide-up')">
            <span class="inline-block px-4 py-1.5 bg-white/10 text-white/90 rounded-full text-sm font-semibold mb-4 backdrop-blur-sm border border-white/20">✨ {{ __('home.why_title') }}</span>
            <h2 class="text-4xl lg:text-5xl font-bold text-white mb-4">{{ __('home.why_title') }}</h2>
            <p class="text-xl text-white/70 max-w-2xl mx-auto">{{ __('home.why_subtitle') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
                $features = [
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>', 'title' => __('home.why_experience'), 'desc' => __('home.why_experience_desc')],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>', 'title' => __('home.why_support'), 'desc' => __('home.why_support_desc')],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>', 'title' => __('home.why_custom'), 'desc' => __('home.why_custom_desc')],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>', 'title' => __('home.why_value'), 'desc' => __('home.why_value_desc')],
                ];
            @endphp

            @foreach($features as $index => $feature)
                <div class="text-center p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-500 group"
                     x-data x-intersect="$el.classList.add('animate-slide-up')" style="animation-delay: {{ $index * 100 }}ms">
                    <div class="w-16 h-16 mx-auto mb-6 bg-gradient-to-br from-primary-400 to-primary-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $feature['icon'] !!}</svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-3">{{ $feature['title'] }}</h3>
                    <p class="text-white/60 text-sm leading-relaxed">{{ $feature['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Statistics Counter -->
<section class="py-20 bg-white">
    <div class="container-custom">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
            @php
                $stats = [
                    ['target' => 15000, 'label' => __('home.stats_travelers'), 'suffix' => '+'],
                    ['target' => 120, 'label' => __('home.stats_destinations'), 'suffix' => '+'],
                    ['target' => 8500, 'label' => __('home.stats_tours'), 'suffix' => '+'],
                    ['target' => 4.9, 'label' => __('home.stats_rating'), 'suffix' => '/5'],
                ];
            @endphp

            @foreach($stats as $stat)
                <div class="text-center" x-data="counter" data-target="{{ $stat['target'] }}" x-intersect="start()">
                    <div class="text-4xl lg:text-5xl font-bold gradient-text mb-2">
                        <span x-text="Math.round(count).toLocaleString()">0</span><span>{{ $stat['suffix'] }}</span>
                    </div>
                    <p class="text-gray-500 font-medium">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="section-padding bg-gray-50/50">
    <div class="container-custom">
        <div class="text-center mb-16" x-data x-intersect="$el.classList.add('animate-slide-up')">
            <span class="inline-block px-4 py-1.5 bg-secondary-100 text-secondary-700 rounded-full text-sm font-semibold mb-4">⭐ {{ __('general.testimonials') }}</span>
            <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">{{ __('home.testimonials_title') }}</h2>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto">{{ __('home.testimonials_subtitle') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($testimonials ?? [] as $testimonial)
                <div class="card-glass">
                    <div class="flex items-center gap-1 mb-4">
                        @for($s = 1; $s <= 5; $s++)
                            <svg class="w-5 h-5 {{ $s <= $testimonial->rating ? 'text-gold-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <p class="text-gray-600 mb-6 leading-relaxed italic">"{{ $testimonial->getTranslation('content', $locale) }}"</p>
                    <div class="flex items-center gap-3">
                        <img src="{{ $testimonial->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($testimonial->name) }}" alt="{{ $testimonial->name }}" class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $testimonial->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $testimonial->designation }}</p>
                        </div>
                    </div>
                </div>
            @empty
                @php
                    $demoTestimonials = [
                        ['name' => 'Sarah Johnson', 'role' => 'Travel Enthusiast', 'content' => 'An absolutely incredible experience! The team at Designation 2 Go made every moment of our trip magical and unforgettable.', 'rating' => 5],
                        ['name' => 'Ahmed Hassan', 'role' => 'Business Traveler', 'content' => 'Professional service from start to finish. They handled every detail perfectly and exceeded all my expectations.', 'rating' => 5],
                        ['name' => 'Maria Kovač', 'role' => 'Adventure Seeker', 'content' => 'The best travel agency I have ever worked with. Their attention to detail and personalized service is unmatched.', 'rating' => 5],
                    ];
                @endphp
                @foreach($demoTestimonials as $t)
                    <div class="card-glass">
                        <div class="flex items-center gap-1 mb-4">
                            @for($s = 1; $s <= 5; $s++)
                                <svg class="w-5 h-5 text-gold-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <p class="text-gray-600 mb-6 leading-relaxed italic">"{{ $t['content'] }}"</p>
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($t['name']) }}&background=0ea5e9&color=fff" alt="{{ $t['name'] }}" class="w-12 h-12 rounded-full">
                            <div>
                                <h4 class="font-semibold text-gray-900">{{ $t['name'] }}</h4>
                                <p class="text-sm text-gray-500">{{ $t['role'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

<!-- Newsletter -->
<section class="section-padding bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900 relative overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute top-10 {{ $isRtl ? 'left-10' : 'right-10' }} w-64 h-64 bg-white/5 rounded-full blur-2xl"></div>
        <div class="absolute bottom-10 {{ $isRtl ? 'right-10' : 'left-10' }} w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
    </div>

    <div class="container-custom relative z-10">
        <div class="max-w-2xl mx-auto text-center">
            <h2 class="text-4xl lg:text-5xl font-bold text-white mb-4">{{ __('home.newsletter_title') }}</h2>
            <p class="text-xl text-white/80 mb-10">{{ __('home.newsletter_subtitle') }}</p>

            <form action="{{ route('newsletter.store') }}" method="POST" class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto" x-data="{ submitted: false, email: '' }">
                @csrf
                <input type="email" name="email" x-model="email" required
                       placeholder="{{ __('home.newsletter_placeholder') }}"
                       class="flex-1 px-6 py-4 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-white/60 focus:ring-2 focus:ring-white/40 focus:border-transparent outline-none transition-all">
                <button type="submit" class="px-8 py-4 bg-white text-primary-700 font-bold rounded-xl hover:bg-gray-100 hover:-translate-y-0.5 transition-all duration-300 shadow-lg whitespace-nowrap">
                    {{ __('general.subscribe') }}
                </button>
            </form>
        </div>
    </div>
</section>

@endsection
