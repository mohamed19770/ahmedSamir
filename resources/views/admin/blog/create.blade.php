@extends('layouts.admin')

@section('title', isset($post) ? 'Edit Post' : 'Create Post')

@section('content')
<div class="max-w-4xl">
    <form action="{{ isset($post) ? route('admin.blog.update', $post) : route('admin.blog.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf @if(isset($post)) @method('PUT') @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div x-data="{ tab: 'en' }">
                <div class="flex gap-2 mb-4 border-b border-gray-200">
                    @foreach(['en' => 'English', 'ar' => 'العربية', 'hr' => 'Hrvatski'] as $code => $name)
                        <button type="button" @click="tab = '{{ $code }}'" :class="tab === '{{ $code }}' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500'" class="px-4 py-2 text-sm font-medium border-b-2">{{ $name }}</button>
                    @endforeach
                </div>
                @foreach(['en', 'ar', 'hr'] as $lang)
                    <div x-show="tab === '{{ $lang }}'" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input type="text" name="title[{{ $lang }}]" value="{{ old('title.'.$lang, $post->getTranslation('title', $lang) ?? '') }}" class="input-luxury" {{ $lang === 'ar' ? 'dir=rtl' : '' }}>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Excerpt</label>
                            <textarea name="excerpt[{{ $lang }}]" rows="2" class="input-luxury" {{ $lang === 'ar' ? 'dir=rtl' : '' }}>{{ old('excerpt.'.$lang, $post->getTranslation('excerpt', $lang) ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                            <textarea name="content[{{ $lang }}]" rows="8" class="input-luxury" {{ $lang === 'ar' ? 'dir=rtl' : '' }}>{{ old('content.'.$lang, $post->getTranslation('content', $lang) ?? '') }}</textarea>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category" class="input-luxury" required>
                    @foreach(['saudi-travel', 'riyadh', 'jeddah', 'alula', 'red-sea', 'culture', 'tips', 'visa', 'events'] as $cat)
                        <option value="{{ $cat }}" {{ old('category', $post->category ?? '') === $cat ? 'selected' : '' }}>{{ ucwords(str_replace('-', ' ', $cat)) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Featured Image</label>
                <input type="file" name="image" accept="image/*" class="input-luxury">
            </div>
            <label class="flex items-center gap-3 cursor-pointer md:col-span-2">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $post->is_published ?? false) ? 'checked' : '' }} class="w-5 h-5 text-primary-600 rounded">
                <span class="text-sm font-medium text-gray-700">Publish immediately</span>
            </label>
        </div>

        <x-admin-seo-fields :model="$post ?? null" />

        <div class="flex gap-4">
            <button type="submit" class="btn-primary">{{ isset($post) ? 'Update Post' : 'Create Post' }}</button>
            <a href="{{ route('admin.blog.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
