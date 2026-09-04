<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'Samahang Pisika ng Pilipinas' }}</title>
    <meta name="description" content="{{ $description ?? 'Samahang Pisika ng Pilipinas' }}" />

    <link rel="icon" href="{{ asset('favicon.ico') }}" />

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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <!-- User Side Loading Screen -->
    <div id="user-loading-screen" class="admin-loading-overlay" role="status" aria-live="polite" aria-label="Loading Website">
        <div class="admin-loading-card">
            <div class="admin-loading-spinner-wrap" aria-hidden="true">
                <div class="admin-loading-spinner-glow"></div>
                <div class="admin-loading-spinner-outer"></div>
                <div class="admin-loading-spinner-inner"></div>
            </div>
            <p class="admin-loading-status" id="user-loading-text">Loading...</p>
        </div>
    </div>

    <a class="skip-link" href="#main-content">Skip to content</a>

    <x-public-header />

    <main id="main-content" {{ $attributes }}>
        {{ $slot }}
    </main>

    <x-public-footer />
    
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

    @if (view()->exists('components.image-debug-bar'))
        <x-image-debug-bar />
    @endif
</body>

</html>
