@props(['title' => null, 'description' => null, 'image' => null])
@php
    $siteName = config('site.name');
    $fullTitle = $title ? $title.' | '.$siteName : $siteName.': '.config('site.tagline');
    $desc = $description ?: config('site.description');
    $img = $image ?: asset('images/og-default.jpg');
    $url = url()->current();

    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => $siteName,
        'url' => url('/'),
        'logo' => asset('images/logo/logo-horizontal.png'),
        'email' => config('site.email'),
        'telephone' => config('site.phone'),
        'foundingDate' => (string) config('site.established'),
        'description' => config('site.description'),
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'Mituntu Building, Ring Road, Kileleshwa',
            'addressLocality' => 'Nairobi',
            'addressCountry' => 'KE',
        ],
    ];
@endphp

<title>{{ $fullTitle }}</title>
<meta name="description" content="{{ $desc }}">
<link rel="canonical" href="{{ $url }}">
<meta name="theme-color" content="#0a0a0a">

{{-- Favicons --}}
<link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}">
<link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon-192.png') }}">
<link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

{{-- Open Graph / social sharing (WhatsApp, LinkedIn, Facebook) --}}
<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $fullTitle }}">
<meta property="og:description" content="{{ $desc }}">
<meta property="og:url" content="{{ $url }}">
<meta property="og:image" content="{{ $img }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $fullTitle }}">
<meta name="twitter:description" content="{{ $desc }}">
<meta name="twitter:image" content="{{ $img }}">

<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
