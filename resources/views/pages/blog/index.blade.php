@extends('layouts.app')

@section('content')
@php $locale = app()->getLocale(); $isRtl = in_array($locale, config('locales.rtl', [])); @endphp

<x-page-hero :title="__('general.blog')" :badge="__('general.blog')" subtitle="Travel stories, tips, and inspiration from around the world." />

<!-- Blog Grid -->
<section class="section-padding">
    <div class="container-custom">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($posts ?? [] as $index => $post)
                <article class="card-luxury" x-data x-intersect="$el.classList.add('animate-slide-up')" style="animation-delay: {{ ($index % 3) * 100 }}ms">
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ $post->image }}" alt="{{ $post->getTranslation('title', $locale) }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
                        <div class="absolute top-4 {{ $isRtl ? 'right-4' : 'left-4' }} bg-primary-600 text-white px-3 py-1 rounded-lg text-xs font-semibold capitalize">
                            {{ $post->category }}
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-3">
                            <span>{{ $post->published_at?->format('M d, Y') }}</span>
                            <span>{{ $post->views_count }} views</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-primary-600 transition-colors">
                            {{ $post->getTranslation('title', $locale) }}
                        </h3>
                        <p class="text-gray-500 mb-4 line-clamp-3">{{ $post->getTranslation('excerpt', $locale) }}</p>
                        <a href="{{ route('blog.show', [$locale, $post->getTranslation('slug', $locale)]) }}" class="inline-flex items-center gap-2 text-primary-600 font-semibold hover:text-primary-700 transition-colors">
                            {{ __('general.read_more') }}
                            <svg class="w-4 h-4 {{ $isRtl ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </article>
            @empty
                @php
                    $demoPosts = [
                        ['title' => '10 Hidden Gems in Southeast Asia', 'excerpt' => 'Discover untouched paradises that most travelers miss on their journeys through Southeast Asia.', 'image' => 'https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?w=800', 'category' => 'destinations', 'date' => 'May 20, 2026'],
                        ['title' => 'Ultimate Packing Guide for Luxury Travel', 'excerpt' => 'Everything you need to know about packing smart for your next luxury vacation.', 'image' => 'https://images.unsplash.com/photo-1553697388-94e804e2f0f6?w=800', 'category' => 'tips', 'date' => 'May 15, 2026'],
                        ['title' => 'Best Time to Visit the Maldives', 'excerpt' => 'Plan your perfect Maldives getaway with our comprehensive seasonal guide.', 'image' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=800', 'category' => 'guides', 'date' => 'May 10, 2026'],
                    ];
                @endphp
                @foreach($demoPosts as $index => $post)
                    <article class="card-luxury" x-data x-intersect="$el.classList.add('animate-slide-up')" style="animation-delay: {{ $index * 100 }}ms">
                        <div class="relative h-56 overflow-hidden">
                            <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
                            <div class="absolute top-4 {{ $isRtl ? 'right-4' : 'left-4' }} bg-primary-600 text-white px-3 py-1 rounded-lg text-xs font-semibold capitalize">{{ $post['category'] }}</div>
                        </div>
                        <div class="p-6">
                            <div class="text-sm text-gray-500 mb-3">{{ $post['date'] }}</div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $post['title'] }}</h3>
                            <p class="text-gray-500 mb-4 line-clamp-3">{{ $post['excerpt'] }}</p>
                            <a href="#" class="inline-flex items-center gap-2 text-primary-600 font-semibold hover:text-primary-700 transition-colors">
                                {{ __('general.read_more') }}
                                <svg class="w-4 h-4 {{ $isRtl ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            @endforelse
        </div>

        @if(isset($posts) && method_exists($posts, 'hasPages') && $posts->hasPages())
            <div class="mt-12">{{ $posts->links() }}</div>
        @endif
    </div>
</section>
@endsection
