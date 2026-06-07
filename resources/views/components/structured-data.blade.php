@if(!empty($pageSchemas))
    @foreach(array_filter($pageSchemas) as $schema)
        <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @endforeach
@endif

<script type="application/ld+json">{!! app(\App\Services\SchemaService::class)->encode(
    app(\App\Services\SchemaService::class)->organization(),
    app(\App\Services\SchemaService::class)->website()
) !!}</script>

@stack('schema')
