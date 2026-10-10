<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
