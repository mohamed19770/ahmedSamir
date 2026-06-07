@extends('layouts.app')

@section('content')
@php $locale = app()->getLocale(); $isRtl = in_array($locale, config('locales.rtl', [])); @endphp

<x-page-hero :title="__('seo.destinations_title')" :badge="__('general.destinations')" :subtitle="__('seo.destinations_description')" />

<section class="section-padding bg-gray-50/50">
    <div class="container-custom">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($destinations as $destination)
                <article class="card-luxury p-6 group">
                    <a href="{{ route('destinations.show', [$locale, $destination->getTranslation('slug', $locale)]) }}">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2 group-hover:text-primary-600">{{ $destination->getTranslation('name', $locale) }}</h2>
                        @if($destination->city || $destination->country)
                            <p class="text-primary-600 text-sm font-medium mb-3">{{ trim($destination->city.', '.$destination->country, ', ') }}</p>
                        @endif
                        <p class="text-gray-500 line-clamp-3">{{ $destination->getTranslation('short_description', $locale) }}</p>
                        <span class="inline-flex items-center gap-2 mt-4 text-primary-600 font-semibold">
                            {{ __('general.learn_more') }}
                            <x-icon name="{{ $isRtl ? 'arrow-left' : 'arrow-right' }}" class="w-4 h-4" />
                        </span>
                    </a>
                </article>
            @empty
                <p class="col-span-full text-center text-gray-500 py-12">{{ __('home.empty_destinations') }}</p>
            @endforelse
        </div>

        <div class="mt-12">{{ $destinations->links() }}</div>
    </div>
</section>
@endsection
