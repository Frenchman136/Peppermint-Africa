@php
    $why = config('content.why');
    $process = config('content.process');

    $featured = \App\Models\Project::with('service')->published()->featured()->orderBy('sort_order')->take(6)->get();
    $collage = \App\Models\Project::published()->whereNotNull('cover_image')->orderBy('sort_order')->take(3)->get();
    $clients = \App\Models\Client::published()->orderBy('sort_order')->get();
    $testimonials = \App\Models\Testimonial::published()->orderBy('sort_order')->get();
    $posts = \App\Models\Post::published()->orderByDesc('published_at')->take(3)->get();

    // A few photos from each album for the gallery teaser (round-robin so it is not all one event)
    $teaser = \App\Models\Album::published()->orderBy('sort_order')->get()
        ->flatMap(fn ($a) => array_slice($a->photo_urls, 0, 2))
        ->take(5)
        ->values();
@endphp

<x-layouts.app headerTheme="dark">

    {{-- 1. HERO --}}
    <section class="relative isolate overflow-hidden bg-ink text-white">
        <div class="pointer-events-none absolute -right-32 -top-32 -z-10 size-[42rem] rounded-full bg-leaf/20 blur-[120px]" aria-hidden="true"></div>
        <img src="{{ asset('images/logo/leaf.png') }}" alt="" aria-hidden="true"
             class="pointer-events-none absolute -right-10 top-1/3 -z-10 hidden w-[26rem] rotate-12 opacity-[0.07] lg:block">

        <div class="container-x pb-20 pt-40 sm:pb-28 sm:pt-48 lg:pb-36 lg:pt-56">
            <p class="reveal inline-flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.25em] text-leaf" x-data x-reveal>
                <img src="{{ asset('images/logo/leaf.png') }}" alt="" aria-hidden="true" class="h-5 w-auto">Nairobi · Since {{ config('site.established') }}
            </p>

            <h1 class="reveal mt-6 max-w-5xl text-balance text-5xl font-extrabold leading-[1.02] tracking-tight sm:text-6xl lg:text-8xl" x-data x-reveal="100">
                Strategic Communications.
                <span class="text-leaf">Experiential Impact.</span>
            </h1>

            <p class="reveal mt-8 max-w-2xl text-lg leading-relaxed text-white/75 sm:text-xl" x-data x-reveal="200">
                A modern African communications agency helping brands, institutions and development partners build influence across global markets.
            </p>

            <div class="reveal mt-10 flex flex-wrap gap-4" x-data x-reveal="300">
                <x-button :contact="true" class="px-8! py-4! text-base">Request a proposal</x-button>
                <x-button :href="route('work')" variant="light" class="px-8! py-4! text-base">See our work</x-button>
            </div>
        </div>

        <div class="border-t border-white/10 bg-white/[0.03]">
            <dl class="container-x grid grid-cols-2 gap-y-8 py-10 lg:grid-cols-4">
                @foreach (config('site.stats') as $i => $stat)
                    <div class="reveal flex flex-col" x-data x-reveal="{{ $i * 120 }}">
                        <dt class="order-2 mt-2 max-w-[14rem] text-sm leading-snug text-white/60">{{ $stat['label'] }}</dt>
                        <dd class="font-display text-4xl font-extrabold text-white sm:text-5xl"
                            x-data x-counter="{{ $stat['value'] }}" data-suffix="{{ $stat['suffix'] }}">{{ $stat['value'] }}{{ $stat['suffix'] }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </section>

    {{-- 2. CLIENTS --}}
    <x-client-wall :clients="$clients" />

    {{-- 3. WHO WE ARE: photo collage + one clear statement --}}
    <section class="overflow-hidden bg-white pb-24 pt-8 lg:pb-32">
        <div class="container-x grid items-center gap-16 lg:grid-cols-2 lg:gap-24">

            <div class="reveal relative mx-auto aspect-[5/6] w-full max-w-md sm:max-w-lg" x-data x-reveal>
                @forelse ($collage as $i => $project)
                    @php
                        $layout = [
                            'left-0 top-0 w-[62%] aspect-[4/5] -rotate-3',
                            'right-0 top-[16%] w-[52%] aspect-square rotate-[4deg]',
                            'bottom-0 left-[12%] w-[54%] aspect-[4/3] -rotate-1',
                        ][$i];
                    @endphp
                    <div class="absolute {{ $layout }} transition duration-500 ease-out hover:z-10 hover:rotate-0 hover:scale-[1.03]">
                        <x-project-cover :project="$project" :index="$i" class="size-full shadow-xl ring-4 ring-white" />
                    </div>
                @empty
                    <div class="absolute inset-0 grid place-items-center rounded-3xl bg-linear-to-br from-forest to-ink">
                        <img src="{{ asset('images/logo/leaf.png') }}" alt="" aria-hidden="true" class="w-32 opacity-80">
                    </div>
                @endforelse

                <div class="absolute -bottom-3 right-2 rounded-2xl bg-ink px-6 py-5 text-white shadow-2xl sm:right-0">
                    <p class="font-display text-4xl font-extrabold text-leaf" x-data x-counter="15" data-suffix="+">15+</p>
                    <p class="mt-1 max-w-[9rem] text-sm leading-snug text-white/70">years of industry experience</p>
                </div>
            </div>

            <div class="reveal" x-data x-reveal="120">
                <x-section-heading eyebrow="Who we are" title="Where strategy meets execution" />
                <p class="mt-6 text-lg leading-relaxed text-ink/70">
                    We help corporations, NGOs and government institutions communicate with clarity, combining creativity, strategic intelligence and execution excellence.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <x-button :href="route('about')">More about us</x-button>
                    <x-button :contact="true" variant="outline">Start a project</x-button>
                </div>
            </div>
        </div>
    </section>

    {{-- 4. WHY PEPPERMINT: interactive tabs --}}
    <section class="bg-mist py-24 lg:py-32">
        <div class="container-x" x-data="{ active: 0 }">
            <div class="reveal" x-data x-reveal>
                <x-section-heading eyebrow="Why Peppermint" title="Five reasons clients stay with us" />
            </div>

            <div class="mt-14 grid gap-10 lg:grid-cols-12 lg:gap-16">
                <div class="lg:col-span-5" role="tablist" aria-label="Why Peppermint">
                    @foreach ($why as $i => $item)
                        <button type="button" role="tab" id="why-tab-{{ $i }}" aria-controls="why-panel-{{ $i }}"
                                @click="active = {{ $i }}" @mouseenter="active = {{ $i }}" @focus="active = {{ $i }}"
                                :aria-selected="(active === {{ $i }}).toString()"
                                class="group flex w-full items-center gap-5 border-b border-ink/10 py-5 text-left transition-colors duration-300"
                                :class="active === {{ $i }} ? 'text-ink' : 'text-ink/40 hover:text-ink/70'">
                            <span class="font-display text-sm font-bold transition-colors" :class="active === {{ $i }} ? 'text-forest' : ''">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="font-display text-xl font-bold sm:text-2xl">{{ $item['title'] }}</span>
                            <span aria-hidden="true" class="ml-auto transition duration-300" :class="active === {{ $i }} ? 'translate-x-0 opacity-100' : '-translate-x-2 opacity-0'">→</span>
                        </button>
                    @endforeach
                </div>

                <div class="lg:col-span-7">
                    <div class="relative min-h-[17rem] overflow-hidden rounded-3xl bg-ink p-8 text-white sm:p-12">
                        <img src="{{ asset('images/logo/leaf.png') }}" alt="" aria-hidden="true" class="pointer-events-none absolute -bottom-10 -right-6 w-60 rotate-12 opacity-10">
                        @foreach ($why as $i => $item)
                            <div x-show="active === {{ $i }}" x-cloak role="tabpanel" id="why-panel-{{ $i }}" aria-labelledby="why-tab-{{ $i }}"
                                 x-transition:enter="transition duration-500 ease-out" x-transition:enter-start="translate-y-3 opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
                                 class="relative">
                                <span class="font-display text-7xl font-extrabold text-leaf/90">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <h3 class="mt-4 text-2xl font-extrabold sm:text-3xl">{{ $item['title'] }}</h3>
                                <p class="mt-4 max-w-xl text-lg leading-relaxed text-white/75">{{ $item['text'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 5. FEATURED WORK: swipe / drag carousel --}}
    @if ($featured->isNotEmpty())
        <section class="bg-white py-24 lg:py-32" id="work">
            <div class="container-x" x-data>
                <div class="flex flex-col justify-between gap-8 lg:flex-row lg:items-end">
                    <div class="reveal" x-data x-reveal>
                        <x-section-heading eyebrow="Selected work" title="Proof, not promises"
                            intro="A sample of the conferences, campaigns and programmes we’ve delivered with government, development partners and private-sector brands." />
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" aria-label="Previous projects"
                                @click="$refs.track.scrollBy({ left: -$refs.track.clientWidth * 0.8, behavior: 'smooth' })"
                                class="grid size-12 place-items-center rounded-full border border-ink/20 text-lg transition hover:border-ink hover:bg-ink hover:text-white">←</button>
                        <button type="button" aria-label="Next projects"
                                @click="$refs.track.scrollBy({ left: $refs.track.clientWidth * 0.8, behavior: 'smooth' })"
                                class="grid size-12 place-items-center rounded-full border border-ink/20 text-lg transition hover:border-ink hover:bg-ink hover:text-white">→</button>
                        <x-button :href="route('work')" variant="outline" class="ml-2">View all work</x-button>
                    </div>
                </div>

                <div x-ref="track" x-drag-scroll
                     class="no-scrollbar -mx-5 mt-14 flex cursor-grab snap-x snap-mandatory gap-6 overflow-x-auto scroll-smooth px-5 pb-4 sm:-mx-8 sm:px-8 lg:-mx-12 lg:px-12">
                    @foreach ($featured as $i => $project)
                        <div class="w-[85%] shrink-0 snap-start sm:w-[46%] lg:w-[31%]">
                            <x-project-card :project="$project" :index="$i" />
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- 6. PROCESS --}}
    <section class="relative overflow-hidden bg-ink py-24 text-white lg:py-32" id="process">
        <img src="{{ asset('images/logo/leaf.png') }}" alt="" aria-hidden="true" loading="lazy"
             class="pointer-events-none absolute -bottom-20 -left-16 w-96 -rotate-12 opacity-[0.05]">
        <div class="container-x relative">
            <div class="reveal" x-data x-reveal>
                <x-section-heading theme="dark" eyebrow="Our approach" title="From insight to impact, in five steps"
                    intro="A disciplined process that keeps every campaign focused, measurable and improving." />
            </div>
            <x-process-steps :steps="$process" class="mt-16" />
        </div>
    </section>

    {{-- 7. GALLERY TEASER --}}
    @if ($teaser->count() >= 5)
        <section class="bg-white py-24 lg:py-32">
            <div class="container-x">
                <div class="flex flex-col justify-between gap-8 lg:flex-row lg:items-end">
                    <div class="reveal" x-data x-reveal>
                        <x-section-heading eyebrow="Gallery" title="Moments from the field" intro="Events, launches and the people behind them." />
                    </div>
                    <x-button :href="route('gallery')" variant="outline" class="self-start lg:self-auto">Open the gallery</x-button>
                </div>

                <div class="mt-14 grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-4 lg:grid-rows-2">
                    @foreach ($teaser as $i => $url)
                        <a href="{{ route('gallery') }}" wire:navigate aria-label="Open the gallery"
                           class="reveal group relative block overflow-hidden rounded-2xl bg-ink/10 {{ $i === 0 ? 'col-span-2 row-span-2 aspect-square lg:aspect-auto' : 'aspect-[4/3]' }}"
                           x-data x-reveal="{{ $i * 80 }}">
                            <img src="{{ $url }}" alt="" loading="lazy" class="size-full object-cover transition duration-700 group-hover:scale-105">
                            <span class="absolute inset-0 bg-ink/0 transition duration-500 group-hover:bg-ink/25"></span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- 8. FROM THE BLOG --}}
    @if ($posts->isNotEmpty())
        <section class="bg-mist py-24 lg:py-32">
            <div class="container-x">
                <div class="flex flex-col justify-between gap-8 lg:flex-row lg:items-end">
                    <div class="reveal" x-data x-reveal>
                        <x-section-heading eyebrow="Insights" title="Ideas worth sharing" intro="Practical thinking on events, PR and communication." />
                    </div>
                    <x-button :href="route('blog')" variant="outline" class="self-start lg:self-auto">All articles</x-button>
                </div>

                <div class="mt-14 grid gap-x-8 gap-y-14 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($posts as $i => $post)
                        <div class="reveal" x-data x-reveal="{{ $i * 100 }}">
                            <x-post-card :post="$post" />
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- 9. TESTIMONIALS (hidden until real testimonials are added in the admin) --}}
    @if ($testimonials->isNotEmpty())
        <section class="bg-white py-24 lg:py-32" id="testimonials">
            <div class="container-x">
                <div class="reveal" x-data x-reveal>
                    <x-section-heading eyebrow="Kind words" title="What our partners say" />
                </div>
                <div class="mt-14 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($testimonials as $i => $testimonial)
                        <div class="reveal" x-data x-reveal="{{ $i * 100 }}">
                            <x-testimonial-card :testimonial="$testimonial" class="border border-ink/10" />
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

</x-layouts.app>
