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
                        <a href="{{ route('spp.show', ['year' => '2024']) }}" id="year-btn-2024"
                            class="year-menu-link">SPP2024</a>
                        <a href="{{ route('spp.show', ['year' => '2025']) }}" id="year-btn-2025"
                            class="year-menu-link">SPP2025</a>
                        <a href="{{ route('spp.show', ['year' => '2026']) }}" id="year-btn-2026"
                            class="year-menu-link">SPP2026</a>
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

            <a class="btn-login-header" href="javascript:void(0)" aria-label="Log in">Log In</a>
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
                        <a href="{{ route('spp.show', ['year' => '2024']) }}" id="mob-year-btn-2024"
                            class="year-menu-link">SPP2024</a>
                        <a href="{{ route('spp.show', ['year' => '2025']) }}" id="mob-year-btn-2025"
                            class="year-menu-link">SPP2025</a>
                        <a href="{{ route('spp.show', ['year' => '2026']) }}" id="mob-year-btn-2026"
                            class="year-menu-link">SPP2026</a>
                    </div>
                    <a class="btn-login-header mobile" href="javascript:void(0)">Log In</a>
                    <a class="btn-join-spp mobile" href="#about">Join SPP</a>

                </nav>
            </details>
        </div>
    </div>
</header>