@php
    $mapQuery = urlencode('Mituntu Building, Ring Road, Kileleshwa, Nairobi, Kenya');
@endphp
<x-layouts.app title="Contact"
    description="Contact Peppermint Africa in Nairobi to discuss your communications, PR, events, marketing or project management needs."
    headerTheme="dark">

    <x-page-hero eyebrow="Contact us" title="Let’s build something" accent="impactful."
        intro="Launching a brand, managing stakeholders or planning a high-level event? Tell us what you have in mind and we’ll get back to you." />

    <section class="bg-white py-20 lg:py-28">
        <div class="container-x grid gap-14 lg:grid-cols-12">

            {{-- Form --}}
            <div class="lg:col-span-7">
                <h2 class="mb-8 text-2xl font-extrabold tracking-tight sm:text-3xl">Request a proposal or ask a question</h2>
                <livewire:contact-form />
            </div>

            {{-- Details --}}
            <aside class="space-y-8 lg:col-span-5">
                <div class="rounded-2xl bg-ink p-8 text-white">
                    <h2 class="text-xs font-semibold uppercase tracking-[0.2em] text-leaf">Head office</h2>
                    <address class="mt-4 space-y-1 text-lg not-italic text-white/85">
                        @foreach (config('site.address') as $line)
                            <div>{{ $line }}</div>
                        @endforeach
                    </address>

                    <dl class="mt-8 space-y-5">
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-[0.2em] text-white/50">Phone</dt>
                            <dd class="mt-1"><a href="tel:{{ config('site.phone_href') }}" class="text-lg font-semibold transition-colors hover:text-leaf">{{ config('site.phone') }}</a></dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-[0.2em] text-white/50">Email</dt>
                            <dd class="mt-1"><a href="mailto:{{ config('site.email') }}" class="break-all text-lg font-semibold transition-colors hover:text-leaf">{{ config('site.email') }}</a></dd>
                        </div>
                    </dl>

                    <x-button :href="'https://wa.me/'.config('site.whatsapp').'?text='.rawurlencode(config('site.whatsapp_message'))"
                              :navigate="false" target="_blank" rel="noopener" class="mt-8">
                        Chat on WhatsApp
                    </x-button>
                </div>

                <div class="overflow-hidden rounded-2xl border border-ink/10">
                    <iframe title="Map showing the Peppermint Africa head office in Kileleshwa, Nairobi"
                            src="https://www.google.com/maps?q={{ $mapQuery }}&output=embed"
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                            class="block h-72 w-full border-0"></iframe>
                    <a href="https://www.google.com/maps/search/?api=1&query={{ $mapQuery }}" target="_blank" rel="noopener"
                       class="flex items-center justify-between bg-mist px-5 py-4 text-sm font-semibold transition hover:bg-ink hover:text-white">
                        Get directions <span aria-hidden="true">→</span>
                    </a>
                </div>
            </aside>
        </div>
    </section>
</x-layouts.app>
