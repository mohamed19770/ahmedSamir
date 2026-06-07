@extends('layouts.app')

@section('content')
@php $locale = app()->getLocale(); $isRtl = in_array($locale, config('locales.rtl', [])); @endphp

<x-page-hero :title="__('general.gallery')" :badge="__('general.gallery')" subtitle="Visual stories from our most breathtaking destinations." />

<!-- Gallery -->
<section class="section-padding" x-data="gallery">
    <div class="container-custom">
        <!-- Filter -->
        <div class="flex flex-wrap items-center gap-3 mb-12">
            @foreach(['all', 'destinations', 'activities', 'hotels', 'nature'] as $cat)
                <button class="px-5 py-2.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700 hover:bg-primary-600 hover:text-white transition-all capitalize">
                    {{ $cat === 'all' ? __('general.all') : $cat }}
                </button>
            @endforeach
        </div>

        <!-- Masonry Grid -->
        <div class="columns-1 md:columns-2 lg:columns-3 gap-6 space-y-6">
            @forelse($galleries ?? [] as $item)
                <div class="break-inside-avoid cursor-pointer group" @click="openLightbox('{{ $item->image }}')">
                    <div class="relative rounded-2xl overflow-hidden">
                        <img src="{{ $item->image }}" alt="{{ $item->getTranslation('title', $locale) }}" class="w-full group-hover:scale-105 transition-transform duration-700" loading="lazy">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300 flex items-center justify-center">
                            <svg class="w-12 h-12 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform scale-50 group-hover:scale-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            @empty
                @php
                    $demoGallery = [
                        'https://images.unsplash.com/photo-1506929562872-bb421503ef21?w=600',
                        'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600',
                        'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=600',
                        'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=600',
                        'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=600',
                        'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=600',
                        'https://images.unsplash.com/photo-1613395877344-13d4a8e0d49e?w=600',
                        'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=600',
                        'https://images.unsplash.com/photo-1507608616759-54f48f0af0ee?w=600',
                    ];
                @endphp
                @foreach($demoGallery as $img)
                    <div class="break-inside-avoid cursor-pointer group" @click="openLightbox('{{ $img }}')">
                        <div class="relative rounded-2xl overflow-hidden">
                            <img src="{{ $img }}" alt="Gallery" class="w-full group-hover:scale-105 transition-transform duration-700" loading="lazy">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300 flex items-center justify-center">
                                <svg class="w-12 h-12 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>

    <!-- Lightbox -->
    <div x-show="lightboxOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 bg-black/95 flex items-center justify-center p-4" @click="closeLightbox()" @keydown.escape.window="closeLightbox()" x-cloak>
        <button class="absolute top-6 {{ $isRtl ? 'left-6' : 'right-6' }} text-white hover:text-gray-300 transition-colors">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <img :src="currentImage" alt="Gallery Image" class="max-w-full max-h-[90vh] rounded-lg object-contain" @click.stop>
    </div>
</section>
@endsection
