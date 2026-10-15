<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'Membership Portal | Samahang Pisika ng Pilipinas' }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" />
    <script>
        (function () {
            const theme = localStorage.getItem('spp-theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
            document.documentElement.classList.toggle('dark', theme === 'dark');
        })();
    </script>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/portal.css') }}" />
</head>
<body class="portal-body">
    <a class="skip-link" href="#portal-content">Skip to content</a>

    <header class="portal-topbar">
        <a class="brand" href="{{ route('membership-portal.dashboard') }}" aria-label="SPP Membership Portal dashboard">
            <span class="brand-mark" aria-hidden="true">SPP</span>
            <span class="brand-copy">
                <strong>Samahang Pisika ng Pilipinas</strong>
                <span>Membership Portal</span>
            </span>
        </a>

        <div class="portal-topbar-actions">
            <button class="portal-menu-button" type="button" data-portal-menu aria-expanded="false" aria-controls="portal-sidebar">Menu</button>
            <button class="portal-notification-button" type="button" data-notification-popover aria-expanded="false" aria-controls="notification-popover" aria-label="3 notifications">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18 9a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4" /></svg>
                <span>3</span>
            </button>
            <section id="notification-popover" class="portal-notification-popover" hidden aria-label="Notifications">
                <div class="portal-popover-heading"><strong>Notifications</strong><a href="{{ route('membership-portal.notifications') }}">View all</a></div>
                <ul>
                    <li><strong>Application Submitted <em class="portal-new-indicator">New</em></strong><span>Your application was submitted.</span></li>
                    <li><strong>Application Under Evaluation <em class="portal-new-indicator">New</em></strong><span>Your application is currently being reviewed.</span></li>
                    <li><strong>Additional Information Required <em class="portal-new-indicator">New</em></strong><span>Please review your application.</span></li>
                    <li class="portal-extra-notification" hidden><strong>Membership Update</strong><span>Sample membership update.</span></li>
                    <li class="portal-extra-notification" hidden><strong>Inquiry Update</strong><span>Your inquiry has been updated.</span></li>
                </ul>
                <button type="button" class="portal-popover-toggle" data-show-more>Show more</button>
                <button type="button" class="portal-popover-toggle" data-show-less hidden>Show less</button>
            </section>

            <details class="portal-account-menu">
                <summary>Sample Name</summary>
                <span>Account</span>
            </details>
        </div>
    </header>

    <div class="portal-shell">
        @include('portal.partials.sidebar')
        <main id="portal-content" class="portal-content">
            {{ $slot }}
        </main>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelector('[data-theme-toggle]')?.addEventListener('click', () => {
                const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
                const theme = isDark ? 'light' : 'dark';
                document.documentElement.setAttribute('data-theme', theme);
                document.documentElement.classList.toggle('dark', theme === 'dark');
                localStorage.setItem('spp-theme', theme);
            });

            const notificationButton = document.querySelector('[data-notification-popover]');
            const notificationPopover = document.getElementById('notification-popover');
            notificationButton?.addEventListener('click', () => {
                const isOpen = notificationPopover?.hasAttribute('hidden') ?? false;
                notificationPopover?.toggleAttribute('hidden', !isOpen);
                notificationButton.setAttribute('aria-expanded', String(isOpen));
            });
            document.querySelector('[data-show-more]')?.addEventListener('click', () => {
                document.querySelectorAll('.portal-extra-notification').forEach((item) => item.hidden = false);
                document.querySelector('[data-show-more]').hidden = true;
                document.querySelector('[data-show-less]').hidden = false;
            });
            document.querySelector('[data-show-less]')?.addEventListener('click', () => {
                document.querySelectorAll('.portal-extra-notification').forEach((item) => item.hidden = true);
                document.querySelector('[data-show-more]').hidden = false;
                document.querySelector('[data-show-less]').hidden = true;
            });

            const menuButton = document.querySelector('[data-portal-menu]');
            const sidebar = document.getElementById('portal-sidebar');

            menuButton?.addEventListener('click', () => {
                const isOpen = sidebar?.classList.toggle('is-open') ?? false;
                menuButton.setAttribute('aria-expanded', String(isOpen));
            });

            document.querySelectorAll('.portal-nav-link').forEach((link) => {
                link.addEventListener('click', (event) => {
                    if (event.ctrlKey || event.metaKey || event.shiftKey || event.altKey || link.href === window.location.href) {
                        return;
                    }

                    event.preventDefault();
                    document.querySelector('.portal-content')?.classList.add('is-leaving');
                    window.setTimeout(() => window.location.assign(link.href), 140);
                });
            });

            document.querySelectorAll('[data-membership-state]').forEach((button) => {
                button.addEventListener('click', () => {
                    const state = button.dataset.membershipState;
                    document.querySelectorAll('[data-membership-panel]').forEach((panel) => {
                        panel.hidden = panel.dataset.membershipPanel !== state;
                    });
                    document.querySelectorAll('[data-membership-state]').forEach((control) => {
                        const isSelected = control === button;
                        control.classList.toggle('is-selected', isSelected);
                        control.setAttribute('aria-pressed', String(isSelected));
                    });
                });
            });
        });
    </script>
    <!-- Floating Theme Toggle Button -->
    <button class="theme-toggle floating-theme-toggle" type="button" data-theme-toggle
        aria-label="Toggle theme mode" title="Toggle theme mode">
        <span class="theme-icon theme-icon-moon" aria-hidden="true">&#x263E;</span>
        <span class="theme-icon theme-icon-sun" aria-hidden="true">&#x2600;</span>
        <span class="floating-theme-tooltip">
            <span class="theme-toggle-text theme-label-dark">Dark Mode</span>
            <span class="theme-toggle-text theme-label-light">Light Mode</span>
        </span>
    </button>
</body>
</html>
