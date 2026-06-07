@extends('layouts.admin')

@section('title', 'Users')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-gray-500">Manage admin and staff users</p>
    <a href="{{ route('admin.users.create') }}" class="btn-primary text-sm">Add User</a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b"><tr>
            <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Name</th>
            <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Email</th>
            <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Role</th>
            <th class="text-right px-6 py-4 text-sm font-semibold text-gray-600">Actions</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                    <td class="px-6 py-4"><span class="px-2 py-1 bg-primary-50 text-primary-700 rounded text-xs capitalize">{{ $user->role }}</span></td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.users.edit', $user) }}" class="text-primary-600 text-sm mr-3">Edit</a>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Delete user?')">@csrf @method('DELETE')<button class="text-red-600 text-sm">Delete</button></form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-6 py-12 text-center text-gray-400">No users found.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($users->hasPages())<div class="p-4 border-t">{{ $users->links() }}</div>@endif
</div>
@endsection
