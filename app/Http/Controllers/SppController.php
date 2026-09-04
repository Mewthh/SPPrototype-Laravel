<?php

namespace App\Http\Controllers;

use App\Models\SppEvent;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SppController extends Controller
{
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
