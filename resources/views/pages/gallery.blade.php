@php
    // Flatten every published album into one list of photos
    $photos = collect();
    foreach ($albums as $album) {
        foreach ($album->photo_urls as $url) {
            $photos->push(['u' => $url, 'a' => $album->slug, 't' => $album->title]);
        }
    }
@endphp
<x-layouts.app title="Gallery"
    description="Photos from Peppermint Africa events, conferences, launches and campaigns."
    headerTheme="dark">

    <x-page-hero eyebrow="Gallery" title="Our work," accent="up close."
        intro="Events, conferences and campaigns, and the teams that make them happen." />

    <section class="bg-white py-16 lg:py-24"
        x-data="{
            filter: 'all',
            open: false,
            i: 0,
            tx: 0,
            photos: @js($photos->values()),
            get visible() {
                return this.photos
                    .map((p, idx) => ({ ...p, idx }))
                    .filter(p => this.filter === 'all' || p.a === this.filter);
            },
            show(idx) { this.i = this.visible.findIndex(p => p.idx === idx); this.open = true; },
            next() { this.i = (this.i + 1) % this.visible.length; },
            prev() { this.i = (this.i - 1 + this.visible.length) % this.visible.length; },
        }"
        x-effect="document.documentElement.classList.toggle('overflow-hidden', open)"
        @keydown.escape.window="open = false"
        @keydown.arrow-right.window="open && next()"
        @keydown.arrow-left.window="open && prev()">

        <div class="container-x">
            @if ($photos->isEmpty())
                <div class="rounded-2xl bg-mist p-12 text-center">
                    <img src="{{ asset('images/logo/leaf.png') }}" alt="" aria-hidden="true" class="mx-auto h-12 w-auto opacity-70">
                    <h2 class="mt-5 text-2xl font-extrabold">Photos are on their way</h2>
                    <p class="mt-2 text-ink/65">Check back soon, or see our projects in the meantime.</p>
                    <x-button :href="route('work')" variant="dark" class="mt-6">See our work</x-button>
                </div>
            @else
                {{-- Filters --}}
                <div class="flex flex-wrap gap-2" role="group" aria-label="Filter by album">
                    <button type="button" @click="filter = 'all'"
                            class="rounded-full border px-5 py-2.5 text-sm font-semibold transition duration-200"
                            :class="filter === 'all' ? 'border-ink bg-ink text-white' : 'border-ink/15 hover:border-ink'">
                        All photos <span class="ml-1 text-xs opacity-60">{{ $photos->count() }}</span>
                    </button>
                    @foreach ($albums as $album)
                        @if (count($album->photo_urls))
                            <button type="button" @click="filter = '{{ $album->slug }}'"
                                    class="rounded-full border px-5 py-2.5 text-sm font-semibold transition duration-200"
                                    :class="filter === '{{ $album->slug }}' ? 'border-ink bg-ink text-white' : 'border-ink/15 hover:border-ink'">
                                {{ $album->title }}
                            </button>
                        @endif
                    @endforeach
                </div>

                {{-- Masonry grid --}}
                <div class="mt-10 columns-2 gap-3 sm:gap-4 lg:columns-3">
                    @foreach ($photos as $n => $photo)
                        <button type="button" @click="show({{ $n }})"
                                x-show="filter === 'all' || filter === '{{ $photo['a'] }}'"
                                x-transition:enter="transition duration-500" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                class="group relative mb-3 block w-full break-inside-avoid overflow-hidden rounded-2xl bg-ink/10 sm:mb-4"
                                aria-label="Open photo {{ $n + 1 }}: {{ $photo['t'] }}">
                            <img src="{{ $photo['u'] }}" alt="{{ $photo['t'] }}, photo {{ $n + 1 }}" loading="lazy" class="block h-auto w-full transition duration-700 group-hover:scale-105">
                            <span class="pointer-events-none absolute inset-x-0 bottom-0 translate-y-2 bg-linear-to-t from-ink/80 to-transparent p-4 text-left text-sm font-semibold text-white opacity-0 transition duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                                {{ $photo['t'] }}
                            </span>
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Lightbox: arrow keys, Esc and swipe --}}
        <div x-show="open" x-cloak x-transition.opacity
             class="fixed inset-0 z-[90] flex items-center justify-center bg-black/90 p-4"
             @click.self="open = false" role="dialog" aria-modal="true" aria-label="Photo viewer"
             @touchstart.passive="tx = $event.touches[0].clientX"
             @touchend.passive="const dx = $event.changedTouches[0].clientX - tx; if (Math.abs(dx) > 50) { dx < 0 ? next() : prev() }">

            <button type="button" @click="open = false" class="absolute right-4 top-4 grid size-12 place-items-center rounded-full bg-white/10 text-3xl text-white transition hover:bg-leaf hover:text-ink" aria-label="Close viewer">×</button>
            <button type="button" x-show="visible.length > 1" @click="prev()" class="absolute left-3 top-1/2 grid size-12 -translate-y-1/2 place-items-center rounded-full bg-white/10 text-2xl text-white transition hover:bg-leaf hover:text-ink sm:left-6" aria-label="Previous photo">←</button>

            <figure class="flex max-h-full max-w-full flex-col items-center">
                <img :src="visible[i] && visible[i].u" :alt="visible[i] && visible[i].t" class="max-h-[80vh] max-w-full rounded-lg object-contain">
                <figcaption class="mt-4 text-center text-sm font-semibold text-white/80">
                    <span x-text="visible[i] && visible[i].t"></span>
                    <span class="ml-2 text-white/50" x-text="(i + 1) + ' / ' + visible.length"></span>
                </figcaption>
            </figure>

            <button type="button" x-show="visible.length > 1" @click="next()" class="absolute right-3 top-1/2 grid size-12 -translate-y-1/2 place-items-center rounded-full bg-white/10 text-2xl text-white transition hover:bg-leaf hover:text-ink sm:right-6" aria-label="Next photo">→</button>
        </div>
    </section>
</x-layouts.app>
