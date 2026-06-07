@extends('layouts.app')

@section('content')
@php $locale = app()->getLocale(); @endphp

<x-page-hero :title="__('general.about')" :badge="__('general.about')" :subtitle="__('general.tagline')" />

<section class="section-padding">
    <div class="container-custom max-w-3xl">
        <p class="text-gray-600 leading-relaxed text-lg">{{ __('general.tagline') }}</p>
        <p class="text-gray-500 mt-6">{{ __('home.empty_destinations') }}</p>
    </div>
</section>
@endsection
