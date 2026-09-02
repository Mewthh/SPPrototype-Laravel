<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HeroBannerController extends Controller
{
    /**
     * Get current hero banner settings.
     */
    public function show(): JsonResponse
    {
        $page = Page::where('slug', 'home-hero')->first();

        return response()->json([
            'image_url' => $page ? $page->image_url : null,
            'image_path' => $page ? $page->image : null,
        ]);
    }

    /**
     * Store/update hero banner image.
     */
    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'image' => ['nullable', 'file', 'image', 'max:10240'],
            'image_url' => ['nullable', 'string'],
        ]);

        $disk = config('filesystems.default', 'public');
        if ($disk === 'local') {
            $disk = 'public';
        }

        $imageUrl = null;
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
            $imageUrl = Storage::disk($disk)->url($storedPath);
        } elseif ($request->input('image_url')) {
            $imagePath = $request->input('image_url');
            $imageUrl = $imagePath;
        }

        $page = Page::updateOrCreate(
            ['slug' => 'home-hero'],
            [
                'title' => 'Home Hero Banner',
                'content' => 'Hero Banner Configuration',
                'image' => $imagePath,
                'status' => 'published',
            ]
        );

        return response()->json([
            'message' => 'Hero banner updated successfully.',
            'image_url' => $page->image_url,
            'image_path' => $page->image,
        ]);
    }

    /**
     * Delete/reset hero banner image.
     */
    public function destroy(): JsonResponse
    {
        $page = Page::where('slug', 'home-hero')->first();
        if ($page) {
            $page->update(['image' => null]);
        }

        return response()->json([
            'message' => 'Hero banner removed successfully.',
            'image_url' => null,
        ]);
    }
}
