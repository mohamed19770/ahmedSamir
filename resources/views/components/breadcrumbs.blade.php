@props(['items' => []])
@php
    $locale = app()->getLocale();
    $isRtl = in_array($locale, config('locales.rtl', []));
@endphp

@if(count($items) > 0)
<nav aria-label="Breadcrumb" class="pt-24 pb-4 bg-gray-50/90 border-b border-gray-100">
    <div class="container-custom">
    <ol class="flex flex-wrap items-center gap-2 text-sm text-gray-500" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
        @foreach($items as $index => $item)
            <li class="flex items-center gap-2">
                @if($index > 0)
                    <x-icon name="{{ $isRtl ? 'chevron-left' : 'chevron-right' }}" class="w-3.5 h-3.5 text-gray-400" />
                @endif
                @if(!empty($item['url']) && $index < count($items) - 1)
                    <a href="{{ $item['url'] }}" class="hover:text-primary-600 transition-colors">{{ $item['name'] }}</a>
                @else
                    <span class="text-gray-900 font-medium" aria-current="page">{{ $item['name'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
    </div>
</nav>
@endif
