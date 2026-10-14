<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\MembershipApplication;
use App\Models\MembershipInquiry;
use Illuminate\View\View;

class PortalManagerController extends Controller
{
    /**
     * Display the portal manager view with announcement, application, and inquiry data.
     */
    public function index(): View
    {
        $announcements = Announcement::query()->latest('created_at')->latest('id')->get();

        $announcementCounts = [
            'all' => $announcements->count(),
            'published' => $announcements->where('status', 'published')->count(),
            'draft' => $announcements->where('status', 'draft')->count(),
            'archived' => $announcements->where('status', 'archived')->count(),
        ];

        $applications = MembershipApplication::query()->latest('created_at')->latest('id')->get();

        $applicationCounts = [
            'all' => $applications->count(),
            'under_evaluation' => $applications->where('status', 'Under Evaluation')->count(),
            'pending' => $applications->where('status', 'Pending')->count(),
            'approved' => $applications->where('status', 'Approved')->count(),
            'rejected' => $applications->where('status', 'Rejected')->count(),
        ];

        $approvedMembers = MembershipApplication::query()
            ->where('status', 'Approved')
            ->latest('updated_at')
            ->get();

        $inquiries = MembershipInquiry::query()->latest('created_at')->latest('id')->get();

        $inquiryCounts = [
            'all' => $inquiries->count(),
            'submitted' => $inquiries->where('status', 'Submitted')->count(),
            'under_review' => $inquiries->where('status', 'Under Review')->count(),
            'responded' => $inquiries->where('status', 'Responded')->count(),
            'closed' => $inquiries->where('status', 'Closed')->count(),
        ];

        return view('admin.portal-manager', compact(
            'announcements',
            'announcementCounts',
            'applications',
            'applicationCounts',
            'approvedMembers',
            'inquiries',
            'inquiryCounts'
        ));
    }
}
