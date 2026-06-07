@extends('layouts.admin')

@section('title', isset($gallery) ? 'Edit Image' : 'Upload Image')

@section('content')
<div class="max-w-2xl">
    <form action="{{ isset($gallery) ? route('admin.gallery.update', $gallery) : route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf @if(isset($gallery)) @method('PUT') @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
            @if(isset($gallery))
                <img src="{{ asset('storage/'.$gallery->image) }}" alt="" class="w-full h-48 object-cover rounded-xl">
            @else
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Image *</label>
                    <input type="file" name="image" accept="image/*" class="input-luxury" required>
                </div>
            @endif
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <input type="text" name="category" value="{{ old('category', $gallery->category ?? '') }}" class="input-luxury" placeholder="e.g. destinations">
            </div>
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $gallery->is_active ?? true) ? 'checked' : '' }} class="w-5 h-5 text-primary-600 rounded">
                <span class="text-sm font-medium text-gray-700">Active</span>
            </label>
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $gallery->is_featured ?? false) ? 'checked' : '' }} class="w-5 h-5 text-primary-600 rounded">
                <span class="text-sm font-medium text-gray-700">Featured</span>
            </label>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="btn-primary">{{ isset($gallery) ? 'Update' : 'Upload' }}</button>
            <a href="{{ route('admin.gallery.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
