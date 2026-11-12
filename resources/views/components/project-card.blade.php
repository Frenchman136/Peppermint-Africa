@props(['project', 'index' => 0])
<a href="{{ $project->url }}" wire:navigate {{ $attributes->class(['group block']) }}>
    <x-project-cover :project="$project" :index="$index" class="h-64 sm:h-80" />
    <div class="mt-5">
        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-forest">{{ $project->category }}</p>
        <h3 class="mt-2 text-xl font-bold leading-snug transition-colors group-hover:text-forest">{{ $project->title }}</h3>
        @if ($project->client)
            <p class="mt-1 text-sm font-medium text-ink/60">{{ $project->client }}</p>
        @endif
        <p class="mt-3 leading-relaxed text-ink/70">{{ $project->summary }}</p>
    </div>
</a>
