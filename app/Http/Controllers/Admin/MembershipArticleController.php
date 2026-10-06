<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MembershipArticleController extends Controller
{
    public function show(): JsonResponse
    {
        return response()->json(['data' => $this->article()]);
    }

    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate(['title' => ['required', 'string', 'max:255'], 'content' => ['required', 'string', 'max:50000']]);
        $article = $this->article();
        $article->update($validated);

        return response()->json(['data' => $article, 'message' => 'Article II updated successfully.']);
    }

    private function article(): Page
    {
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

        return $article;
    }
}
