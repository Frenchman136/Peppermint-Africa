@php
    $uid = $this->getId();
    $isModal = $variant === 'modal';
    $showAll = ! $isModal || $showMore || $errors->hasAny(['phone', 'organisation']);

    $field = 'w-full rounded-xl border border-ink/15 bg-white px-4 py-3 text-base text-ink outline-none transition placeholder:text-ink/40 focus:border-leaf focus:ring-4 focus:ring-leaf/20';
    $label = 'mb-2 block text-sm font-semibold';
    $error = 'mt-1.5 text-sm font-medium text-red-600';
@endphp

<div>
    @if ($sent)
        <div class="flex flex-col items-start rounded-2xl bg-mist p-8 sm:p-10" role="status">
            <img src="{{ asset('images/logo/leaf.png') }}" alt="" aria-hidden="true" class="h-14 w-auto">
            <h3 class="mt-6 text-3xl font-extrabold tracking-tight">Thank you. We’ve got your message.</h3>
            <p class="mt-3 max-w-md text-lg leading-relaxed text-ink/70">
                Someone from the Peppermint team will be in touch soon. If it’s urgent, you can also reach us on WhatsApp or by phone.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <x-button :href="'https://wa.me/'.config('site.whatsapp')" :navigate="false" target="_blank" rel="noopener">WhatsApp us</x-button>
                @if ($isModal)
                    <button type="button" @click="$dispatch('close-contact')" class="rounded-full border border-ink/30 px-7 py-3.5 text-sm font-semibold transition hover:bg-ink hover:text-white">Close</button>
                @else
                    <button type="button" wire:click="sendAnother" class="rounded-full border border-ink/30 px-7 py-3.5 text-sm font-semibold transition hover:bg-ink hover:text-white">Send another message</button>
                @endif
            </div>
        </div>
    @else
        <form wire:submit="submit" novalidate class="space-y-5">

            @error('form')
                <p class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700" role="alert">{{ $message }}</p>
            @enderror

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="name-{{ $uid }}" class="{{ $label }}">Full name <span class="text-forest">*</span></label>
                    <input id="name-{{ $uid }}" type="text" wire:model="name" autocomplete="name" class="{{ $field }}" placeholder="Jane Wanjiku"
                           @error('name') aria-invalid="true" aria-describedby="name-error-{{ $uid }}" @enderror>
                    @error('name') <p id="name-error-{{ $uid }}" class="{{ $error }}">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email-{{ $uid }}" class="{{ $label }}">Email <span class="text-forest">*</span></label>
                    <input id="email-{{ $uid }}" type="email" wire:model="email" autocomplete="email" class="{{ $field }}" placeholder="you@organisation.com"
                           @error('email') aria-invalid="true" aria-describedby="email-error-{{ $uid }}" @enderror>
                    @error('email') <p id="email-error-{{ $uid }}" class="{{ $error }}">{{ $message }}</p> @enderror
                </div>
            </div>

            @if ($showAll)
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="phone-{{ $uid }}" class="{{ $label }}">Phone <span class="font-normal text-ink/50">(optional)</span></label>
                        <input id="phone-{{ $uid }}" type="tel" wire:model="phone" autocomplete="tel" class="{{ $field }}" placeholder="+254 700 000 000"
                               @error('phone') aria-invalid="true" aria-describedby="phone-error-{{ $uid }}" @enderror>
                        @error('phone') <p id="phone-error-{{ $uid }}" class="{{ $error }}">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="organisation-{{ $uid }}" class="{{ $label }}">Organisation <span class="font-normal text-ink/50">(optional)</span></label>
                        <input id="organisation-{{ $uid }}" type="text" wire:model="organisation" autocomplete="organization" class="{{ $field }}" placeholder="Company, NGO or institution">
                    </div>
                </div>
            @endif

            <div>
                <label for="service-{{ $uid }}" class="{{ $label }}">What do you need help with? <span class="font-normal text-ink/50">(optional)</span></label>
                <select id="service-{{ $uid }}" wire:model="service" class="{{ $field }}">
                    <option value="">Not sure yet</option>
                    @foreach ($services as $item)
                        <option value="{{ $item->title }}">{{ $item->title }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="message-{{ $uid }}" class="{{ $label }}">Tell us about your project <span class="text-forest">*</span></label>
                <textarea id="message-{{ $uid }}" rows="{{ $isModal ? 4 : 6 }}" wire:model="message" class="{{ $field }} resize-y"
                          placeholder="What are you planning, who is the audience and when do you need it?"
                          @error('message') aria-invalid="true" aria-describedby="message-error-{{ $uid }}" @enderror></textarea>
                @error('message') <p id="message-error-{{ $uid }}" class="{{ $error }}">{{ $message }}</p> @enderror
            </div>

            {{-- Honeypot: invisible to people. Leave empty. --}}
            <div class="absolute -left-[9999px] h-0 w-0 overflow-hidden" aria-hidden="true">
                <label for="website-{{ $uid }}">Website</label>
                <input id="website-{{ $uid }}" type="text" wire:model="website" tabindex="-1" autocomplete="off">
            </div>

            <div class="flex flex-wrap items-center gap-4 pt-1">
                <x-button type="submit" class="px-9! py-4! text-base" wire:loading.attr="disabled" wire:target="submit">
                    <span wire:loading.remove wire:target="submit">Send message</span>
                    <span wire:loading wire:target="submit" class="inline-flex items-center gap-2">
                        <svg class="size-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-opacity=".25" stroke-width="3"/>
                            <path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                        </svg>
                        Sending…
                    </span>
                </x-button>

                @if ($isModal && ! $showAll)
                    <button type="button" wire:click="toggleMore" class="text-sm font-semibold text-forest underline underline-offset-4 hover:text-ink">Add phone or organisation</button>
                @elseif ($isModal)
                    <button type="button" wire:click="toggleMore" class="text-sm font-semibold text-forest underline underline-offset-4 hover:text-ink">Hide extra details</button>
                @else
                    <p class="text-sm text-ink/55">We only use your details to reply to your inquiry.</p>
                @endif
            </div>
        </form>
    @endif
</div>
