@extends('layouts.app')

@section('content')
@php $locale = app()->getLocale(); $isRtl = in_array($locale, config('locales.rtl', [])); @endphp

<x-page-hero :title="__('general.tours')" :badge="__('general.tours')" :subtitle="__('seo.tours_description')" />

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
                <div class="card-luxury p-6" x-data x-intersect="$el.classList.add('animate-slide-up')" style="animation-delay: {{ ($index % 3) * 100 }}ms">
                        <div class="flex items-center gap-2 mb-3 flex-wrap">
                            <span class="px-2.5 py-0.5 bg-gray-100 text-gray-700 rounded-md text-xs font-medium">
                                {{ $package->duration_days }} {{ __('general.days') }} / {{ $package->duration_nights }} {{ __('general.nights') }}
                            </span>
                            @if($package->sale_price)
                                <span class="px-2.5 py-0.5 bg-red-50 text-red-700 rounded-md text-xs font-bold">
                                    -{{ round((($package->price - $package->sale_price) / $package->price) * 100) }}%
                                </span>
                            @endif
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
            @empty
                <div class="col-span-full text-center py-20">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-400 mb-2">{{ __('general.no_results') }}</h3>
                    <p class="text-gray-400">{{ __('home.empty_packages') }}</p>
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
