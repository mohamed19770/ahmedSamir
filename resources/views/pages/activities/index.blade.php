@extends('layouts.app')

@section('meta_title', __('general.activities') . ' - ' . __('general.site_name'))

@section('content')
@php $locale = app()->getLocale(); $isRtl = in_array($locale, config('locales.rtl', [])); @endphp

<!-- Hero -->
<section class="relative pt-32 pb-20 bg-gradient-to-br from-primary-900 to-dark-900">
    <div class="absolute inset-0 opacity-20">
        <img src="https://images.unsplash.com/photo-1530789253388-582c481c54b0?w=1920" alt="" class="w-full h-full object-cover">
    </div>
    <div class="absolute inset-0 bg-gradient-to-b from-primary-900/80 to-dark-900/90"></div>
    <div class="container-custom relative z-10">
        <span class="inline-block px-4 py-1.5 bg-white/10 text-white/90 rounded-full text-sm font-semibold mb-6 backdrop-blur-sm border border-white/20">{{ __('general.activities') }}</span>
        <h1 class="text-5xl lg:text-6xl font-bold text-white mb-4">{{ __('general.activities') }}</h1>
        <p class="text-xl text-white/70 max-w-2xl">From adrenaline-pumping adventures to serene cultural experiences.</p>
    </div>
</section>

<!-- Activities Grid -->
<section class="section-padding">
    <div class="container-custom">
        <!-- Category Filter -->
        <div class="flex flex-wrap items-center gap-3 mb-12">
            <a href="{{ route('activities.index', $locale) }}" class="px-5 py-2.5 rounded-full text-sm font-medium {{ !request('category') ? 'bg-primary-600 text-white shadow-lg shadow-primary-500/25' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition-all">
                {{ __('general.all') }}
            </a>
            @foreach(['desert-safari', 'diving', 'cruises', 'historical', 'adventure', 'beach'] as $cat)
                <a href="{{ route('activities.index', [$locale, 'category' => $cat]) }}" class="px-5 py-2.5 rounded-full text-sm font-medium {{ request('category') === $cat ? 'bg-primary-600 text-white shadow-lg shadow-primary-500/25' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition-all capitalize">
                    {{ str_replace('-', ' ', $cat) }}
                </a>
            @endforeach
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($activities ?? [] as $index => $activity)
                <div class="card-luxury" x-data x-intersect="$el.classList.add('animate-slide-up')" style="animation-delay: {{ ($index % 3) * 100 }}ms">
                    <div class="relative h-60 overflow-hidden">
                        <img src="{{ $activity->image }}" alt="{{ $activity->getTranslation('title', $locale) }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                        <div class="absolute top-4 {{ $isRtl ? 'right-4' : 'left-4' }} bg-white/90 backdrop-blur-sm px-3 py-1 rounded-lg text-sm font-semibold text-primary-700 capitalize">
                            {{ $activity->category }}
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $activity->getTranslation('title', $locale) }}</h3>
                        <p class="text-gray-500 mb-4 line-clamp-2">{{ $activity->getTranslation('short_description', $locale) }}</p>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $activity->duration }}
                                </span>
                            </div>
                            <span class="text-xl font-bold text-primary-600">${{ number_format($activity->price) }}</span>
                        </div>
                        <a href="{{ route('activities.show', [$locale, $activity->getTranslation('slug', $locale)]) }}" class="btn-primary w-full text-center mt-4">
                            {{ __('general.book_now') }}
                        </a>
                    </div>
                </div>
            @empty
                @php
                    $demoActivities = [
                        ['title' => 'Desert Safari', 'desc' => 'Experience the thrill of dune bashing and enjoy a magical sunset in the desert.', 'price' => 150, 'duration' => '6 Hours', 'image' => 'https://images.unsplash.com/photo-1451337516015-6b6e9a44a8a3?w=800'],
                        ['title' => 'Scuba Diving', 'desc' => 'Explore vibrant coral reefs and swim with exotic marine life.', 'price' => 200, 'duration' => '4 Hours', 'image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800'],
                        ['title' => 'Historical Tour', 'desc' => 'Walk through ancient civilizations with expert guides.', 'price' => 85, 'duration' => '8 Hours', 'image' => 'https://images.unsplash.com/photo-1539650116574-75c0c6d73f6e?w=800'],
                        ['title' => 'Nile Cruise', 'desc' => 'Luxury cruise along the Nile with gourmet dining and live entertainment.', 'price' => 350, 'duration' => '3 Days', 'image' => 'https://images.unsplash.com/photo-1548013146-72479768bada?w=800'],
                        ['title' => 'Mountain Hiking', 'desc' => 'Conquer breathtaking peaks with professional mountain guides.', 'price' => 120, 'duration' => '10 Hours', 'image' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800'],
                        ['title' => 'Hot Air Balloon', 'desc' => 'Soar above stunning landscapes at sunrise for unforgettable views.', 'price' => 250, 'duration' => '2 Hours', 'image' => 'https://images.unsplash.com/photo-1507608616759-54f48f0af0ee?w=800'],
                    ];
                @endphp
                @foreach($demoActivities as $index => $activity)
                    <div class="card-luxury" x-data x-intersect="$el.classList.add('animate-slide-up')" style="animation-delay: {{ ($index % 3) * 100 }}ms">
                        <div class="relative h-60 overflow-hidden">
                            <img src="{{ $activity['image'] }}" alt="{{ $activity['title'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $activity['title'] }}</h3>
                            <p class="text-gray-500 mb-4 line-clamp-2">{{ $activity['desc'] }}</p>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <span class="flex items-center gap-1 text-sm text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $activity['duration'] }}
                                </span>
                                <span class="text-xl font-bold text-primary-600">${{ $activity['price'] }}</span>
                            </div>
                            <a href="#" class="btn-primary w-full text-center mt-4">{{ __('general.book_now') }}</a>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>

        @if(isset($activities) && method_exists($activities, 'hasPages') && $activities->hasPages())
            <div class="mt-12">{{ $activities->links() }}</div>
        @endif
    </div>
</section>
@endsection
