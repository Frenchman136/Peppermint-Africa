<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Contracts\View\View;

class GalleryController extends Controller
{
    public function __invoke(): View
    {
        $albums = Album::published()->orderBy('sort_order')->orderByDesc('event_date')->get();

        return view('pages.gallery', ['albums' => $albums]);
    }
}
