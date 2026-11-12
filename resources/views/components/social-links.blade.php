@props(['size' => 'size-11', 'theme' => 'dark'])
@php
    // Platform home pages are used until the real profile URLs are set in .env (SOCIAL_LINKEDIN etc.)
    $fallbacks = [
        'LinkedIn' => 'https://www.linkedin.com/',
        'Instagram' => 'https://www.instagram.com/',
        'Facebook' => 'https://www.facebook.com/',
        'X' => 'https://x.com/',
    ];
    $tone = $theme === 'dark'
        ? 'border-white/20 text-white/80 hover:border-leaf hover:bg-leaf hover:text-ink'
        : 'border-ink/15 text-ink/70 hover:border-ink hover:bg-ink hover:text-white';
@endphp
<ul {{ $attributes->class(['flex flex-wrap gap-3']) }}>
    @foreach (config('site.social') as $label => $url)
        <li>
            <a href="{{ $url ?: ($fallbacks[$label] ?? '#') }}" target="_blank" rel="noopener noreferrer" aria-label="{{ config('site.name') }} on {{ $label }}"
               class="grid {{ $size }} place-items-center rounded-full border transition duration-200 hover:-translate-y-0.5 {{ $tone }}">
                @switch($label)
                    @case('LinkedIn')
                        <svg viewBox="0 0 24 24" class="size-[45%]" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        @break
                    @case('Instagram')
                        <svg viewBox="0 0 24 24" class="size-[45%]" aria-hidden="true"><g fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4.2"/></g><circle cx="17.4" cy="6.6" r="1.2" fill="currentColor"/></svg>
                        @break
                    @case('Facebook')
                        <svg viewBox="0 0 24 24" class="size-[45%]" fill="currentColor" aria-hidden="true"><path d="M13.5 22v-8.2h2.8l.5-3.4h-3.3V8.2c0-1 .4-1.7 1.8-1.7H17V3.4c-.3 0-1.3-.1-2.4-.1-2.5 0-4.1 1.5-4.1 4.2v2.9H7.7v3.4h2.8V22h3z"/></svg>
                        @break
                    @case('X')
                        <svg viewBox="0 0 24 24" class="size-[40%]" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        @break
                @endswitch
            </a>
        </li>
    @endforeach
</ul>
