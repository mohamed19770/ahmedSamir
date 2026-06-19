<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Coming Soon — Designation 2 Go</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-gradient-to-br from-primary-900 via-primary-800 to-dark-900 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl flex items-center justify-center shadow-2xl shadow-primary-500/30 mb-4">
                <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">Designation 2 Go</h1>
            <p class="text-white/60 mt-1">Site under construction — private preview</p>
        </div>

        <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl p-8 shadow-2xl">
            <h2 class="text-xl font-bold text-white mb-2">Sign In</h2>
            <p class="text-white/50 text-sm mb-6">Enter your preview credentials to access the site</p>

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-500/20 border border-red-400/30 rounded-xl text-red-200 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('site-lock.unlock') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-white/80 mb-2">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required autofocus autocomplete="username"
                           class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/40 focus:ring-2 focus:ring-primary-400 focus:border-transparent outline-none transition-all"
                           placeholder="Username">
                </div>
                <div>
                    <label class="block text-sm font-medium text-white/80 mb-2">Password</label>
                    <input type="password" name="password" required autocomplete="current-password"
                           class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/40 focus:ring-2 focus:ring-primary-400 focus:border-transparent outline-none transition-all"
                           placeholder="••••••••">
                </div>
                <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold rounded-xl shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 hover:-translate-y-0.5 transition-all duration-300">
                    Enter Site
                </button>
            </form>
        </div>

        <p class="text-center text-white/40 text-sm mt-6">
            <a href="{{ route('login') }}" class="hover:text-white/70 transition-colors">Admin login →</a>
        </p>
    </div>
</body>
</html>
