@extends('layouts.admin')

@section('title', 'Blog Posts')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-gray-500">Manage blog articles</p>
    <a href="{{ route('admin.blog.create') }}" class="btn-primary text-sm">Add Post</a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Title</th>
                <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Category</th>
                <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Author</th>
                <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Status</th>
                <th class="text-right px-6 py-4 text-sm font-semibold text-gray-600">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($posts as $post)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $post->getTranslation('title', 'en') }}</td>
                    <td class="px-6 py-4 capitalize text-gray-600">{{ $post->category }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $post->author?->name ?? '—' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $post->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $post->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.blog.edit', $post) }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium mr-3">Edit</a>
                        <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Delete this post?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:text-red-700 text-sm font-medium">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400">No blog posts yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($posts->hasPages())<div class="p-4 border-t">{{ $posts->links() }}</div>@endif
</div>
@endsection
