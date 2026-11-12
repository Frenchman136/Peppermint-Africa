<?php

namespace App\Livewire;

use App\Models\Industry;
use App\Models\Project;
use App\Models\Service;
use Livewire\Attributes\Url;
use Livewire\Component;

class ProjectFilter extends Component
{
    // Kept in the URL (?service=events&industry=hospitality-tourism) so filtered views can be shared.
    #[Url(as: 'service', except: '')]
    public string $service = '';

    #[Url(as: 'industry', except: '')]
    public string $industry = '';

    public function setService(string $slug): void
    {
        $this->service = $slug;
    }

    public function resetFilters(): void
    {
        $this->reset(['service', 'industry']);
    }

    public function render()
    {
        $projects = Project::with(['service', 'industry'])
            ->published()
            ->when($this->service, fn ($q) => $q->whereHas('service', fn ($s) => $s->where('slug', $this->service)))
            ->when($this->industry, fn ($q) => $q->whereHas('industry', fn ($i) => $i->where('slug', $this->industry)))
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        // Only offer filters that actually contain published work
        $services = Service::whereHas('projects', fn ($q) => $q->published())->orderBy('sort_order')->get();
        $industries = Industry::whereHas('projects', fn ($q) => $q->published())->orderBy('sort_order')->get();

        return view('livewire.project-filter', compact('projects', 'services', 'industries'));
    }
}
