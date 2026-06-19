@extends('layouts.app')

@section('content')
@php $locale = app()->getLocale(); $isRtl = in_array($locale, config('locales.rtl', [])); @endphp

<x-page-hero
    :title="$package->getTranslation('title', $locale)"
    :badge="$package->category"
    :subtitle="$package->duration_days.' '.__('general.days').' / '.$package->duration_nights.' '.__('general.nights')"
/>

<!-- Content -->
<section class="section-padding">
    <div class="container-custom">
        <div class="grid lg:grid-cols-3 gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <div class="prose prose-lg max-w-none mb-12">
                    <x-safe-html :content="$package->getTranslation('description', $locale)" class="prose prose-lg max-w-none text-gray-600" />
                </div>

                <!-- Itinerary -->
                @if($package->itinerary)
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('general.itinerary') }}</h2>
                        <div class="space-y-4" x-data="{ openDay: 0 }">
                            @foreach($package->itinerary as $index => $day)
                                <div class="border border-gray-200 rounded-xl overflow-hidden">
                                    <button @click="openDay = openDay === {{ $index }} ? null : {{ $index }}" class="w-full flex items-center justify-between p-5 bg-gray-50 hover:bg-gray-100 transition-colors text-{{ $isRtl ? 'right' : 'left' }}">
                                        <span class="font-semibold text-gray-900">Day {{ $index + 1 }}: {{ $day['title'] ?? '' }}</span>
                                        <svg class="w-5 h-5 text-gray-500 transition-transform" :class="openDay === {{ $index }} && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <div x-show="openDay === {{ $index }}" x-collapse class="p-5 text-gray-600">
                                        {{ $day['description'] ?? '' }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Included/Excluded -->
                <div class="grid md:grid-cols-2 gap-8">
                    @if($package->included)
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ __('general.included') }}
                            </h3>
                            <ul class="space-y-2">
                                @foreach($package->included as $item)
                                    <li class="flex items-start gap-2 text-gray-600">
                                        <svg class="w-5 h-5 text-green-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        {{ $item }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if($package->excluded)
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ __('general.excluded') }}
                            </h3>
                            <ul class="space-y-2">
                                @foreach($package->excluded as $item)
                                    <li class="flex items-start gap-2 text-gray-600">
                                        <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                        {{ $item }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar - Booking Card -->
            <div class="lg:col-span-1">
                <div class="sticky top-28 glass rounded-2xl p-8 shadow-xl">
                    <div class="mb-6">
                        <span class="text-sm text-gray-500">{{ __('general.price_from') }}</span>
                        @if($package->sale_price)
                            <span class="text-lg text-gray-400 line-through {{ $isRtl ? 'mr-2' : 'ml-2' }}">${{ number_format($package->price) }}</span>
                        @endif
                        <div class="text-4xl font-bold text-primary-600">${{ number_format($package->sale_price ?? $package->price) }}</div>
                        <span class="text-sm text-gray-500">{{ __('general.per_person') }}</span>
                    </div>

                    <a href="{{ route('booking.create', [$locale, 'package', $package->id]) }}" class="btn-primary w-full text-center text-lg py-4 mb-4">
                        {{ __('general.book_now') }}
                    </a>

                    <p class="text-center text-sm text-gray-500">No hidden charges. Free cancellation within 48h.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@if(($relatedPackages ?? collect())->isNotEmpty())
<section class="section-padding bg-gray-50/50">
    <div class="container-custom">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">{{ __('general.related_tours') }}</h2>
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($relatedPackages as $related)
                <article class="card-luxury p-6">
                    <a href="{{ route('tours.show', [$locale, $related->getTranslation('slug', $locale)]) }}">
                        <h3 class="font-bold text-gray-900">{{ $related->getTranslation('title', $locale) }}</h3>
                        <p class="text-primary-600 font-bold mt-2">${{ number_format($related->sale_price ?? $related->price) }}</p>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@if(($testimonials ?? collect())->isNotEmpty())
<section class="section-padding">
    <div class="container-custom">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">{{ __('general.reviews') }}</h2>
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($testimonials as $testimonial)
                <article class="card-glass">
                    <div class="flex gap-1 mb-3">
                        @for($s = 1; $s <= 5; $s++)
                            <x-icon name="star" variant="solid" class="w-4 h-4 {{ $s <= $testimonial->rating ? 'text-gold-400' : 'text-gray-300' }}" />
                        @endfor
                    </div>
                    <p class="text-gray-600 italic mb-4">"{{ $testimonial->getTranslation('content', $locale) }}"</p>
                    <p class="font-semibold text-gray-900">{{ $testimonial->name }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<x-faq-section :faqs="$faqs ?? collect()" />
@endsection
