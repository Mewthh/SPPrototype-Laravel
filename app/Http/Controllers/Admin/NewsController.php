<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of the news posts with filter counts.
     */
    public function index(Request $request): JsonResponse
    {
        $allNews = News::query()->latest('created_at')->get();

        $counts = [
            'all' => $allNews->count(),
            'published' => $allNews->where('status', 'published')->count(),
            'scheduled' => $allNews->where('status', 'scheduled')->count(),
            'draft' => $allNews->where('status', 'draft')->count(),
            'archived' => $allNews->where('status', 'archived')->count(),
        ];

        $statusFilter = $request->query('status');
        $filtered = ($statusFilter && $statusFilter !== 'all')
            ? $allNews->where('status', $statusFilter)->values()
            : $allNews;

        return response()->json([
            'data' => $filtered,
            'counts' => $counts,
        ]);
    }

    /**
     * Store a newly created news post in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'summary' => ['nullable', 'string'],
            'excerpt' => ['nullable', 'string'],
            'publishDate' => ['nullable', 'date'],
            'published_at' => ['nullable', 'date'],
            'body' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published,scheduled,archived'],
            'coverImage' => ['nullable'],
            'image' => ['nullable'],
        ]);

        $title = $validated['title'];
        $slug = $this->generateUniqueSlug($title);
        $content = $validated['content'] ?? $validated['body'] ?? '';
        $excerpt = $validated['excerpt'] ?? $validated['summary'] ?? null;
        $status = $validated['status'];

        $publishedAt = null;
        $rawDate = $validated['published_at'] ?? $validated['publishDate'] ?? null;
        if ($rawDate) {
            $publishedAt = Carbon::parse($rawDate);
        } elseif ($status === 'published') {
            $publishedAt = Carbon::now();
        }

        $imagePath = $this->handleImageUpload($request);

        $news = News::create([
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'excerpt' => $excerpt,
            'image' => $imagePath,
            'status' => $status,
            'published_at' => $publishedAt,
        ]);

        return response()->json([
            'message' => 'News post created successfully.',
            'data' => $news,
        ], 201);
    }

    /**
     * Display the specified news post.
     */
    public function show(News $news): JsonResponse
    {
        return response()->json([
            'data' => $news,
        ]);
    }

    /**
     * Update the specified news post in storage.
     */
    public function update(Request $request, News $news): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'summary' => ['nullable', 'string'],
            'excerpt' => ['nullable', 'string'],
            'publishDate' => ['nullable'],
            'published_at' => ['nullable'],
            'body' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'status' => ['sometimes', 'required', 'in:draft,published,scheduled,archived'],
            'coverImage' => ['nullable'],
            'image' => ['nullable'],
            'removeImage' => ['nullable', 'boolean'],
        ]);

        if (isset($validated['title']) && $validated['title'] !== $news->title) {
            $news->title = $validated['title'];
            $news->slug = $this->generateUniqueSlug($validated['title'], $news->id);
        }

        if (array_key_exists('content', $validated) || array_key_exists('body', $validated)) {
            $news->content = $validated['content'] ?? $validated['body'] ?? '';
        }

        if (array_key_exists('excerpt', $validated) || array_key_exists('summary', $validated)) {
            $news->excerpt = $validated['excerpt'] ?? $validated['summary'] ?? null;
        }

        if (isset($validated['status'])) {
            $news->status = $validated['status'];
        }

        $rawDate = $validated['published_at'] ?? $validated['publishDate'] ?? null;
        if ($rawDate) {
            $news->published_at = Carbon::parse($rawDate);
        } elseif ($news->status === 'published' && ! $news->published_at) {
            $news->published_at = Carbon::now();
        }

        if (! empty($validated['removeImage'])) {
            $news->image = null;
        } else {
            $imagePath = $this->handleImageUpload($request);
            if ($imagePath !== null) {
                $news->image = $imagePath;
            }
        }

        $news->save();

        return response()->json([
            'message' => 'News post updated successfully.',
            'data' => $news,
        ]);
    }

    /**
     * Remove the specified news post from storage.
     */
    public function destroy(News $news): JsonResponse
    {
        $news->delete();

        return response()->json([
            'message' => 'News post deleted successfully.',
        ]);
    }

    /**
     * Quick update of the status of the specified news post.
     */
    public function updateStatus(Request $request, News $news): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:draft,published,scheduled,archived'],
        ]);

        $news->status = $validated['status'];
        if ($news->status === 'published' && ! $news->published_at) {
            $news->published_at = Carbon::now();
        }
        $news->save();

        return response()->json([
            'message' => 'Status updated successfully.',
            'data' => $news,
        ]);
    }

    /**
     * Generate a unique slug for news articles.
     */
    protected function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        if (empty($baseSlug)) {
            $baseSlug = 'news-post-'.time();
        }

        $slug = $baseSlug;
        $count = 2;

        while (News::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = "{$baseSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    /**
     * Handle image file upload or string/dataURL image.
     */
    protected function handleImageUpload(Request $request): ?string
    {
        if ($request->hasFile('coverImage')) {
            $path = $request->file('coverImage')->store('news', 'public');

            return '/storage/'.$path;
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news', 'public');

            return '/storage/'.$path;
        }

        $imageString = $request->input('coverImage') ?? $request->input('image');
        if (is_string($imageString) && ! empty($imageString)) {
            // If base64 data image URL is provided, save it to public storage
            if (preg_match('/^data:image\/(\w+);base64,/', $imageString, $type)) {
                $data = substr($imageString, strpos($imageString, ',') + 1);
                $type = strtolower($type[1]);
                if (in_array($type, ['jpg', 'jpeg', 'gif', 'png', 'webp'])) {
                    $data = base64_decode($data, true);
                    if ($data !== false) {
                        $fileName = 'news/'.Str::random(40).'.'.$type;
                        Storage::disk('public')->put($fileName, $data);

                        return '/storage/'.$fileName;
                    }
                }
            }

            return $imageString;
        }

        return null;
    }
}
