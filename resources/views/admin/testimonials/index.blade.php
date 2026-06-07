@extends('layouts.admin')

@section('title', 'Testimonials')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-gray-500">Manage customer testimonials</p>
    <a href="{{ route('admin.testimonials.create') }}" class="btn-primary text-sm">Add Testimonial</a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b"><tr>
            <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Name</th>
            <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Rating</th>
            <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Status</th>
            <th class="text-right px-6 py-4 text-sm font-semibold text-gray-600">Actions</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($testimonials as $t)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900">{{ $t->name }}</p>
                        <p class="text-sm text-gray-500">{{ Str::limit($t->getTranslation('content', 'en'), 60) }}</p>
                    </td>
                    <td class="px-6 py-4">{{ $t->rating }}/5</td>
                    <td class="px-6 py-4">
                        <span class="text-xs px-2 py-1 rounded-full {{ $t->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $t->is_active ? 'Active' : 'Inactive' }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.testimonials.edit', $t) }}" class="text-primary-600 text-sm mr-3">Edit</a>
                        <form action="{{ route('admin.testimonials.destroy', $t) }}" method="POST" class="inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-red-600 text-sm">Delete</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-6 py-12 text-center text-gray-400">No testimonials yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($testimonials->hasPages())<div class="p-4 border-t">{{ $testimonials->links() }}</div>@endif
</div>
@endsection
