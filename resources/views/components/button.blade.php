@props([
    'href' => null,
    'variant' => 'primary', // primary | dark | outline | light
    'type' => 'button',
    'navigate' => true,     // set to false for tel:, mailto: and external links
    'contact' => false,     // true = opens the contact pop-up (falls back to /contact without JavaScript)
    'service' => '',        // service slug to pre-select in the pop-up, e.g. "events"
])
@php
    if ($contact) {
        $href = route('contact', array_filter(['service' => $service]));
        $navigate = false;
    }

    $base = 'inline-flex items-center justify-center gap-2 rounded-full px-7 py-3.5 text-sm font-semibold tracking-wide transition duration-200 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-leaf disabled:cursor-not-allowed disabled:opacity-60';

    $variants = [
        // ink text on leaf green keeps strong contrast (white on this green would not)
        'primary' => 'bg-leaf text-ink hover:bg-forest hover:text-white',
        'dark' => 'bg-ink text-white hover:bg-forest',
        'outline' => 'border border-ink/30 text-ink hover:border-ink hover:bg-ink hover:text-white',
        'light' => 'border border-white/40 text-white hover:bg-white hover:text-ink',
    ];
    $classes = $base.' '.($variants[$variant] ?? $variants['primary']);
@endphp

@if ($href)
    <a href="{{ $href }}" @if ($contact) data-contact="{{ $service }}" @endif @if ($navigate) wire:navigate @endif {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
