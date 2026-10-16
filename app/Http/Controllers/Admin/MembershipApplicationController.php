<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipApplication;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class MembershipApplicationController extends Controller
{
    /**
     * Display a listing of membership applications with counts.
     */
    public function index(Request $request): JsonResponse
    {
        $allApplications = MembershipApplication::query()->latest('created_at')->latest('id')->get();

        $counts = [
            'all' => $allApplications->count(),
            'under_evaluation' => $allApplications->where('status', 'Under Evaluation')->count(),
            'pending' => $allApplications->where('status', 'Pending')->count(),
            'approved' => $allApplications->where('status', 'Approved')->count(),
            'rejected' => $allApplications->where('status', 'Rejected')->count(),
        ];

        $statusFilter = $request->query('status');
        $filtered = ($statusFilter && $statusFilter !== 'all')
            ? $allApplications->where('status', $statusFilter)->values()
            : $allApplications;

        return response()->json([
            'data' => $filtered,
            'counts' => $counts,
        ]);
    }

    /**
     * Display the specified membership application.
     */
    public function show(MembershipApplication $application): JsonResponse
    {
        return response()->json([
            'data' => $application,
        ]);
    }

    /**
     * Display or download the attached document (cv or proof).
     */
    public function viewDocument(Request $request, MembershipApplication $application, string $type): Response
    {
        $user = $request->user();
        if (! $user || (! $user->isAdmin() && $user->id !== $application->user_id)) {
            abort(403, 'Unauthorized access to application documents.');
        }

        $path = $type === 'cv' ? $application->cv_path : ($type === 'proof' ? $application->proof_path : null);

        if (! $path) {
            abort(404, 'Document not attached to this application.');
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return redirect()->away($path);
        }

        $disk = config('filesystems.default', 'public');
        $diskName = (is_string($disk) && $disk !== 'local') ? $disk : 'public';

        /** @var FilesystemAdapter $storage */
        $storage = Storage::disk((string) $diskName);

        if (! $storage->exists($path) && $diskName !== 'public') {
            /** @var FilesystemAdapter $publicStorage */
            $publicStorage = Storage::disk('public');
            if ($publicStorage->exists($path)) {
                $storage = $publicStorage;
            }
        }

        if (! $storage->exists($path)) {
            abort(404, 'Document file not found in storage.');
        }

        return $storage->response($path);
    }

    /**
     * Update the status of the specified membership application.
     */
    public function updateStatus(Request $request, MembershipApplication $application): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:Under Evaluation,Pending,Approved,Rejected'],
            'remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        $application->update($validated);

        return response()->json([
            'data' => $application,
            'message' => "Application status updated to {$application->status}.",
        ]);
    }

    /**
     * Remove the specified membership application from storage.
     */
    public function destroy(MembershipApplication $application): JsonResponse
    {
        $application->delete();

        return response()->json([
            'message' => 'Membership application deleted successfully.',
        ]);
    }
}
