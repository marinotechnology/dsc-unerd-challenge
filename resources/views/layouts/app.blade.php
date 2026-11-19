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
    <body class="font-sans antialiased text-unerd-ink dark:text-zinc-100 bg-unerd-canvas dark:bg-unerd-black min-h-screen flex flex-col transition-colors duration-200">
        @include('layouts.navigation')

        <!-- Page Heading (Optional Banner) -->
        @isset($header)
            <header class="bg-unerd-surface-card dark:bg-zinc-900 border-b border-unerd-hairline dark:border-zinc-800">
                <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Flash Notifications -->
        @if (session('status'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 w-full">
                <div class="p-4 rounded-md bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 text-sm font-medium flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="font-bold">SUKSES:</span>
                        <span>{{ session('status') }}</span>
                    </div>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 w-full">
                <div class="p-4 rounded-md bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-200 text-sm">
                    <div class="font-bold mb-1">PERHATIAN:</div>
                    <ul class="list-disc list-inside space-y-0.5 text-xs">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Main Content -->
        <main class="flex-1 py-6 sm:py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>

        <!-- Signature UNERD MOVE Footer -->
        <footer class="bg-unerd-surface-card dark:bg-zinc-950 border-t border-unerd-hairline dark:border-zinc-800 text-unerd-muted dark:text-zinc-400 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <x-application-logo mode="icon-only" class="h-6 w-auto" />
                    <span class="text-xs font-mono font-bold text-unerd-ink dark:text-white uppercase tracking-wider">
                        UNERD MOVE SERIES • Race. Move. Share.
                    </span>
                </div>
                <!-- <div class="text-[11px] font-sans text-center sm:text-right">
                    GBK Pilot 21 Nov 2026 • Multi-City Expansion • O2O Performance Platform
                </div> -->
            </div>
        </footer>
    </body>
</html>
