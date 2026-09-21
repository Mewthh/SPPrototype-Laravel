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
            ['title' => 'Article II — Membership', 'content' => 'Add the Article II content through the Membership FAQ editor.', 'status' => 'published'],
        );

        return view('membership-article', ['article' => $article]);
    }
}
