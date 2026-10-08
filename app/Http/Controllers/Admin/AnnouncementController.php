<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of announcements with counts.
     */
    public function index(Request $request): JsonResponse
    {
        $allAnnouncements = Announcement::query()->latest('created_at')->latest('id')->get();

        $counts = [
            'all' => $allAnnouncements->count(),
            'published' => $allAnnouncements->where('status', 'published')->count(),
            'draft' => $allAnnouncements->where('status', 'draft')->count(),
            'archived' => $allAnnouncements->where('status', 'archived')->count(),
        ];

        $statusFilter = $request->query('status');
        $filtered = ($statusFilter && $statusFilter !== 'all')
            ? $allAnnouncements->where('status', $statusFilter)->values()
            : $allAnnouncements;

        return response()->json([
            'data' => $filtered,
            'counts' => $counts,
        ]);
    }

    /**
     * Store a newly created announcement.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $this->validateAnnouncement($request);

        $announcement = Announcement::create($validated);

        return response()->json([
            'data' => $announcement,
            'message' => 'Announcement created successfully.',
        ], 201);
    }

    /**
     * Display the specified announcement.
     */
    public function show(Announcement $announcement): JsonResponse
    {
        return response()->json([
            'data' => $announcement,
        ]);
    }

    /**
     * Update the specified announcement.
     */
    public function update(Request $request, Announcement $announcement): JsonResponse
    {
        $validated = $this->validateAnnouncement($request);

        $announcement->update($validated);

        return response()->json([
            'data' => $announcement,
            'message' => 'Announcement updated successfully.',
        ]);
    }

    /**
     * Remove the specified announcement.
     */
    public function destroy(Announcement $announcement): JsonResponse
    {
        $announcement->delete();

        return response()->json([
            'message' => 'Announcement deleted successfully.',
        ]);
    }

    /**
     * Update the status of the specified announcement.
     */
    public function updateStatus(Request $request, Announcement $announcement): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:published,draft,archived'],
        ]);

        $announcement->update(['status' => $validated['status']]);

        return response()->json([
            'data' => $announcement,
            'message' => 'Announcement status updated successfully.',
        ]);
    }

    /**
     * Validate the announcement payload.
     *
     * @return array{title: string, target_audience: string, summary: string|null, content: string, status: string}
     */
    private function validateAnnouncement(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'target_audience' => ['required', 'string', 'in:all,regular,associate,institutional'],
            'summary' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'status' => ['required', 'string', 'in:published,draft,archived'],
        ]);
    }
}
