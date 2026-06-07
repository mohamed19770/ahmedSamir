<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ in_array(app()->getLocale(), config('locales.rtl', [])) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-seo-meta />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://images.unsplash.com" crossorigin>
    <link rel="dns-prefetch" href="https://images.unsplash.com">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @include('components.structured-data')
    @stack('head')
</head>
<body class="min-h-screen bg-white" x-data>
    @include('components.navbar')

    @if(!empty($breadcrumbItems))
        <x-breadcrumbs :items="$breadcrumbItems" />
    @endif

    <main id="main-content">
        @yield('content')
    </main>

    @include('components.footer')
    <x-whatsapp-button />

    @stack('scripts')
</body>
</html>
