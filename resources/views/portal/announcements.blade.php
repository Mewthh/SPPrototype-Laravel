<x-layouts.portal title="Announcements | SPP Membership Portal">
    <div class="portal-page-header">
        <div><p class="portal-eyebrow">Membership portal</p><h1>Announcements</h1></div>
    </div>

    <div class="announce-feed" id="announce-feed">

        {{-- Post 1 --}}
        <article class="announce-post">
            <header class="announce-post-header">
                <div class="announce-avatar" aria-hidden="true">SPP</div>
                <div class="announce-meta">
                    <strong class="announce-author">Samahang Pisika ng Pilipinas</strong>
                    <time class="announce-time" datetime="2025-09-30">September 30, 2025</time>
                </div>
            </header>
            <div class="announce-body">
                <h2 class="announce-title">Annual Conference 2025 – Registration Now Open</h2>
                <p>We are pleased to announce that registration for the <strong>SPP Annual National Physics Conference 2025</strong> is now open! Join fellow physicists, researchers, and students for three days of talks, workshops, and networking.</p>
                <p>Early-bird registration ends <strong>October 15, 2025</strong>. Visit the website for full details and the program schedule.</p>
            </div>
        </article>

        {{-- Post 2 --}}
        <article class="announce-post">
            <header class="announce-post-header">
                <div class="announce-avatar" aria-hidden="true">SPP</div>
                <div class="announce-meta">
                    <strong class="announce-author">Samahang Pisika ng Pilipinas</strong>
                    <time class="announce-time" datetime="2025-09-15">September 15, 2025</time>
                </div>
            </header>
            <div class="announce-body">
                <h2 class="announce-title">Membership Renewal for 2026</h2>
                <p>Members are reminded that <strong>membership renewals for the year 2026</strong> will begin on <strong>November 1, 2025</strong>. Please ensure your contact information and institutional affiliation are up to date in your profile before renewing.</p>
                <p>Kindly use the Inquiries tab if you have questions about your membership status.</p>
            </div>
        </article>

        {{-- Post 3 --}}
        <article class="announce-post">
            <header class="announce-post-header">
                <div class="announce-avatar" aria-hidden="true">SPP</div>
                <div class="announce-meta">
                    <strong class="announce-author">Samahang Pisika ng Pilipinas</strong>
                    <time class="announce-time" datetime="2025-09-01">September 1, 2025</time>
                </div>
            </header>
            <div class="announce-body">
                <h2 class="announce-title">Call for Papers – SPP 2025</h2>
                <p>The SPP invites submissions of abstracts for oral and poster presentations at the <strong>2025 Annual Conference</strong>. Topics include condensed matter physics, photonics, biophysics, physics education, and more.</p>
                <p>Submission deadline: <strong>September 20, 2025</strong>.</p>
            </div>
        </article>

        {{-- Post 4 --}}
        <article class="announce-post">
            <header class="announce-post-header">
                <div class="announce-avatar" aria-hidden="true">SPP</div>
                <div class="announce-meta">
                    <strong class="announce-author">Samahang Pisika ng Pilipinas</strong>
                    <time class="announce-time" datetime="2025-08-20">August 20, 2025</time>
                </div>
            </header>
            <div class="announce-body">
                <h2 class="announce-title">Welcome to the SPP Membership Portal</h2>
                <p>We are excited to launch the new <strong>SPP Membership Portal</strong>! You can now track your application status, view your membership certificate, submit inquiries, and manage your personal information — all in one place.</p>
                <p>If you encounter any issues, please reach out through the Inquiries tab.</p>
            </div>
        </article>

        {{-- Post 5 --}}
        <article class="announce-post">
            <header class="announce-post-header">
                <div class="announce-avatar" aria-hidden="true">SPP</div>
                <div class="announce-meta">
                    <strong class="announce-author">Samahang Pisika ng Pilipinas</strong>
                    <time class="announce-time" datetime="2025-07-10">July 10, 2025</time>
                </div>
            </header>
            <div class="announce-body">
                <h2 class="announce-title">SPP Research Grant Applications Open</h2>
                <p>The SPP is now accepting applications for its <strong>2025 Research Grant Program</strong>. Grants are available for student research, faculty-led projects, and collaborative institutional studies.</p>
                <p>Applications must be submitted by <strong>August 31, 2025</strong>.</p>
            </div>
        </article>

        {{-- Post 6 (hidden by default) --}}
        <article class="announce-post announce-post-extra" hidden>
            <header class="announce-post-header">
                <div class="announce-avatar" aria-hidden="true">SPP</div>
                <div class="announce-meta">
                    <strong class="announce-author">Samahang Pisika ng Pilipinas</strong>
                    <time class="announce-time" datetime="2025-06-05">June 5, 2025</time>
                </div>
            </header>
            <div class="announce-body">
                <h2 class="announce-title">New Partnership with National Research Council</h2>
                <p>The SPP is proud to announce a new partnership with the <strong>National Research Council of the Philippines</strong>, aimed at promoting physics research and expanding opportunities for Filipino physicists nationwide.</p>
            </div>
        </article>

        {{-- Post 7 (hidden by default) --}}
        <article class="announce-post announce-post-extra" hidden>
            <header class="announce-post-header">
                <div class="announce-avatar" aria-hidden="true">SPP</div>
                <div class="announce-meta">
                    <strong class="announce-author">Samahang Pisika ng Pilipinas</strong>
                    <time class="announce-time" datetime="2025-05-18">May 18, 2025</time>
                </div>
            </header>
            <div class="announce-body">
                <h2 class="announce-title">Physics Olympiad Coaching Program</h2>
                <p>SPP will be conducting a <strong>coaching program</strong> for students joining the International Physics Olympiad (IPhO) 2026. Interested mentors and institutions may coordinate with the SPP secretariat for details.</p>
            </div>
        </article>

    </div>

    <div class="announce-toggle-wrap" id="announce-toggle-wrap" style="display: none;">
        <button type="button" class="announce-toggle-btn" id="announce-show-more" data-announce-toggle="more">
            Show More
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <button type="button" class="announce-toggle-btn" id="announce-show-less" data-announce-toggle="less" hidden>
            Show Less
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18 15l-6-6-6 6"/></svg>
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const extras = document.querySelectorAll('.announce-post-extra');
            const toggleWrap = document.getElementById('announce-toggle-wrap');
            const showMore = document.getElementById('announce-show-more');
            const showLess = document.getElementById('announce-show-less');

            if (extras.length > 0) {
                toggleWrap.style.display = '';

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
            gap: 20px;
            margin: 0 auto;
            max-width: 680px;
            width: 100%;
        }

        .announce-post {
            background: var(--portal-card-bg);
            border: 1px solid var(--portal-border);
            border-radius: 14px;
            box-shadow: var(--portal-shadow);
            overflow: hidden;
        }

        .announce-post-header {
            align-items: center;
            display: flex;
            gap: 12px;
            padding: 18px 20px 0;
        }

        .announce-avatar {
            align-items: center;
            background: var(--portal-accent-strong);
            border-radius: 50%;
            color: var(--portal-bg);
            display: grid;
            flex-shrink: 0;
            font-size: 0.65rem;
            font-weight: 800;
            height: 42px;
            letter-spacing: 0.5px;
            place-items: center;
            width: 42px;
        }

        .announce-meta {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .announce-author {
            color: var(--portal-text);
            font-size: 0.9rem;
        }

        .announce-time {
            color: var(--portal-muted);
            font-size: 0.78rem;
        }

        .announce-body {
            padding: 14px 20px 16px;
        }

        .announce-title {
            color: var(--portal-text);
            font-size: 1rem;
            font-weight: 700;
            margin: 0 0 10px;
        }

        .announce-body p {
            color: var(--portal-muted);
            font-size: 0.88rem;
            line-height: 1.65;
            margin: 0 0 8px;
        }

        .announce-body p:last-child {
            margin-bottom: 0;
        }

        .announce-body strong {
            color: var(--portal-text);
        }

        .announce-post-footer {
            border-top: 1px solid var(--portal-border);
            padding: 12px 20px;
        }

        .announce-link {
            color: var(--portal-accent);
            font-size: 0.83rem;
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
            margin: 16px auto 0;
            max-width: 680px;
            padding-bottom: 8px;
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
            font-size: 0.85rem;
            font-weight: 600;
            gap: 6px;
            padding: 8px 22px;
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
