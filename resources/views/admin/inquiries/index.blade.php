@extends('layouts.admin')

@section('title', 'Inquiries')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-6 py-3 text-sm font-semibold text-gray-600">Name</th>
                    <th class="text-left px-6 py-3 text-sm font-semibold text-gray-600">Subject</th>
                    <th class="text-left px-6 py-3 text-sm font-semibold text-gray-600">Type</th>
                    <th class="text-left px-6 py-3 text-sm font-semibold text-gray-600">Status</th>
                    <th class="text-left px-6 py-3 text-sm font-semibold text-gray-600">Date</th>
                    <th class="text-right px-6 py-3 text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($inquiries as $inquiry)
                    <tr class="hover:bg-gray-50 {{ $inquiry->status === 'new' ? 'bg-blue-50/30' : '' }}">
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-900">{{ $inquiry->name }}</p>
                            <p class="text-sm text-gray-500">{{ $inquiry->email }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ Str::limit($inquiry->subject ?? $inquiry->message, 50) }}</td>
                        <td class="px-6 py-4"><span class="px-2.5 py-1 bg-gray-100 text-gray-600 rounded-lg text-xs font-medium capitalize">{{ $inquiry->type }}</span></td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $inquiry->status === 'new' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $inquiry->status === 'read' ? 'bg-gray-100 text-gray-700' : '' }}
                                {{ $inquiry->status === 'replied' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $inquiry->status === 'closed' ? 'bg-red-100 text-red-700' : '' }}">
                                {{ ucfirst($inquiry->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $inquiry->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="text-primary-600 hover:text-primary-700 font-medium text-sm">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">No inquiries yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($inquiries->hasPages())
        <div class="p-4 border-t border-gray-100">{{ $inquiries->links() }}</div>
    @endif
</div>
@endsection
