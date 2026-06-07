@props(['faqs' => [], 'title' => null])
@php $locale = app()->getLocale(); @endphp

@if($faqs->count() > 0)
<section class="section-padding bg-gray-50/50" aria-labelledby="faq-heading">
    <div class="container-custom max-w-4xl">
        <div class="text-center mb-12">
            <h2 id="faq-heading" class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">{{ $title ?? __('general.faq') }}</h2>
        </div>
        <div class="space-y-4" x-data="{ open: 0 }">
            @foreach($faqs as $index => $faq)
                <article class="border border-gray-200 rounded-xl overflow-hidden bg-white">
                    <h3>
                        <button type="button"
                                @click="open = open === {{ $index }} ? null : {{ $index }}"
                                class="w-full flex items-center justify-between p-5 text-start hover:bg-gray-50 transition-colors"
                                :aria-expanded="open === {{ $index }}">
                            <span class="font-semibold text-gray-900 pe-4">{{ $faq->getTranslation('question', $locale) }}</span>
                            <x-icon name="chevron-down" class="w-5 h-5 text-gray-500 shrink-0 transition-transform" x-bind:class="open === {{ $index }} && 'rotate-180'" />
                        </button>
                    </h3>
                    <div x-show="open === {{ $index }}" x-collapse class="px-5 pb-5 text-gray-600 leading-relaxed">
                        {!! nl2br(e($faq->getTranslation('answer', $locale))) !!}
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif
