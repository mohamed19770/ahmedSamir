@extends('layouts.app')

@section('content')
@php $locale = app()->getLocale(); $isRtl = in_array($locale, config('locales.rtl', [])); @endphp

<!-- Hero -->
<section class="relative h-[50vh] min-h-[400px]">
    <img src="{{ $post->image }}" alt="{{ $post->getTranslation('title', $locale) }}" class="w-full h-full object-cover">
    <div class="gradient-overlay"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8">
        <div class="container-custom max-w-4xl">
            <span class="inline-block px-3 py-1 bg-primary-500 text-white rounded-lg text-sm font-medium mb-4 capitalize">{{ $post->category }}</span>
            <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">{{ $post->getTranslation('title', $locale) }}</h1>
            <div class="flex items-center gap-6 text-white/80 text-sm">
                <span>{{ $post->author->name ?? 'Admin' }}</span>
                <span>{{ $post->published_at?->format('M d, Y') }}</span>
                <span>{{ $post->views_count }} views</span>
            </div>
        </div>
    </div>
</section>

<!-- Content -->
<section class="section-padding">
    <div class="container-custom max-w-4xl">
        <article class="prose prose-lg max-w-none prose-headings:font-bold prose-a:text-primary-600 prose-img:rounded-xl">
            {!! $post->getTranslation('content', $locale) !!}
        </article>

        @if($post->tags)
            <div class="mt-12 pt-8 border-t border-gray-200">
                <div class="flex flex-wrap gap-2">
                    @foreach($post->tags as $tag)
                        <span class="px-3 py-1.5 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium">#{{ $tag }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-8 pt-8 border-t border-gray-200">
            <a href="{{ route('blog.index', $locale) }}" class="inline-flex items-center gap-2 text-primary-600 font-semibold hover:text-primary-700">
                <svg class="w-5 h-5 {{ $isRtl ? '' : 'rotate-180' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                {{ __('general.back') }} {{ __('general.blog') }}
            </a>
        </div>
    </div>
</section>
@endsection
