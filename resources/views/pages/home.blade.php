@extends('layouts.app')

@php
    $locale = app()->getLocale();
    $isRtl = in_array($locale, config('locales.rtl', []));

    $heroSlides = collect(config('hero.slides', []))->map(function ($slide) {
        $id = $slide['id'];
        $image = $slide['image'];
        $branded = ! empty($slide['branded']);
        if (! str_starts_with($image, 'http')) {
            $image = '/'.ltrim($image, '/');
        }

        return [
            'image' => $image,
            'branded' => $branded,
            'hide_logo' => ! empty($slide['hide_logo']),
            'alt' => __("home.hero_slide_{$id}_alt"),
            'title' => $branded ? '' : __("home.hero_slide_{$id}_title"),
            'subtitle' => $branded ? '' : __("home.hero_slide_{$id}_subtitle"),
        ];
    })->values();

    $firstSlideBranded = (bool) ($heroSlides->first()['branded'] ?? false);
@endphp

@push('head')
    @if($heroSlides->isNotEmpty())
        <link rel="preload" as="image" href="{{ $heroSlides->first()['image'] }}">
    @endif
@endpush

@section('content')

<!-- Hero Slider -->
<section
    class="relative h-screen min-h-[700px] flex items-center overflow-hidden"
    x-data="heroSlider"
    data-slides='@json($heroSlides->all())'
>
    <div class="absolute inset-0 bg-gray-900">
        @foreach($heroSlides as $index => $slide)
            <img
                src="{{ $slide['image'] }}"
                alt="{{ $slide['alt'] }}"
                class="hero-slide-img {{ $index === 0 ? 'hero-slide-active' : 'hero-slide-inactive' }}"
                width="3840"
                height="2160"
                @if($index === 0) fetchpriority="high" @else loading="lazy" @endif
                decoding="async"
                data-slide-index="{{ $index }}"
            >
        @endforeach
        <div
            class="absolute inset-0 z-[2] bg-gradient-to-r from-black/45 via-black/20 to-transparent pointer-events-none transition-opacity duration-500"
            :class="slides[current]?.branded ? 'opacity-20' : 'opacity-100'"
        ></div>
        <div
            class="absolute inset-0 z-[2] bg-gradient-to-t from-black/35 via-transparent to-transparent pointer-events-none transition-opacity duration-500"
            :class="slides[current]?.branded ? 'opacity-10' : 'opacity-100'"
        ></div>
        <div
            x-show="slides[current]?.hide_logo"
            class="absolute top-0 left-0 z-[3] h-24 w-56 sm:h-28 sm:w-72 pointer-events-none bg-gradient-to-br from-[#0f6178] via-[#0f6178]/75 to-transparent"
            @if($firstSlideBranded) style="display:block" @else x-cloak @endif
        ></div>
    </div>

    <div class="absolute top-1/4 {{ $isRtl ? 'left-10' : 'right-10' }} w-72 h-72 bg-primary-500/20 rounded-full blur-3xl floating pointer-events-none" x-show="!slides[current]?.branded" x-cloak></div>
    <div class="absolute bottom-1/4 {{ $isRtl ? 'right-10' : 'left-10' }} w-96 h-96 bg-secondary-500/10 rounded-full blur-3xl floating-slow pointer-events-none" x-show="!slides[current]?.branded" x-cloak></div>

    <div class="container-custom relative z-10" x-show="!slides[current]?.branded" @unless($firstSlideBranded) x-cloak @endunless style="{{ $firstSlideBranded ? 'display:none' : '' }}">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md rounded-full border border-white/20 mb-8">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                <span class="text-white/90 text-sm font-medium">{{ __('home.hero_badge') }}</span>
            </div>

            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6 transition-opacity duration-500"
                x-text="slides[current]?.title || '{{ addslashes(__('home.hero_title')) }}'">{{ __('home.hero_title') }}</h1>
            <p class="text-xl text-white/80 leading-relaxed mb-10 max-w-xl transition-opacity duration-500"
               x-text="slides[current]?.subtitle || '{{ addslashes(__('home.hero_subtitle')) }}'">{{ __('home.hero_subtitle') }}</p>

            <div class="flex flex-wrap gap-4">
                <a href="{{ route('tours.index', $locale) }}" class="btn-primary text-lg px-10 py-4">{{ __('home.hero_cta') }}</a>
                <a href="{{ route('about', $locale) }}" class="inline-flex items-center px-8 py-4 text-white border-2 border-white/30 rounded-xl hover:bg-white/10 transition-all font-semibold text-lg">{{ __('home.hero_cta_secondary') }}</a>
            </div>
        </div>
    </div>

    <div
        class="absolute bottom-28 left-1/2 -translate-x-1/2 z-10 flex flex-wrap justify-center gap-4 px-4"
        x-show="slides[current]?.branded"
        @if($firstSlideBranded) style="display:flex" @else x-cloak @endif
    >
        <a href="{{ route('tours.index', $locale) }}" class="btn-primary text-lg px-10 py-4">{{ __('home.hero_cta') }}</a>
        <a href="{{ route('about', $locale) }}" class="inline-flex items-center px-8 py-4 text-white border-2 border-white/30 rounded-xl hover:bg-white/10 transition-all font-semibold text-lg backdrop-blur-sm">{{ __('home.hero_cta_secondary') }}</a>
    </div>

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

    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 animate-bounce-slow pointer-events-none">
        <div class="w-8 h-12 border-2 border-white/40 rounded-full flex justify-center pt-2">
            <div class="w-1.5 h-3 bg-white/60 rounded-full animate-pulse"></div>
        </div>
    </div>
