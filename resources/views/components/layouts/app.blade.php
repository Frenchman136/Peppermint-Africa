@props([
    'title' => null,
    'description' => null,
    'image' => null,
    // 'dark'  = page starts with a dark hero (header is transparent with a white logo)
    // 'light' = page starts light (header is solid white from the top)
    'headerTheme' => 'dark',
])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

    {{-- Flags used by CSS: JS is available; skip the preloader if already seen this session --}}
    <script>
        document.documentElement.classList.add('js');
        try { if (sessionStorage.getItem('pm_seen')) document.documentElement.classList.add('no-preloader'); } catch (e) {}
    </script>
    <noscript><style>#preloader{display:none!important}</style></noscript>

    <x-seo :title="$title" :description="$description" :image="$image" />

    {{-- Fonts (Inter + Montserrat) are self-hosted through resources/css/app.css --}}

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen">
    <a href="#main"
       class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[110] focus:rounded-full focus:bg-leaf focus:px-5 focus:py-2 focus:font-semibold focus:text-ink">
        Skip to content
    </a>

    @persist('preloader')
        <x-preloader />
    @endpersist

    <x-header :theme="$headerTheme" />

    <main id="main">
        {{ $slot }}
    </main>

    <x-footer />
    <x-whatsapp-button />
    <x-contact-modal />

    @livewireScripts
</body>
</html>
