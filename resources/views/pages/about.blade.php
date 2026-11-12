@php
    $services = \App\Models\Service::orderBy('sort_order')->get();
    $industries = \App\Models\Industry::with(['projects' => fn ($q) => $q->published()->orderBy('sort_order')])
        ->orderBy('sort_order')
        ->get();
@endphp
<x-layouts.app title="About us"
    description="Peppermint Africa is a Nairobi-based strategic communications and integrated marketing agency, established in 2010, delivering high-impact campaigns and PR solutions across Africa."
    headerTheme="dark">

    <x-page-hero eyebrow="About Peppermint Africa" title="Communication with" accent="purpose."
        intro="A modern African communications agency helping brands, institutions and development partners build influence across global markets." />

    {{-- Story + numbers --}}
    <section class="bg-white py-24 lg:py-32">
        <div class="container-x grid gap-16 lg:grid-cols-12 lg:items-center">
            <div class="reveal lg:col-span-7" x-data x-reveal>
                <x-section-heading eyebrow="Our story" title="Built in Nairobi. Delivering across Africa." />
                <div class="mt-6 space-y-5 text-lg leading-relaxed text-ink/70">
                    <p>
                        Established in {{ config('site.established') }} and headquartered in Nairobi, Kenya, Peppermint Africa is a strategic communications and
                        integrated marketing agency. We combine creativity, strategic intelligence and execution excellence to help corporations, NGOs and
                        government institutions communicate with clarity.
                    </p>
                    <p>
                        We understand African markets and deliver work aligned with international standards. Across ten sectors, we adapt our approach so
                        that every strategy is culturally relevant and globally competitive.
                    </p>
                    <p>
                        And we work as an extension of our clients’ teams: from research and strategy through to delivery, measurement and improvement.
                    </p>
                </div>
            </div>

            <dl class="grid grid-cols-2 gap-px overflow-hidden rounded-2xl bg-ink/10 lg:col-span-5">
                @foreach (config('site.stats') as $stat)
                    <div class="bg-mist p-7">
                        <dd class="font-display text-4xl font-extrabold sm:text-5xl"><span x-data x-counter="{{ $stat['value'] }}" data-suffix="{{ $stat['suffix'] }}">{{ $stat['value'] }}{{ $stat['suffix'] }}</span></dd>
                        <dt class="mt-2 text-sm leading-snug text-ink/60">{{ $stat['label'] }}</dt>
                    </div>
                @endforeach
            </dl>
        </div>
    </section>

    {{-- Mission --}}
    <section class="bg-leaf text-ink">
        <div class="container-x py-20 lg:py-28">
            <p class="text-xs font-semibold uppercase tracking-[0.25em]">Our vision &amp; mission</p>
            <p class="reveal mt-6 max-w-5xl font-display text-2xl font-bold leading-snug sm:text-3xl lg:text-5xl lg:leading-tight" x-data x-reveal>
                {{ config('content.mission') }}
            </p>
        </div>
    </section>

    {{-- WHAT WE DO: interactive services --}}
    @if ($services->isNotEmpty())
        <section class="bg-white py-24 lg:py-32" id="what-we-do">
            <div class="container-x" x-data="{ active: 0 }">
                <div class="reveal" x-data x-reveal>
                    <x-section-heading eyebrow="What we do" title="Six services. One integrated team."
                        intro="Choose a service to see what it covers. Use one or all six, everything is planned and delivered together." />
                </div>

                <div class="mt-14 grid gap-10 lg:grid-cols-12 lg:gap-16">
                    <div class="lg:col-span-5" role="tablist" aria-label="Our services">
                        @foreach ($services as $i => $service)
                            <button type="button" role="tab" id="svc-tab-{{ $i }}" aria-controls="svc-panel-{{ $i }}"
                                    @click="active = {{ $i }}" @mouseenter="active = {{ $i }}" @focus="active = {{ $i }}"
                                    :aria-selected="(active === {{ $i }}).toString()"
                                    class="flex w-full items-center gap-5 border-b border-ink/10 py-5 text-left transition-colors duration-300"
                                    :class="active === {{ $i }} ? 'text-ink' : 'text-ink/40 hover:text-ink/70'">
                                <span class="font-display text-sm font-bold transition-colors" :class="active === {{ $i }} ? 'text-forest' : ''">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <span class="font-display text-lg font-bold leading-snug sm:text-xl">{{ $service->title }}</span>
                                <span aria-hidden="true" class="ml-auto transition duration-300" :class="active === {{ $i }} ? 'translate-x-0 opacity-100' : '-translate-x-2 opacity-0'">→</span>
                            </button>
                        @endforeach
                    </div>

                    <div class="lg:col-span-7">
                        <div class="rounded-3xl bg-mist p-8 sm:p-12">
                            @foreach ($services as $i => $service)
                                <div x-show="active === {{ $i }}" x-cloak role="tabpanel" id="svc-panel-{{ $i }}" aria-labelledby="svc-tab-{{ $i }}"
                                     x-transition:enter="transition duration-500 ease-out" x-transition:enter-start="translate-y-3 opacity-0" x-transition:enter-end="translate-y-0 opacity-100">
                                    <h3 class="text-2xl font-extrabold leading-snug sm:text-3xl">{{ $service->title }}</h3>
                                    <p class="mt-4 text-lg leading-relaxed text-ink/70">{{ $service->description }}</p>

                                    @if (! empty($service->includes))
                                        <ul class="mt-6 grid gap-x-8 gap-y-3 sm:grid-cols-2">
                                            @foreach ($service->includes as $item)
                                                <li class="flex items-start gap-3">
                                                    <img src="{{ asset('images/logo/leaf.png') }}" alt="" aria-hidden="true" loading="lazy" class="mt-1 h-5 w-auto shrink-0">
                                                    <span class="font-medium">{{ $item }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    <div class="mt-8 flex flex-wrap gap-3">
                                        <x-button :contact="true" :service="$service->slug">Discuss this service</x-button>
                                        <x-button :href="route('services').'#'.$service->slug" variant="outline">Full details</x-button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- INDUSTRIES: sector explorer --}}
    @if ($industries->isNotEmpty())
        <section class="bg-ink py-24 text-white lg:py-32" id="industries">
            <div class="container-x" x-data="{ active: 0 }">
                <div class="reveal" x-data x-reveal>
                    <x-section-heading theme="dark" eyebrow="Industries we serve" title="One agency. Every sector we work in."
                        intro="Our ability to adapt lets us build communication that is both culturally relevant and globally competitive." />
                </div>

                <div class="mt-14 grid gap-10 lg:grid-cols-12 lg:gap-16">
                    <div class="lg:col-span-7" role="tablist" aria-label="Industries">
                        @foreach ($industries as $i => $industry)
                            <button type="button" role="tab" id="ind-tab-{{ $i }}" aria-controls="ind-panel-{{ $i }}"
                                    @click="active = {{ $i }}" @mouseenter="active = {{ $i }}" @focus="active = {{ $i }}"
                                    :aria-selected="(active === {{ $i }}).toString()"
                                    class="flex w-full items-baseline gap-5 border-b border-white/10 py-4 text-left transition-colors duration-300"
                                    :class="active === {{ $i }} ? 'text-white' : 'text-white/35 hover:text-white/70'">
                                <span class="font-display text-xs font-bold tracking-widest" :class="active === {{ $i }} ? 'text-leaf' : ''">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <span class="font-display text-2xl font-extrabold leading-tight sm:text-3xl">{{ $industry->name }}</span>
                                <span aria-hidden="true" class="ml-auto self-center text-leaf transition duration-300" :class="active === {{ $i }} ? 'translate-x-0 opacity-100' : '-translate-x-2 opacity-0'">→</span>
                            </button>
                        @endforeach
                    </div>

                    <div class="lg:col-span-5">
                        <div class="rounded-3xl bg-white/[0.06] p-8 ring-1 ring-white/10 lg:sticky lg:top-28">
                            @foreach ($industries as $i => $industry)
                                <div x-show="active === {{ $i }}" x-cloak role="tabpanel" id="ind-panel-{{ $i }}" aria-labelledby="ind-tab-{{ $i }}"
                                     x-transition:enter="transition duration-500 ease-out" x-transition:enter-start="translate-y-3 opacity-0" x-transition:enter-end="translate-y-0 opacity-100">
                                    <h3 class="text-xl font-extrabold">{{ $industry->name }}</h3>

                                    @if ($industry->projects->isNotEmpty())
                                        <p class="mt-5 text-xs font-semibold uppercase tracking-[0.18em] text-leaf">Work in this sector</p>
                                        <ul class="mt-4 space-y-3">
                                            @foreach ($industry->projects as $project)
                                                <li>
                                                    <a href="{{ $project->url }}" wire:navigate class="group flex items-center gap-4 rounded-xl p-2 transition hover:bg-white/10">
                                                        <span class="block size-16 shrink-0 overflow-hidden rounded-lg bg-white/10">
                                                            @if ($project->cover_url)
                                                                <img src="{{ $project->cover_url }}" alt="" loading="lazy" class="size-full object-cover transition duration-500 group-hover:scale-110">
                                                            @else
                                                                <span class="grid size-full place-items-center bg-linear-to-br from-forest to-ink"><img src="{{ asset('images/logo/leaf.png') }}" alt="" class="h-8 w-auto opacity-70"></span>
                                                            @endif
                                                        </span>
                                                        <span class="font-semibold leading-snug">{{ $project->title }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="mt-4 leading-relaxed text-white/70">
                                            Tell us about your communication goals and we’ll shape a strategy that fits your audience and sector.
                                        </p>
                                        <x-button :contact="true" class="mt-6">Start a conversation</x-button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Values --}}
    <section class="bg-white py-24 lg:py-32">
        <div class="container-x">
            <div class="reveal" x-data x-reveal>
                <x-section-heading eyebrow="What we stand for" title="Five values behind every project" />
            </div>

            <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach (config('content.values') as $i => $value)
                    <div class="reveal rounded-2xl border border-ink/10 p-8 transition duration-300 hover:-translate-y-1 hover:border-leaf hover:shadow-lg" x-data x-reveal="{{ ($i % 3) * 100 }}">
                        <span class="font-display text-5xl font-extrabold text-leaf/40">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <h3 class="mt-5 text-xl font-bold">{{ $value['title'] }}</h3>
                        <p class="mt-3 leading-relaxed text-ink/70">{{ $value['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Process --}}
    <section class="bg-mist py-24 lg:py-32">
        <div class="container-x">
            <div class="reveal" x-data x-reveal>
                <x-section-heading eyebrow="How we work" title="From insight to impact, in five steps"
                    intro="Every engagement follows the same disciplined path, so the work stays focused, measurable and improving." />
            </div>
            <x-process-steps :steps="config('content.process')" class="mt-16 text-ink [&_p]:text-ink/65 [&_li]:border-ink/15" />
        </div>
    </section>
</x-layouts.app>
