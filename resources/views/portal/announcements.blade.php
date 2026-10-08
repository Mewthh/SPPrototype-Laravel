<x-layouts.portal title="Announcements | SPP Membership Portal">
    <div class="portal-page-header">
        <div><p class="portal-eyebrow">Membership portal</p><h1>Announcements</h1></div>
    </div>

    <div class="announce-feed" id="announce-feed">

        @forelse ($announcements as $index => $announcement)
            <article class="announce-post {{ $index >= 5 ? 'announce-post-extra' : '' }}" {{ $index >= 5 ? 'hidden' : '' }}>
                <header class="announce-post-header">
                    <div class="announce-avatar" aria-hidden="true">SPP</div>
                    <div class="announce-meta">
                        <strong class="announce-author">Samahang Pisika ng Pilipinas</strong>
                        <div class="announce-meta-row">
                            <time class="announce-time" datetime="{{ $announcement->created_at?->format('Y-m-d') }}">{{ $announcement->created_at?->format('F j, Y') ?? 'Recently' }}</time>
                            <span class="announce-audience-badge announce-audience-{{ $announcement->target_audience }}">
                                @if ($announcement->target_audience === 'institutional')
                                    <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                                @elseif ($announcement->target_audience === 'regular' || $announcement->target_audience === 'associate')
                                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                @else
                                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                @endif
                                {{ $announcement->audience_label }}
                            </span>
                        </div>
                    </div>
                </header>
                <div class="announce-body">
                    <h2 class="announce-title">{{ $announcement->title }}</h2>
                    <div class="announce-content">
                        {!! nl2br(e($announcement->content)) !!}
                    </div>
                </div>
            </article>
        @empty
            <div class="announce-empty-state">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <h3>No announcements yet</h3>
                <p>There are no announcements published at this time. Please check back later for updates from Samahang Pisika ng Pilipinas.</p>
            </div>
        @endforelse

    </div>

    @if (count($announcements) > 5)
        <div class="announce-toggle-wrap" id="announce-toggle-wrap">
            <button type="button" class="announce-toggle-btn" id="announce-show-more" data-announce-toggle="more">
                Show More
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
            </button>
            <button type="button" class="announce-toggle-btn" id="announce-show-less" data-announce-toggle="less" hidden>
                Show Less
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18 15l-6-6-6 6"/></svg>
            </button>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const extras = document.querySelectorAll('.announce-post-extra');
            const showMore = document.getElementById('announce-show-more');
            const showLess = document.getElementById('announce-show-less');

            if (extras.length > 0 && showMore && showLess) {
                showMore.addEventListener('click', () => {
                    extras.forEach(p => p.hidden = false);
                    showMore.hidden = true;
                    showLess.hidden = false;
                });

                showLess.addEventListener('click', () => {
                    extras.forEach(p => p.hidden = true);
                    showMore.hidden = false;
                    showLess.hidden = true;
                    document.getElementById('announce-feed').scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            }
        });
    </script>

    <style>
        .announce-feed {
            display: flex;
            flex-direction: column;
            gap: 28px;
            margin: 0 auto;
            max-width: 860px;
            width: 100%;
        }

        .announce-post {
            background: var(--portal-card-bg);
            border: 1px solid var(--portal-border);
            border-radius: 18px;
            box-shadow: var(--portal-shadow);
            overflow: hidden;
        }

        .announce-post-header {
            align-items: center;
            display: flex;
            gap: 16px;
            padding: 24px 30px 0;
        }

        .announce-avatar {
            align-items: center;
            background: var(--portal-accent-strong);
            border-radius: 50%;
            color: var(--portal-bg);
            display: grid;
            flex-shrink: 0;
            font-size: 0.82rem;
            font-weight: 800;
            height: 52px;
            letter-spacing: 0.5px;
            place-items: center;
            width: 52px;
        }

        .announce-meta {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .announce-meta-row {
            align-items: center;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .announce-author {
            color: var(--portal-text);
            font-size: 1.05rem;
            font-weight: 700;
        }

        .announce-time {
            color: var(--portal-muted);
            font-size: 0.86rem;
        }

        .announce-audience-badge {
            align-items: center;
            border-radius: 999px;
            display: inline-flex;
            font-size: 0.8rem;
            font-weight: 700;
            gap: 6px;
            letter-spacing: 0.01em;
            padding: 3px 11px 3px 8px;
        }

        .announce-audience-badge svg {
            fill: none;
            flex-shrink: 0;
            height: 14px;
            stroke: currentColor;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-width: 2;
            width: 14px;
        }

        .announce-audience-all,
        .announce-audience-regular,
        .announce-audience-associate,
        .announce-audience-institutional {
            background: color-mix(in srgb, var(--portal-muted) 10%, transparent);
            border: 1px solid color-mix(in srgb, var(--portal-muted) 25%, transparent);
            color: var(--portal-muted);
        }

        .announce-body {
            padding: 20px 30px 28px;
        }

        .announce-title {
            color: var(--portal-text);
            font-size: 1.4rem;
            font-weight: 800;
            line-height: 1.35;
            margin: 0 0 14px;
        }

        .announce-content {
            color: var(--portal-muted);
            font-size: 1.02rem;
            line-height: 1.75;
        }

        .announce-empty-state {
            align-items: center;
            background: var(--portal-card-bg);
            border: 1px dashed var(--portal-border);
            border-radius: 18px;
            box-shadow: var(--portal-shadow);
            color: var(--portal-muted);
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 64px 32px;
            text-align: center;
        }

        .announce-empty-state svg {
            opacity: 0.5;
            width: 48px;
            height: 48px;
        }

        .announce-empty-state h3 {
            color: var(--portal-text);
            font-size: 1.25rem;
            font-weight: 700;
            margin: 4px 0 0;
        }

        .announce-empty-state p {
            color: var(--portal-muted);
            font-size: 0.98rem;
            line-height: 1.6;
            margin: 0;
            max-width: 520px;
        }

        .announce-post-footer {
            border-top: 1px solid var(--portal-border);
            padding: 16px 30px;
        }

        .announce-link {
            color: var(--portal-accent);
            font-size: 0.92rem;
            font-weight: 600;
            text-decoration: none;
        }

        .announce-link:hover {
            color: var(--portal-accent-strong);
            text-decoration: underline;
        }

        .announce-toggle-wrap {
            display: flex;
            justify-content: center;
            margin: 24px auto 0;
            max-width: 860px;
            padding-bottom: 12px;
            width: 100%;
        }

        .announce-toggle-btn {
            align-items: center;
            background: var(--portal-card-bg);
            border: 1px solid var(--portal-border);
            border-radius: 999px;
            color: var(--portal-accent);
            cursor: pointer;
            display: flex;
            font-size: 0.92rem;
            font-weight: 600;
            gap: 7px;
            padding: 10px 28px;
            transition: background 0.18s, color 0.18s;
        }

        .announce-toggle-btn:hover {
            background: var(--portal-accent-soft);
            color: var(--portal-accent-strong);
        }

        .announce-toggle-btn svg {
            height: 16px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
            width: 16px;
        }
    </style>
</x-layouts.portal>
