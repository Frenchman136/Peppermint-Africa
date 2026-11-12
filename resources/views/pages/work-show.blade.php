@php
    $gallery = $project->gallery_urls;
    $story = array_filter([
        'The challenge' => $project->challenge,
        'Our approach' => $project->approach,
        'The result' => $project->result,
    ]);
@endphp
<x-layouts.app :title="$project->title"
    :description="\Illuminate\Support\Str::limit($project->summary, 155)"
    :image="$project->cover_url"
    headerTheme="dark">

    <x-page-hero :eyebrow="$project->category" :title="$project->title" :intro="$project->client">
        <a href="{{ route('work') }}" wire:navigate class="reveal mt-10 inline-flex items-center gap-2 text-sm font-semibold text-white/70 transition hover:text-leaf" x-data x-reveal="300">
            <span aria-hidden="true">←</span> All work
        </a>
    </x-page-hero>

    {{-- Cover image (only when a real photo exists) --}}
    @if ($project->cover_url)
        <div class="container-x -mt-10 relative z-10 sm:-mt-14">
            <x-project-cover :project="$project" class="h-72 shadow-2xl sm:h-[30rem]" />
        </div>
    @endif

    {{-- Story + facts --}}
    <section class="bg-white py-20 lg:py-28">
        <div class="container-x grid gap-14 lg:grid-cols-12">
            <div class="space-y-12 lg:col-span-8">
                <div>
                    <h2 class="text-xs font-semibold uppercase tracking-[0.2em] text-forest">Overview</h2>
                    <p class="mt-4 text-xl leading-relaxed text-ink/80 sm:text-2xl">{{ $project->summary }}</p>
                </div>

                @foreach ($story as $heading => $text)
                    <div class="border-t border-ink/10 pt-10">
                        <h2 class="text-2xl font-extrabold tracking-tight">{{ $heading }}</h2>
                        <div class="mt-4 space-y-4 text-lg leading-relaxed text-ink/70">
                            @foreach (preg_split('/\R{2,}/', trim($text)) as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <aside class="lg:col-span-4">
                <div class="rounded-2xl bg-mist p-8 lg:sticky lg:top-28">
                    <dl class="space-y-5">
                        @if ($project->client)
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-[0.2em] text-ink/50">Client</dt>
                                <dd class="mt-1 font-semibold">{{ $project->client }}</dd>
                            </div>
                        @endif
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-[0.2em] text-ink/50">Service</dt>
                            <dd class="mt-1 font-semibold">{{ $project->category }}</dd>
                        </div>
                        @if ($project->industry)
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-[0.2em] text-ink/50">Sector</dt>
                                <dd class="mt-1 font-semibold">{{ $project->industry->name }}</dd>
                            </div>
                        @endif
                        @if ($project->year)
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-[0.2em] text-ink/50">Year</dt>
                                <dd class="mt-1 font-semibold">{{ $project->year }}</dd>
                            </div>
                        @endif
                    </dl>

                    <x-button :contact="true" :service="$project->service?->slug ?? ''" class="mt-8 w-full">Start a similar project</x-button>
                </div>
            </aside>
        </div>
    </section>

    {{-- Video (loads only on click) --}}
    @if ($project->video_embed_url)
        <section class="bg-white pb-20 lg:pb-28">
            <div class="container-x max-w-5xl">
                <x-video-embed :src="$project->video_embed_url" :title="$project->title" />
            </div>
        </section>
    @endif

    {{-- Gallery + lightbox --}}
    @if (count($gallery))
        <section class="bg-mist py-20 lg:py-28"
            x-data="{
                open: false, i: 0, imgs: @js($gallery),
                show(n) { this.i = n; this.open = true },
                next() { this.i = (this.i + 1) % this.imgs.length },
                prev() { this.i = (this.i - 1 + this.imgs.length) % this.imgs.length }
            }"
            x-effect="document.documentElement.classList.toggle('overflow-hidden', open)"
            @keydown.escape.window="open = false"
            @keydown.arrow-right.window="open && next()"
            @keydown.arrow-left.window="open && prev()">

            <div class="container-x">
                <x-section-heading eyebrow="Gallery" title="Moments from the project" />

                <div class="mt-12 grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-3">
                    @foreach ($gallery as $n => $url)
                        <button type="button" @click="show({{ $n }})" class="group relative aspect-[4/3] overflow-hidden rounded-xl bg-ink/10" aria-label="Open image {{ $n + 1 }} of {{ count($gallery) }}">
                            <img src="{{ $url }}" alt="{{ $project->title }}, photo {{ $n + 1 }}" loading="lazy" class="size-full object-cover transition duration-500 group-hover:scale-105">
                        </button>
                    @endforeach
                </div>
            </div>

            <div x-show="open" x-cloak x-transition.opacity
                 class="fixed inset-0 z-[90] flex items-center justify-center bg-black/90 p-4"
                 @click.self="open = false" role="dialog" aria-modal="true" aria-label="Photo gallery">
                <button type="button" @click="open = false" class="absolute right-4 top-4 grid size-12 place-items-center rounded-full bg-white/10 text-3xl text-white transition hover:bg-leaf hover:text-ink" aria-label="Close gallery">×</button>

                <button type="button" x-show="imgs.length > 1" @click="prev()" class="absolute left-3 top-1/2 grid size-12 -translate-y-1/2 place-items-center rounded-full bg-white/10 text-2xl text-white transition hover:bg-leaf hover:text-ink sm:left-6" aria-label="Previous photo">←</button>

                <img :src="imgs[i]" alt="" class="max-h-[85vh] max-w-full rounded-lg object-contain">

                <button type="button" x-show="imgs.length > 1" @click="next()" class="absolute right-3 top-1/2 grid size-12 -translate-y-1/2 place-items-center rounded-full bg-white/10 text-2xl text-white transition hover:bg-leaf hover:text-ink sm:right-6" aria-label="Next photo">→</button>

                <p class="absolute bottom-5 left-1/2 -translate-x-1/2 text-sm font-semibold text-white/70" x-text="(i + 1) + ' / ' + imgs.length"></p>
            </div>
        </section>
    @endif

    {{-- Related work --}}
    @if ($related->isNotEmpty())
        <section class="bg-white py-20 lg:py-28">
            <div class="container-x">
                <div class="flex items-end justify-between gap-6">
                    <x-section-heading eyebrow="More work" title="Related projects" />
                    <x-button :href="route('work')" variant="outline" class="hidden shrink-0 sm:inline-flex">View all work</x-button>
                </div>
                <div class="mt-12 grid gap-x-8 gap-y-14 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($related as $i => $item)
                        <x-project-card :project="$item" :index="$i + 1" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.app>
