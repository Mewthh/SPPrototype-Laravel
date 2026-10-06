<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Contracts\View\View;

class MembershipArticleController extends Controller
{
    public function show(string $slug): View
    {
        abort_unless($slug === 'article-ii', 404);

        $article = Page::query()->firstOrCreate(
            ['slug' => 'article-ii'],
            ['title' => 'Article II: Membership', 'content' => Page::defaultArticleIIContent(), 'status' => 'published'],
        );

        if (in_array($article->content, ['Add the Article II content here.', 'Add the Article II content through the Membership FAQ editor.'], true)) {
            $article->update([
                'title' => 'Article II: Membership',
                'content' => Page::defaultArticleIIContent(),
            ]);
        }

        return view('membership-article', ['article' => $article]);
    }
}
