<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Download;
use App\Models\DownloadCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $this->validated($request, true);
        $category = DownloadCategory::query()->findOrFail($validated['download_category_id']);
        $file = $request->file('file');
        $disk = config('filesystems.private', 'r2-private');
        $path = $file->store('downloads', $disk);

        $download = Download::create([
            'download_category_id' => $category->id,
            'category' => $category->name,
            'title' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) ?: 'Document',
            'year' => $validated['year'],
            'file_url' => $path,
            'file_name' => $file->getClientOriginalName(),
            'status' => $validated['status'],
        ]);

        return response()->json(['data' => $download, 'message' => 'Document posted successfully.'], 201);
    }

    public function update(Request $request, Download $download): JsonResponse
    {
        $validated = $this->validated($request, false);
        $category = DownloadCategory::query()->findOrFail($validated['download_category_id']);
        $attributes = [
            'download_category_id' => $category->id,
            'category' => $category->name,
            'year' => $validated['year'],
            'status' => $validated['status'],
        ];

        if ($request->hasFile('file')) {
            $disk = config('filesystems.private', 'r2-private');
            Storage::disk($disk)->delete($download->file_url);
            $file = $request->file('file');
            $attributes['file_url'] = $file->store('downloads', $disk);
            $attributes['file_name'] = $file->getClientOriginalName();
            $attributes['title'] = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) ?: 'Document';
        }

        $download->update($attributes);

        return response()->json(['data' => $download, 'message' => 'Document updated successfully.']);
    }

    public function destroy(Download $download): JsonResponse
    {
        Storage::disk(config('filesystems.private', 'r2-private'))->delete($download->file_url);
        $download->delete();

        return response()->json(['message' => 'Document deleted successfully.']);
    }

    /**
     * @return array{download_category_id: int, year: int, status: 'draft'|'published'|'archived', file?: UploadedFile}
     */
    private function validated(Request $request, bool $fileRequired): array
    {
        return $request->validate([
            'download_category_id' => ['required', 'integer', 'exists:download_categories,id'],
            'year' => ['required', 'integer', 'between:1900,2100'],
            'status' => ['required', 'in:draft,published,archived'],
            'file' => [$fileRequired ? 'required' : 'nullable', 'file', 'mimes:pdf,doc,docx,zip,png', 'max:25600'],
        ]);
    }
}
