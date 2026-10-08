<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\View\View;

class PortalAnnouncementController extends Controller
{
    /**
     * Display the portal announcements feed.
     */
    public function index(): View
    {
        $announcements = Announcement::query()
            ->where('status', 'published')
            ->latest('created_at')
            ->get();

        return view('portal.announcements', compact('announcements'));
    }
}
