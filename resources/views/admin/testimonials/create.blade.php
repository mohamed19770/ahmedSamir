@extends('layouts.admin')

@section('title', isset($testimonial) ? 'Edit Testimonial' : 'Add Testimonial')

@section('content')
<div class="max-w-3xl">
    <form action="{{ isset($testimonial) ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}" method="POST" class="space-y-6">
        @csrf @if(isset($testimonial)) @method('PUT') @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
            <div class="grid md:grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Name *</label><input type="text" name="name" value="{{ old('name', $testimonial->name ?? '') }}" class="input-luxury" required></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Email</label><input type="email" name="email" value="{{ old('email', $testimonial->email ?? '') }}" class="input-luxury"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Designation</label><input type="text" name="designation" value="{{ old('designation', $testimonial->designation ?? '') }}" class="input-luxury"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Rating *</label><select name="rating" class="input-luxury" required>@for($i=1;$i<=5;$i++)<option value="{{ $i }}" {{ old('rating', $testimonial->rating ?? 5) == $i ? 'selected' : '' }}>{{ $i }}</option>@endfor</select></div>
            </div>
            <div x-data="{ tab: 'en' }">
                <div class="flex gap-2 mb-4 border-b">@foreach(['en'=>'English','ar'=>'العربية','hr'=>'Hrvatski'] as $c=>$n)<button type="button" @click="tab='{{ $c }}'" :class="tab==='{{ $c }}'?'border-primary-500 text-primary-600':'border-transparent text-gray-500'" class="px-4 py-2 text-sm border-b-2">{{ $n }}</button>@endforeach</div>
                @foreach(['en','ar','hr'] as $lang)
                    <div x-show="tab==='{{ $lang }}'"><label class="block text-sm font-medium text-gray-700 mb-1">Review ({{ strtoupper($lang) }})</label><textarea name="content[{{ $lang }}]" rows="4" class="input-luxury" {{ $lang==='ar'?'dir=rtl':'' }} required>{{ old('content.'.$lang, $testimonial->getTranslation('content', $lang) ?? '') }}</textarea></div>
                @endforeach
            </div>
            <div class="flex gap-8">
                <label class="flex items-center gap-3"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $testimonial->is_active ?? true) ? 'checked' : '' }} class="w-5 h-5 rounded"> Active</label>
                <label class="flex items-center gap-3"><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $testimonial->is_featured ?? false) ? 'checked' : '' }} class="w-5 h-5 rounded"> Featured</label>
            </div>
        </div>
        <div class="flex gap-4"><button type="submit" class="btn-primary">Save</button><a href="{{ route('admin.testimonials.index') }}" class="btn-secondary">Cancel</a></div>
    </form>
</div>
@endsection
