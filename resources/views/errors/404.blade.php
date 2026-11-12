<x-layouts.app title="Page not found" headerTheme="light">
    <section class="bg-mist">
        <div class="container-x flex min-h-[75vh] flex-col items-start justify-center pb-24 pt-40">
            <img src="{{ asset('images/logo/leaf.png') }}" alt="" aria-hidden="true" class="h-16 w-auto">
            <p class="mt-8 font-display text-8xl font-extrabold leading-none text-leaf sm:text-9xl">404</p>
            <h1 class="mt-6 text-3xl font-extrabold tracking-tight sm:text-5xl">This page has wandered off.</h1>
            <p class="mt-4 max-w-xl text-lg leading-relaxed text-ink/70">
                The page you’re looking for doesn’t exist or has moved. Let’s get you back on track.
            </p>
            <div class="mt-10 flex flex-wrap gap-4">
                <x-button :href="route('home')" variant="dark">Back to home</x-button>
                <x-button :href="route('work')" variant="outline">See our work</x-button>
                <x-button :href="route('contact')" variant="outline">Contact us</x-button>
            </div>
        </div>
    </section>
</x-layouts.app>
