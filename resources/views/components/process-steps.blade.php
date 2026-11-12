@props(['steps' => []])
<ol {{ $attributes->class(['grid gap-10 sm:grid-cols-2 lg:grid-cols-5 lg:gap-6']) }}>
    @foreach ($steps as $i => $step)
        <li class="reveal relative border-t border-white/15 pt-8" x-data x-reveal="{{ $i * 110 }}">
            <span class="absolute -top-[5px] left-0 size-[9px] rounded-full bg-leaf" aria-hidden="true"></span>
            <span class="font-display text-sm font-bold tracking-widest text-leaf">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
            <h3 class="mt-3 text-2xl font-extrabold">{{ $step['title'] }}</h3>
            <p class="mt-3 leading-relaxed text-white/65">{{ $step['description'] }}</p>
        </li>
    @endforeach
</ol>
