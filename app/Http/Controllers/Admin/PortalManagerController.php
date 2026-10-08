<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\View\View;

class PortalManagerController extends Controller
{
    /**
     * Display the portal manager view with announcement data.
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

        return view('admin.portal-manager', compact('announcements', 'announcementCounts'));
    }
}
