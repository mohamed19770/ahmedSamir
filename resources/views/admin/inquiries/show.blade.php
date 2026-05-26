@extends('layouts.admin')

@section('title', 'Inquiry from ' . $inquiry->name)

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $inquiry->name }}</h2>
                <p class="text-gray-500">{{ $inquiry->email }} @if($inquiry->phone) &middot; {{ $inquiry->phone }} @endif</p>
            </div>
            <span class="px-3 py-1 rounded-full text-sm font-medium
                {{ $inquiry->status === 'new' ? 'bg-blue-100 text-blue-700' : '' }}
                {{ $inquiry->status === 'replied' ? 'bg-green-100 text-green-700' : '' }}">
                {{ ucfirst($inquiry->status) }}
            </span>
        </div>

        @if($inquiry->subject)
            <h3 class="font-semibold text-gray-900 mb-2">{{ $inquiry->subject }}</h3>
        @endif
        <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $inquiry->message }}</p>

        <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100">
            <span class="text-sm text-gray-500">{{ $inquiry->created_at->format('M d, Y H:i') }}</span>
            <span class="px-2.5 py-1 bg-gray-100 text-gray-600 rounded-lg text-xs font-medium capitalize">{{ $inquiry->type }}</span>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <form action="{{ route('admin.inquiries.reply', $inquiry) }}" method="POST">
            @csrf
            <button class="btn-primary">Mark as Replied</button>
        </form>
        <form action="{{ route('admin.inquiries.updateStatus', $inquiry) }}" method="POST">
            @csrf @method('PATCH')
            <input type="hidden" name="status" value="closed">
            <button class="btn-secondary">Close</button>
        </form>
    </div>
</div>
@endsection
