@props(['src', 'title' => 'Project video'])
{{-- Nothing from YouTube/Vimeo loads until the visitor clicks play (faster page, better privacy). --}}
<div x-data="{ play: false }" {{ $attributes->class(['relative aspect-video overflow-hidden rounded-2xl bg-ink']) }}>
    <template x-if="play">
        <iframe src="{{ $src }}" title="{{ $title }}" class="absolute inset-0 size-full border-0"
                allow="autoplay; encrypted-media; picture-in-picture; fullscreen" allowfullscreen></iframe>
    </template>

    <button type="button" x-show="!play" @click="play = true"
            class="group absolute inset-0 grid place-items-center bg-linear-to-br from-forest to-ink" aria-label="Play video: {{ $title }}">
        <img src="{{ asset('images/logo/leaf.png') }}" alt="" aria-hidden="true" class="absolute -bottom-6 -right-4 w-52 rotate-12 opacity-15">
        <span class="relative grid size-20 place-items-center rounded-full bg-leaf text-ink shadow-xl transition duration-300 group-hover:scale-110 group-hover:bg-white">
            <svg viewBox="0 0 24 24" class="ml-1 size-8" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>
        </span>
        <span class="absolute bottom-5 left-5 text-sm font-semibold uppercase tracking-widest text-white/80">Watch video</span>
    </button>
</div>
