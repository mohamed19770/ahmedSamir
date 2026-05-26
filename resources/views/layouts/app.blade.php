<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ in_array(app()->getLocale(), config('locales.rtl', [])) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('meta_title', __('general.site_name') . ' - ' . __('general.tagline'))</title>
    <meta name="description" content="@yield('meta_description', __('general.tagline'))">
    <meta name="keywords" content="@yield('meta_keywords', 'tourism, travel, packages, adventures, luxury travel')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('og_title', __('general.site_name'))">
    <meta property="og:description" content="@yield('og_description', __('general.tagline'))">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="{{ app()->getLocale() }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', __('general.site_name'))">
    <meta name="twitter:description" content="@yield('og_description', __('general.tagline'))">
    <meta name="twitter:image" content="@yield('og_image', asset('images/og-default.jpg'))">

    <!-- Alternate Languages -->
    @foreach(config('locales.supported') as $loc)
        <link rel="alternate" hreflang="{{ $loc }}" href="{{ url($loc . '/' . ltrim(str_replace(url(app()->getLocale()), '', url()->current()), '/')) }}">
    @endforeach

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('schema')
    @stack('head')
</head>
<body class="min-h-screen bg-white" x-data>
    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

    @stack('scripts')
</body>
</html>
