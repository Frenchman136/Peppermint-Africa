{{-- Branded leaf preloader. Shown once per session (see resources/js/app.js). --}}
<div id="preloader" role="status" aria-live="polite" aria-label="Loading Peppermint Africa">
    <div class="flex flex-col items-center gap-8">
        <img src="{{ asset('images/logo/leaf.png') }}" alt="" width="72" height="100" class="preloader-leaf h-24 w-auto">
        <div class="preloader-bar h-[3px] w-40 overflow-hidden rounded-full bg-white/15"><span></span></div>
        <span class="sr-only">Loading…</span>
    </div>
</div>
