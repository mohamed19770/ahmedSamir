@extends('layouts.app')

@section('meta_title', __('general.visa') . ' - ' . __('general.site_name'))

@section('content')
@php $locale = app()->getLocale(); $isRtl = in_array($locale, config('locales.rtl', [])); @endphp

<!-- Hero -->
<section class="relative pt-32 pb-20 bg-gradient-to-br from-primary-900 to-dark-900">
    <div class="absolute inset-0 bg-gradient-to-b from-primary-900/90 to-dark-900/95"></div>
    <div class="container-custom relative z-10">
        <span class="inline-block px-4 py-1.5 bg-white/10 text-white/90 rounded-full text-sm font-semibold mb-6 backdrop-blur-sm border border-white/20">{{ __('general.visa') }}</span>
        <h1 class="text-5xl lg:text-6xl font-bold text-white mb-4">{{ __('general.visa') }}</h1>
        <p class="text-xl text-white/70 max-w-2xl">Hassle-free visa processing for your dream destination.</p>
    </div>
</section>

<!-- Services -->
<section class="section-padding">
    <div class="container-custom">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Visa Services</h2>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto">Professional visa assistance for all major destinations worldwide</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            @php
                $visaServices = [
                    ['title' => 'Tourist Visa', 'desc' => 'Quick processing for leisure travel to popular destinations.', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['title' => 'Business Visa', 'desc' => 'Fast-track business visa services for professionals.', 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                    ['title' => 'Transit Visa', 'desc' => 'Smooth transit visa arrangements for connecting flights.', 'icon' => 'M12 19l9 2-9-18-9 18 9-2zm0 0v-8'],
                    ['title' => 'Family Visa', 'desc' => 'Group and family visa processing at special rates.', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                    ['title' => 'Express Processing', 'desc' => 'Urgent visa processing within 24-48 hours.', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                    ['title' => 'Visa Consultation', 'desc' => 'Expert guidance on documentation and requirements.', 'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
                ];
            @endphp

            @foreach($visaServices as $index => $service)
                <div class="card-glass hover:-translate-y-1 transition-all duration-300" x-data x-intersect="$el.classList.add('animate-slide-up')" style="animation-delay: {{ ($index % 3) * 100 }}ms">
                    <div class="w-14 h-14 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $service['icon'] }}"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $service['title'] }}</h3>
                    <p class="text-gray-500 mb-4">{{ $service['desc'] }}</p>
                    <a href="{{ route('contact.index', $locale) }}" class="text-primary-600 font-semibold hover:text-primary-700 transition-colors inline-flex items-center gap-1">
                        {{ __('general.learn_more') }}
                        <svg class="w-4 h-4 {{ $isRtl ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            @endforeach
        </div>

        <!-- CTA -->
        <div class="bg-gradient-to-r from-primary-600 to-primary-800 rounded-3xl p-12 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Need Visa Assistance?</h2>
            <p class="text-white/80 text-lg mb-8 max-w-xl mx-auto">Our visa experts are ready to help you with documentation and processing for any destination.</p>
            <a href="{{ route('contact.index', $locale) }}" class="inline-flex items-center gap-2 px-10 py-4 bg-white text-primary-700 font-bold rounded-xl hover:bg-gray-100 transition-all text-lg shadow-lg">
                {{ __('general.contact') }}
                <svg class="w-5 h-5 {{ $isRtl ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>
@endsection
