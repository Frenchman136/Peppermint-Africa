{{--
    Contact pop-up. Any element with data-contact (see <x-button :contact="true">) opens it.
    Alpine owns open/close; the Livewire form inside handles validation, saving and email.
--}}
<div
    x-data="{ open: false }"
    x-effect="document.documentElement.classList.toggle('overflow-hidden', open)"
    @open-contact.window="
        open = true;
        window.Livewire && Livewire.dispatch('prefill-service', { slug: $event.detail.service || '' });
        $nextTick(() => $refs.panel && $refs.panel.focus());
    "
    @close-contact.window="open = false"
    @keydown.escape.window="open = false"
>
    <div x-show="open" x-cloak class="fixed inset-0 z-[95] flex items-end justify-center sm:items-center sm:p-6"
         role="dialog" aria-modal="true" aria-labelledby="contact-modal-title">

        <div x-show="open" x-transition.opacity.duration.250ms @click="open = false" class="absolute inset-0 bg-ink/70 backdrop-blur-sm"></div>

        <div x-show="open" x-ref="panel" tabindex="-1"
             x-transition:enter="transition duration-300 ease-out" x-transition:enter-start="translate-y-8 opacity-0 sm:scale-95"
             x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
             x-transition:leave="transition duration-200 ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="translate-y-4 opacity-0"
             class="relative max-h-[92vh] w-full max-w-2xl overflow-y-auto rounded-t-3xl bg-white p-6 shadow-2xl outline-none sm:rounded-3xl sm:p-10">

            <button type="button" @click="open = false" aria-label="Close"
                    class="absolute right-4 top-4 grid size-10 place-items-center rounded-full text-2xl leading-none text-ink/60 transition hover:bg-ink hover:text-white">×</button>

            <h2 id="contact-modal-title" class="pr-10 text-2xl font-extrabold tracking-tight sm:text-3xl">Let’s talk about your project</h2>
            <p class="mt-2 mb-8 text-ink/65">Tell us a little and we’ll get back to you.</p>

            <livewire:contact-form variant="modal" />
        </div>
    </div>
</div>
