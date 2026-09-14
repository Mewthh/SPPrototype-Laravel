<?php

namespace App\Http\Controllers;

use App\Models\AboutPage;
use Illuminate\Contracts\View\View;

class AboutController extends Controller
{
    public function show(): View
    {
        $aboutPage = AboutPage::query()->firstOrCreate(
            ['id' => 1],
            AboutPage::defaultAttributes(),
        );

        return view('about', compact('aboutPage'));
    }
}
