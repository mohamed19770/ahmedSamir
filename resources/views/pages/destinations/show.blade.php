@extends('layouts.app')

@section('content')
@php $locale = app()->getLocale(); $isRtl = in_array($locale, config('locales.rtl', [])); @endphp

<x-page-hero
    :title="$destination->getTranslation('name', $locale)"
    :subtitle="trim(($destination->city ?? '').', '.($destination->country ?? ''), ', ')"
/>

<section class="section-padding">
    <div class="container-custom">
        <div class="grid lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2 space-y-12">
                <article>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __('general.overview') }}</h2>
                    <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed">
                        {!! nl2br(e($destination->getTranslation('description', $locale))) !!}
                    </div>
                </article>

                @if($packages->isNotEmpty())
                <section aria-labelledby="tours-heading">
                    <h2 id="tours-heading" class="text-3xl font-bold text-gray-900 mb-6">{{ __('general.related_tours') }}</h2>
                    <div class="grid md:grid-cols-2 gap-6">
                        @foreach($packages as $package)
                            <article class="card-luxury p-4">
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-1">
                                        <a href="{{ route('tours.show', [$locale, $package->getTranslation('slug', $locale)]) }}" class="hover:text-primary-600">
                                            {{ $package->getTranslation('title', $locale) }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-gray-500 line-clamp-2">{{ $package->getTranslation('short_description', $locale) }}</p>
                                    <p class="text-primary-600 font-bold mt-2">${{ number_format($package->sale_price ?? $package->price) }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
                @endif
            </div>

            <aside class="lg:col-span-1">
                <div class="sticky top-28 glass rounded-2xl p-8 shadow-xl space-y-6">
                    <h2 class="text-xl font-bold text-gray-900">{{ __('general.get_quote') }}</h2>
                    <p class="text-gray-500 text-sm">{{ __('home.contact_cta_subtitle') }}</p>
                    <a href="{{ route('contact.index', $locale) }}" class="btn-primary w-full text-center">{{ __('general.inquiry') }}</a>
                    <a href="{{ route('tours.index', $locale) }}" class="btn-secondary w-full text-center">{{ __('general.tours') }}</a>
                </div>
            </aside>
        </div>
    </div>
</section>

@if($relatedDestinations->isNotEmpty())
<section class="section-padding bg-gray-50/50">
    <div class="container-custom">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">{{ __('general.related_destinations') }}</h2>
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($relatedDestinations as $related)
                <a href="{{ route('destinations.show', [$locale, $related->getTranslation('slug', $locale)]) }}" class="card-luxury p-4 group">
                    <h3 class="font-bold text-gray-900 group-hover:text-primary-600">{{ $related->getTranslation('name', $locale) }}</h3>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<x-faq-section :faqs="$faqs" :title="__('home.faq_title')" />
@endsection
