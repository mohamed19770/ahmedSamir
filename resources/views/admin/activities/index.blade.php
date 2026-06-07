@extends('layouts.admin')

@section('title', 'Activities')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-gray-500">Manage activities and adventures</p>
    <a href="{{ route('admin.activities.create') }}" class="btn-primary text-sm">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Add Activity
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Activity</th>
                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Category</th>
                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Price</th>
                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Duration</th>
                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Location</th>
                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Status</th>
                    <th class="text-right px-6 py-4 text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($activities as $activity)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($activity->image)
                                    <img src="{{ str_starts_with($activity->image, 'http') ? $activity->image : asset('storage/'.$activity->image) }}" alt="" class="w-12 h-12 rounded-lg object-cover">
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 text-xs">N/A</div>
                                @endif
                                <div>
                                    <p class="font-medium text-gray-900">{{ $activity->getTranslation('title', 'en') }}</p>
                                    @if($activity->is_featured)
                                        <span class="text-xs text-gold-600 font-medium">Featured</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 bg-primary-50 text-primary-700 rounded-lg text-xs font-medium capitalize">{{ $activity->category }}</span>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900">${{ number_format($activity->price) }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $activity->duration }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $activity->location ?? '—' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $activity->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $activity->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.activities.edit', $activity) }}" class="p-2 text-gray-500 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.activities.destroy', $activity) }}" method="POST" onsubmit="return confirm('Delete this activity?')">
                                    @csrf @method('DELETE')
                                    <button class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400">No activities found. Create your first activity.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($activities->hasPages())
        <div class="p-4 border-t border-gray-100">{{ $activities->links() }}</div>
    @endif
</div>
@endsection
