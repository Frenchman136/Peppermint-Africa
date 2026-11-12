<x-layouts.app title="Blog"
    description="Practical thinking on events, public relations, branding and strategic communication from the Peppermint Africa team."
    headerTheme="dark">

    <x-page-hero eyebrow="Insights" title="Ideas worth" accent="sharing."
        intro="Practical thinking on events, PR, branding and communication strategy." />

    <section class="bg-white py-16 lg:py-24">
        <div class="container-x">

            {{-- Category filters --}}
            @if ($categories->isNotEmpty())
                <div class="flex flex-wrap gap-2" role="group" aria-label="Filter by category">
                    <a href="{{ route('blog') }}" wire:navigate
                       class="rounded-full border px-5 py-2.5 text-sm font-semibold transition duration-200 {{ ! $category ? 'border-ink bg-ink text-white' : 'border-ink/15 hover:border-ink' }}">All</a>
                    @foreach ($categories as $item)
                        <a href="{{ route('blog', ['category' => $item]) }}" wire:navigate
                           class="rounded-full border px-5 py-2.5 text-sm font-semibold transition duration-200 {{ $category === $item ? 'border-ink bg-ink text-white' : 'border-ink/15 hover:border-ink' }}">{{ $item }}</a>
                    @endforeach
                </div>
            @endif

            {{-- Featured article --}}
            @if ($featured)
                <a href="{{ $featured->url }}" wire:navigate class="group mt-10 grid overflow-hidden rounded-3xl bg-ink text-white lg:grid-cols-2">
                    <div class="relative aspect-[16/10] overflow-hidden lg:aspect-auto lg:min-h-[22rem]">
                        @if ($featured->cover_url)
                            <img src="{{ $featured->cover_url }}" alt="" class="size-full object-cover transition duration-700 group-hover:scale-105">
                        @else
                            <div class="size-full bg-linear-to-br from-forest to-ink"></div>
                        @endif
                    </div>
                    <div class="flex flex-col justify-center p-8 sm:p-12">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-leaf">Featured{{ $featured->category ? ' · '.$featured->category : '' }}</p>
                        <h2 class="mt-4 text-balance text-3xl font-extrabold leading-tight sm:text-4xl">{{ $featured->title }}</h2>
                        <p class="mt-4 leading-relaxed text-white/70">{{ \Illuminate\Support\Str::limit($featured->summary, 180) }}</p>
                        <p class="mt-6 text-sm text-white/55">{{ $featured->published_at?->format('j M Y') }} · {{ $featured->reading_time }} min read</p>
                        <span class="mt-6 inline-flex items-center gap-2 font-semibold text-leaf">Read article <span aria-hidden="true" class="transition-transform duration-300 group-hover:translate-x-1">→</span></span>
                    </div>
                </a>
            @endif

            {{-- Article grid --}}
            @if ($posts->isNotEmpty())
                <div class="mt-14 grid gap-x-8 gap-y-14 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($posts as $i => $post)
                        <div class="reveal" x-data x-reveal="{{ ($i % 3) * 100 }}">
                            <x-post-card :post="$post" />
                        </div>
                    @endforeach
                </div>

                <div class="mt-14">{{ $posts->links() }}</div>
            @elseif (! $featured)
                <div class="mt-10 rounded-2xl bg-mist p-12 text-center">
                    <img src="{{ asset('images/logo/leaf.png') }}" alt="" aria-hidden="true" class="mx-auto h-12 w-auto opacity-70">
                    <h2 class="mt-5 text-2xl font-extrabold">No articles here yet</h2>
                    <p class="mt-2 text-ink/65">Check back soon for new insights.</p>
                    @if ($category)
                        <x-button :href="route('blog')" variant="dark" class="mt-6">See all articles</x-button>
                    @endif
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
