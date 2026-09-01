<?php

namespace App\Http\Controllers;

use App\Models\Download;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadController extends Controller
{
    /**
     * Download or access a protected file via temporary signed URL or streaming.
     */
    public function download(Request $request, Download $download): RedirectResponse|StreamedResponse
    {
        if ($download->status !== 'published' && ! $request->user()) {
            abort(404, 'Download not found or access restricted.');
        }

        $filePath = $download->file_url;

        // If file_url is an external full URL, redirect directly
        if (str_starts_with($filePath, 'http://') || str_starts_with($filePath, 'https://')) {
            return redirect()->away($filePath);
        }

        $privateDisk = config('filesystems.private', 'r2-private');

        // If the request explicitly asks to stream/proxy the file
        if ($request->boolean('stream')) {
            if (! Storage::disk($privateDisk)->exists($filePath)) {
                abort(404, 'File not found in storage.');
            }

            return Storage::disk($privateDisk)->download($filePath, $download->file_name);
        }

        // Default: Generate a secure 15-minute temporary presigned URL and redirect
        $temporaryUrl = $download->getTemporaryDownloadUrl(15);

        return redirect()->away($temporaryUrl);
    }
}
