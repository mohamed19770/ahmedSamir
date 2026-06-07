@extends('layouts.admin')

@section('title', isset($user) ? 'Edit User' : 'Add User')

@section('content')
<div class="max-w-xl">
    <form action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST" class="space-y-6">
        @csrf @if(isset($user)) @method('PUT') @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Name *</label><input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="input-luxury" required></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Email *</label><input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="input-luxury" required></div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password {{ isset($user) ? '(leave blank to keep)' : '*' }}</label>
                <input type="password" name="password" class="input-luxury" {{ isset($user) ? '' : 'required minlength=8' }}>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role *</label>
                <select name="role" class="input-luxury" required>
                    @foreach(['admin', 'editor', 'user'] as $role)
                        <option value="{{ $role }}" {{ old('role', $user->role ?? '') === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex gap-4"><button type="submit" class="btn-primary">Save</button><a href="{{ route('admin.users.index') }}" class="btn-secondary">Cancel</a></div>
    </form>
</div>
@endsection
