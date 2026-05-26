@extends('layouts.admin')

@section('title', 'Edit SEO - ' . ucfirst($seoSetting->page_identifier))

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('admin.seo.update', $seoSetting) }}" method="POST" class="space-y-6">
        @csrf @method('PUT')

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-6">SEO Settings for "{{ ucfirst($seoSetting->page_identifier) }}" Page</h2>

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
                            <input type="text" name="meta_title[{{ $lang }}]" value="{{ $seoSetting->getTranslation('meta_title', $lang) }}" class="input-luxury" {{ $lang === 'ar' ? 'dir=rtl' : '' }}>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Meta Description ({{ strtoupper($lang) }})</label>
                            <textarea name="meta_description[{{ $lang }}]" rows="3" class="input-luxury" {{ $lang === 'ar' ? 'dir=rtl' : '' }}>{{ $seoSetting->getTranslation('meta_description', $lang) }}</textarea>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">OG Image URL</label>
                    <input type="text" name="og_image" value="{{ $seoSetting->og_image }}" class="input-luxury">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Canonical URL</label>
                    <input type="url" name="canonical_url" value="{{ $seoSetting->canonical_url }}" class="input-luxury">
                </div>
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="btn-primary">Save Changes</button>
            <a href="{{ route('admin.seo.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
