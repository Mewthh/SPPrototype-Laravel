<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAboutPageRequest;
use App\Models\AboutPage;
use Illuminate\Http\RedirectResponse;

class AboutController extends Controller
{
    public function edit(): RedirectResponse
    {
        return to_route('dashboard')->withFragment('about-section');
    }

    public function update(UpdateAboutPageRequest $request): RedirectResponse
    {
        $aboutPage = AboutPage::query()->firstOrCreate(
            ['id' => 1],
            AboutPage::defaultAttributes(),
        );

        $attributes = $request->safe()->except(['image', 'remove_image']);
        $attributes['councilors'] = $request->input('councilors', []);

        if ($request->boolean('remove_image')) {
            $attributes['image'] = null;
        }

        if ($request->hasFile('image')) {
            $disk = config('filesystems.default', 'public');
            $diskName = is_string($disk) && $disk !== 'local' ? $disk : 'public';
            $attributes['image'] = $request->file('image')->store('about', $diskName);
        }

        $aboutPage->update($attributes);

        return to_route('dashboard')->withFragment('about-section')->with('status', 'About SPP details saved.');
    }
}
