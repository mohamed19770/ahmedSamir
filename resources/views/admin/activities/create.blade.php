@extends('layouts.admin')

@section('title', isset($activity) ? 'Edit Activity' : 'Create Activity')

@section('content')
<div class="max-w-4xl">
    <form action="{{ isset($activity) ? route('admin.activities.update', $activity) : route('admin.activities.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @if(isset($activity)) @method('PUT') @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Basic Information</h2>
            <div x-data="{ tab: 'en' }">
                <div class="flex gap-2 mb-4 border-b border-gray-200">
                    @foreach(['en' => 'English', 'ar' => 'العربية', 'hr' => 'Hrvatski'] as $code => $name)
                        <button type="button" @click="tab = '{{ $code }}'" :class="tab === '{{ $code }}' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500'" class="px-4 py-2 text-sm font-medium border-b-2 transition-colors">{{ $name }}</button>
                    @endforeach
                </div>
                @foreach(['en', 'ar', 'hr'] as $lang)
                    <div x-show="tab === '{{ $lang }}'" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Title ({{ strtoupper($lang) }})</label>
                            <input type="text" name="title[{{ $lang }}]" value="{{ old('title.'.$lang, $activity->getTranslation('title', $lang) ?? '') }}" class="input-luxury" {{ $lang === 'ar' ? 'dir=rtl' : '' }}>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Short Description ({{ strtoupper($lang) }})</label>
                            <textarea name="short_description[{{ $lang }}]" rows="2" class="input-luxury" {{ $lang === 'ar' ? 'dir=rtl' : '' }}>{{ old('short_description.'.$lang, $activity->getTranslation('short_description', $lang) ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Description ({{ strtoupper($lang) }})</label>
                            <textarea name="description[{{ $lang }}]" rows="6" class="input-luxury" {{ $lang === 'ar' ? 'dir=rtl' : '' }}>{{ old('description.'.$lang, $activity->getTranslation('description', $lang) ?? '') }}</textarea>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Details</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Price ($)</label>
                    <input type="number" name="price" value="{{ old('price', $activity->price ?? '') }}" step="0.01" class="input-luxury" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Duration</label>
                    <input type="text" name="duration" value="{{ old('duration', $activity->duration ?? '') }}" placeholder="e.g. 4 hours" class="input-luxury" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="category" class="input-luxury" required>
                        @foreach(['adventure', 'cultural', 'desert', 'water', 'family', 'luxury'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $activity->category ?? '') === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                    <input type="text" name="location" value="{{ old('location', $activity->location ?? '') }}" placeholder="e.g. Riyadh, Saudi Arabia" class="input-luxury">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Image</h2>
            <div class="flex items-center gap-6">
                @if(isset($activity) && $activity->image)
                    <img src="{{ str_starts_with($activity->image, 'http') ? $activity->image : asset('storage/'.$activity->image) }}" alt="" class="w-32 h-24 rounded-xl object-cover">
                @endif
                <input type="file" name="image" accept="image/*" class="input-luxury">
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Settings</h2>
            <div class="flex items-center gap-8">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $activity->is_active ?? true) ? 'checked' : '' }} class="w-5 h-5 text-primary-600 rounded border-gray-300">
                    <span class="text-sm font-medium text-gray-700">Active</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $activity->is_featured ?? false) ? 'checked' : '' }} class="w-5 h-5 text-primary-600 rounded border-gray-300">
                    <span class="text-sm font-medium text-gray-700">Featured</span>
                </label>
            </div>
        </div>

        <x-admin-seo-fields :model="$activity ?? null" />

        <div class="flex items-center gap-4">
            <button type="submit" class="btn-primary">{{ isset($activity) ? 'Update Activity' : 'Create Activity' }}</button>
            <a href="{{ route('admin.activities.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
