@php
    $seo = $seo ?? [];
    $hreflangUrls = $hreflangUrls ?? \App\Helpers\LocaleHelper::hreflangUrls();
    $locale = app()->getLocale();
@endphp

<title>{{ $seo['title'] ?? config('site.name') }}</title>
<meta name="description" content="{{ $seo['description'] ?? config('site.tagline') }}">
@if(!empty($seo['keywords']))
<meta name="keywords" content="{{ $seo['keywords'] }}">
@endif
<meta name="robots" content="{{ $seo['robots'] ?? 'index, follow' }}">
<meta name="author" content="{{ config('site.name') }}">
<link rel="canonical" href="{{ $seo['canonical'] ?? url()->current() }}">

@if(config('site.geo.latitude') && config('site.geo.longitude'))
<meta name="geo.position" content="{{ config('site.geo.latitude') }};{{ config('site.geo.longitude') }}">
<meta name="ICBM" content="{{ config('site.geo.latitude') }}, {{ config('site.geo.longitude') }}">
@endif

<meta property="og:title" content="{{ $seo['og_title'] ?? $seo['title'] ?? config('site.name') }}">
<meta property="og:description" content="{{ $seo['og_description'] ?? $seo['description'] ?? config('site.tagline') }}">
<meta property="og:image" content="{{ $seo['og_image'] ?? asset(config('site.og_image')) }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="{{ $seo['og_type'] ?? 'website' }}">
<meta property="og:site_name" content="{{ config('site.name') }}">
<meta property="og:locale" content="{{ \App\Helpers\LocaleHelper::ogLocale($locale) }}">
@foreach(config('locales.supported') as $altLocale)
    @if($altLocale !== $locale)
        <meta property="og:locale:alternate" content="{{ \App\Helpers\LocaleHelper::ogLocale($altLocale) }}">
    @endif
@endforeach

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@destination2go">
<meta name="twitter:title" content="{{ $seo['og_title'] ?? $seo['title'] ?? config('site.name') }}">
<meta name="twitter:description" content="{{ $seo['og_description'] ?? $seo['description'] ?? config('site.tagline') }}">
<meta name="twitter:image" content="{{ $seo['og_image'] ?? asset(config('site.og_image')) }}">

<meta name="theme-color" content="#0c4a6e">

@foreach($hreflangUrls as $lang => $href)
    <link rel="alternate" hreflang="{{ $lang }}" href="{{ $href }}">
@endforeach

<link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
<link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
