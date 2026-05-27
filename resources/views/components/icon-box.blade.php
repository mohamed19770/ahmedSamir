@props([
    'name',
    'size' => 'md',
    'variant' => 'primary',
])

@php
    $sizes = [
        'sm' => 'icon-box-sm',
        'md' => 'icon-box-md',
        'lg' => 'icon-box-lg',
        'xl' => 'icon-box-xl',
    ];
    $variants = [
        'primary' => 'icon-box-primary',
        'white' => 'icon-box-white',
        'glass' => 'icon-box-glass',
        'gold' => 'icon-box-gold',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'icon-box ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($variants[$variant] ?? $variants['primary'])]) }}>
    <x-icon :name="$name" class="icon-box-svg" />
</div>
