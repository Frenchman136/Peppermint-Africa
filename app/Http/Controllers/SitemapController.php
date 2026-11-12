<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Project;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $pages = [
            ['loc' => route('home'), 'priority' => '1.0'],
            ['loc' => route('about'), 'priority' => '0.8'],
            ['loc' => route('services'), 'priority' => '0.9'],
            ['loc' => route('gallery'), 'priority' => '0.7'],
            ['loc' => route('blog'), 'priority' => '0.8'],
            ['loc' => route('work'), 'priority' => '0.9'],
            ['loc' => route('contact'), 'priority' => '0.8'],
        ];

        $projects = Project::published()
            ->orderBy('sort_order')
            ->get(['slug', 'updated_at'])
            ->map(fn (Project $p) => [
                'loc' => route('work.show', $p->slug),
                'lastmod' => $p->updated_at?->toAtomString(),
                'priority' => '0.6',
            ]);

        $posts = Post::published()
            ->orderByDesc('published_at')
            ->get(['slug', 'updated_at'])
            ->map(fn (Post $p) => [
                'loc' => route('blog.show', $p->slug),
                'lastmod' => $p->updated_at?->toAtomString(),
                'priority' => '0.6',
            ]);

        return response()
            ->view('sitemap', ['urls' => collect($pages)->concat($projects)->concat($posts)])
            ->header('Content-Type', 'application/xml');
    }
}
