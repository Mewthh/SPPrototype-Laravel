<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SPP | Samahang Pisika ng Pilipinas</title>
    <meta name="description" content="SPP conference year page &mdash; Samahang Pisika ng Pilipinas." />
    <link rel="stylesheet" href="{{ asset('styles.css') }}" />
    <script src="{{ asset('spp.js') }}" defer></script>
</head>

<body>
    <a class="skip-link" href="#main-content">Skip to content</a>

    <header class="site-header">
        <div class="shell header-inner">
            <a class="brand" href="{{ url('/') }}" aria-label="Samahang Pisika ng Pilipinas home">
                <span class="brand-mark" aria-hidden="true">SPP</span>
                <span class="brand-copy">
                    <strong>Samahang Pisika ng Pilipinas</strong>
                    <span>sample text</span>
                </span>
            </a>

            <div class="header-nav-group">
                <nav class="desktop-nav" aria-label="Primary navigation">
                    <a href="{{ url('/') }}#news">News</a>
                    <a href="{{ url('/') }}#activities">Activities</a>
                    <div class="nav-dropdown">
                        <a href="{{ url('/') }}#resources" class="nav-dropdown-toggle">Resources <span class="dropdown-chevron">&#x25BE;</span></a>
                        <div class="nav-dropdown-panel" aria-label="Resources submenu">
                            <a href="#membership-faq">Membership FAQ</a>
                            <a href="https://proceedings.spp-online.org/" target="_blank" rel="noopener noreferrer">Proceedings of the SPP</a>
                            <a href="#videos-webinars">Videos and Webinars</a>
                            <a href="https://paperview.spp-online.org/" target="_blank" rel="noopener noreferrer">Pisika Journal</a>
                        </div>
                    </div>
                    <a href="{{ url('/') }}#downloads">Downloads</a>
                    <a href="{{ url('/') }}#about">About SPP</a>
                    <details class="year-menu">
                        <summary aria-label="Open conference year choices">&#x22EF;</summary>
                        <div class="year-menu-panel" aria-label="Conference year choices">
                            <a href="spp.html?year=2024" id="nav-year-2024" class="year-menu-link">SPP2024</a>
                            <a href="spp.html?year=2025" id="nav-year-2025" class="year-menu-link">SPP2025</a>
                            <a href="spp.html?year=2026" id="nav-year-2026" class="year-menu-link">SPP2026</a>
                        </div>
                    </details>
                </nav>
            </div>

            <div class="header-tools">
                <form class="search-box" role="search">
                    <input type="search" aria-label="Search the dashboard" placeholder="Search" />
                    <button type="submit">Search</button>
                </form>

                <button class="theme-toggle" type="button" data-theme-toggle aria-label="Switch to dark mode">
                    <span class="theme-icon theme-icon-moon" aria-hidden="true">&#x263E;</span>
                    <span class="theme-icon theme-icon-sun" aria-hidden="true">&#x2600;</span>
                </button>

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
                        <a href="{{ url('/') }}#news">News</a>
                        <a href="{{ url('/') }}#activities">Activities</a>
                        <details class="mobile-sub-menu">
                            <summary>Resources <span class="dropdown-chevron">&#x25BE;</span></summary>
                            <div class="mobile-sub-menu-panel">
                                <a href="#membership-faq">Membership FAQ</a>
                                <a href="https://proceedings.spp-online.org/" target="_blank" rel="noopener noreferrer">Proceedings of the SPP</a>
                                <a href="#videos-webinars">Videos and Webinars</a>
                                <a href="https://paperview.spp-online.org/" target="_blank" rel="noopener noreferrer">Pisika Journal</a>
                            </div>
                        </details>
                        <a href="{{ url('/') }}#downloads">Downloads</a>
                        <a href="{{ url('/') }}#about">About SPP</a>
                        <div class="mobile-nav-years" aria-label="Conference year choices">
                            <a href="spp.html?year=2024" id="mobile-nav-year-2024" class="year-menu-link">SPP2024</a>
                            <a href="spp.html?year=2025" id="mobile-nav-year-2025" class="year-menu-link">SPP2025</a>
                            <a href="spp.html?year=2026" id="mobile-nav-year-2026" class="year-menu-link">SPP2026</a>
                        </div>
                    </nav>
                </details>
            </div>
        </div>
    </header>

    <main id="main-content" class="shell" style="min-height: 60vh;">
    </main>

    <footer class="site-footer">
        <div class="shell footer-grid">
            <div class="footer-brand">
                <div class="brand-mark" aria-hidden="true">SPP</div>
                <p>Samahang Pisika ng Pilipinas</p>
                <p>sample text.</p>
            </div>

            <div>
                <h3>SPP</h3>
                <a href="{{ url('/') }}#about">About</a>
                <a href="{{ url('/') }}#activities">Activities</a>
                <a href="{{ url('/') }}#events">Events</a>
                <a href="{{ url('/') }}#news">News</a>
            </div>

            <div>
                <h3>Conference Years</h3>
                <a href="spp.html?year=2024">SPP 2024</a>
                <a href="spp.html?year=2025">SPP 2025</a>
                <a href="spp.html?year=2026">SPP 2026</a>
                <a href="{{ url('/') }}">Back to Home</a>
            </div>

            <div>
                <h3>Social Media</h3>
                <div class="social-links" aria-label="Social media links">
                    <a href="#top" aria-label="Facebook">f</a>
                    <a href="#top" aria-label="Instagram">ig</a>
                    <a href="#top" aria-label="LinkedIn">in</a>
                    <a href="#top" aria-label="X">x</a>
                </div>
                <p>sample text.</p>
                <p class="copyright">&#x00A9; 2026 Samahang Pisika ng Pilipinas</p>
            </div>
        </div>
    </footer>
</body>

</html>
