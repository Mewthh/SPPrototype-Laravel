<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display the activity detail page by query parameter or redirect to home activities section.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $slug = $request->query('slug');
        $id = $request->query('id');

        if (! $slug && ! $id) {
            return redirect()->to(route('home').'#activities');
        }

        $activity = $this->findActivityBySlugOrId($slug ?? $id);

        return view('activity', [
            'activity' => $activity,
            'slug' => $slug ?? $id,
        ]);
    }

    /**
     * Display the specified activity by route slug.
     */
    public function show(Request $request, string $slug): View
    {
        $activity = $this->findActivityBySlugOrId($slug);

        return view('activity', [
            'activity' => $activity,
            'slug' => $slug,
        ]);
    }

    /**
     * Look up visible activity item by slug or numeric ID.
     */
    protected function findActivityBySlugOrId(string|int $identifier): ?Activity
    {
        $query = Activity::query();

        if (is_numeric($identifier)) {
            $query->where(function ($q) use ($identifier) {
                $q->where('id', $identifier)
                    ->orWhere('slug', (string) $identifier);
            });
        } else {
            $query->where('slug', $identifier);
        }

        /** @var Activity|null $activity */
        $activity = $query->first();

        if (! $activity) {
            return null;
        }

        if (in_array($activity->status, ['published', 'scheduled'])) {
            return $activity;
        }

        return null;
    }
}
