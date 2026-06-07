@extends('layouts.admin')

@section('title', 'SEO Settings')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-6 py-3 text-sm font-semibold text-gray-600">Page</th>
                    <th class="text-left px-6 py-3 text-sm font-semibold text-gray-600">Meta Title (EN)</th>
                    <th class="text-left px-6 py-3 text-sm font-semibold text-gray-600">Meta Description (EN)</th>
                    <th class="text-left px-6 py-3 text-sm font-semibold text-gray-600">{{ __('seo.meta_keywords') }}</th>
                    <th class="text-right px-6 py-3 text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($settings as $setting)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-semibold text-gray-900 capitalize">{{ $setting->page_identifier }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ Str::limit($setting->getTranslation('meta_title', 'en'), 50) }}</td>
                        <td class="px-6 py-4 text-gray-500 text-sm">{{ Str::limit($setting->getTranslation('meta_description', 'en'), 60) }}</td>
                        <td class="px-6 py-4 text-gray-500 text-xs">{{ Str::limit($setting->getTranslation('meta_keywords', 'en'), 50) }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.seo.edit', $setting) }}" class="text-primary-600 hover:text-primary-700 font-medium text-sm">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
