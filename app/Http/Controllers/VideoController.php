<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Contracts\View\View;

class VideoController extends Controller
{
    /**
     * Display publicly available videos and webinars.
     */
    public function index(): View
    {
        $videos = Video::query()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->latest('id')
            ->get();

        return view('videos', ['videos' => $videos]);
    }
}
