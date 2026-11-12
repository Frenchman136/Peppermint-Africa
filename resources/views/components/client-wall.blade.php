@props(['clients' => [], 'label' => 'Organisations we’ve worked with'])
{{--
    Few clients: a tidy row of tiles. Eight or more: a slow scrolling strip that pauses on hover.
    Logos are shown in greyscale and come to life on hover; clients without a logo show their name.
--}}
@if (count($clients))
    <section class="bg-white py-16 lg:py-20" aria-label="{{ $label }}">
        <div class="container-x">
            <p class="reveal text-center text-xs font-semibold uppercase tracking-[0.2em] text-ink/50" x-data x-reveal>{{ $label }}</p>

            @if (count($clients) >= 8)
                <div class="marquee relative mt-10 overflow-hidden [mask-image:linear-gradient(to_right,transparent,black_8%,black_92%,transparent)]">
                    <div class="marquee-track flex w-max">
                        @foreach ([false, true] as $isCopy)
                            <ul class="flex shrink-0 items-center" @if ($isCopy) aria-hidden="true" @endif>
                                @foreach ($clients as $client)
                                    <li class="flex items-center whitespace-nowrap pr-14">
                                        @if ($client->logo_url)
                                            <img src="{{ $client->logo_url }}" alt="{{ $isCopy ? '' : $client->name }}" loading="lazy"
                                                 class="h-10 w-auto max-w-[9rem] object-contain opacity-70 grayscale transition hover:opacity-100 hover:grayscale-0">
                                        @else
                                            <span class="font-display text-lg font-bold text-ink/70">{{ $client->name }}</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                </div>
            @else
                <ul class="mt-10 flex flex-wrap justify-center gap-4">
                    @foreach ($clients as $i => $client)
                        <li class="reveal" x-data x-reveal="{{ $i * 70 }}">
                            <div class="group flex h-24 w-44 items-center justify-center rounded-2xl border border-ink/10 bg-white px-5 transition duration-300 hover:-translate-y-1 hover:border-leaf hover:shadow-lg sm:w-52">
                                @if ($client->logo_url)
                                    <img src="{{ $client->logo_url }}" alt="{{ $client->name }}" loading="lazy"
                                         class="max-h-12 w-auto max-w-full object-contain opacity-70 grayscale transition duration-300 group-hover:opacity-100 group-hover:grayscale-0">
                                @else
                                    <span class="text-center font-display text-base font-bold leading-snug text-ink/60 transition-colors group-hover:text-ink">{{ $client->name }}</span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </section>
@endif
