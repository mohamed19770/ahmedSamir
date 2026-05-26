@extends('layouts.app')

@section('meta_title', __('general.search') . ' - ' . __('general.site_name'))

@section('content')
@php $locale = app()->getLocale(); $isRtl = in_array($locale, config('locales.rtl', [])); @endphp

<section class="pt-32 pb-12 bg-gradient-to-br from-primary-900 to-dark-900">
    <div class="container-custom">
        <h1 class="text-4xl font-bold text-white mb-6">{{ __('general.search') }}</h1>
        <form action="{{ route('search', $locale) }}" method="GET" class="max-w-xl">
            <div class="relative">
                <input type="text" name="q" value="{{ $query }}" placeholder="{{ __('home.search_destination') }}" class="w-full px-6 py-4 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-white/60 focus:ring-2 focus:ring-white/40 outline-none {{ $isRtl ? 'pr-14' : 'pl-14' }}">
                <svg class="absolute {{ $isRtl ? 'right-5' : 'left-5' }} top-1/2 -translate-y-1/2 w-5 h-5 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </form>
    </div>
</section>

<section class="section-padding">
    <div class="container-custom">
        @if($query)
            <p class="text-gray-500 mb-8">Showing results for "<strong class="text-gray-900">{{ $query }}</strong>"</p>
        @endif

        @if($packages->count() > 0)
            <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('general.packages') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                @foreach($packages as $package)
                    <a href="{{ route('packages.show', [$locale, $package->getTranslation('slug', $locale)]) }}" class="card-luxury p-4">
                        <div class="flex gap-4">
                            <img src="{{ $package->image }}" alt="" class="w-20 h-20 rounded-xl object-cover shrink-0">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $package->getTranslation('title', $locale) }}</h3>
                                <p class="text-sm text-gray-500 mt-1">{{ $package->duration_days }} {{ __('general.days') }}</p>
                                <p class="text-primary-600 font-bold mt-1">${{ number_format($package->sale_price ?? $package->price) }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        @if($activities->count() > 0)
            <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('general.activities') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($activities as $activity)
                    <a href="{{ route('activities.show', [$locale, $activity->getTranslation('slug', $locale)]) }}" class="card-luxury p-4">
                        <div class="flex gap-4">
                            <img src="{{ $activity->image }}" alt="" class="w-20 h-20 rounded-xl object-cover shrink-0">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $activity->getTranslation('title', $locale) }}</h3>
                                <p class="text-sm text-gray-500 mt-1">{{ $activity->duration }}</p>
                                <p class="text-primary-600 font-bold mt-1">${{ number_format($activity->price) }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        @if($packages->count() === 0 && $activities->count() === 0 && $query)
            <div class="text-center py-20">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <h3 class="text-2xl font-bold text-gray-400">{{ __('general.no_results') }}</h3>
            </div>
        @endif
    </div>
</section>
@endsection
