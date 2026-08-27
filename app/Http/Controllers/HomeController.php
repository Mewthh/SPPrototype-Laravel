<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\News;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the SPP home page.
     */
    public function index(Request $request): View
    {
        $news = News::query()
            ->where(function ($query) {
                $query->where('status', 'published')
                    ->orWhere(function ($q) {
                        $q->where('status', 'scheduled')
                            ->whereNotNull('published_at')
                            ->where('published_at', '<=', now());
                    });
            })
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->get();

        $activities = Activity::query()
            ->whereIn('status', ['published', 'scheduled'])
            ->orderBy('event_date', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('welcome', [
            'news' => $news,
            'activities' => $activities,
        ]);
    }
}
