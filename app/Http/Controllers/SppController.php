<?php

namespace App\Http\Controllers;

use App\Models\SppEvent;
use Illuminate\Contracts\View\View;
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

        if (str_starts_with($conference->handbook_file, 'http://') || str_starts_with($conference->handbook_file, 'https://')) {
            return redirect()->away($conference->handbook_file);
        }

        $disk = config('filesystems.default', 'public');
        $diskName = is_string($disk) && $disk !== 'local' ? $disk : 'public';

        if (! Storage::disk($diskName)->exists($conference->handbook_file)) {
            abort(404, 'Handbook file not found in storage.');
        }

        $extension = pathinfo($conference->handbook_file, PATHINFO_EXTENSION);
        $cleanTitle = $conference->handbook_name ?: ($conference->title.' Handbook');
        $fileName = Str::slug($cleanTitle).($extension ? '.'.$extension : '');

        return Storage::disk($diskName)->download($conference->handbook_file, $fileName);
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
