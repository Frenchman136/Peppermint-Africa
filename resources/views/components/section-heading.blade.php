@props([
    'eyebrow' => null,
    'title',
    'intro' => null,
    'align' => 'left',   // left | center
    'theme' => 'light',  // light = dark text, dark = white text
])
<div {{ $attributes->class([
    'max-w-3xl',
    'mx-auto text-center' => $align === 'center',
    'text-white' => $theme === 'dark',
]) }}>
    @if ($eyebrow)
        <p @class([
            'mb-4 inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.2em]',
            'text-forest' => $theme === 'light',
            'text-leaf' => $theme === 'dark',
        ])>
            <img src="{{ asset('images/logo/leaf.png') }}" alt="" aria-hidden="true" class="h-4 w-auto">{{ $eyebrow }}
        </p>
    @endif
    <h2 class="text-balance text-3xl font-extrabold leading-tight tracking-tight sm:text-4xl lg:text-5xl">{{ $title }}</h2>
    @if ($intro)
        <p @class(['mt-5 text-lg leading-relaxed', 'text-ink/70' => $theme === 'light', 'text-white/70' => $theme === 'dark'])>{{ $intro }}</p>
    @endif
</div>
