@php
    $meta = $seo_meta ?? [];
    $title = $meta['title'] ?? config('app.name');
    $description = $meta['description'] ?? null;
    $robots = $meta['robots'] ?? 'noindex, follow';
    $canonical = $meta['canonical'] ?? null;
    $og = $meta['og'] ?? [];
    $ogImage = $og['image'] ?? null;

    if ($ogImage && !\Illuminate\Support\Str::startsWith($ogImage, ['http://', 'https://', '/'])) {
        $ogImage = asset('storage/' . ltrim($ogImage, '/'));
    }
@endphp

<title>{{ $title }}</title>
@if ($description)
    <meta name="description" content="{{ $description }}">
@endif
<meta name="robots" content="{{ $robots }}">
@if ($canonical)
    <link rel="canonical" href="{{ $canonical }}">
@endif

@if (!empty($og['title']))
    <meta property="og:title" content="{{ $og['title'] }}">
@endif
@if (!empty($og['description']))
    <meta property="og:description" content="{{ $og['description'] }}">
@endif
@if ($ogImage)
    <meta property="og:image" content="{{ $ogImage }}">
@endif

@if (!empty($meta['h1']))
    <h1 class="visually-hidden">{{ $meta['h1'] }}</h1>
    {{-- <meta name="headline" content="{{ $meta['h1'] }}">
    <meta property="og:headline" content="{{ $meta['h1'] }}"> --}}
@endif

@if (!empty($meta['structured_data']))
    <script type="application/ld+json">
        {!! json_encode($meta['structured_data'], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT) !!}
    </script>
@endif
