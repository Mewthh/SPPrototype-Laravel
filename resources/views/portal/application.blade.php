@php
    $currentUser = auth()->user();
    $isAdmin = $currentUser?->isAdmin() ?? false;
    $applications = $isAdmin
        ? \App\Models\MembershipApplication::query()->latest('created_at')->latest('id')->get()
        : collect();

    $app = null;
    if ($isAdmin && request('id')) {
        $app = \App\Models\MembershipApplication::query()->find(request('id'));
    }
    if (! $app) {
        $app = $currentUser?->applications()->latest()->first();
    }
    if (! $app && $isAdmin && $applications->isNotEmpty()) {
        $app = $applications->first();
    }

    $cvUrl = $app && $app->cv_path
        ? route('membership-portal.applications.document', ['application' => $app->id, 'type' => 'cv'])
        : null;

    $proofUrl = $app && $app->proof_path
        ? route('membership-portal.applications.document', ['application' => $app->id, 'type' => 'proof'])
        : null;
@endphp

<x-layouts.portal title="My Application | SPP Membership Portal">
    <div class="portal-page-header">
        <div>
            <p class="portal-eyebrow">{{ $isAdmin ? 'Admin Review' : 'Application' }}</p>
            <h1>{{ $isAdmin ? 'Applicant Review' : 'My Application' }}</h1>
        </div>
        <x-portal.status-badge :status="$app?->status ?? 'Under Evaluation'" />
    </div>

    @if($isAdmin)
        <div class="portal-card" style="margin-bottom: 24px; border-left: 4px solid var(--portal-accent); background: var(--portal-surface-soft);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
                <div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span class="portal-badge portal-badge-active" style="font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;">ADMIN MODE</span>
                        <strong style="color: var(--portal-text);">Reviewing Application #{{ $app?->id ?? '—' }}: {{ $app ? ($app->first_name . ' ' . $app->surname) : 'No Application Found' }}</strong>
                    </div>
                    <p style="margin: 4px 0 0; font-size: 0.82rem; color: var(--portal-muted);">
                        Switch between applicants below to inspect their submitted information, CV, and proof documents.
                    </p>
                </div>
                @if($applications->isNotEmpty())
                    <form method="GET" action="{{ route('membership-portal.application') }}" style="display: flex; gap: 8px; align-items: center;">
                        <label for="applicant-select" class="sr-only" style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); border: 0;">Select Applicant</label>
                        <select id="applicant-select" name="id" onchange="this.form.submit()" style="padding: 8px 14px; font-size: 0.84rem; border-radius: 8px; border: 1px solid var(--portal-border); background: var(--portal-surface); color: var(--portal-text); font-weight: 600; cursor: pointer;">
                            @foreach($applications as $item)
                                <option value="{{ $item->id }}" {{ $app?->id === $item->id ? 'selected' : '' }}>
                                    #{{ $item->id }} - {{ $item->first_name }} {{ $item->surname }} ({{ $item->status }})
                                </option>
                            @endforeach
                        </select>
                        <a href="{{ route('admin.membership-portal') }}" class="portal-button" style="text-decoration: none; font-size: 0.82rem; padding: 8px 14px; display: inline-flex; align-items: center; gap: 6px;">
                            Portal Manager
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                        </a>
                    </form>
                @endif
            </div>
        </div>
    @endif

    <section class="portal-card">
        <div class="portal-section-heading">
            <h2>Application Flow</h2>
        </div>
        <x-portal.timeline :steps="['Membership Type', 'Recommender', 'Member Information', 'Documents', 'Validation / Certification', 'Review & Submit']" :current="5" />
    </section>

    <div class="portal-information-grid">
        <x-portal.info-card title="Membership Information">
            <div><dt>Membership Type</dt><dd>{{ $app?->membership_type ?? 'Regular Member' }}</dd></div>
            <div><dt>Application Type</dt><dd>{{ $app?->application_type ?? 'New Application' }}</dd></div>
            <div><dt>Application Date</dt><dd>{{ $app?->application_date ?? now()->format('m/d/Y') }}</dd></div>
            <div><dt>Application Status</dt><dd><x-portal.status-badge :status="$app?->status ?? 'Under Evaluation'" /></dd></div>
        </x-portal.info-card>

        <x-portal.info-card title="Recommender">
            <div><dt>Suffix</dt><dd>{{ $app?->recommender_suffix ?? '—' }}</dd></div>
            <div>
                <dt>Primary Recommender</dt>
                <dd>{{ $app ? ($app->recommender_first_name ? trim("{$app->recommender_first_name} {$app->recommender_surname}") : ($app->recommender_name ?: '—')) : 'Sample Name' }}</dd>
            </div>
            <div><dt>Email</dt><dd>{{ $app?->recommender_email ?? 'example@email.com' }}</dd></div>
            <div><dt>Alternate Recommender</dt><dd>{{ $app?->alt_recommender_name ?? '—' }}</dd></div>
            <div><dt>Alternate Email</dt><dd>{{ $app?->alt_recommender_email ?? '—' }}</dd></div>
        </x-portal.info-card>

        <x-portal.info-card title="Personal Information">
            <div><dt>Surname</dt><dd>{{ $app?->surname ?? 'Sample' }}</dd></div>
            <div><dt>First Name(s)</dt><dd>{{ $app?->first_name ?? 'Sample Name' }}</dd></div>
            <div><dt>Middle Name(s)</dt><dd>{{ $app?->middle_name ?? '—' }}</dd></div>
            <div><dt>Mobile Number</dt><dd>{{ $app?->mobile_number ?? '0988-123-4567' }}</dd></div>
            <div><dt>Secondary Mobile (Optional)</dt><dd>{{ $app?->alt_mobile_number ?? '—' }}</dd></div>
            <div><dt>Email Address</dt><dd>{{ $app?->account_email ?? (auth()->user()?->email ?? 'example@email.com') }}</dd></div>
        </x-portal.info-card>

        <x-portal.info-card title="Professional Information">
            <div><dt>Current Institutional Affiliation</dt><dd>{{ $app?->current_affiliation ?? 'Sample Institution' }}</dd></div>
            <div><dt>Current Position</dt><dd>{{ $app?->current_position ?? 'Sample' }}</dd></div>
            <div><dt>Professional / Institutional Email</dt><dd>{{ $app?->institutional_email ?? 'example@email.com' }}</dd></div>
        </x-portal.info-card>

        <x-portal.info-card title="Educational Information">
            <div><dt>Highest Educational Attainment (Degree)</dt><dd>{{ $app?->highest_educational_attainment ?? 'Sample' }}</dd></div>
            <div><dt>Date Degree Obtained</dt><dd>{{ $app?->date_degree_obtained ?? 'MM/YYYY' }}</dd></div>
            <div><dt>Institution</dt><dd>{{ $app?->institution_name ?? 'Sample Institution' }}</dd></div>
            <div><dt>Institution Address</dt><dd>{{ $app?->institution_address ?? 'Sample' }}</dd></div>
        </x-portal.info-card>

        <section class="portal-card portal-info-card">
            <h2>Documents</h2>
            
            {{-- Updated CV Card --}}
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 14px 0; border-bottom: 1px dashed var(--portal-border); flex-wrap: wrap; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 38px; height: 38px; border-radius: 8px; background: var(--portal-surface-soft); border: 1px solid var(--portal-border); color: var(--portal-text); display: grid; place-items: center; flex-shrink: 0;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                    </div>
                    <div>
                        <strong style="color: var(--portal-text); font-size: 0.95rem;">Updated Curriculum Vitae (CV)</strong>
                        <div style="font-size: 0.78rem; color: var(--portal-muted);">
                            {{ $app?->cv_path ? 'Document uploaded and attached' : 'Curriculum Vitae (PDF)' }}
                        </div>
                    </div>
                </div>
                <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                    @if($cvUrl)
                        <a href="{{ $cvUrl }}" target="_blank" rel="noopener noreferrer" class="portal-button" style="text-decoration: none; font-size: 0.82rem; padding: 7px 16px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                            View CV
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                        </a>
                    @else
                        <span class="portal-badge portal-badge-pending">Not Uploaded</span>
                    @endif
                </div>
            </div>

            {{-- Proof Card --}}
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 14px 0; flex-wrap: wrap; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 38px; height: 38px; border-radius: 8px; background: var(--portal-surface-soft); border: 1px solid var(--portal-border); color: var(--portal-text); display: grid; place-items: center; flex-shrink: 0;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path></svg>
                    </div>
                    <div>
                        <strong style="color: var(--portal-text); font-size: 0.95rem;">Proof of Employment / Enrollment</strong>
                        <div style="font-size: 0.78rem; color: var(--portal-muted);">
                            {{ $app?->proof_path ? 'Document uploaded and attached' : 'ID or Certificate' }}
                        </div>
                    </div>
                </div>
                <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                    @if($proofUrl)
                        <a href="{{ $proofUrl }}" target="_blank" rel="noopener noreferrer" class="portal-button" style="text-decoration: none; font-size: 0.82rem; padding: 7px 16px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                            View Proof
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                        </a>
                    @else
                        <span class="portal-badge portal-badge-pending">Not Uploaded</span>
                    @endif
                </div>
            </div>
        </section>

        <x-portal.info-card title="Validation / Certification">
            <div><dt>Declaration</dt><dd>{{ ($app && $app->declaration_agree) ? 'Agreed' : 'Agreed' }}</dd></div>
            <div><dt>Certification</dt><dd>{{ ($app && $app->certification_email) ? 'Certified via ' . $app->certification_email : 'Confirmed' }}</dd></div>
        </x-portal.info-card>
    </div>
</x-layouts.portal>
