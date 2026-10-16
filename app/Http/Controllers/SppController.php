<?php

namespace App\Http\Controllers;

use App\Models\SppEvent;
use Illuminate\Contracts\View\View;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SppController extends Controller
{
    /**
     * Download the conference handbook.
     */
    public function downloadHandbook(Request $request, SppEvent $conference): StreamedResponse|RedirectResponse
    {
        if ($conference->status !== 'published' && ! $request->user()) {
            abort(404, 'Conference not found or handbook not available.');
        }

        if (! $conference->handbook_file) {
            abort(404, 'Handbook not found for this conference.');
        }

        $handbookFile = (string) $conference->handbook_file;

        if (str_starts_with($handbookFile, 'http://') || str_starts_with($handbookFile, 'https://')) {
            return redirect()->away($handbookFile);
        }

        $disk = config('filesystems.default', 'public');
        $diskName = (string) ((is_string($disk) && $disk !== 'local') ? $disk : 'public');

        /** @var FilesystemAdapter $storage */
        $storage = Storage::disk($diskName);

        if (! $storage->exists($handbookFile)) {
            abort(404, 'Handbook file not found in storage.');
        }

        $extension = pathinfo($handbookFile, PATHINFO_EXTENSION);
        $cleanTitle = $conference->handbook_name ?: ($conference->title.' Handbook');
        $fileName = Str::slug($cleanTitle).($extension ? '.'.$extension : '');

        return $storage->download($handbookFile, $fileName);
    }

    /**
     * Display the SPP conference portal.
     */
    public function show(Request $request): View
    {
        $year = $request->query('year');
        $slug = $request->query('slug');

        $conferences = SppEvent::published()
            ->orderBy('year', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $conference = null;

        if ($year) {
            $conference = $conferences->firstWhere('year', $year);
        } elseif ($slug) {
            $conference = $conferences->firstWhere('slug', $slug);
        }

        if (! $conference && $conferences->isNotEmpty()) {
            $conference = $conferences->first();
        }

        $activeYear = $conference?->year ?: ($year ?: '2026');

        return view('spp', compact('conference', 'conferences', 'activeYear'));
    }

    /**
     * Handle legacy URL parameters from static prototype (e.g. /spp.html?year=2024).
     */
    public function legacyRedirect(Request $request): View|RedirectResponse
    {
        $year = $request->input('year', '2024');

        return redirect()->route('spp.show', ['year' => $year]);
    }
}
