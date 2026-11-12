@php $services = \App\Models\Service::orderBy('sort_order')->get(); @endphp
<x-layouts.app title="Services"
    description="Public relations, event management, brand strategy, project management, digital marketing and strategic communications: integrated services from Peppermint Africa in Nairobi."
    headerTheme="dark">

    <x-page-hero eyebrow="Our services" title="Six services." accent="One integrated team."
        intro="Use one service or all six. Everything is planned and delivered together, so your message stays consistent from strategy to execution.">
        <nav class="reveal mt-10 flex flex-wrap gap-2" aria-label="Jump to a service" x-data x-reveal="300">
            @foreach ($services as $service)
                <a href="#{{ $service->slug }}" class="rounded-full border border-white/25 px-4 py-2 text-sm font-semibold text-white/85 transition hover:border-leaf hover:bg-leaf hover:text-ink">
                    {{ $service->title }}
                </a>
            @endforeach
        </nav>
    </x-page-hero>

    @foreach ($services as $i => $service)
        <section id="{{ $service->slug }}" class="{{ $i % 2 === 0 ? 'bg-white' : 'bg-mist' }} py-20 lg:py-28">
            <div class="container-x grid gap-12 lg:grid-cols-12">
                <div class="reveal lg:col-span-6" x-data x-reveal>
                    <span class="font-display text-6xl font-extrabold text-leaf/50 sm:text-7xl">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <h2 class="mt-4 text-3xl font-extrabold leading-tight tracking-tight sm:text-4xl">{{ $service->title }}</h2>
                    <p class="mt-5 text-lg leading-relaxed text-ink/70">{{ $service->description }}</p>
                    <x-button :contact="true" :service="$service->slug" class="mt-8">Discuss this service</x-button>
                </div>

                <div class="reveal lg:col-span-5 lg:col-start-8" x-data x-reveal="120">
                    <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-forest">What’s included</h3>
                    <ul class="mt-5 divide-y divide-ink/10 border-y border-ink/10">
                        @foreach ($service->includes ?? [] as $item)
                            <li class="flex items-center gap-4 py-4 text-lg font-medium">
                                <img src="{{ asset('images/logo/leaf.png') }}" alt="" aria-hidden="true" loading="lazy" class="h-6 w-auto shrink-0">
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>
    @endforeach

    {{-- Process --}}
    <section class="bg-ink py-24 text-white lg:py-28">
        <div class="container-x">
            <div class="reveal" x-data x-reveal>
                <x-section-heading theme="dark" eyebrow="How every service is delivered" title="Discover. Design. Deliver. Measure. Evolve." />
            </div>
            <x-process-steps :steps="config('content.process')" class="mt-14" />
        </div>
    </section>
</x-layouts.app>
