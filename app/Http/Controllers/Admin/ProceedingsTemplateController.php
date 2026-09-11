<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProceedingsTemplate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProceedingsTemplateController extends Controller
{
    public function show(): JsonResponse
    {
        return response()->json(['data' => ProceedingsTemplate::first()]);
    }

    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:500'],
            'first_label' => ['nullable', 'string', 'max:100'],
            'first_url' => ['nullable', 'url', 'max:500'],
            'first_opens_in_new_tab' => ['nullable', 'boolean'],
            'second_label' => ['nullable', 'string', 'max:100'],
            'second_url' => ['nullable', 'url', 'max:500'],
            'second_opens_in_new_tab' => ['nullable', 'boolean'],
        ]);

        $template = ProceedingsTemplate::query()->firstOrNew();
        $validated['first_opens_in_new_tab'] = $request->boolean('first_opens_in_new_tab', true);
        $validated['second_opens_in_new_tab'] = $request->boolean('second_opens_in_new_tab', true);
        $template->fill($validated);
        $template->save();

        return response()->json(['data' => $template, 'message' => 'Proceedings template saved successfully.']);
    }
}
