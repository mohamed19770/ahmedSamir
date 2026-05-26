<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | Designation 2 Go</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-gradient-to-br from-primary-900 via-primary-800 to-dark-900 flex items-center justify-center p-4">
    <div class="text-center max-w-xl">
        <!-- Floating Globe -->
        <div class="relative mb-12">
            <div class="w-48 h-48 mx-auto bg-gradient-to-br from-primary-400 to-primary-600 rounded-full flex items-center justify-center shadow-2xl shadow-primary-500/30 floating">
                <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="absolute -top-4 -right-4 w-20 h-20 bg-gold-400/20 rounded-full blur-xl"></div>
            <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-secondary-400/20 rounded-full blur-xl"></div>
        </div>

        <h1 class="text-8xl font-bold text-white mb-4">404</h1>
        <h2 class="text-3xl font-bold text-white mb-4">Lost in Paradise?</h2>
        <p class="text-xl text-white/70 mb-10">The page you're looking for has wandered off the map. Let us guide you back to amazing destinations.</p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="/" class="btn-primary text-lg px-10 py-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Back Home
            </a>
            <a href="/en/contact" class="inline-flex items-center gap-2 px-8 py-4 text-white border-2 border-white/30 rounded-xl hover:bg-white/10 transition-all font-semibold text-lg">
                Contact Support
            </a>
        </div>
    </div>

    <style>
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
        .floating { animation: float 6s ease-in-out infinite; }
    </style>
</body>
</html>
