@props(['service', 'number'])
<a href="{{ route('services') }}#{{ $service->slug }}" wire:navigate
   {{ $attributes->class(['group relative flex h-full flex-col overflow-hidden rounded-2xl border border-ink/10 bg-white p-8 transition duration-300 hover:-translate-y-1 hover:border-ink hover:bg-ink hover:text-white hover:shadow-xl']) }}>
    <span class="font-display text-5xl font-extrabold text-leaf/40 transition-colors group-hover:text-leaf">{{ str_pad($number, 2, '0', STR_PAD_LEFT) }}</span>
    <h3 class="mt-6 text-xl font-bold leading-snug">{{ $service->title }}</h3>
    <p class="mt-3 flex-1 leading-relaxed text-ink/70 transition-colors group-hover:text-white/70">{{ $service->description }}</p>
    <span class="mt-8 inline-flex items-center gap-2 text-sm font-semibold text-forest transition-colors group-hover:text-leaf">
        Learn more
        <span aria-hidden="true" class="transition-transform duration-300 group-hover:translate-x-1">→</span>
    </span>
</a>