</section>

<!-- Search -->
<section class="relative -mt-16 z-20 pb-8">
    <div class="container-custom">
        <form action="{{ route('search', $locale) }}" method="GET" class="glass rounded-2xl shadow-2xl p-6 md:p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('home.search_title') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label for="search-q" class="block text-sm font-medium text-gray-600 mb-2">{{ __('home.search_destination') }}</label>
                    <input type="text" id="search-q" name="q" placeholder="{{ __('home.search_placeholder') }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 outline-none">
                </div>
                <div>
                    <label for="search-date" class="block text-sm font-medium text-gray-600 mb-2">{{ __('home.search_date') }}</label>
                    <input type="date" id="search-date" name="date"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 outline-none">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="btn-primary w-full py-3">{{ __('home.search_btn') }}</button>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Destinations -->
<section class="section-padding bg-gray-50/50">
    <div class="container-custom">
        <header class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ __('home.destinations_title') }}</h2>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto">{{ __('home.destinations_subtitle') }}</p>
        </header>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($destinations ?? [] as $destination)
                <a href="{{ route('destinations.show', [$locale, $destination->getTranslation('slug', $locale)]) }}" class="card-luxury p-6 hover:border-primary-200 transition-colors">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $destination->getTranslation('name', $locale) }}</h3>
                    <p class="text-gray-500 text-sm line-clamp-3">{{ $destination->getTranslation('short_description', $locale) }}</p>
                    @if($destination->country)
                        <p class="text-primary-600 text-sm font-medium mt-3">{{ $destination->country }}</p>
                    @endif
                </a>
            @empty
                <p class="col-span-full text-center text-gray-500 py-12">{{ __('home.empty_destinations') }}</p>
            @endforelse
        </div>
    </div>
</section>

<!-- Packages -->
<section class="section-padding">
    <div class="container-custom">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-12">
            <header>
                <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ __('home.packages_title') }}</h2>
                <p class="text-xl text-gray-500 max-w-xl">{{ __('home.packages_subtitle') }}</p>
            </header>
            <a href="{{ route('tours.index', $locale) }}" class="btn-secondary mt-6 md:mt-0">{{ __('general.view_all') }}</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($packages ?? [] as $package)
                <article class="card-luxury p-6">
                    <span class="text-sm text-gray-500">{{ $package->duration_days }} {{ __('general.days') }}</span>
                    <h3 class="text-xl font-bold text-gray-900 mt-2 mb-2">{{ $package->getTranslation('title', $locale) }}</h3>
                    <p class="text-gray-500 text-sm line-clamp-2 mb-4">{{ $package->getTranslation('short_description', $locale) }}</p>
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <span class="text-2xl font-bold text-primary-600">${{ number_format($package->sale_price ?? $package->price) }}</span>
                        <a href="{{ route('tours.show', [$locale, $package->getTranslation('slug', $locale)]) }}" class="btn-primary text-sm px-5 py-2.5">{{ __('general.book_now') }}</a>
                    </div>
                </article>
            @empty
                <p class="col-span-full text-center text-gray-500 py-12">{{ __('home.empty_packages') }}</p>
            @endforelse
        </div>
    </div>
