<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    /**
     * Upload an image or file asset to storage (R2).
     */
    public function upload(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'image' => ['nullable', 'file', 'image', 'max:10240'], // 10MB
            'file' => ['nullable', 'file', 'max:51200'], // 50MB for general files/PDFs
            'is_private' => ['nullable', 'boolean'],
            'folder' => ['nullable', 'string', 'max:50'],
        ]);

        $uploadedFile = $request->file('image') ?? $request->file('file');

        if (! $uploadedFile) {
            return response()->json([
                'message' => 'No valid file was provided.',
            ], 422);
        }

        $isPrivate = $request->boolean('is_private', false);
        $folder = $validated['folder'] ?? ($isPrivate ? 'private-media' : 'media');

        // Sanitize folder path
        $folder = trim(preg_replace('/[^a-zA-Z0-9_\-\/]/', '', $folder), '/');
        if (empty($folder)) {
            $folder = 'media';
        }

        if ($isPrivate) {
            $disk = config('filesystems.private', 'r2-private');
        } else {
            $disk = config('filesystems.default', 'public');
            if ($disk === 'local') {
                $disk = 'public';
            }
        }

        $extension = $uploadedFile->getClientOriginalExtension();
        $safeName = Str::random(40).($extension ? '.'.$extension : '');
        $storedPath = $uploadedFile->storeAs($folder, $safeName, $disk);

        if ($storedPath === false) {
            return response()->json([
                'message' => 'Failed to store uploaded file.',
            ], 500);
        }

        $url = $isPrivate
            ? route('downloads.download', ['download' => 0, 'file' => $storedPath])
            : Storage::disk($disk)->url($storedPath);

        return response()->json([
            'message' => 'File uploaded successfully.',
            'url' => $url,
            'path' => $storedPath,
            'filename' => $uploadedFile->getClientOriginalName(),
            'size' => $uploadedFile->getSize(),
            'mime_type' => $uploadedFile->getMimeType(),
        ], 201);
    }
}
