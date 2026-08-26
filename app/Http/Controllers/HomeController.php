<?php

namespace App\Http\Controllers;

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

        return view('welcome', [
            'news' => $news,
        ]);
    }
}
