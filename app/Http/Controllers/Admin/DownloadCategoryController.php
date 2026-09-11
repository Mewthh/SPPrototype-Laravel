<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DownloadCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadCategoryController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => DownloadCategory::query()
                ->with(['downloads' => fn ($query) => $query->latest('created_at')])
                ->withCount('downloads')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate(['name' => ['required', 'string', 'max:100', 'unique:download_categories,name']]);
        $category = DownloadCategory::create($validated);

        return response()->json(['data' => $category->load('downloads'), 'message' => 'Category created successfully.'], 201);
    }

    public function update(Request $request, DownloadCategory $downloadCategory): JsonResponse
    {
        $validated = $request->validate(['name' => ['required', 'string', 'max:100', 'unique:download_categories,name,'.$downloadCategory->id]]);
        $downloadCategory->update($validated);

        return response()->json(['data' => $downloadCategory->load('downloads'), 'message' => 'Category updated successfully.']);
    }

    public function destroy(DownloadCategory $downloadCategory): JsonResponse
    {
        $disk = config('filesystems.private', 'r2-private');
        foreach ($downloadCategory->downloads as $download) {
            Storage::disk($disk)->delete($download->file_url);
        }

        $downloadCategory->downloads()->delete();
        $downloadCategory->delete();

        return response()->json(['message' => 'Category deleted successfully.']);
    }
}
