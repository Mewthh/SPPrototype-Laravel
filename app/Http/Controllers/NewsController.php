<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display the news article detail page by query parameter or route.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $slug = $request->query('slug');
        $id = $request->query('id');

        if (! $slug && ! $id) {
            return redirect()->to(route('home').'#news');
        }

        $news = $this->findNewsBySlugOrId($slug ?? $id);

        return view('news', [
            'news' => $news,
            'slug' => $slug ?? $id,
        ]);
    }

    /**
     * Display the specified news article by route slug.
     */
    public function show(Request $request, string $slug): View
    {
        $news = $this->findNewsBySlugOrId($slug);

        return view('news', [
            'news' => $news,
            'slug' => $slug,
        ]);
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

    /**
     * Look up visible news item by slug or numeric ID.
     */
    protected function findNewsBySlugOrId(string|int $identifier): ?News
    {
        $query = News::query();

        if (is_numeric($identifier)) {
            $query->where(function ($q) use ($identifier) {
                $q->where('id', $identifier)
                    ->orWhere('slug', (string) $identifier);
            });
        } else {
            $query->where('slug', $identifier);
        }

        /** @var News|null $news */
        $news = $query->first();

        if (! $news) {
            return null;
        }

        if ($news->status === 'published') {
            return $news;
        }

        if ($news->status === 'scheduled' && $news->published_at && $news->published_at->isPast()) {
            return $news;
        }

        return null;
    }
}
