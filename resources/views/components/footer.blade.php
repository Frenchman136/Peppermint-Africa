@props(['cta' => true])

@if ($cta)
    <section class="bg-leaf text-ink">
        <div class="container-x flex flex-col items-start justify-between gap-8 py-16 lg:flex-row lg:items-center lg:py-20">
            <div class="max-w-2xl">
                <h2 class="text-3xl font-extrabold leading-tight tracking-tight sm:text-4xl lg:text-5xl">Let’s Build Something Impactful</h2>
                <p class="mt-4 text-lg text-ink/80">
                    Launching a brand, managing stakeholder engagement, organising a high-level event or leading a
                    large-scale communication campaign? We’re ready to help you deliver measurable impact.
                </p>
            </div>
            <x-button :contact="true" variant="dark" class="shrink-0 px-9! py-4! text-base">Request a proposal</x-button>
        </div>
    </section>
@endif

<footer class="bg-ink text-white">
    <div class="container-x grid gap-12 py-16 md:grid-cols-2 lg:grid-cols-12">

        <div class="lg:col-span-4">
            <a href="{{ route('home') }}" wire:navigate aria-label="{{ config('site.name') }} home">
                <img src="{{ asset('images/logo/logo-horizontal-white.png') }}" alt="{{ config('site.name') }}" width="220" height="45" loading="lazy" class="h-10 w-auto">
            </a>
            <p class="mt-6 max-w-xs leading-relaxed text-white/70">
                A modern African communications agency helping brands, institutions and development partners build influence across global markets.
            </p>
        </div>

        <div class="lg:col-span-2">
            <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-leaf">Explore</h3>
            <ul class="mt-5 space-y-3 text-white/80">
                @foreach (config('site.nav') as $item)
                    <li><a href="{{ route($item['route']) }}" wire:navigate class="transition-colors hover:text-leaf">{{ $item['label'] }}</a></li>
                @endforeach
                <li><a href="{{ route('contact') }}" wire:navigate class="transition-colors hover:text-leaf">Contact</a></li>
            </ul>
        </div>

        <div class="lg:col-span-3">
            <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-leaf">Services</h3>
            <ul class="mt-5 space-y-3 text-white/80">
                @foreach (\App\Models\Service::orderBy('sort_order')->get() as $service)
                    <li>
                        <a href="{{ route('services') }}#{{ $service->slug }}" wire:navigate class="transition-colors hover:text-leaf">{{ $service->title }}</a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="lg:col-span-3">
            <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-leaf">Head Office</h3>
            <address class="mt-5 space-y-1 text-white/80 not-italic">
                @foreach (config('site.address') as $line)
                    <div>{{ $line }}</div>
                @endforeach
            </address>
            <div class="mt-5 space-y-2 text-white/80">
                <a href="tel:{{ config('site.phone_href') }}" class="block transition-colors hover:text-leaf">{{ config('site.phone') }}</a>
                <a href="mailto:{{ config('site.email') }}" class="block break-all transition-colors hover:text-leaf">{{ config('site.email') }}</a>
            </div>

            <x-social-links class="mt-6" />
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="container-x flex flex-col items-start justify-between gap-2 py-6 text-sm text-white/50 sm:flex-row sm:items-center">
            <p>© {{ date('Y') }} {{ config('site.name') }}. All rights reserved.</p>
            <p>Communications · PR · Events · Marketing · Project Management</p>
        </div>
    </div>
</footer>
