<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SppEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ConferenceController extends Controller
{
    /**
     * Display a listing of conferences with status counts.
     */
    public function index(Request $request): JsonResponse
    {
        $allConferences = SppEvent::query()
            ->orderByRaw("CASE WHEN year IS NOT NULL AND year != '' THEN CAST(year AS INTEGER) ELSE 0 END DESC")
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $counts = [
            'all' => $allConferences->count(),
            'published' => $allConferences->where('status', 'published')->count(),
            'draft' => $allConferences->where('status', 'draft')->count(),
            'archived' => $allConferences->where('status', 'archived')->count(),
        ];

        $statusFilter = $request->query('status');
        $filtered = ($statusFilter && $statusFilter !== 'all')
            ? $allConferences->where('status', $statusFilter)->values()
            : $allConferences;

        return response()->json([
            'data' => $filtered,
            'counts' => $counts,
        ]);
    }

    /**
     * Store a newly created conference.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'year' => ['nullable', 'string', 'max:20'],
            'title' => ['required', 'string', 'max:255'],
            'theme' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'dates' => ['nullable', 'string', 'max:150'],
            'summary' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published,archived'],
            'coverImage' => ['nullable'],
            'image' => ['nullable'],
            'tabs' => ['nullable'],
        ]);

        $title = $validated['title'];
        $year = $validated['year'] ?? null;
        $slug = $this->generateUniqueSlug($year ? "spp-{$year}" : $title);
        $description = $validated['description'] ?? $validated['body'] ?? '';
        $summary = $validated['summary'] ?? null;
        $status = $validated['status'];

        $imagePath = $this->handleImageUpload($request);
        $tabs = $this->normalizeTabs($request->input('tabs'));

        $conference = SppEvent::create([
            'year' => $year,
            'title' => $title,
            'slug' => $slug,
            'theme' => $validated['theme'] ?? null,
            'description' => $description,
            'summary' => $summary,
            'location' => $validated['location'] ?? null,
            'dates' => $validated['dates'] ?? null,
            'tabs' => $tabs,
            'image' => $imagePath,
            'status' => $status,
        ]);

        return response()->json([
            'message' => 'Conference created successfully.',
            'data' => $conference,
        ], 201);
    }

    /**
     * Display the specified conference.
     */
    public function show(SppEvent $conference): JsonResponse
    {
        return response()->json([
            'data' => $conference,
        ]);
    }

    /**
     * Update the specified conference.
     */
    public function update(Request $request, SppEvent $conference): JsonResponse
    {
        $validated = $request->validate([
            'year' => ['nullable', 'string', 'max:20'],
            'title' => ['required', 'string', 'max:255'],
            'theme' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'dates' => ['nullable', 'string', 'max:150'],
            'summary' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published,archived'],
            'coverImage' => ['nullable'],
            'image' => ['nullable'],
            'tabs' => ['nullable'],
        ]);

        $title = $validated['title'];
        $year = $validated['year'] ?? null;
        $description = $validated['description'] ?? $validated['body'] ?? $conference->description;
        $summary = $validated['summary'] ?? $conference->summary;
        $status = $validated['status'];

        // Only regenerate slug if year or title meaningfully changed
        $slug = $conference->slug;
        if (empty($slug) || ($year && ! str_contains($slug, $year))) {
            $slug = $this->generateUniqueSlug($year ? "spp-{$year}" : $title, $conference->id);
        }

        $imagePath = $this->handleImageUpload($request, $conference->image);
        $tabs = $this->normalizeTabs($request->input('tabs'));

        $conference->update([
            'year' => $year,
            'title' => $title,
            'slug' => $slug,
            'theme' => $validated['theme'] ?? null,
            'description' => $description,
            'summary' => $summary,
            'location' => $validated['location'] ?? null,
            'dates' => $validated['dates'] ?? null,
            'tabs' => $tabs,
            'image' => $imagePath,
            'status' => $status,
        ]);

        return response()->json([
            'message' => 'Conference updated successfully.',
            'data' => $conference->fresh(),
        ]);
    }

    /**
     * Remove the specified conference from storage.
     */
    public function destroy(SppEvent $conference): JsonResponse
    {
        if ($conference->image) {
            $disk = config('filesystems.default', 'public');
            $diskName = is_string($disk) && $disk !== 'local' ? $disk : 'public';
            if (Storage::disk($diskName)->exists($conference->image)) {
                Storage::disk($diskName)->delete($conference->image);
            }
        }

        $conference->delete();

        return response()->json([
            'message' => 'Conference deleted successfully.',
        ]);
    }

    /**
     * Quick status toggle (published, draft, archived).
     */
    public function updateStatus(Request $request, SppEvent $conference): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:draft,published,archived'],
        ]);

        $conference->update([
            'status' => $validated['status'],
        ]);

        return response()->json([
            'message' => "Conference status updated to {$validated['status']}.",
            'data' => $conference,
        ]);
    }

    /**
     * Generate a unique slug for conference.
     */
    private function generateUniqueSlug(string $title, ?int $exceptId = null): string
    {
        $baseSlug = Str::slug($title);
        if (empty($baseSlug)) {
            $baseSlug = 'spp-conference';
        }

        $slug = $baseSlug;
        $counter = 1;

        while (SppEvent::where('slug', $slug)
            ->when($exceptId, fn ($q) => $q->where('id', '!=', $exceptId))
            ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    /**
     * Normalize tabs input from request (array or JSON string).
     *
     * @return array<int, array{id: string, title: string, content: string}>
     */
    private function normalizeTabs(mixed $tabsInput): array
    {
        if (empty($tabsInput)) {
            return [];
        }

        if (is_string($tabsInput)) {
            $decoded = json_decode($tabsInput, true);
            $tabsInput = is_array($decoded) ? $decoded : [];
        }

        if (! is_array($tabsInput)) {
            return [];
        }

        $cleanTabs = [];
        foreach ($tabsInput as $index => $tab) {
            if (! is_array($tab)) {
                continue;
            }

            $title = trim((string) ($tab['title'] ?? ''));
            $content = (string) ($tab['content'] ?? '');
            $id = trim((string) ($tab['id'] ?? 'tab-'.($index + 1)));

            if ($title === '' && trim($content) === '') {
                continue;
            }

            $cleanTabs[] = [
                'id' => $id ?: 'tab-'.($index + 1),
                'title' => $title ?: 'Tab '.($index + 1),
                'content' => $content,
            ];
        }

        return $cleanTabs;
    }

    /**
     * Handle banner/cover image upload or removal.
     */
    private function handleImageUpload(Request $request, ?string $currentImage = null): ?string
    {
        $disk = config('filesystems.default', 'public');
        $diskName = is_string($disk) && $disk !== 'local' ? $disk : 'public';

        if ($request->hasFile('coverImage')) {
            $file = $request->file('coverImage');
            if ($file && $file->isValid()) {
                if ($currentImage && Storage::disk($diskName)->exists($currentImage)) {
                    Storage::disk($diskName)->delete($currentImage);
                }

                $path = $file->store('conferences', $diskName);

                return is_string($path) ? $path : null;
            }
        }

        if ($request->input('removeImage') === 'true' || $request->input('removeImage') === '1') {
            if ($currentImage && Storage::disk($diskName)->exists($currentImage)) {
                Storage::disk($diskName)->delete($currentImage);
            }

            return null;
        }

        return $currentImage;
    }
}
