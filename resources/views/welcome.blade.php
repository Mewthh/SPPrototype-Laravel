<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Samahang Pisika ng Pilipinas</title>
    <link rel="stylesheet" href="{{ asset('styles.css') }}" />
    <script src="{{ asset('content-util.js') }}" defer></script>
    <script src="{{ asset('app.js') }}" defer></script>
</head>

<body>
    <a class="skip-link" href="#main-content">Skip to content</a>

    <header class="site-header">
        <div class="shell header-inner">
            <a class="brand" href="#top" aria-label="Samahang Pisika ng Pilipinas home">
                <span class="brand-mark" aria-hidden="true">SPP</span>
                <span class="brand-copy">
                    <strong>Samahang Pisika ng Pilipinas</strong>
                    <span>sample text</span>
                </span>
            </a>

            <div class="header-nav-group">
                <nav class="desktop-nav" aria-label="Primary navigation">
                    <a href="#news">News</a>
                    <a href="#activities">Activities</a>
                    <div class="nav-dropdown">
                        <a href="#resources" class="nav-dropdown-toggle">Resources <span class="dropdown-chevron">&#x25BE;</span></a>
                        <div class="nav-dropdown-panel" aria-label="Resources submenu">
                            <a href="#membership-faq">Membership FAQ</a>
                            <a href="https://proceedings.spp-online.org/" target="_blank" rel="noopener noreferrer">Proceedings of the SPP</a>
                            <a href="#videos-webinars">Videos and Webinars</a>
                            <a href="https://paperview.spp-online.org/" target="_blank" rel="noopener noreferrer">Pisika Journal</a>
                        </div>
                    </div>
                    <a href="#downloads">Downloads</a>
                    <a href="#about">About SPP</a>
                    <details class="year-menu">
                        <summary aria-label="Open conference year choices">&#x22EF;</summary>
                        <div class="year-menu-panel" aria-label="Conference year choices">
                            <a href="spp.html?year=2024" id="year-btn-2024" class="year-menu-link">SPP2024</a>
                            <a href="spp.html?year=2025" id="year-btn-2025" class="year-menu-link">SPP2025</a>
                            <a href="spp.html?year=2026" id="year-btn-2026" class="year-menu-link">SPP2026</a>
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
                        <a href="#news">News</a>
                        <a href="#activities">Activities</a>
                        <details class="mobile-sub-menu">
                            <summary>Resources <span class="dropdown-chevron">&#x25BE;</span></summary>
                            <div class="mobile-sub-menu-panel">
                                <a href="#membership-faq">Membership FAQ</a>
                                <a href="https://proceedings.spp-online.org/" target="_blank" rel="noopener noreferrer">Proceedings of the SPP</a>
                                <a href="#videos-webinars">Videos and Webinars</a>
                                <a href="https://paperview.spp-online.org/" target="_blank" rel="noopener noreferrer">Pisika Journal</a>
                            </div>
                        </details>
                        <a href="#downloads">Downloads</a>
                        <a href="#about">About SPP</a>
                        <div class="mobile-nav-years" aria-label="Conference year choices">
                            <a href="spp.html?year=2024" id="mob-year-btn-2024" class="year-menu-link">SPP2024</a>
                            <a href="spp.html?year=2025" id="mob-year-btn-2025" class="year-menu-link">SPP2025</a>
                            <a href="spp.html?year=2026" id="mob-year-btn-2026" class="year-menu-link">SPP2026</a>
                        </div>
                    </nav>
                </details>
            </div>
        </div>
    </header>

    <main id="main-content">
        <section class="hero section-shell" id="top">
            <div class="hero-grid shell">
                <div class="hero-copy">
                    <p class="eyebrow">SAMAHANG PISIKA NG PILIPINAS</p>
                    <h1>title</h1>
                    <p class="hero-text">sample text.</p>

                    <div class="hero-actions">
                        <a class="button button-primary" href="#events">View Events</a>
                        <a class="button button-secondary" href="#about">Join SPP</a>
                    </div>

                    <div class="hero-meta" aria-label="Quick highlights">
                        <article>
                            <strong>sample text</strong>
                            <span>sample text</span>
                        </article>
                        <article>
                            <strong>sample text</strong>
                            <span>sample text</span>
                        </article>
                        <article>
                            <strong>sample text</strong>
                            <span>sample text</span>
                        </article>
                    </div>
                </div>
            </div>
        </section>


        <section class="section shell" id="news">
            <div class="section-header">
                <div>
                    <p class="eyebrow">News and Announcements</p>
                    <h2>title</h2>
                    <p>sample text.</p>
                </div>
            </div>

            <div id="news-listing-wrapper">
                <div id="news-grid" class="card-grid news-grid">
                    <div class="news-loading">Loading news...</div>
                </div>
                <nav id="news-pagination" class="pagination-bar" aria-label="News pagination" style="display: none;"></nav>
            </div>
        </section>

        <section class="section shell" id="activities">
            <div class="section-header">
                <div>
                    <p class="eyebrow">Activities</p>
                    <h2>title</h2>
                    <p>sample text.</p>
                </div>
            </div>

            <div class="card-grid activity-grid">
                <article class="content-card">
                    <img src="data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 520'><rect width='800' height='520' rx='28' fill='%23e5e7eb'/><rect x='40' y='40' width='720' height='440' rx='22' fill='%23f8fafc' stroke='%23cbd5e1'/><text x='50%25' y='50%25' text-anchor='middle' dominant-baseline='middle' fill='%236b7280' font-family='Segoe UI,Arial,sans-serif' font-size='40'>sample text</text></svg>"
                        alt="sample text" />
                    <div class="card-body">
                        <span class="card-chip">Activities</span>
                        <h3>title</h3>
                        <p>sample text.</p>
                        <small>sample text</small>
                    </div>
                </article>

                <article class="content-card">
                    <img src="data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 520'><rect width='800' height='520' rx='28' fill='%23e5e7eb'/><rect x='40' y='40' width='720' height='440' rx='22' fill='%23f8fafc' stroke='%23cbd5e1'/><text x='50%25' y='50%25' text-anchor='middle' dominant-baseline='middle' fill='%236b7280' font-family='Segoe UI,Arial,sans-serif' font-size='40'>sample text</text></svg>"
                        alt="sample text" />
                    <div class="card-body">
                        <span class="card-chip">Activities</span>
                        <h3>title</h3>
                        <p>sample text.</p>
                        <small>sample text</small>
                    </div>
                </article>

                <article class="content-card">
                    <img src="data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 520'><rect width='800' height='520' rx='28' fill='%23e5e7eb'/><rect x='40' y='40' width='720' height='440' rx='22' fill='%23f8fafc' stroke='%23cbd5e1'/><text x='50%25' y='50%25' text-anchor='middle' dominant-baseline='middle' fill='%236b7280' font-family='Segoe UI,Arial,sans-serif' font-size='40'>sample text</text></svg>"
                        alt="sample text" />
                    <div class="card-body">
                        <span class="card-chip">Activities</span>
                        <h3>title</h3>
                        <p>sample text.</p>
                        <small>sample text</small>
                    </div>
                </article>

                <article class="content-card">
                    <img src="data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 520'><rect width='800' height='520' rx='28' fill='%23e5e7eb'/><rect x='40' y='40' width='720' height='440' rx='22' fill='%23f8fafc' stroke='%23cbd5e1'/><text x='50%25' y='50%25' text-anchor='middle' dominant-baseline='middle' fill='%236b7280' font-family='Segoe UI,Arial,sans-serif' font-size='40'>sample text</text></svg>"
                        alt="sample text" />
                    <div class="card-body">
                        <span class="card-chip">Activities</span>
                        <h3>title</h3>
                        <p>sample text.</p>
                        <small>sample text</small>
                    </div>
                </article>
            </div>
        </section>


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
                <a href="#about">About</a>
                <a href="#activities">Activities</a>
                <a href="#events">Events</a>
                <a href="#news">News</a>
            </div>

            <div>
                <h3>Membership</h3>
                <a href="#years">SPP 2024-2026 Events</a>
                <a href="#top">Top of page</a>
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
