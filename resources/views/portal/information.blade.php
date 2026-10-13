@php
    $app = auth()->user()?->applications()->latest()->first();
@endphp

<x-layouts.portal title="My Information | SPP Membership Portal">
    <div class="portal-page-header">
        <div>
            <p class="portal-eyebrow">Member record</p>
            <h1>My Information</h1>
        </div>
        <button type="button" class="portal-button">Request Update</button>
    </div>
    <div class="portal-information-grid portal-information-grid-single">
        <x-portal.info-card title="Personal">
            <div><dt>Surname</dt><dd>{{ $app?->surname ?? 'Sample' }}</dd></div>
            <div><dt>First Name(s)</dt><dd>{{ $app?->first_name ?? 'Sample Name' }}</dd></div>
            <div><dt>Middle Name</dt><dd>{{ $app?->middle_name ?? '—' }}</dd></div>
            <div><dt>Mobile Number</dt><dd>{{ $app?->mobile_number ?? '0988-123-4567' }}</dd></div>
            @if($app?->alt_mobile_number)
                <div><dt>Secondary Mobile (Optional)</dt><dd>{{ $app->alt_mobile_number }}</dd></div>
            @endif
            <div><dt>Email</dt><dd>{{ $app?->account_email ?? (auth()->user()?->email ?? 'example@email.com') }}</dd></div>
        </x-portal.info-card>
        <x-portal.info-card title="Professional">
            <div><dt>Current Institutional Affiliation</dt><dd>{{ $app?->current_affiliation ?? 'Sample Institution' }}</dd></div>
            <div><dt>Current Position</dt><dd>{{ $app?->current_position ?? 'Sample' }}</dd></div>
            <div><dt>Professional / Institutional Email</dt><dd>{{ $app?->institutional_email ?? 'example@email.com' }}</dd></div>
        </x-portal.info-card>
        <x-portal.info-card title="Educational">
            <div><dt>Highest Educational Attainment (Degree)</dt><dd>{{ $app?->highest_educational_attainment ?? 'Sample' }}</dd></div>
            <div><dt>Institution</dt><dd>{{ $app?->institution_name ?? 'Sample Institution' }}</dd></div>
            <div><dt>Institution Address</dt><dd>{{ $app?->institution_address ?? 'Sample' }}</dd></div>
            <div><dt>Date Degree Obtained</dt><dd>{{ $app?->date_degree_obtained ?? 'MM/YYYY' }}</dd></div>
        </x-portal.info-card>
    </div>
</x-layouts.portal>
