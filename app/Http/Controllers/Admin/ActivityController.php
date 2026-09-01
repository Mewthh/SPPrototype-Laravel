<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ActivityController extends Controller
{
    /**
     * Display a listing of activities with filter counts.
     */
    public function index(Request $request): JsonResponse
    {
        $all = Activity::query()->latest('created_at')->get();

        $counts = [
            'all' => $all->count(),
            'published' => $all->where('status', 'published')->count(),
            'scheduled' => $all->where('status', 'scheduled')->count(),
            'draft' => $all->where('status', 'draft')->count(),
            'archived' => $all->where('status', 'archived')->count(),
        ];

        $statusFilter = $request->query('status');
        $filtered = ($statusFilter && $statusFilter !== 'all')
            ? $all->where('status', $statusFilter)->values()
            : $all;

        return response()->json([
            'data' => $filtered,
            'counts' => $counts,
        ]);
    }

    /**
     * Store a newly created activity in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'summary' => ['nullable', 'string'],
            'publishDate' => ['nullable', 'date'],
            'event_date' => ['nullable', 'date'],
            'body' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:draft,published,scheduled,archived'],
            'coverImage' => ['nullable'],
            'featureOnHomepage' => ['nullable'],
        ]);

        $title = $validated['title'];
        $slug = $this->generateUniqueSlug($title);
        $description = $validated['description'] ?? $validated['body'] ?? '';
        $summary = $validated['summary'] ?? null;
        $status = $validated['status'];
        $eventDate = $validated['event_date'] ?? $validated['publishDate'] ?? null;
        $location = $validated['location'] ?? null;
        $featured = (bool) ($request->input('featureOnHomepage', false));

        $imagePath = $this->handleImageUpload($request);

        $activity = Activity::create([
            'title' => $title,
            'slug' => $slug,
            'summary' => $summary,
            'description' => $description,
            'image' => $imagePath,
            'event_date' => $eventDate,
            'location' => $location,
            'status' => $status,
            'is_featured' => $featured,
        ]);

        return response()->json([
            'message' => 'Activity created successfully.',
            'data' => $activity,
        ], 201);
    }

    /**
     * Display the specified activity.
     */
    public function show(Activity $activity): JsonResponse
    {
        return response()->json([
            'data' => $activity,
        ]);
    }

    /**
     * Update the specified activity in storage.
     */
    public function update(Request $request, Activity $activity): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'summary' => ['nullable', 'string'],
            'publishDate' => ['nullable'],
            'event_date' => ['nullable'],
            'body' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['sometimes', 'required', 'in:draft,published,scheduled,archived'],
            'coverImage' => ['nullable'],
            'removeImage' => ['nullable', 'boolean'],
            'featureOnHomepage' => ['nullable'],
        ]);

        if (isset($validated['title']) && $validated['title'] !== $activity->title) {
            $activity->title = $validated['title'];
            $activity->slug = $this->generateUniqueSlug($validated['title'], $activity->id);
        }

        if (array_key_exists('description', $validated) || array_key_exists('body', $validated)) {
            $activity->description = $validated['description'] ?? $validated['body'] ?? '';
        }

        if (array_key_exists('summary', $validated)) {
            $activity->summary = $validated['summary'];
        }

        if (isset($validated['status'])) {
            $activity->status = $validated['status'];
        }

        $rawDate = $validated['event_date'] ?? $validated['publishDate'] ?? null;
        if ($rawDate) {
            $activity->event_date = $rawDate;
        }

        if (isset($validated['location'])) {
            $activity->location = $validated['location'];
        }

        if ($request->has('featureOnHomepage')) {
            $activity->is_featured = (bool) $request->input('featureOnHomepage');
        }

        if (! empty($validated['removeImage'])) {
            $activity->image = null;
        } else {
            $imagePath = $this->handleImageUpload($request);
            if ($imagePath !== null) {
                $activity->image = $imagePath;
            }
        }

        $activity->save();

        return response()->json([
            'message' => 'Activity updated successfully.',
            'data' => $activity,
        ]);
    }

    /**
     * Remove the specified activity from storage.
     */
    public function destroy(Activity $activity): JsonResponse
    {
        $activity->delete();

        return response()->json([
            'message' => 'Activity deleted successfully.',
        ]);
    }

    /**
     * Quick update of the status of the specified activity.
     */
    public function updateStatus(Request $request, Activity $activity): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:draft,published,scheduled,archived'],
        ]);

        $activity->status = $validated['status'];
        $activity->save();

        return response()->json([
            'message' => 'Status updated successfully.',
            'data' => $activity,
        ]);
    }

    /**
     * Generate a unique slug for activities.
     */
    protected function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        if (empty($baseSlug)) {
            $baseSlug = 'activity-'.time();
        }

        $slug = $baseSlug;
        $count = 2;

        while (Activity::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = "{$baseSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    /**
     * Handle image file upload or string/dataURL image.
     */
    protected function handleImageUpload(Request $request): ?string
    {
        $disk = config('filesystems.default', 'public');
        if ($disk === 'local') {
            $disk = 'public';
        }

        if ($request->hasFile('coverImage')) {
            $path = $request->file('coverImage')->store('activities', $disk);

            return $path !== false ? $path : null;
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('activities', $disk);

            return $path !== false ? $path : null;
        }

        $imageString = $request->input('coverImage') ?? $request->input('image');
        if (is_string($imageString) && ! empty($imageString)) {
            if (preg_match('/^data:image\/(\w+);base64,/', $imageString, $type)) {
                $data = substr($imageString, strpos($imageString, ',') + 1);
                $type = strtolower($type[1]);
                if (in_array($type, ['jpg', 'jpeg', 'gif', 'png', 'webp'])) {
                    $data = base64_decode($data, true);
                    if ($data !== false) {
                        $fileName = 'activities/'.Str::random(40).'.'.$type;
                        Storage::disk($disk)->put($fileName, $data, 'public');

                        return $fileName;
                    }
                }
            }

            return $imageString;
        }

        return null;
    }
}
