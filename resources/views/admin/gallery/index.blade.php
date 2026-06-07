@extends('layouts.admin')

@section('title', 'Gallery')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-gray-500">Manage gallery images</p>
    <a href="{{ route('admin.gallery.create') }}" class="btn-primary text-sm">Upload Image</a>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    @forelse($galleries as $item)
        <div class="bg-white rounded-xl border border-gray-100 overflow-hidden group">
            <img src="{{ str_starts_with($item->image, 'http') ? $item->image : asset('storage/'.$item->image) }}" alt="" class="w-full h-40 object-cover">
            <div class="p-3 flex items-center justify-between">
                <span class="text-sm text-gray-600 capitalize">{{ $item->category ?? 'General' }}</span>
                <div class="flex gap-2">
                    <a href="{{ route('admin.gallery.edit', $item) }}" class="text-primary-600 text-sm">Edit</a>
                    <form action="{{ route('admin.gallery.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-red-600 text-sm">Delete</button></form>
                </div>
            </div>
        </div>
    @empty
        <p class="col-span-full text-center text-gray-400 py-12">No gallery images yet.</p>
    @endforelse
</div>
@if($galleries->hasPages())<div class="mt-6">{{ $galleries->links() }}</div>@endif
@endsection
