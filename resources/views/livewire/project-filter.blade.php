@php
    $pill = 'rounded-full border px-5 py-2.5 text-sm font-semibold transition duration-200';
    $pillOff = 'border-ink/15 hover:border-ink hover:bg-ink hover:text-white';
    $pillOn = 'border-ink bg-ink text-white';
@endphp

<div>
    {{-- Filters --}}
    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
        <div class="flex flex-wrap gap-2" role="group" aria-label="Filter by service">
            <button type="button" wire:click="setService('')" class="{{ $pill }} {{ $service === '' ? $pillOn : $pillOff }}" @if ($service === '') aria-pressed="true" @endif>
                All work
            </button>
            @foreach ($services as $item)
                <button type="button" wire:click="setService('{{ $item->slug }}')" wire:key="svc-{{ $item->id }}"
                        class="{{ $pill }} {{ $service === $item->slug ? $pillOn : $pillOff }}" @if ($service === $item->slug) aria-pressed="true" @endif>
                    {{ $item->title }}
                </button>
            @endforeach
        </div>

        @if ($industries->count() > 1)
            <div class="shrink-0">
                <label for="industry" class="sr-only">Filter by sector</label>
                <select id="industry" wire:model.live="industry"
                        class="w-full rounded-full border border-ink/15 bg-white px-5 py-2.5 text-sm font-semibold outline-none transition focus:border-leaf focus:ring-4 focus:ring-leaf/20 lg:w-64">
                    <option value="">All sectors</option>
                    @foreach ($industries as $item)
                        <option value="{{ $item->slug }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif
    </div>

    <p class="mt-8 text-sm text-ink/60" aria-live="polite">
        Showing {{ $projects->count() }} {{ \Illuminate\Support\Str::plural('project', $projects->count()) }}
        @if ($service !== '' || $industry !== '')
            · <button type="button" wire:click="resetFilters" class="font-semibold text-forest underline underline-offset-4 hover:text-ink">Clear filters</button>
        @endif
    </p>

    {{-- Skeleton shown while results refresh --}}
    <div wire:loading.delay.shortest wire:target="setService,industry,resetFilters" class="mt-8 grid gap-x-8 gap-y-14 sm:grid-cols-2 lg:grid-cols-3" aria-hidden="true">
        @foreach (range(1, 3) as $n)
            <div class="animate-pulse">
                <div class="h-64 rounded-2xl bg-ink/10 sm:h-80"></div>
                <div class="mt-5 h-3 w-24 rounded bg-ink/10"></div>
                <div class="mt-3 h-5 w-3/4 rounded bg-ink/10"></div>
                <div class="mt-3 h-4 w-full rounded bg-ink/10"></div>
            </div>
        @endforeach
    </div>

    {{-- Results --}}
    <div wire:loading.remove wire:target="setService,industry,resetFilters">
        @if ($projects->isEmpty())
            <div class="mt-8 rounded-2xl bg-mist p-10 text-center">
                <img src="{{ asset('images/logo/leaf.png') }}" alt="" aria-hidden="true" class="mx-auto h-12 w-auto opacity-70">
                <h2 class="mt-5 text-2xl font-extrabold">Nothing matches those filters</h2>
                <p class="mt-2 text-ink/65">Try a different service or sector, or see everything we’ve done.</p>
                <button type="button" wire:click="resetFilters" class="mt-6 rounded-full bg-ink px-7 py-3.5 text-sm font-semibold text-white transition hover:bg-forest">Show all work</button>
            </div>
        @else
            <div class="mt-8 grid gap-x-8 gap-y-14 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($projects as $i => $project)
                    <x-project-card :project="$project" :index="$i" wire:key="project-{{ $project->id }}" />
                @endforeach
            </div>
        @endif
    </div>
</div>
