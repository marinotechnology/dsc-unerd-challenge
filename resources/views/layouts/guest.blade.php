<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title . ' — UNERD Move' : 'UNERD Move — Every Week League' }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/logos/icon-light.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/logos/icon-light.png') }}">

        <!-- Google Fonts: Plus Jakarta Sans & Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@700;800&family=Space+Grotesk:wght@700&display=swap" rel="stylesheet">

        <!-- Theme Initialization Script (Default: Dark Mode, Prevents FOUC) -->
        <script>
            (function() {
                const preference = localStorage.theme || 'dark';
                if (preference !== 'light') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();

            function applyTheme(preference) {
                if (preference === 'light') {
                    document.documentElement.classList.remove('dark');
                    localStorage.theme = 'light';
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.theme = 'dark';
                }
                window.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme: localStorage.theme } }));
            }

            function toggleTheme() {
                const current = localStorage.theme || 'dark';
                if (current === 'dark') applyTheme('light');
                else applyTheme('dark');
            }
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-unerd-ink dark:text-zinc-100 bg-unerd-canvas dark:bg-unerd-black min-h-screen transition-colors duration-200">
        {{ $slot }}
    </body>
</html>
