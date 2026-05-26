@extends('layouts.app')

@section('meta_title', __('general.packages') . ' - ' . __('general.site_name'))

@section('content')
@php $locale = app()->getLocale(); $isRtl = in_array($locale, config('locales.rtl', [])); @endphp

<!-- Hero -->
<section class="relative pt-32 pb-20 bg-gradient-to-br from-primary-900 to-dark-900">
    <div class="absolute inset-0 opacity-20">
        <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=1920" alt="" class="w-full h-full object-cover">
    </div>
    <div class="absolute inset-0 bg-gradient-to-b from-primary-900/80 to-dark-900/90"></div>
    <div class="container-custom relative z-10">
        <span class="inline-block px-4 py-1.5 bg-white/10 text-white/90 rounded-full text-sm font-semibold mb-6 backdrop-blur-sm border border-white/20">{{ __('general.packages') }}</span>
        <h1 class="text-5xl lg:text-6xl font-bold text-white mb-4">{{ __('general.packages') }}</h1>
        <p class="text-xl text-white/70 max-w-2xl">Discover our curated selection of premium travel packages designed for unforgettable experiences.</p>
    </div>
</section>

<!-- Filters -->
<section class="py-8 bg-white border-b border-gray-100 sticky top-20 z-30 glass-navbar">
    <div class="container-custom">
        <div class="flex flex-wrap items-center gap-4">
            <a href="{{ route('packages.index', $locale) }}" class="px-5 py-2 rounded-full text-sm font-medium {{ !request('category') ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition-colors">
                {{ __('general.all') }}
            </a>
            @foreach(['adventure', 'beach', 'cultural', 'luxury', 'honeymoon', 'family'] as $cat)
                <a href="{{ route('packages.index', [$locale, 'category' => $cat]) }}" class="px-5 py-2 rounded-full text-sm font-medium {{ request('category') === $cat ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition-colors capitalize">
                    {{ $cat }}
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Packages Grid -->
<section class="section-padding">
    <div class="container-custom">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($packages ?? [] as $index => $package)
                <div class="card-luxury" x-data x-intersect="$el.classList.add('animate-slide-up')" style="animation-delay: {{ ($index % 3) * 100 }}ms">
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ $package->image ?? 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800' }}"
                             alt="{{ $package->getTranslation('title', $locale) }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
                        @if($package->sale_price)
                            <div class="absolute top-4 {{ $isRtl ? 'left-4' : 'right-4' }} bg-red-500 text-white px-3 py-1 rounded-lg text-sm font-bold">
                                -{{ round((($package->price - $package->sale_price) / $package->price) * 100) }}%
                            </div>
                        @endif
                        <div class="absolute top-4 {{ $isRtl ? 'right-4' : 'left-4' }} bg-white/90 backdrop-blur-sm px-3 py-1 rounded-lg text-sm font-semibold text-gray-700">
                            {{ $package->duration_days }} {{ __('general.days') }} / {{ $package->duration_nights }} {{ __('general.nights') }}
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="px-2.5 py-0.5 bg-primary-50 text-primary-700 rounded-md text-xs font-medium capitalize">{{ $package->category }}</span>
                            @if($package->is_featured)
                                <span class="px-2.5 py-0.5 bg-gold-50 text-gold-700 rounded-md text-xs font-medium">{{ __('general.featured') }}</span>
                            @endif
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-primary-600 transition-colors">
                            {{ $package->getTranslation('title', $locale) }}
                        </h3>
                        <p class="text-gray-500 mb-4 line-clamp-2">{{ $package->getTranslation('short_description', $locale) }}</p>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div>
                                <span class="text-sm text-gray-500">{{ __('general.price_from') }}</span>
                                @if($package->sale_price)
                                    <span class="text-sm text-gray-400 line-through {{ $isRtl ? 'mr-1' : 'ml-1' }}">${{ number_format($package->price) }}</span>
                                @endif
                                <div class="text-2xl font-bold text-primary-600">${{ number_format($package->sale_price ?? $package->price) }}</div>
                            </div>
                            <a href="{{ route('packages.show', [$locale, $package->getTranslation('slug', $locale)]) }}" class="btn-primary text-sm px-5 py-2.5">
                                {{ __('general.book_now') }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-400 mb-2">{{ __('general.no_results') }}</h3>
                    <p class="text-gray-400">Check back soon for new packages.</p>
                </div>
            @endforelse
        </div>

        @if(isset($packages) && $packages->hasPages())
            <div class="mt-12">
                {{ $packages->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
