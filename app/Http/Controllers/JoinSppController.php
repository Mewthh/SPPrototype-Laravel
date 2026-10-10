<?php

namespace App\Http\Controllers;

use App\Models\MembershipApplication;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JoinSppController extends Controller
{
    /**
     * Show the join-spp application page.
     */
    public function create(): View
    {
        return view('join-spp');
    }

    /**
     * Store a newly submitted membership application.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'membership_type' => ['required', 'string', 'max:100'],
            'application_type' => ['nullable', 'string', 'max:100'],
            'application_date' => ['nullable', 'string', 'max:50'],
            'recommender_name' => ['nullable', 'string', 'max:255'],
            'recommender_email' => ['nullable', 'email', 'max:255'],
            'recommender_suffix' => ['nullable', 'string', 'max:50'],
            'alt_recommender_name' => ['nullable', 'string', 'max:255'],
            'alt_recommender_email' => ['nullable', 'email', 'max:255'],
            'alt_recommender_suffix' => ['nullable', 'string', 'max:50'],
            'surname' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'suffix' => ['nullable', 'string', 'max:50'],
            'mobile_number' => ['nullable', 'string', 'max:50'],
            'birthdate' => ['nullable', 'string', 'max:50'],
            'sex' => ['nullable', 'string', 'max:50'],
            'civil_status' => ['nullable', 'string', 'max:50'],
            'nationality' => ['nullable', 'string', 'max:100'],
            'home_address' => ['nullable', 'string', 'max:1000'],
            'current_affiliation' => ['nullable', 'string', 'max:255'],
            'current_position' => ['nullable', 'string', 'max:255'],
            'institutional_email' => ['nullable', 'email', 'max:255'],
            'highest_educational_attainment' => ['nullable', 'string', 'max:100'],
            'degree' => ['nullable', 'string', 'max:255'],
            'date_degree_obtained' => ['nullable', 'string', 'max:50'],
            'institution_name' => ['nullable', 'string', 'max:255'],
            'institution_address' => ['nullable', 'string', 'max:1000'],
            'declaration_agree' => ['nullable'],
            'certification_confirm' => ['nullable'],
            'account_email' => ['required', 'email', 'max:255'],
            'account_password' => ['required', 'string', 'min:8', 'confirmed'],
            'cv_file' => ['nullable', 'file', 'max:10240'],
            'proof_file' => ['nullable', 'file', 'max:10240'],
        ]);

        $cvPath = $request->hasFile('cv_file')
            ? $request->file('cv_file')?->store('applications/cv', 'public')
            : null;

        $proofPath = $request->hasFile('proof_file')
            ? $request->file('proof_file')?->store('applications/proofs', 'public')
            : null;

        $user = User::firstOrCreate(
            ['email' => $validated['account_email']],
            [
                'name' => trim("{$validated['first_name']} {$validated['surname']}"),
                'password' => $validated['account_password'],
                'role' => 'member',
            ]
        );

        $application = MembershipApplication::create([
            'user_id' => $user->id,
            'membership_type' => $validated['membership_type'] ?? 'Regular Member',
            'application_type' => $validated['application_type'] ?? 'New Application',
            'application_date' => $validated['application_date'] ?: now()->format('m/d/Y'),
            'recommender_name' => $validated['recommender_name'] ?? null,
            'recommender_email' => $validated['recommender_email'] ?? null,
            'recommender_suffix' => $validated['recommender_suffix'] ?? null,
            'alt_recommender_name' => $validated['alt_recommender_name'] ?? null,
            'alt_recommender_email' => $validated['alt_recommender_email'] ?? null,
            'alt_recommender_suffix' => $validated['alt_recommender_suffix'] ?? null,
            'surname' => $validated['surname'],
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'suffix' => $validated['suffix'] ?? null,
            'mobile_number' => $validated['mobile_number'] ?? null,
            'birthdate' => $validated['birthdate'] ?? null,
            'sex' => $validated['sex'] ?? null,
            'civil_status' => $validated['civil_status'] ?? null,
            'nationality' => $validated['nationality'] ?? 'Filipino',
            'home_address' => $validated['home_address'] ?? null,
            'current_affiliation' => $validated['current_affiliation'] ?? null,
            'current_position' => $validated['current_position'] ?? null,
            'institutional_email' => $validated['institutional_email'] ?? null,
            'highest_educational_attainment' => $validated['highest_educational_attainment'] ?? null,
            'degree' => $validated['degree'] ?? null,
            'date_degree_obtained' => $validated['date_degree_obtained'] ?? null,
            'institution_name' => $validated['institution_name'] ?? null,
            'institution_address' => $validated['institution_address'] ?? null,
            'cv_path' => $cvPath,
            'proof_path' => $proofPath,
            'declaration_agree' => $request->boolean('declaration_agree'),
            'certification_confirm' => $request->boolean('certification_confirm'),
            'account_email' => $validated['account_email'],
            'status' => 'Under Evaluation',
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Account created & application submitted! You can now log in to the portal.',
                'data' => $application,
            ], 201);
        }

        return redirect()->route('join-spp')->with('success', 'Account created & application submitted! You can now log in to the portal.');
    }
}
