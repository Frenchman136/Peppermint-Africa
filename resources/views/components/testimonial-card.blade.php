@props(['testimonial'])
<figure {{ $attributes->class(['flex h-full flex-col rounded-2xl bg-white p-8 shadow-sm']) }}>
    <svg class="size-8 text-leaf" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M9.5 6C6.5 7 4 9.8 4 13.5V18h6v-6H7c0-2 1-3.6 3-4.4L9.5 6Zm9 0c-3 1-5.5 3.8-5.5 7.5V18h6v-6h-3c0-2 1-3.6 3-4.4L18.5 6Z"/></svg>
    <blockquote class="mt-5 flex-1 text-lg leading-relaxed">{{ $testimonial['quote'] }}</blockquote>
    <figcaption class="mt-6 border-t border-ink/10 pt-5">
        <p class="font-bold">{{ $testimonial['name'] }}</p>
        <p class="text-sm text-ink/60">{{ trim(($testimonial['role'] ?? '').', '.($testimonial['company'] ?? ''), ', ') }}</p>
    </figcaption>
</figure>
