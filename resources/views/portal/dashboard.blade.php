<x-layouts.portal title="Dashboard | SPP Membership Portal">
    <div class="portal-page-header">
        <div><p class="portal-eyebrow">Membership portal</p><h1>Welcome, Sample Name</h1></div>
    </div>

    <div class="portal-summary-grid">
        <article class="portal-summary-card"><span>Membership Status</span><x-portal.status-badge status="Pending" /></article>
        <article class="portal-summary-card"><span>Membership Type</span><strong>Regular Member</strong></article>
        <article class="portal-summary-card"><span>Application Date</span><strong>MM/DD/YYYY</strong></article>
    </div>

    <div class="portal-page-grid">
        <section class="portal-card"><div class="portal-section-heading"><h2>Application Progress</h2></div><x-portal.timeline :steps="['Account Created', 'Application Submitted', 'Under Evaluation', 'Approved']" :current="2" /></section>
        <section class="portal-card"><div class="portal-section-heading"><h2>Quick Actions</h2></div><div class="portal-action-grid"><a class="portal-button" href="{{ route('membership-portal.application') }}">View Application</a><a class="portal-button" href="{{ route('membership-portal.membership') }}">View Membership</a><a class="portal-button" href="{{ route('membership-portal.inquiries') }}">Submit Inquiry</a><a class="portal-button" href="{{ route('membership-portal.notifications') }}">View Notifications</a></div></section>
    </div>

    <section class="portal-card">
        <div class="portal-section-heading"><h2>Recent Notifications</h2><a class="portal-text-link" href="{{ route('membership-portal.notifications') }}">View all</a></div>
        <ul class="portal-notification-list">
            @foreach ($announcements ?? [] as $item)
                <li>
                    <strong>{{ $item->title }}</strong>
                    <span>{{ $item->summary ?: \Illuminate\Support\Str::limit(strip_tags($item->content), 120) }}</span>
                </li>
            @endforeach
            <li><strong>Application Submitted</strong><span>Your application was submitted.</span></li>
            <li><strong>Application Under Evaluation</strong><span>Your application is currently being reviewed.</span></li>
            <li><strong>Additional Information Required</strong><span>Please review your application.</span></li>
        </ul>
    </section>
</x-layouts.portal>
