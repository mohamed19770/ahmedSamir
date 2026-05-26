<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() { return view('admin.users.index', ['users' => User::latest()->paginate(20)]); }
    public function create() { return view('admin.users.create'); }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255', 'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8', 'role' => 'required|in:admin,editor,user',
        ]);
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);
        return redirect()->route('admin.users.index')->with('success', 'User created.');
    }

    public function edit(User $user) { return view('admin.users.create', compact('user')); }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255', 'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,editor,user',
        ]);
        if ($request->filled('password')) { $validated['password'] = Hash::make($request->password); }
        $user->update($validated);
        return redirect()->route('admin.users.index')->with('success', 'User updated.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) { return back()->with('error', 'Cannot delete yourself.'); }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }
}
