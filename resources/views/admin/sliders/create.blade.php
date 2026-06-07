@extends('layouts.admin')

@section('title', isset($slider) ? 'Edit Slider' : 'Add Slider')

@section('content')
<div class="max-w-3xl">
    <form action="{{ isset($slider) ? route('admin.sliders.update', $slider) : route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf @if(isset($slider)) @method('PUT') @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div x-data="{ tab: 'en' }">
                <div class="flex gap-2 mb-4 border-b">@foreach(['en'=>'English','ar'=>'العربية','hr'=>'Hrvatski'] as $c=>$n)<button type="button" @click="tab='{{ $c }}'" :class="tab==='{{ $c }}'?'border-primary-500 text-primary-600':'border-transparent text-gray-500'" class="px-4 py-2 text-sm border-b-2">{{ $n }}</button>@endforeach</div>
                @foreach(['en','ar','hr'] as $lang)
                    <div x-show="tab==='{{ $lang }}'" class="space-y-4">
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Title</label><input type="text" name="title[{{ $lang }}]" value="{{ old('title.'.$lang, $slider?->getTranslation('title', $lang) ?? '') }}" class="input-luxury" {{ $lang==='ar'?'dir=rtl':'' }}></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label><input type="text" name="subtitle[{{ $lang }}]" value="{{ old('subtitle.'.$lang, $slider?->getTranslation('subtitle', $lang) ?? '') }}" class="input-luxury" {{ $lang==='ar'?'dir=rtl':'' }}></div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 space-y-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Button URL</label><input type="text" name="button_url" value="{{ old('button_url', $slider?->button_url ?? '') }}" class="input-luxury"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Slide Image</label><input type="file" name="image" accept="image/*" class="input-luxury" {{ isset($slider) ? '' : 'required' }}></div>
                @if(isset($slider) && $slider->image)
                    <div><img src="{{ asset('storage/'.$slider->image) }}" alt="" class="h-24 rounded-lg object-cover"></div>
                @endif
                <label class="flex items-center gap-3"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $slider?->is_active ?? true) ? 'checked' : '' }} class="w-5 h-5 rounded"> Active</label>
            </div>
        </div>
        <div class="flex gap-4"><button type="submit" class="btn-primary">Save</button><a href="{{ route('admin.sliders.index') }}" class="btn-secondary">Cancel</a></div>
    </form>
</div>
@endsection
