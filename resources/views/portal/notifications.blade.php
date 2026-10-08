<x-layouts.portal title="Notifications | SPP Membership Portal">
    <div class="portal-page-header"><div><p class="portal-eyebrow">Updates</p><h1>Notifications</h1></div></div>
    <section class="portal-card">
        <ul class="portal-notification-list portal-notification-list-spaced">
            @foreach ($announcements ?? [] as $item)
                <li>
                    <div style="display: flex; justify-content: space-between; align-items: baseline; gap: 8px;">
                        <strong>{{ $item->title }}</strong>
                        <span style="font-size: 0.75rem; color: var(--portal-muted);">{{ $item->created_at?->format('M d, Y') }}</span>
                    </div>
                    <span>{{ $item->summary ?: \Illuminate\Support\Str::limit(strip_tags($item->content), 140) }}</span>
                </li>
            @endforeach
            <li><strong>Application Submitted</strong><span>Your application was submitted.</span></li>
            <li><strong>Application Under Evaluation</strong><span>Your application is currently being reviewed.</span></li>
            <li><strong>Additional Information Required</strong><span>Please review your application.</span></li>
        </ul>
    </section>
</x-layouts.portal>