</section>

<!-- Experiences -->
<section class="section-padding bg-white border-y border-gray-100">
    <div class="container-custom">
        <header class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ __('home.experiences_title') }}</h2>
            <p class="text-xl text-gray-500 max-w-3xl mx-auto">{{ __('home.experiences_subtitle') }}</p>
        </header>
        <div class="grid md:grid-cols-3 gap-8 mb-12">
            @foreach([
                ['icon' => 'puzzle', 'title' => __('home.experiences_culture'), 'desc' => __('home.experiences_culture_desc')],
                ['icon' => 'globe', 'title' => __('home.experiences_adventure'), 'desc' => __('home.experiences_adventure_desc')],
                ['icon' => 'star', 'title' => __('home.experiences_luxury'), 'desc' => __('home.experiences_luxury_desc')],
            ] as $feature)
                <article class="text-center p-8 rounded-2xl border border-gray-100">
                    <x-icon-box :name="$feature['icon']" size="md" variant="primary" class="mx-auto mb-4" />
                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $feature['title'] }}</h3>
                    <p class="text-gray-500 leading-relaxed">{{ $feature['desc'] }}</p>
                </article>
            @endforeach
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($activities ?? [] as $activity)
                <a href="{{ route('activities.show', [$locale, $activity->getTranslation('slug', $locale)]) }}" class="card-luxury p-6 block hover:border-primary-200 transition-colors">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $activity->getTranslation('title', $locale) }}</h3>
                    <p class="text-gray-500 text-sm line-clamp-2">{{ $activity->getTranslation('short_description', $locale) }}</p>
                </a>
            @empty
                <p class="col-span-full text-center text-gray-500 py-8">{{ __('home.empty_activities') }}</p>
            @endforelse
        </div>
        <div class="text-center mt-10">
            <a href="{{ route('activities.index', $locale) }}" class="btn-secondary">{{ __('general.view_all') }}</a>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="section-padding bg-gradient-to-br from-primary-900 via-primary-800 to-dark-900">
    <div class="container-custom">
        <header class="text-center mb-12">
            <h2 class="text-4xl font-bold text-white mb-4">{{ __('home.why_title') }}</h2>
            <p class="text-xl text-white/70 max-w-2xl mx-auto">{{ __('home.why_subtitle') }}</p>
        </header>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach([
                ['icon' => 'clock', 'title' => __('home.why_experience'), 'desc' => __('home.why_experience_desc')],
                ['icon' => 'headset', 'title' => __('home.why_support'), 'desc' => __('home.why_support_desc')],
                ['icon' => 'puzzle', 'title' => __('home.why_custom'), 'desc' => __('home.why_custom_desc')],
                ['icon' => 'currency', 'title' => __('home.why_value'), 'desc' => __('home.why_value_desc')],
            ] as $feature)
                <div class="text-center p-6 rounded-2xl bg-white/5 border border-white/10">
                    <x-icon-box :name="$feature['icon']" size="md" variant="primary" class="mx-auto mb-4" />
                    <h3 class="text-lg font-bold text-white mb-3">{{ $feature['title'] }}</h3>
                    <p class="text-white/60 text-sm leading-relaxed">{{ $feature['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Stats -->
<section class="py-20 bg-white">
    <div class="container-custom">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach([
                ['target' => 15000, 'label' => __('home.stats_travelers'), 'suffix' => '+'],
                ['target' => 120, 'label' => __('home.stats_destinations'), 'suffix' => '+'],
                ['target' => 8500, 'label' => __('home.stats_tours'), 'suffix' => '+'],
                ['target' => 4.9, 'label' => __('home.stats_rating'), 'suffix' => '/5'],
            ] as $stat)
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
        <header class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ __('home.testimonials_title') }}</h2>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto">{{ __('home.testimonials_subtitle') }}</p>
        </header>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($testimonials ?? [] as $testimonial)
                <div class="card-glass p-6">
                    <div class="flex items-center gap-1 mb-4">
                        @for($s = 1; $s <= 5; $s++)
                            <x-icon name="star" variant="solid" class="w-4 h-4 {{ $s <= $testimonial->rating ? 'text-gold-400' : 'text-gray-300' }}" />
                        @endfor
                    </div>
                    <p class="text-gray-600 mb-6 leading-relaxed italic">"{{ $testimonial->getTranslation('content', $locale) }}"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold">{{ mb_substr($testimonial->name, 0, 1) }}</div>
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $testimonial->name }}</h4>
                            @if($testimonial->designation)
                                <p class="text-sm text-gray-500">{{ $testimonial->designation }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500 py-12">{{ __('home.empty_testimonials') }}</p>
            @endforelse
        </div>
    </div>
</section>

<!-- Blog -->
<section class="section-padding">
    <div class="container-custom">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-12">
            <header>
                <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ __('home.blog_title') }}</h2>
                <p class="text-xl text-gray-500 max-w-xl">{{ __('home.blog_subtitle') }}</p>
            </header>
            <a href="{{ route('blog.index', $locale) }}" class="btn-secondary mt-6 md:mt-0">{{ __('general.view_all') }}</a>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @forelse($posts ?? [] as $post)
                <article class="card-luxury p-6">
                    <a href="{{ route('blog.show', [$locale, $post->getTranslation('slug', $locale)]) }}" class="block group">
                        <time class="text-sm text-gray-400">{{ optional($post->published_at)->format('M d, Y') }}</time>
                        <h3 class="text-lg font-bold text-gray-900 mt-2 mb-2 group-hover:text-primary-600">{{ $post->getTranslation('title', $locale) }}</h3>
                        <p class="text-gray-500 text-sm line-clamp-2">{{ $post->getTranslation('excerpt', $locale) }}</p>
                    </a>
                </article>
            @empty
                <p class="col-span-full text-center text-gray-500 py-12">{{ __('home.empty_blog') }}</p>
            @endforelse
        </div>
    </div>
