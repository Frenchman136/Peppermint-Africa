{{--
    Cover image for a project. Shows the real photo when 'image' is set (public/images/...),
    otherwise a branded gradient placeholder with the leaf watermark.
--}}
@props(['project', 'index' => 0])
@php
    $gradients = [
        'bg-linear-to-br from-forest to-ink',
        'bg-linear-to-tr from-ink via-forest to-leaf/70',
        'bg-linear-to-br from-leaf/80 via-forest to-ink',
        'bg-linear-to-bl from-ink to-forest',
    ];
    $gradient = $gradients[$index % count($gradients)];
@endphp
<div {{ $attributes->class(['relative overflow-hidden rounded-2xl bg-ink']) }}>
    @if ($project->cover_url)
        <img src="{{ $project->cover_url }}" alt="{{ $project->title }}" loading="lazy"
             class="size-full object-cover transition duration-700 group-hover:scale-105">
    @else
        <div class="size-full {{ $gradient }} transition duration-700 group-hover:scale-105"></div>
        <img src="{{ asset('images/logo/leaf.png') }}" alt="" aria-hidden="true" loading="lazy"
             class="absolute -bottom-6 -right-4 w-40 rotate-12 opacity-20 transition duration-700 group-hover:rotate-[18deg] sm:w-52">
        <span class="absolute left-5 top-5 rounded-full bg-white/15 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-white backdrop-blur">
            {{ $project->category }}
        </span>
    @endif
</div>
