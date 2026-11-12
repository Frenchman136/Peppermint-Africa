@php
    $shareUrl = urlencode($post->url);
    $shareText = urlencode($post->title);
@endphp
<x-layouts.app :title="$post->title"
    :description="\Illuminate\Support\Str::limit($post->summary, 155)"
    :image="$post->cover_url"
    headerTheme="dark">

    <x-page-hero :eyebrow="$post->category ?: 'Insights'" :title="$post->title">
        <p class="reveal mt-8 text-sm text-white/65" x-data x-reveal="200">
            {{ $post->author_name ?: config('site.name') }} · {{ $post->published_at?->format('j F Y') }} · {{ $post->reading_time }} min read
        </p>
    </x-page-hero>

    @if ($post->cover_url)
        <div class="container-x relative z-10 -mt-10 sm:-mt-14">
            <div class="mx-auto max-w-5xl overflow-hidden rounded-3xl shadow-2xl">
                <img src="{{ $post->cover_url }}" alt="" class="aspect-[16/8] w-full object-cover">
            </div>
        </div>
    @endif

    <article class="bg-white py-16 lg:py-24">
        <div class="container-x">
            <div class="mx-auto max-w-3xl">
                <div class="article">{!! $post->body_html !!}</div>

                {{-- Share --}}
                <div class="mt-14 border-t border-ink/10 pt-8" x-data="{ copied: false }">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-ink/50">Share this article</p>
                    <div class="mt-4 flex flex-wrap gap-3">
                        @php
                            $btn = 'grid size-11 place-items-center rounded-full border border-ink/15 text-ink/70 transition duration-200 hover:-translate-y-0.5 hover:border-ink hover:bg-ink hover:text-white';
                        @endphp
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" rel="noopener noreferrer" aria-label="Share on LinkedIn" class="{{ $btn }}">
                            <svg viewBox="0 0 24 24" class="size-[45%]" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                        <a href="https://x.com/intent/post?url={{ $shareUrl }}&text={{ $shareText }}" target="_blank" rel="noopener noreferrer" aria-label="Share on X" class="{{ $btn }}">
                            <svg viewBox="0 0 24 24" class="size-[40%]" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener noreferrer" aria-label="Share on Facebook" class="{{ $btn }}">
                            <svg viewBox="0 0 24 24" class="size-[45%]" fill="currentColor" aria-hidden="true"><path d="M13.5 22v-8.2h2.8l.5-3.4h-3.3V8.2c0-1 .4-1.7 1.8-1.7H17V3.4c-.3 0-1.3-.1-2.4-.1-2.5 0-4.1 1.5-4.1 4.2v2.9H7.7v3.4h2.8V22h3z"/></svg>
                        </a>
                        <a href="https://wa.me/?text={{ $shareText }}%20{{ $shareUrl }}" target="_blank" rel="noopener noreferrer" aria-label="Share on WhatsApp" class="{{ $btn }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-[48%]" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z"/></svg>
                        </a>
                        <button type="button" aria-label="Copy link" class="{{ $btn }}"
                                @click="navigator.clipboard.writeText('{{ $post->url }}').then(() => { copied = true; setTimeout(() => copied = false, 2000) })">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="size-[48%]" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244"/></svg>
                        </button>
                        <span x-show="copied" x-cloak x-transition.opacity class="self-center text-sm font-semibold text-forest" role="status">Link copied</span>
                    </div>
                </div>

                {{-- Call to action --}}
                <div class="mt-14 rounded-3xl bg-ink p-8 text-white sm:p-10">
                    <h2 class="text-2xl font-extrabold sm:text-3xl">Planning something similar?</h2>
                    <p class="mt-3 max-w-xl text-white/70">Tell us about your project and we’ll show you how we would approach it.</p>
                    <x-button :contact="true" class="mt-6">Request a proposal</x-button>
                </div>
            </div>
        </div>
    </article>

    @if ($related->isNotEmpty())
        <section class="bg-mist py-20 lg:py-28">
            <div class="container-x">
                <div class="flex items-end justify-between gap-6">
                    <x-section-heading eyebrow="Keep reading" title="More articles" />
                    <x-button :href="route('blog')" variant="outline" class="hidden shrink-0 sm:inline-flex">All articles</x-button>
                </div>
                <div class="mt-12 grid gap-x-8 gap-y-14 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($related as $item)
                        <x-post-card :post="$item" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.app>
