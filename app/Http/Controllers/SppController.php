<?php

namespace App\Http\Controllers;

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
        return view('spp');
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
