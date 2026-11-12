@props(['eyebrow' => null, 'title', 'accent' => null, 'intro' => null])
{{-- Dark hero used at the top of every inner page. Pair with <x-layouts.app headerTheme="dark">. --}}
<section class="relative isolate overflow-hidden bg-ink text-white">
    <div class="pointer-events-none absolute -right-32 -top-40 -z-10 size-[36rem] rounded-full bg-leaf/20 blur-[120px]" aria-hidden="true"></div>
    <img src="{{ asset('images/logo/leaf.png') }}" alt="" aria-hidden="true"
         class="pointer-events-none absolute -right-8 top-1/4 -z-10 hidden w-80 rotate-12 opacity-[0.07] lg:block">

    <div class="container-x pb-16 pt-36 sm:pb-20 sm:pt-44 lg:pb-24 lg:pt-52">
        @if ($eyebrow)
            <p class="reveal inline-flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.25em] text-leaf" x-data x-reveal>
                <img src="{{ asset('images/logo/leaf.png') }}" alt="" aria-hidden="true" class="h-5 w-auto">{{ $eyebrow }}
            </p>
        @endif

        <h1 class="reveal mt-5 max-w-4xl text-balance text-4xl font-extrabold leading-[1.05] tracking-tight sm:text-5xl lg:text-7xl" x-data x-reveal="100">
            {{ $title }}
            @if ($accent)<span class="text-leaf">{{ $accent }}</span>@endif
        </h1>

        @if ($intro)
            <p class="reveal mt-7 max-w-2xl text-lg leading-relaxed text-white/75 sm:text-xl" x-data x-reveal="200">{{ $intro }}</p>
        @endif

        {{ $slot }}
    </div>
</section>
