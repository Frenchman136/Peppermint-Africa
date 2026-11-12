@props(['post', 'index' => 0])
<a href="{{ $post->url }}" wire:navigate {{ $attributes->class(['group block']) }}>
    <div class="relative aspect-[16/10] overflow-hidden rounded-2xl bg-ink">
        @if ($post->cover_url)
            <img src="{{ $post->cover_url }}" alt="" loading="lazy" class="size-full object-cover transition duration-700 group-hover:scale-105">
        @else
            <div class="size-full bg-linear-to-br from-forest to-ink"></div>
            <img src="{{ asset('images/logo/leaf.png') }}" alt="" aria-hidden="true" class="absolute -bottom-4 -right-2 w-32 rotate-12 opacity-20">
        @endif
        @if ($post->category)
            <span class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-ink backdrop-blur">{{ $post->category }}</span>
        @endif
    </div>
    <div class="mt-5">
        <p class="text-sm text-ink/55">
            {{ $post->published_at?->format('j M Y') }} · {{ $post->reading_time }} min read
        </p>
        <h3 class="mt-2 text-xl font-bold leading-snug transition-colors group-hover:text-forest">{{ $post->title }}</h3>
        <p class="mt-3 leading-relaxed text-ink/70">{{ \Illuminate\Support\Str::limit($post->summary, 130) }}</p>
        <span class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-forest">
            Read article <span aria-hidden="true" class="transition-transform duration-300 group-hover:translate-x-1">→</span>
        </span>
    </div>
</a>
