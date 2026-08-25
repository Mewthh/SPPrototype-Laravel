<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display the news page.
     */
    public function index(Request $request): View
    {
        return view('news');
    }

    /**
     * Handle legacy URL parameters from static prototype (e.g. /news.html?slug=foo).
     */
    public function legacyRedirect(Request $request): View|RedirectResponse
    {
        if ($slug = $request->input('slug')) {
            return redirect()->route('news.index', ['slug' => $slug]);
        }

        return redirect()->route('news.index');
    }
}
