@props(['theme' => 'dark'])
{{--
    The wrapper holds the Alpine state. The mobile menu is a SIBLING of the header (not a child)
    because backdrop-blur on the header would otherwise break position:fixed for the menu.
--}}
<div
    x-data="{
        open: false,
        scrolled: window.scrollY > 24,
        get solid() { return this.scrolled || this.open || {{ $theme === 'light' ? 'true' : 'false' }}; }
    }"
    x-effect="document.documentElement.classList.toggle('overflow-hidden', open)"
    @scroll.window.passive="scrolled = window.scrollY > 24"
    @keydown.escape.window="open = false"
>
    <header
        :class="solid ? 'bg-white/90 text-ink shadow-sm backdrop-blur-md' : 'bg-transparent text-white'"
        class="fixed inset-x-0 top-0 z-50 transition-colors duration-300"
    >
        <div class="container-x flex items-center justify-between transition-all duration-300" :class="scrolled ? 'py-3' : 'py-5'">

            {{-- Logo: white version over the dark hero, black version once the header is solid --}}
            <a href="{{ route('home') }}" wire:navigate aria-label="{{ config('site.name') }} home" class="relative block">
                <img src="{{ asset('images/logo/logo-horizontal-white.png') }}" alt="{{ config('site.name') }}"
                     width="200" height="41" :class="{ 'hidden': solid }"
                     class="{{ $theme === 'light' ? 'hidden' : '' }} h-8 w-auto sm:h-9">
                <img src="{{ asset('images/logo/logo-horizontal.png') }}" alt="" aria-hidden="true"
                     width="200" height="41" :class="{ 'hidden': !solid }"
                     class="{{ $theme === 'light' ? '' : 'hidden' }} h-8 w-auto sm:h-9">
            </a>

            {{-- Desktop navigation --}}
            <nav class="hidden items-center gap-6 xl:gap-8 lg:flex" aria-label="Main">
                @foreach (config('site.nav') as $item)
                    <a href="{{ route($item['route']) }}" wire:navigate
                       @class([
                           'border-b-2 py-1 text-sm font-semibold tracking-wide transition-colors hover:border-leaf',
                           'border-leaf' => request()->routeIs($item['route'].'*'),
                           'border-transparent' => ! request()->routeIs($item['route'].'*'),
                       ])>
                        {{ $item['label'] }}
                    </a>
                @endforeach
                <x-button :contact="true" class="px-5! py-2.5!">Request a proposal</x-button>
            </nav>

            {{-- Mobile menu button --}}
            <button type="button" class="relative grid size-11 place-items-center lg:hidden"
                    @click="open = !open" :aria-expanded="open.toString()" aria-controls="mobile-menu" aria-label="Toggle menu">
                <span class="block h-0.5 w-6 bg-current transition-transform duration-300"
                      :class="open ? 'translate-y-[3px] rotate-45' : '-translate-y-[4px]'"></span>
                <span class="absolute block h-0.5 w-6 bg-current transition-transform duration-300"
                      :class="open ? 'translate-y-[3px] -rotate-45' : 'translate-y-[4px]'"></span>
            </button>
        </div>
    </header>

    {{-- Mobile menu (sits under the header, which stays visible on top) --}}
    <div id="mobile-menu" x-show="open" x-cloak
         x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition duration-150 ease-in" x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 overflow-y-auto bg-white pt-20 text-ink lg:hidden">
        <nav class="container-x flex flex-col gap-1 py-8" aria-label="Mobile">
            @foreach (config('site.nav') as $item)
                <a href="{{ route($item['route']) }}" wire:navigate
                   class="border-b border-ink/10 py-4 font-display text-2xl font-bold">
                    {{ $item['label'] }}
                </a>
            @endforeach
            <x-button :contact="true" class="mt-8 py-4! text-base">Request a proposal</x-button>

            <div class="mt-10 space-y-1 text-sm text-ink/70">
                <a href="tel:{{ config('site.phone_href') }}" class="block font-semibold text-ink">{{ config('site.phone') }}</a>
                <a href="mailto:{{ config('site.email') }}" class="block">{{ config('site.email') }}</a>
            </div>
        </nav>
    </div>
</div>
