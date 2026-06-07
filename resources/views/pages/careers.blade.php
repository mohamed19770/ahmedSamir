@extends('layouts.app')

@section('content')
@php $locale = app()->getLocale(); $isRtl = in_array($locale, config('locales.rtl', [])); @endphp

<x-page-hero :title="__('general.careers')" :badge="__('general.careers')" subtitle="Join our team and help people create unforgettable travel memories." />

<!-- Open Positions -->
<section class="section-padding">
    <div class="container-custom max-w-4xl">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Open Positions</h2>
            <p class="text-xl text-gray-500">We're always looking for talented individuals to join our growing team</p>
        </div>

        <div class="space-y-4">
            @php
                $positions = [
                    ['title' => 'Senior Travel Consultant', 'type' => 'Full-time', 'location' => 'Dubai', 'dept' => 'Operations'],
                    ['title' => 'Digital Marketing Specialist', 'type' => 'Full-time', 'location' => 'Remote', 'dept' => 'Marketing'],
                    ['title' => 'Tour Guide - Arabic Speaker', 'type' => 'Contract', 'location' => 'Cairo', 'dept' => 'Operations'],
                    ['title' => 'Full Stack Developer', 'type' => 'Full-time', 'location' => 'Remote', 'dept' => 'Technology'],
                    ['title' => 'Customer Support Representative', 'type' => 'Full-time', 'location' => 'Zagreb', 'dept' => 'Support'],
                ];
            @endphp

            @foreach($positions as $position)
                <div class="bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-lg hover:border-primary-200 transition-all duration-300 group">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-primary-600 transition-colors">{{ $position['title'] }}</h3>
                            <div class="flex flex-wrap items-center gap-3 mt-2">
                                <span class="px-3 py-1 bg-primary-50 text-primary-700 rounded-full text-xs font-medium">{{ $position['dept'] }}</span>
                                <span class="text-sm text-gray-500 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                    {{ $position['location'] }}
                                </span>
                                <span class="text-sm text-gray-500">{{ $position['type'] }}</span>
                            </div>
                        </div>
                        <a href="{{ route('contact.index', $locale) }}" class="btn-primary text-sm whitespace-nowrap">
                            Apply Now
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- CTA -->
        <div class="mt-16 text-center p-12 bg-gray-50 rounded-3xl">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Don't see the right fit?</h3>
            <p class="text-gray-500 mb-6 max-w-md mx-auto">Send us your resume anyway. We're always interested in meeting talented people.</p>
            <a href="mailto:careers@designation2go.com" class="btn-secondary">Send Your CV</a>
        </div>
    </div>
</section>
@endsection
