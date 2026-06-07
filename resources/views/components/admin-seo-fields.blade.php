@props(['model' => null, 'prefix' => ''])

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <h2 class="text-lg font-bold text-gray-900 mb-2">{{ __('seo.admin_seo_section') ?? 'SEO Settings' }}</h2>
    <p class="text-sm text-gray-500 mb-6">{{ __('seo.admin_keywords_hint') ?? 'Target Gulf/GCC countries. Separate keywords with commas.' }}</p>

    <div x-data="{ tab: 'en' }">
        <div class="flex gap-2 mb-4 border-b border-gray-200">
            @foreach(['en' => 'English', 'ar' => 'العربية', 'hr' => 'Hrvatski'] as $code => $name)
                <button type="button" @click="tab = '{{ $code }}'" :class="tab === '{{ $code }}' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500'" class="px-4 py-2 text-sm font-medium border-b-2 transition-colors">{{ $name }}</button>
            @endforeach
        </div>

        @foreach(['en', 'ar', 'hr'] as $lang)
            <div x-show="tab === '{{ $lang }}'" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meta Title ({{ strtoupper($lang) }})</label>
                    <input type="text" name="{{ $prefix }}meta_title[{{ $lang }}]" value="{{ old($prefix.'meta_title.'.$lang, $model?->getTranslation('meta_title', $lang) ?? '') }}" class="input-luxury" {{ $lang === 'ar' ? 'dir=rtl' : '' }}>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meta Description ({{ strtoupper($lang) }})</label>
                    <textarea name="{{ $prefix }}meta_description[{{ $lang }}]" rows="3" class="input-luxury" {{ $lang === 'ar' ? 'dir=rtl' : '' }}>{{ old($prefix.'meta_description.'.$lang, $model?->getTranslation('meta_description', $lang) ?? '') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('seo.meta_keywords') ?? 'Search Keywords' }} ({{ strtoupper($lang) }})
                    </label>
                    <textarea name="{{ $prefix }}meta_keywords[{{ $lang }}]" rows="2" class="input-luxury" placeholder="{{ config('seo.page_keywords.home.'.$lang ?? '') }}" {{ $lang === 'ar' ? 'dir=rtl' : '' }}>{{ old($prefix.'meta_keywords.'.$lang, $model?->getTranslation('meta_keywords', $lang) ?? '') }}</textarea>
                    <p class="text-xs text-gray-400 mt-1">{{ __('seo.keywords_example') ?? 'Example: Gulf tourism, Saudi tours, UAE travel, Qatar holidays' }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
