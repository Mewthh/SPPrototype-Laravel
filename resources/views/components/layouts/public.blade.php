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
    <a class="skip-link" href="#main-content">Skip to content</a>

    <x-public-header />

    <main id="main-content" {{ $attributes }}>
        {{ $slot }}
    </main>

    <x-public-footer />
</body>

</html>
