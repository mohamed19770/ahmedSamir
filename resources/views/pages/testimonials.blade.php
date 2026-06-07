@extends('layouts.app')

@section('content')
@php $locale = app()->getLocale(); $isRtl = in_array($locale, config('locales.rtl', [])); @endphp

<x-page-hero :title="__('general.testimonials')" :badge="__('general.testimonials')" subtitle="What our travelers say about their experiences with us." />

<!-- Testimonials -->
<section class="section-padding">
    <div class="container-custom">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($testimonials ?? [] as $index => $testimonial)
                <div class="card-glass" x-data x-intersect="$el.classList.add('animate-slide-up')" style="animation-delay: {{ ($index % 3) * 100 }}ms">
                    <div class="flex items-center gap-1 mb-4">
                        @for($s = 1; $s <= 5; $s++)
                            <svg class="w-5 h-5 {{ $s <= $testimonial->rating ? 'text-gold-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <p class="text-gray-600 mb-6 leading-relaxed italic">"{{ $testimonial->getTranslation('content', $locale) }}"</p>
                    <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                        <img src="{{ $testimonial->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($testimonial->name) . '&background=0ea5e9&color=fff' }}" alt="{{ $testimonial->name }}" class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $testimonial->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $testimonial->designation }}</p>
                        </div>
                    </div>
                </div>
            @empty
                @php
                    $demoTestimonials = [
                        ['name' => 'Sarah Johnson', 'role' => 'Travel Enthusiast', 'content' => 'An absolutely incredible experience! The attention to detail and the level of service exceeded all my expectations. Will definitely book again!', 'rating' => 5],
                        ['name' => 'Ahmed Al-Rashid', 'role' => 'Business Executive', 'content' => 'Professional, punctual, and perfectly organized. The corporate travel package was exactly what our team needed.', 'rating' => 5],
                        ['name' => 'Maria Kovačević', 'role' => 'Honeymoon Traveler', 'content' => 'Our honeymoon was absolutely magical thanks to the team. Every detail was perfectly planned and the destinations were breathtaking.', 'rating' => 5],
                        ['name' => 'James Mitchell', 'role' => 'Adventure Seeker', 'content' => 'The desert safari adventure was the highlight of my year! Professional guides, amazing food, and unforgettable sunset views.', 'rating' => 5],
                        ['name' => 'Fatima Hassan', 'role' => 'Family Traveler', 'content' => 'Traveling with kids is always challenging, but the team made it completely stress-free. The family package was perfect for us.', 'rating' => 5],
                        ['name' => 'David Chen', 'role' => 'Solo Explorer', 'content' => 'As a solo traveler, safety and experience are my top priorities. Designation 2 Go delivered on both fronts brilliantly.', 'rating' => 4],
                    ];
                @endphp
                @foreach($demoTestimonials as $index => $t)
                    <div class="card-glass" x-data x-intersect="$el.classList.add('animate-slide-up')" style="animation-delay: {{ ($index % 3) * 100 }}ms">
                        <div class="flex items-center gap-1 mb-4">
                            @for($s = 1; $s <= 5; $s++)
                                <svg class="w-5 h-5 {{ $s <= $t['rating'] ? 'text-gold-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <p class="text-gray-600 mb-6 leading-relaxed italic">"{{ $t['content'] }}"</p>
                        <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
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
@endsection
