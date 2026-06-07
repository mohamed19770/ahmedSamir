@extends('layouts.admin')

@section('title', isset($package) ? 'Edit Package' : 'Create Package')

@section('content')
<div class="max-w-4xl">
    <form action="{{ isset($package) ? route('admin.packages.update', $package) : route('admin.packages.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @if(isset($package)) @method('PUT') @endif

        <!-- Basic Info -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Basic Information</h2>

            <!-- Multilingual Tabs -->
            <div x-data="{ tab: 'en' }" class="mb-6">
                <div class="flex gap-2 mb-4 border-b border-gray-200">
                    @foreach(['en' => 'English', 'ar' => 'العربية', 'hr' => 'Hrvatski'] as $code => $name)
                        <button type="button" @click="tab = '{{ $code }}'" :class="tab === '{{ $code }}' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500'" class="px-4 py-2 text-sm font-medium border-b-2 transition-colors">
                            {{ $name }}
                        </button>
                    @endforeach
                </div>

                @foreach(['en', 'ar', 'hr'] as $lang)
                    <div x-show="tab === '{{ $lang }}'" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Title ({{ strtoupper($lang) }})</label>
                            <input type="text" name="title[{{ $lang }}]" value="{{ old('title.' . $lang, $package->getTranslation('title', $lang) ?? '') }}" class="input-luxury" {{ $lang === 'ar' ? 'dir=rtl' : '' }}>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Short Description ({{ strtoupper($lang) }})</label>
                            <textarea name="short_description[{{ $lang }}]" rows="2" class="input-luxury" {{ $lang === 'ar' ? 'dir=rtl' : '' }}>{{ old('short_description.' . $lang, $package->getTranslation('short_description', $lang) ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Description ({{ strtoupper($lang) }})</label>
                            <textarea name="description[{{ $lang }}]" rows="6" class="input-luxury" {{ $lang === 'ar' ? 'dir=rtl' : '' }}>{{ old('description.' . $lang, $package->getTranslation('description', $lang) ?? '') }}</textarea>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Pricing & Duration -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Pricing & Duration</h2>
            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Price ($)</label>
                    <input type="number" name="price" value="{{ old('price', $package->price ?? '') }}" step="0.01" class="input-luxury" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sale Price ($)</label>
                    <input type="number" name="sale_price" value="{{ old('sale_price', $package->sale_price ?? '') }}" step="0.01" class="input-luxury">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="category" class="input-luxury">
                        @foreach(['adventure', 'beach', 'cultural', 'luxury', 'honeymoon', 'family', 'corporate'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $package->category ?? '') === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Duration (Days)</label>
                    <input type="number" name="duration_days" value="{{ old('duration_days', $package->duration_days ?? '') }}" class="input-luxury" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Duration (Nights)</label>
                    <input type="number" name="duration_nights" value="{{ old('duration_nights', $package->duration_nights ?? '') }}" class="input-luxury" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Max Guests</label>
                    <input type="number" name="max_guests" value="{{ old('max_guests', $package->max_guests ?? 20) }}" class="input-luxury">
                </div>
            </div>
        </div>

        <!-- Image -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Image</h2>
            <div class="flex items-center gap-6">
                @if(isset($package) && $package->image)
                    <img src="{{ $package->image }}" alt="" class="w-32 h-24 rounded-xl object-cover">
                @endif
                <input type="file" name="image" accept="image/*" class="input-luxury">
            </div>
        </div>

        <!-- Settings -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Settings</h2>
            <div class="flex items-center gap-8">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $package->is_active ?? true) ? 'checked' : '' }} class="w-5 h-5 text-primary-600 rounded border-gray-300 focus:ring-primary-500">
                    <span class="text-sm font-medium text-gray-700">Active</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $package->is_featured ?? false) ? 'checked' : '' }} class="w-5 h-5 text-primary-600 rounded border-gray-300 focus:ring-primary-500">
                    <span class="text-sm font-medium text-gray-700">Featured</span>
                </label>
            </div>
        </div>

        <x-admin-seo-fields :model="$package ?? null" />

        <!-- Submit -->
        <div class="flex items-center gap-4">
            <button type="submit" class="btn-primary">
                {{ isset($package) ? 'Update Package' : 'Create Package' }}
            </button>
            <a href="{{ route('admin.packages.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
