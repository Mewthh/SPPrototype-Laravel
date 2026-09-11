<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\News;
use App\Models\Page;
use App\Models\SppEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HeroBannerController extends Controller
{
    /**
     * Get current hero banner settings and available posts for linking.
     */
    public function show(): JsonResponse
    {
        $page = Page::where('slug', 'home-hero')->first();

        $newsPosts = News::query()
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->orderBy('id', 'desc')
            ->get(['id', 'title', 'slug', 'status', 'published_at', 'created_at'])
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'type' => 'news',
                    'title' => $item->title,
                    'slug' => $item->slug,
                    'status' => $item->status,
                    'date' => $item->published_at ? $item->published_at->format('M d, Y') : $item->created_at->format('M d, Y'),
                ];
            });

        $activityPosts = Activity::query()
            ->orderBy('event_date', 'desc')
            ->orderBy('id', 'desc')
            ->get(['id', 'title', 'slug', 'status', 'event_date', 'created_at'])
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'type' => 'activity',
                    'title' => $item->title,
                    'slug' => $item->slug,
                    'status' => $item->status,
                    'date' => $item->event_date ? $item->event_date->format('M d, Y') : $item->created_at->format('M d, Y'),
                ];
            });
        $conferencePosts = SppEvent::query()
            ->orderBy('event_date', 'desc')
            ->orderBy('id', 'desc')
            ->get(['id', 'year', 'title', 'slug', 'status', 'event_date', 'created_at'])
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'type' => 'conference',
                    'title' => $item->title ?: ('SPP'.($item->year ?? '')),
                    'slug' => $item->slug,
                    'year' => $item->year,
                    'status' => $item->status,
                    'date' => $item->event_date
                        ? $item->event_date->format('M d, Y')
                        : $item->created_at->format('M d, Y'),
                ];
            });

        return response()->json([
            'image_url' => $page ? $page->image_url : null,
            'image_path' => $page ? $page->image : null,
            'link_type' => $page ? ($page->link_type ?? 'none') : 'none',
            'link_url' => $page ? $page->link_url : null,
            'link_target_id' => $page ? $page->link_target_id : null,
            'link_target_slug' => $page ? $page->link_target_slug : null,
            'open_in_new_tab' => $page ? (bool) $page->open_in_new_tab : false,
            'resolved_link_url' => $page ? $page->resolved_link_url : null,
            'available_posts' => [
                'news' => $newsPosts,
                'activities' => $activityPosts,
                'conferences' => $conferencePosts,
            ],
        ]);
    }

    /**
     * Store/update hero banner image and link destinations.
     */
    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'image' => ['nullable', 'file', 'image', 'max:10240'],
            'image_url' => ['nullable', 'string'],
            'link_type' => ['nullable', 'string', 'in:none,url,news,activity,conference'],
            'link_url' => ['nullable', 'string', 'max:1000'],
            'link_target_id' => ['nullable', 'integer'],
            'link_target_slug' => ['nullable', 'string', 'max:255'],
            'open_in_new_tab' => ['nullable', 'boolean'],
        ]);

        $disk = config('filesystems.default', 'public');
        if ($disk === 'local') {
            $disk = 'public';
        }

        $imagePath = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $safeName = Str::random(40).($extension ? '.'.$extension : '');
            $storedPath = $file->storeAs('banners', $safeName, $disk);

            if ($storedPath === false) {
                return response()->json(['message' => 'Failed to upload banner image.'], 500);
            }

            $imagePath = $storedPath;
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->input('image_url');
        }

        $page = Page::where('slug', 'home-hero')->first();

        // If no new image was provided, retain current image if available
        if ($imagePath === null && $page) {
            $imagePath = $page->image;
        }

        $linkType = $validated['link_type'] ?? 'none';
        $linkUrl = $linkType === 'url' ? ($validated['link_url'] ?? null) : null;
        $linkTargetId = in_array($linkType, ['news', 'activity'], true) ? ($validated['link_target_id'] ?? null) : null;
        $linkTargetSlug = $linkType === 'conference' ? ($validated['link_target_slug'] ?? null) : null;
        $openInNewTab = $request->boolean('open_in_new_tab');

        $page = Page::updateOrCreate(
            ['slug' => 'home-hero'],
            [
                'title' => 'Home Hero Banner',
                'content' => 'Hero Banner Configuration',
                'image' => $imagePath,
                'link_type' => $linkType,
                'link_url' => $linkUrl,
                'link_target_id' => $linkTargetId,
                'link_target_slug' => $linkTargetSlug,
                'open_in_new_tab' => $openInNewTab,
                'status' => 'published',
            ]
        );

        return response()->json([
            'message' => 'Hero banner updated successfully.',
            'image_url' => $page->image_url,
            'image_path' => $page->image,
            'link_type' => $page->link_type,
            'link_url' => $page->link_url,
            'link_target_id' => $page->link_target_id,
            'link_target_slug' => $page->link_target_slug,
            'open_in_new_tab' => (bool) $page->open_in_new_tab,
            'resolved_link_url' => $page->resolved_link_url,
        ]);
    }

    /**
     * Delete/reset hero banner image and link settings.
     */
    public function destroy(): JsonResponse
    {
        $page = Page::where('slug', 'home-hero')->first();
        if ($page) {
            $page->update([
                'image' => null,
                'link_type' => 'none',
                'link_url' => null,
                'link_target_id' => null,
                'link_target_slug' => null,
                'open_in_new_tab' => false,
            ]);
        }

        return response()->json([
            'message' => 'Hero banner removed successfully.',
            'image_url' => null,
            'link_type' => 'none',
            'link_url' => null,
            'link_target_id' => null,
            'link_target_slug' => null,
            'open_in_new_tab' => false,
            'resolved_link_url' => null,
        ]);
    }
}
