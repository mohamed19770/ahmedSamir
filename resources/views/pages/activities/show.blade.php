@extends('layouts.app')

@section('content')
@php $locale = app()->getLocale(); $isRtl = in_array($locale, config('locales.rtl', [])); @endphp

<!-- Hero -->
<section class="relative h-[50vh] min-h-[400px]">
    <img src="{{ $activity->image }}" alt="{{ $activity->getTranslation('title', $locale) }}" class="w-full h-full object-cover">
    <div class="gradient-overlay"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8">
        <div class="container-custom">
            <span class="inline-block px-3 py-1 bg-primary-500 text-white rounded-lg text-sm font-medium mb-4 capitalize">{{ $activity->category }}</span>
            <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">{{ $activity->getTranslation('title', $locale) }}</h1>
            <div class="flex flex-wrap items-center gap-6 text-white/80">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $activity->duration }}
                </span>
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    {{ $activity->location }}
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Content -->
<section class="section-padding">
    <div class="container-custom">
        <div class="grid lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2">
                <div class="prose prose-lg max-w-none">
                    {!! $activity->getTranslation('description', $locale) !!}
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-28 glass rounded-2xl p-8 shadow-xl">
                    <div class="mb-6">
                        <span class="text-sm text-gray-500">{{ __('general.price_from') }}</span>
                        <div class="text-4xl font-bold text-primary-600">${{ number_format($activity->price) }}</div>
                        <span class="text-sm text-gray-500">{{ __('general.per_person') }}</span>
                    </div>
                    <a href="{{ route('booking.create', [$locale, 'activity', $activity->id]) }}" class="btn-primary w-full text-center text-lg py-4">
                        {{ __('general.book_now') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
