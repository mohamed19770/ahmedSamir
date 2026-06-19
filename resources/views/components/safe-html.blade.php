@props(['content' => ''])

<div {{ $attributes }}>
    {!! \App\Support\HtmlSanitizer::clean($content) !!}
</div>
