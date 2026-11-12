<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Contracts\View\View;

class WorkController extends Controller
{
    public function index(): View
    {
        return view('pages.work');
    }

    public function show(Project $project): View
    {
        // Unpublished projects (e.g. political work you have not approved) must never be reachable by URL.
        abort_unless($project->is_published, 404);

        $project->load(['service', 'industry']);

        // Related work: same service first, then fill up with other published projects
        $related = Project::with('service')->published()
            ->where('id', '!=', $project->id)
            ->orderByRaw('CASE WHEN service_id = ? THEN 0 ELSE 1 END', [$project->service_id])
            ->orderBy('sort_order')
            ->take(3)
            ->get();

        return view('pages.work-show', ['project' => $project, 'related' => $related]);
    }
}
