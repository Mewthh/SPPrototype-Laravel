<?php

namespace App\Http\Controllers;

use App\Models\MembershipInquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortalInquiryController extends Controller
{
    /**
     * Display the portal inquiries page with inquiry history.
     */
    public function index(): View
    {
        $inquiries = MembershipInquiry::query()
            ->latest('created_at')
            ->latest('id')
            ->get();

        return view('portal.inquiries', compact('inquiries'));
    }

    /**
     * Store a newly submitted inquiry from the portal.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'query_type' => ['required', 'string'],
            'last_known_membership' => ['required_if:query_type,membership_status', 'nullable', 'string', 'max:255'],
            'status_last_attendance_year' => ['nullable', 'string', 'max:10'],
            'status_last_attendance_place' => ['nullable', 'string', 'max:255'],
            'status_remarks' => ['nullable', 'string', 'max:2000'],
            'cert_oath_year' => ['nullable', 'string', 'max:10'],
            'cert_oath_venue' => ['nullable', 'string', 'max:255'],
            'cert_membership_type' => ['nullable', 'string', 'max:255'],
            'cert_attendance_year' => ['nullable', 'string', 'max:10'],
            'cert_attendance_place' => ['nullable', 'string', 'max:255'],
            'cert_purpose' => ['nullable', 'string', 'max:2000'],
            'other_keywords' => ['required_if:query_type,other', 'nullable', 'string', 'max:255'],
            'other_concern' => ['nullable', 'string', 'max:2000'],
        ]);

        $queryType = match ($validated['query_type']) {
            'membership_status', 'Membership Status' => 'Membership Status',
            'certificate', 'Request for Certificate of Membership' => 'Request for Certificate of Membership',
            default => 'Other',
        };

        $user = auth()->user();
        $appName = $user?->name ?? 'Sample Name';
        $appEmail = $user?->email ?? 'example@email.com';
        $application = $user?->applications()->latest()->first();

        $lastKnownMem = null;
        $lastAttYear = null;
        $lastAttPlace = null;
        $oathYear = null;
        $oathVenue = null;
        $knownMemType = null;
        $purpose = null;
        $keywords = null;
        $remarks = null;

        if ($queryType === 'Membership Status') {
            $lastKnownMem = $request->input('last_known_membership');
            $lastAttYear = $request->input('status_last_attendance_year');
            $lastAttPlace = $request->input('status_last_attendance_place');
            $remarks = $request->input('status_remarks');
        } elseif ($queryType === 'Request for Certificate of Membership') {
            $oathYear = $request->input('cert_oath_year');
            $oathVenue = $request->input('cert_oath_venue');
            $knownMemType = $request->input('cert_membership_type');
            $lastAttYear = $request->input('cert_attendance_year');
            $lastAttPlace = $request->input('cert_attendance_place');
            $purpose = $request->input('cert_purpose');
            $remarks = $purpose;
        } else {
            $keywords = $request->input('other_keywords');
            $remarks = $request->input('other_concern');
        }

        $inquiry = MembershipInquiry::create([
            'ticket_id' => MembershipInquiry::nextTicketId(),
            'user_id' => $user?->id,
            'inquirer_name' => $appName,
            'inquirer_email' => $appEmail,
            'inquirer_institution' => $application?->current_affiliation ?? 'Physics Department',
            'inquirer_tier' => $application?->membership_type ?? 'Regular Member',
            'application_type' => $application?->application_type ?? 'New Application',
            'query_type' => $queryType,
            'last_known_membership' => $lastKnownMem,
            'last_attendance_year' => $lastAttYear,
            'last_attendance_place' => $lastAttPlace,
            'oath_year' => $oathYear,
            'oath_venue' => $oathVenue,
            'known_membership_type' => $knownMemType,
            'purpose' => $purpose,
            'keywords' => $keywords,
            'remarks' => $remarks,
            'status' => 'Submitted',
            'priority' => 'Normal',
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Your inquiry has been submitted to the Secretariat. If a response is required, we will email you.',
                'data' => $inquiry,
                'formatted' => [
                    'query_type' => $inquiry->query_type,
                    'details_summary' => match ($inquiry->query_type) {
                        'Membership Status' => 'Last known: '.($inquiry->last_known_membership ?? 'Not specified').($inquiry->last_attendance_year ? ' • Last attended: '.$inquiry->last_attendance_year.($inquiry->last_attendance_place ? ' ('.$inquiry->last_attendance_place.')' : '') : ''),
                        'Request for Certificate of Membership' => ($inquiry->purpose ? $inquiry->purpose.' • ' : '').'Known type: '.($inquiry->known_membership_type ?? 'Regular').($inquiry->oath_year ? ' • Oath: '.$inquiry->oath_year : ''),
                        default => 'Keywords: '.($inquiry->keywords ?? 'General').($inquiry->remarks ? ' • '.str($inquiry->remarks)->limit(60) : ''),
                    },
                    'date' => $inquiry->created_at?->format('m/d/Y') ?? now()->format('m/d/Y'),
                    'status' => $inquiry->status,
                ],
            ]);
        }

        return redirect()->route('membership-portal.inquiries')
            ->with('status', 'Your inquiry has been submitted to the Secretariat. If a response is required, we will email you.');
    }
}
