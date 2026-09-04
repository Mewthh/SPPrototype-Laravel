<header class="site-header">
    <div class="shell header-inner">
        <a class="brand" href="{{ route('home') }}" aria-label="Samahang Pisika ng Pilipinas home">
            <span class="brand-mark" aria-hidden="true">SPP</span>
            <span class="brand-copy">
                <strong>Samahang Pisika ng Pilipinas</strong>
                <span>Physics Society of the Philippines</span>
            </span>
        </a>

        <div class="header-nav-group">
            <nav class="desktop-nav" aria-label="Primary navigation">
                <a href="{{ route('home') }}#news">News</a>
                <a href="{{ route('home') }}#activities">Activities</a>
                <div class="nav-dropdown">
                    <a href="#resources" class="nav-dropdown-toggle">Resources <span
                            class="dropdown-chevron">&#x25BE;</span></a>
                    <div class="nav-dropdown-panel" aria-label="Resources submenu">
                        <a href="#membership-faq">Membership FAQ</a>
                        <a href="https://proceedings.spp-online.org/" target="_blank"
                            rel="noopener noreferrer">Proceedings of the SPP</a>
                        <a href="#videos-webinars">Videos and Webinars</a>
                        <a href="https://paperview.spp-online.org/" target="_blank" rel="noopener noreferrer">Pisika
                            Journal</a>
                    </div>
                </div>
                <a href="#downloads">Downloads</a>
                <a href="#about">About SPP</a>
                <details class="year-menu">
                    <summary aria-label="Open conference year choices">&#x22EF;</summary>
                    <div class="year-menu-panel" aria-label="Conference year choices">
                        @php
                            $confs = isset($headerConferences) && $headerConferences->isNotEmpty() 
                                ? $headerConferences 
                                : collect([
                                    (object)['year' => '2026', 'title' => 'SPP2026'],
                                    (object)['year' => '2025', 'title' => 'SPP2025'],
                                    (object)['year' => '2024', 'title' => 'SPP2024'],
                                ]);
                            $topConfs = $confs->take(3);
                            $moreConfs = $confs->slice(3);
                        @endphp

                        @php
                            $getConfLabel = function($item) {
                                $rawYear = trim($item->year ?? '');
                                $rawTitle = trim($item->title ?? '');
                                
                                // If title starts with SPP (case-insensitive), e.g. "SPP2027" or "SPP 2027", clean it
                                if (preg_match('/^spp\s*(\d{4}|\w+)/i', $rawTitle, $m)) {
                                    return 'SPP' . $m[1];
                                }
                                if (!empty($rawYear)) {
                                    return preg_match('/^spp/i', $rawYear) ? strtoupper($rawYear) : 'SPP' . $rawYear;
                                }
                                if (!empty($rawTitle)) {
                                    return preg_match('/^spp/i', $rawTitle) ? $rawTitle : 'SPP ' . $rawTitle;
                                }
                                return 'SPP';
                            };
                            $getConfTarget = function($item) {
                                return $item->year ?: ($item->title ?: $item->id);
                            };
                        @endphp

                        @foreach($topConfs as $c)
                            <a href="{{ route('spp.show', ['year' => $getConfTarget($c)]) }}"
                                id="year-btn-{{ $c->year ?? Str::slug($c->title ?? $c->id) }}"
                                class="year-menu-link">{{ $getConfLabel($c) }}</a>
                        @endforeach

                        @if($moreConfs->isNotEmpty())
                            <details class="year-menu-more">
                                <summary class="year-menu-more-trigger">Show more &#x25BE;</summary>
                                <div class="year-menu-more-list">
                                    @foreach($moreConfs as $c)
                                        <a href="{{ route('spp.show', ['year' => $getConfTarget($c)]) }}"
                                            id="year-btn-{{ $c->year ?? Str::slug($c->title ?? $c->id) }}"
                                            class="year-menu-link">{{ $getConfLabel($c) }}</a>
                                    @endforeach
                                </div>
                            </details>
                        @endif
                    </div>
                </details>
            </nav>
        </div>

        <div class="header-tools">
            <form class="search-box" role="search">
                <input type="search" aria-label="Search the dashboard" placeholder="Search" />
                <button type="submit" aria-label="Search">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </button>
            </form>

            <a class="btn-login-header" href="{{ route('login') }}" aria-label="Log in">Log In</a>
            <a class="btn-join-spp" href="#about">Join SPP</a>

            <details class="mobile-nav">
                <summary class="mobile-nav-toggle" aria-label="Open menu">
                    <span class="hamburger" aria-hidden="true">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                    <span class="mobile-nav-label">Menu</span>
                </summary>
                <nav class="mobile-nav-panel" aria-label="Mobile navigation">
                    <a href="{{ route('home') }}#news">News</a>
                    <a href="{{ route('home') }}#activities">Activities</a>
                    <details class="mobile-sub-menu">
                        <summary>Resources <span class="dropdown-chevron">&#x25BE;</span></summary>
                        <div class="mobile-sub-menu-panel">
                            <a href="#membership-faq">Membership FAQ</a>
                            <a href="https://proceedings.spp-online.org/" target="_blank"
                                rel="noopener noreferrer">Proceedings of the SPP</a>
                            <a href="#videos-webinars">Videos and Webinars</a>
                            <a href="https://paperview.spp-online.org/" target="_blank" rel="noopener noreferrer">Pisika
                                Journal</a>
                        </div>
                    </details>
                    <a href="#downloads">Downloads</a>
                    <a href="#about">About SPP</a>
                    <div class="mobile-nav-years" aria-label="Conference year choices">
                        @foreach($topConfs as $c)
                            <a href="{{ route('spp.show', ['year' => $getConfTarget($c)]) }}"
                                id="mob-year-btn-{{ $c->year ?? Str::slug($c->title ?? $c->id) }}"
                                class="year-menu-link">{{ $getConfLabel($c) }}</a>
                        @endforeach

                        @if($moreConfs->isNotEmpty())
                            <details class="mobile-sub-menu" style="margin-top: 4px;">
                                <summary style="font-size: 0.9rem; padding: 6px 12px; cursor: pointer; color: var(--text-muted, #64748b);">More Conferences <span class="dropdown-chevron">&#x25BE;</span></summary>
                                <div class="mobile-sub-menu-panel" style="padding: 4px 0;">
                                    @foreach($moreConfs as $c)
                                        <a href="{{ route('spp.show', ['year' => $getConfTarget($c)]) }}"
                                            id="mob-year-btn-{{ $c->year ?? Str::slug($c->title ?? $c->id) }}"
                                            class="year-menu-link">{{ $getConfLabel($c) }}</a>
                                    @endforeach
                                </div>
                            </details>
                        @endif
                    </div>
                    <a class="btn-login-header mobile" href="{{ route('login') }}">Log In</a>
                    <a class="btn-join-spp mobile" href="#about">Join SPP</a>

                </nav>
            </details>
        </div>
    </div>
</header>