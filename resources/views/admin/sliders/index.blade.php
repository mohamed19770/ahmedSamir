@extends('layouts.admin')

@section('title', 'Hero Sliders')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-gray-500">Manage homepage hero slides</p>
    <a href="{{ route('admin.sliders.create') }}" class="btn-primary text-sm">Add Slider</a>
</div>

<div class="grid md:grid-cols-2 gap-4">
    @forelse($sliders as $slider)
        <div class="bg-white rounded-xl border border-gray-100 overflow-hidden flex gap-4 p-4">
            @if($slider->image)
                <img src="{{ str_starts_with($slider->image, 'http') ? $slider->image : asset('storage/'.$slider->image) }}" alt="" class="w-32 h-20 rounded-lg object-cover shrink-0">
            @endif
            <div class="flex-1">
                <p class="font-medium text-gray-900">{{ $slider->getTranslation('title', 'en') }}</p>
                <p class="text-sm text-gray-500">{{ $slider->is_active ? 'Active' : 'Inactive' }} · Order: {{ $slider->sort_order }}</p>
                <div class="mt-2 flex gap-3">
                    <a href="{{ route('admin.sliders.edit', $slider) }}" class="text-primary-600 text-sm">Edit</a>
                    <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-red-600 text-sm">Delete</button></form>
                </div>
            </div>
        </div>
    @empty
        <p class="col-span-full text-center text-gray-400 py-12">No sliders yet.</p>
    @endforelse
</div>
@endsection