</section>

@if(($partners ?? collect())->isNotEmpty())
<section class="py-16 bg-gray-50/50">
    <div class="container-custom text-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-10">{{ __('home.partners_title') }}</h2>
        <div class="flex flex-wrap items-center justify-center gap-8">
            @foreach($partners as $partner)
                <span class="text-gray-600 font-semibold">{{ $partner->name }}</span>
            @endforeach
        </div>
    </div>
</section>
@endif

<x-faq-section :faqs="$faqs ?? collect()" :title="__('home.faq_title')" />

<section class="section-padding bg-gradient-to-r from-primary-600 to-primary-800">
    <div class="container-custom text-center max-w-3xl mx-auto">
        <h2 class="text-4xl font-bold text-white mb-4">{{ __('home.contact_cta_title') }}</h2>
        <p class="text-xl text-white/80 mb-8">{{ __('home.contact_cta_subtitle') }}</p>
        <a href="{{ route('contact.index', $locale) }}" class="inline-block px-8 py-4 bg-white text-primary-700 font-bold rounded-xl hover:bg-gray-100 transition-colors">{{ __('home.contact_cta_btn') }}</a>
    </div>
</section>

<section class="section-padding bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900">
    <div class="container-custom max-w-2xl mx-auto text-center">
        <h2 class="text-4xl font-bold text-white mb-4">{{ __('home.newsletter_title') }}</h2>
        <p class="text-xl text-white/80 mb-10">{{ __('home.newsletter_subtitle') }}</p>
        <form action="{{ route('newsletter.store') }}" method="POST" class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto">
            @csrf
            <input type="email" name="email" required placeholder="{{ __('home.newsletter_placeholder') }}"
                   class="flex-1 px-6 py-4 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 focus:ring-2 focus:ring-white/40 outline-none">
            <button type="submit" class="px-8 py-4 bg-white text-primary-700 font-bold rounded-xl hover:bg-gray-100 transition-colors">{{ __('general.subscribe') }}</button>
        </form>
    </div>
</section>
@endsection
