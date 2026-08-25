<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'Samahang Pisika ng Pilipinas' }}</title>
    <meta name="description" content="{{ $description ?? 'Samahang Pisika ng Pilipinas (SPP) - The premier professional organization of physicists in the Philippines.' }}" />

    <link rel="icon" href="/favicon.ico" sizes="any">

    <script>
        (function() {
            const saved = localStorage.getItem('spp-theme');
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            const theme = saved || (prefersDark ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    @vite(['resources/css/spp.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body>
    <a class="skip-link" href="#main-content">Skip to content</a>

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
                    <a href="{{ route('home') }}#news" class="{{ request()->routeIs('news.*') ? 'active' : '' }}">News</a>
                    <a href="{{ route('home') }}#activities">Activities</a>
                    <div class="nav-dropdown">
                        <a href="{{ route('home') }}#resources" class="nav-dropdown-toggle">Resources <span class="dropdown-chevron">&#x25BE;</span></a>
                        <div class="nav-dropdown-panel" aria-label="Resources submenu">
                            <a href="{{ route('home') }}#membership-faq">Membership FAQ</a>
                            <a href="https://proceedings.spp-online.org/" target="_blank" rel="noopener noreferrer">Proceedings of the SPP</a>
                            <a href="{{ route('home') }}#videos-webinars">Videos and Webinars</a>
                            <a href="https://paperview.spp-online.org/" target="_blank" rel="noopener noreferrer">Pisika Journal</a>
                        </div>
                    </div>
                    <a href="{{ route('home') }}#downloads">Downloads</a>
                    <a href="{{ route('home') }}#about">About SPP</a>
                    <details class="year-menu">
                        <summary aria-label="Open conference year choices">&#x22EF;</summary>
                        <div class="year-menu-panel" aria-label="Conference year choices">
                            <a href="{{ route('spp.show', ['year' => 2024]) }}" id="year-btn-2024" class="year-menu-link {{ request('year') == '2024' ? 'active' : '' }}">SPP2024</a>
                            <a href="{{ route('spp.show', ['year' => 2025]) }}" id="year-btn-2025" class="year-menu-link {{ request('year') == '2025' ? 'active' : '' }}">SPP2025</a>
                            <a href="{{ route('spp.show', ['year' => 2026]) }}" id="year-btn-2026" class="year-menu-link {{ request('year') == '2026' ? 'active' : '' }}">SPP2026</a>
                        </div>
                    </details>
                </nav>
            </div>

            <div class="header-tools">
                <form class="search-box" role="search" action="{{ route('home') }}" method="GET">
                    <input type="search" name="q" aria-label="Search" placeholder="Search" value="{{ request('q') }}" />
                    <button type="submit">Search</button>
                </form>

                <button class="theme-toggle" type="button" data-theme-toggle aria-label="Switch dark/light mode">
                    <span class="theme-icon theme-icon-moon" aria-hidden="true">&#x263E;</span>
                    <span class="theme-icon theme-icon-sun" aria-hidden="true">&#x2600;</span>
                </button>

                @auth
                    <a href="{{ route('dashboard') }}" class="button button-secondary" style="padding: 6px 12px; font-size: 0.85rem;">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="button button-secondary" style="padding: 6px 12px; font-size: 0.85rem;">Log in</a>
                @endauth

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
                                <a href="{{ route('home') }}#membership-faq">Membership FAQ</a>
                                <a href="https://proceedings.spp-online.org/" target="_blank" rel="noopener noreferrer">Proceedings of the SPP</a>
                                <a href="{{ route('home') }}#videos-webinars">Videos and Webinars</a>
                                <a href="https://paperview.spp-online.org/" target="_blank" rel="noopener noreferrer">Pisika Journal</a>
                            </div>
                        </details>
                        <a href="{{ route('home') }}#downloads">Downloads</a>
                        <a href="{{ route('home') }}#about">About SPP</a>
                        <div class="mobile-nav-years" aria-label="Conference year choices">
                            <a href="{{ route('spp.show', ['year' => 2024]) }}" class="year-menu-link">SPP2024</a>
                            <a href="{{ route('spp.show', ['year' => 2025]) }}" class="year-menu-link">SPP2025</a>
                            <a href="{{ route('spp.show', ['year' => 2026]) }}" class="year-menu-link">SPP2026</a>
                        </div>
                    </nav>
                </details>
            </div>
        </div>
    </header>

    <main id="main-content">
        {{ $slot }}
    </main>

    <footer class="site-footer">
        <div class="shell footer-grid">
            <div class="footer-brand">
                <div class="brand-mark" aria-hidden="true">SPP</div>
                <p>Samahang Pisika ng Pilipinas</p>
                <p>Advancing Physics research, education, and community across the Philippines.</p>
            </div>

            <div>
                <h3>SPP</h3>
                <a href="{{ route('home') }}#about">About</a>
                <a href="{{ route('home') }}#activities">Activities</a>
                <a href="{{ route('spp.show', ['year' => 2026]) }}">Conferences</a>
                <a href="{{ route('home') }}#news">News</a>
            </div>

            <div>
                <h3>Conference Years</h3>
                <a href="{{ route('spp.show', ['year' => 2024]) }}">SPP 2024</a>
                <a href="{{ route('spp.show', ['year' => 2025]) }}">SPP 2025</a>
                <a href="{{ route('spp.show', ['year' => 2026]) }}">SPP 2026</a>
                <a href="#main-content">Top of page</a>
            </div>

            <div>
                <h3>Social Media</h3>
                <div class="social-links" aria-label="Social media links">
                    <a href="https://www.facebook.com" target="_blank" rel="noopener noreferrer" aria-label="Facebook">f</a>
                    <a href="https://www.instagram.com" target="_blank" rel="noopener noreferrer" aria-label="Instagram">ig</a>
                    <a href="https://www.linkedin.com" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">in</a>
                    <a href="https://x.com" target="_blank" rel="noopener noreferrer" aria-label="X">x</a>
                </div>
                <p>Physics Society of the Philippines</p>
                <p class="copyright">&copy; {{ date('Y') }} Samahang Pisika ng Pilipinas. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const themeToggle = document.querySelector('[data-theme-toggle]');
            if (themeToggle) {
                themeToggle.addEventListener('click', () => {
                    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
                    const next = isDark ? 'light' : 'dark';
                    document.documentElement.setAttribute('data-theme', next);
                    if (next === 'dark') {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                    localStorage.setItem('spp-theme', next);
                });
            }
        });
    </script>

    @livewireScripts
</body>

</html>
