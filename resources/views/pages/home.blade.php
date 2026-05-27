@extends('layouts.app')

@section('meta_title', __('general.site_name') . ' - ' . __('general.tagline'))
@section('meta_description', __('home.hero_subtitle'))

@section('content')
@php
    $locale = app()->getLocale();
    $isRtl = in_array($locale, config('locales.rtl', []));

    $defaultHeroSlides = [
        ['image' => 'https://images.unsplash.com/photo-1506929562872-bb421503ef21?w=1920&q=80', 'alt' => 'Luxury Travel'],
        ['image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1920&q=80', 'alt' => 'Beach Paradise'],
        ['image' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1920&q=80', 'alt' => 'Mountain Adventure'],
        ['image' => 'https://images.unsplash.com/photo-1539650116574-75c0c6d73f6e?w=1920&q=80', 'alt' => 'Historic Destination'],
        ['image' => 'https://images.unsplash.com/photo-1451337516015-6b6e9a44a8a3?w=1920&q=80', 'alt' => 'Desert Safari'],
    ];

    $heroSlides = ($sliders ?? collect())->map(function ($slider) use ($locale) {
        $image = $slider->image;
        if ($image && ! str_starts_with($image, 'http')) {
            $image = asset('storage/' . ltrim($image, '/'));
        }
        return [
            'image' => $image,
            'alt' => $slider->getTranslation('title', $locale) ?: __('general.site_name'),
        ];
    })->filter(fn ($slide) => ! empty($slide['image']))->values();

    if ($heroSlides->count() < 2) {
        $heroSlides = collect($defaultHeroSlides);
    }
@endphp

<!-- Hero Section -->
<section
    class="relative h-screen min-h-[700px] flex items-center overflow-hidden"
    x-data="heroSlider"
    data-slides='@json($heroSlides->values()->all())'
>
    <!-- Background Slideshow -->
    <div class="absolute inset-0 bg-gray-900">
        <template x-for="(slide, index) in slides" :key="index">
            <img
                :src="slide.image"
                :alt="slide.alt"
                class="hero-slide"
                :class="current === index ? 'hero-slide-active' : 'hero-slide-inactive'"
                :loading="index === 0 ? 'eager' : 'lazy'"
            >
        </template>
        <div class="absolute inset-0 z-[2] bg-gradient-to-r from-black/70 via-black/50 to-black/30"></div>
        <div class="absolute inset-0 z-[2] bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
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
                    <span class="btn-icon-wrap btn-icon-wrap-sm {{ $isRtl ? 'mr-1.5' : 'ml-1.5' }}">
                        <x-icon name="{{ $isRtl ? 'arrow-left' : 'arrow-right' }}" class="w-3 h-3" />
                    </span>
                </a>
                <a href="#" class="inline-flex items-center gap-2.5 px-8 py-4 text-white border-2 border-white/30 rounded-xl hover:bg-white/10 transition-all duration-300 font-semibold text-lg">
                    <span class="btn-icon-wrap btn-icon-wrap-md">
                        <x-icon name="play" class="w-3 h-3 text-white" />
                    </span>
                    {{ __('home.hero_cta_secondary') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Slide Indicators -->
    <div class="absolute bottom-20 left-1/2 -translate-x-1/2 z-10 flex items-center gap-2" x-show="slides.length > 1" x-cloak>
        <template x-for="(slide, index) in slides" :key="'dot-' + index">
            <button
                type="button"
                @click="goTo(index)"
                class="h-2 rounded-full transition-all duration-300"
                :class="current === index ? 'w-8 bg-white' : 'w-2 bg-white/40 hover:bg-white/70'"
                :aria-label="'Slide ' + (index + 1)"
            ></button>
        </template>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 animate-bounce-slow">
        <div class="w-8 h-12 border-2 border-white/40 rounded-full flex justify-center pt-2">
            <div class="w-1.5 h-3 bg-white/60 rounded-full animate-pulse"></div>
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
                <x-icon name="{{ $isRtl ? 'arrow-left' : 'arrow-right' }}" class="w-3.5 h-3.5 {{ $isRtl ? 'mr-1.5' : 'ml-1.5' }}" />
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
                    ['icon' => 'clock', 'title' => __('home.why_experience'), 'desc' => __('home.why_experience_desc')],
                    ['icon' => 'headset', 'title' => __('home.why_support'), 'desc' => __('home.why_support_desc')],
                    ['icon' => 'puzzle', 'title' => __('home.why_custom'), 'desc' => __('home.why_custom_desc')],
                    ['icon' => 'currency', 'title' => __('home.why_value'), 'desc' => __('home.why_value_desc')],
                ];
            @endphp

            @foreach($features as $index => $feature)
                <div class="text-center p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-500 group"
                     x-data x-intersect="$el.classList.add('animate-slide-up')" style="animation-delay: {{ $index * 100 }}ms">
                    <x-icon-box :name="$feature['icon']" size="md" variant="primary" class="mx-auto -mt-1 mb-4 group-hover:scale-105" />
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
                            <x-icon name="star" variant="solid" class="w-4 h-4 {{ $s <= $testimonial->rating ? 'text-gold-400' : 'text-gray-300' }}" />
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
                                <x-icon name="star" variant="solid" class="w-4 h-4 text-gold-400" />
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
