@extends('layouts.app')

@section('meta_title', __('general.about') . ' - ' . __('general.site_name'))

@section('content')
@php $locale = app()->getLocale(); $isRtl = in_array($locale, config('locales.rtl', [])); @endphp

<!-- Hero -->
<section class="relative pt-32 pb-20 bg-gradient-to-br from-primary-900 to-dark-900 overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <img src="https://images.unsplash.com/photo-1488085061387-422e29b40080?w=1920" alt="" class="w-full h-full object-cover">
    </div>
    <div class="absolute inset-0 bg-gradient-to-b from-primary-900/80 to-dark-900/90"></div>
    <div class="container-custom relative z-10">
        <div class="max-w-3xl">
            <span class="inline-block px-4 py-1.5 bg-white/10 text-white/90 rounded-full text-sm font-semibold mb-6 backdrop-blur-sm border border-white/20">{{ __('general.about') }}</span>
            <h1 class="text-5xl lg:text-6xl font-bold text-white mb-6">{{ __('general.about') }}</h1>
            <p class="text-xl text-white/70">We are passionate about creating extraordinary travel experiences that transform lives and create lasting memories.</p>
        </div>
    </div>
</section>

<!-- Story -->
<section class="section-padding">
    <div class="container-custom">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div x-data x-intersect="$el.classList.add('animate-slide-up')">
                <span class="inline-block px-4 py-1.5 bg-primary-100 text-primary-700 rounded-full text-sm font-semibold mb-6">Our Story</span>
                <h2 class="text-4xl font-bold text-gray-900 mb-6">Crafting Dream Vacations Since 2010</h2>
                <p class="text-gray-600 leading-relaxed mb-6">Founded with a passion for exploration and a commitment to excellence, Designation 2 Go has grown from a small boutique agency into a globally recognized luxury travel company.</p>
                <p class="text-gray-600 leading-relaxed mb-8">Our team of experienced travel designers works tirelessly to create bespoke journeys that exceed expectations. Every trip we craft is a masterpiece of careful planning, local expertise, and personalized attention to detail.</p>
                <div class="grid grid-cols-2 gap-6">
                    <div class="p-4 bg-primary-50 rounded-xl">
                        <div class="text-3xl font-bold text-primary-600 mb-1">15+</div>
                        <div class="text-sm text-gray-600">Years Experience</div>
                    </div>
                    <div class="p-4 bg-gold-50 rounded-xl">
                        <div class="text-3xl font-bold text-gold-600 mb-1">120+</div>
                        <div class="text-sm text-gray-600">Destinations</div>
                    </div>
                </div>
            </div>
            <div class="relative" x-data x-intersect="$el.classList.add('animate-fade-in')">
                <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=800" alt="Our Team" class="rounded-2xl shadow-2xl w-full">
                <div class="absolute -bottom-6 {{ $isRtl ? '-left-6' : '-right-6' }} w-48 h-48 bg-primary-100 rounded-2xl -z-10"></div>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section class="section-padding bg-gray-50">
    <div class="container-custom">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Core Values</h2>
            <p class="text-xl text-gray-500">The principles that guide everything we do</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            @php
                $values = [
                    ['title' => 'Excellence', 'desc' => 'We strive for perfection in every journey we create, ensuring the highest quality of service.', 'icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z'],
                    ['title' => 'Integrity', 'desc' => 'Transparency and honesty form the foundation of every relationship we build.', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                    ['title' => 'Innovation', 'desc' => 'We constantly evolve our offerings to bring fresh, unique experiences to our travelers.', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                ];
            @endphp
            @foreach($values as $value)
                <div class="card-glass text-center" x-data x-intersect="$el.classList.add('animate-slide-up')">
                    <div class="w-16 h-16 mx-auto mb-6 bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $value['icon'] }}"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $value['title'] }}</h3>
                    <p class="text-gray-500">{{ $value['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
