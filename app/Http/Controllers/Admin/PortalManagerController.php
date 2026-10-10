<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\MembershipApplication;
use Illuminate\View\View;

class PortalManagerController extends Controller
{
    /**
     * Display the portal manager view with announcement and application data.
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

        return view('admin.portal-manager', compact(
            'announcements',
            'announcementCounts',
            'applications',
            'applicationCounts',
            'approvedMembers'
        ));
    }
}
