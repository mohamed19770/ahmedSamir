@extends('layouts.admin')

@section('title', 'Tourism Packages')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-gray-500">Manage all tourism packages</p>
    <a href="{{ route('admin.packages.create') }}" class="btn-primary text-sm">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Add Package
    </a>
</div>

<!-- Packages Table -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Package</th>
                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Category</th>
                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Price</th>
                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Duration</th>
                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Status</th>
                    <th class="text-right px-6 py-4 text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($packages ?? [] as $package)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $package->image }}" alt="" class="w-12 h-12 rounded-lg object-cover">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $package->getTranslation('title', 'en') }}</p>
                                    <p class="text-sm text-gray-500">{{ $package->destination?->getTranslation('name', 'en') }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 bg-primary-50 text-primary-700 rounded-lg text-xs font-medium capitalize">{{ $package->category }}</span>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900">${{ number_format($package->price) }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $package->duration_days }}D / {{ $package->duration_nights }}N</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $package->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $package->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.packages.edit', $package) }}" class="p-2 text-gray-500 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" onsubmit="return confirm('Delete this package?')">
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
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400">No packages found. Create your first package.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($packages) && method_exists($packages, 'hasPages') && $packages->hasPages())
        <div class="p-4 border-t border-gray-100">{{ $packages->links() }}</div>
    @endif
</div>
@endsection
