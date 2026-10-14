<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipInquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MembershipInquiryController extends Controller
{
    /**
     * Display a listing of membership inquiries with counts.
     */
    public function index(Request $request): JsonResponse
    {
        $allInquiries = MembershipInquiry::query()->latest('created_at')->latest('id')->get();

        $counts = [
            'all' => $allInquiries->count(),
            'submitted' => $allInquiries->where('status', 'Submitted')->count(),
            'under_review' => $allInquiries->where('status', 'Under Review')->count(),
            'responded' => $allInquiries->where('status', 'Responded')->count(),
            'closed' => $allInquiries->where('status', 'Closed')->count(),
        ];

        $statusFilter = $request->query('status');
        $filtered = ($statusFilter && $statusFilter !== 'all')
            ? $allInquiries->where('status', $statusFilter)->values()
            : $allInquiries;

        return response()->json([
            'data' => $filtered,
            'counts' => $counts,
        ]);
    }

    /**
     * Display the specified membership inquiry.
     */
    public function show(MembershipInquiry $inquiry): JsonResponse
    {
        return response()->json([
            'data' => $inquiry,
        ]);
    }

    /**
     * Update the status and response of the specified membership inquiry.
     */
    public function updateStatus(Request $request, MembershipInquiry $inquiry): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:Submitted,Under Review,Responded,Closed'],
            'admin_response' => ['nullable', 'string', 'max:3000'],
            'certificate_attached' => ['nullable', 'string', 'max:255'],
            'certificate_size' => ['nullable', 'string', 'max:100'],
        ]);

        $inquiry->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Inquiry updated successfully.',
            'data' => $inquiry->fresh(),
        ]);
    }

    /**
     * Remove the specified membership inquiry from storage.
     */
    public function destroy(MembershipInquiry $inquiry): JsonResponse
    {
        $inquiry->delete();

        return response()->json([
            'success' => true,
            'message' => 'Inquiry deleted successfully.',
        ]);
    }
}
