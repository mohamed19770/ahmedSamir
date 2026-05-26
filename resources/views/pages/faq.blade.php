@extends('layouts.app')

@section('meta_title', __('general.faq') . ' - ' . __('general.site_name'))

@section('content')
@php $locale = app()->getLocale(); $isRtl = in_array($locale, config('locales.rtl', [])); @endphp

<!-- Hero -->
<section class="relative pt-32 pb-20 bg-gradient-to-br from-primary-900 to-dark-900">
    <div class="absolute inset-0 bg-gradient-to-b from-primary-900/90 to-dark-900/95"></div>
    <div class="container-custom relative z-10">
        <span class="inline-block px-4 py-1.5 bg-white/10 text-white/90 rounded-full text-sm font-semibold mb-6 backdrop-blur-sm border border-white/20">{{ __('general.faq') }}</span>
        <h1 class="text-5xl lg:text-6xl font-bold text-white mb-4">{{ __('general.faq') }}</h1>
        <p class="text-xl text-white/70 max-w-2xl">Find answers to commonly asked questions about our services.</p>
    </div>
</section>

<!-- FAQ -->
<section class="section-padding">
    <div class="container-custom max-w-4xl">
        <div class="space-y-4" x-data="{ openFaq: null }">
            @forelse($faqs ?? [] as $index => $faq)
                <div class="border border-gray-200 rounded-2xl overflow-hidden transition-all" :class="openFaq === {{ $index }} && 'shadow-lg border-primary-200'">
                    <button @click="openFaq = openFaq === {{ $index }} ? null : {{ $index }}" class="w-full flex items-center justify-between p-6 text-{{ $isRtl ? 'right' : 'left' }} hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-lg text-gray-900 {{ $isRtl ? 'pl-4' : 'pr-4' }}">{{ $faq->getTranslation('question', $locale) }}</span>
                        <svg class="w-5 h-5 text-primary-500 shrink-0 transition-transform duration-300" :class="openFaq === {{ $index }} && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === {{ $index }}" x-collapse>
                        <div class="px-6 pb-6 text-gray-600 leading-relaxed">
                            {{ $faq->getTranslation('answer', $locale) }}
                        </div>
                    </div>
                </div>
            @empty
                @php
                    $demoFaqs = [
                        ['q' => 'How do I book a tourism package?', 'a' => 'You can book directly through our website by selecting a package and filling out the booking form. Alternatively, you can contact us via phone or email for personalized assistance.'],
                        ['q' => 'What is your cancellation policy?', 'a' => 'We offer free cancellation up to 48 hours before the trip start date. After that, a 25% cancellation fee applies. Please refer to our terms and conditions for full details.'],
                        ['q' => 'Do you offer customized travel packages?', 'a' => 'Yes! We specialize in creating bespoke travel experiences tailored to your preferences, budget, and schedule. Contact us with your requirements.'],
                        ['q' => 'What payment methods do you accept?', 'a' => 'We accept all major credit cards (Visa, MasterCard, Amex), bank transfers, and PayPal. Payment plans are available for premium packages.'],
                        ['q' => 'Is travel insurance included?', 'a' => 'Basic travel insurance is included in all our premium packages. We also offer comprehensive insurance upgrades for additional coverage.'],
                        ['q' => 'Do you provide visa assistance?', 'a' => 'Yes, we offer complete visa processing services including document preparation, application submission, and follow-up. Visit our Visa Services page for details.'],
                    ];
                @endphp
                @foreach($demoFaqs as $index => $faq)
                    <div class="border border-gray-200 rounded-2xl overflow-hidden transition-all" :class="openFaq === {{ $index }} && 'shadow-lg border-primary-200'">
                        <button @click="openFaq = openFaq === {{ $index }} ? null : {{ $index }}" class="w-full flex items-center justify-between p-6 text-{{ $isRtl ? 'right' : 'left' }} hover:bg-gray-50 transition-colors">
                            <span class="font-semibold text-lg text-gray-900 {{ $isRtl ? 'pl-4' : 'pr-4' }}">{{ $faq['q'] }}</span>
                            <svg class="w-5 h-5 text-primary-500 shrink-0 transition-transform duration-300" :class="openFaq === {{ $index }} && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="openFaq === {{ $index }}" x-collapse>
                            <div class="px-6 pb-6 text-gray-600 leading-relaxed">{{ $faq['a'] }}</div>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>
@endsection
