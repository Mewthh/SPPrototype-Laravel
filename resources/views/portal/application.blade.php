@php
    $app = auth()->user()?->applications()->latest()->first();
@endphp

<x-layouts.portal title="My Application | SPP Membership Portal">
    <div class="portal-page-header">
        <div>
            <p class="portal-eyebrow">Application</p>
            <h1>My Application</h1>
        </div>
        <x-portal.status-badge :status="$app?->status ?? 'Under Evaluation'" />
    </div>

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
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px dashed var(--portal-border);">
                <div>
                    <strong>Updated CV</strong>
                    <div style="font-size: 0.78rem; color: var(--portal-muted);">Curriculum Vitae (PDF)</div>
                </div>
                <div>
                    @if($app?->cv_path)
                        <a href="{{ asset('storage/' . $app->cv_path) }}" target="_blank" class="portal-badge portal-badge-active" style="text-decoration: underline;">View Uploaded File</a>
                    @else
                        <span class="portal-badge portal-badge-pending">Not Uploaded</span>
                    @endif
                </div>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0;">
                <div>
                    <strong>Proof of Employment / Enrollment</strong>
                    <div style="font-size: 0.78rem; color: var(--portal-muted);">ID or Certificate</div>
                </div>
                <div>
                    @if($app?->proof_path)
                        <a href="{{ asset('storage/' . $app->proof_path) }}" target="_blank" class="portal-badge portal-badge-active" style="text-decoration: underline;">View Uploaded File</a>
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
