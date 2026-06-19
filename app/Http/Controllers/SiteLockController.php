<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SiteLockController extends Controller
{
    public function show(Request $request)
    {
        if (! config('site-lock.enabled')) {
            return redirect('/');
        }

        if ($request->session()->get('site_lock_passed')) {
            return redirect('/');
        }

        return view('auth.site-lock');
    }

    public function unlock(Request $request)
    {
        if (! config('site-lock.enabled')) {
            return redirect('/');
        }

        $request->validate([
            'username' => 'required|string|max:100',
            'password' => 'required|string|max:255',
        ]);

        $username = (string) config('site-lock.username');
        $password = (string) config('site-lock.password');

        if ($username === '' || $password === '') {
            throw ValidationException::withMessages([
                'username' => 'Site lock is not configured. Contact the administrator.',
            ]);
        }

        $validUser = hash_equals($username, $request->input('username'));
        $validPass = hash_equals($password, $request->input('password'));

        if (! $validUser || ! $validPass) {
            throw ValidationException::withMessages([
                'username' => 'Invalid username or password.',
            ]);
        }

        $request->session()->put('site_lock_passed', true);

        return redirect()->intended('/');
    }
}
