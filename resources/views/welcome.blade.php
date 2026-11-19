<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>UNERD MOVE — Race. Move. Share. | UNERD Time Attack GBK</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/logos/icon-light.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/logos/icon-light.png') }}">

        <!-- Google Fonts: Plus Jakarta Sans & Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@700;800&family=Space+Grotesk:wght@700&display=swap" rel="stylesheet">

        <!-- Theme Initialization Script (Default: Dark Mode) -->
        <script>
            (function() {
                const preference = localStorage.theme || 'dark';
                if (preference !== 'light') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();
            function toggleTheme() {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.theme = 'light';
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.theme = 'dark';
                }
            }
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-unerd-ink dark:text-zinc-100 bg-unerd-canvas dark:bg-unerd-black min-h-screen flex flex-col transition-colors duration-200">
        <!-- Sticky Navigation Header (72px) -->
        <header class="sticky top-0 z-40 bg-white/90 dark:bg-zinc-900/90 backdrop-blur-md border-b border-unerd-hairline dark:border-zinc-800 transition-colors">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-[68px] sm:h-[72px] flex items-center justify-between">
                <div class="flex items-center gap-4 sm:gap-8">
                    <!-- Brand Anchor: Icon on Mobile, Master Logo on Desktop -->
                    <a href="/" class="flex items-center gap-2">
                        <x-application-logo />
                    </a>

                    <!-- Section Quick Anchors (Desktop) -->
                    <nav class="hidden lg:flex items-center space-x-1 text-xs font-bold uppercase tracking-wider text-unerd-body dark:text-zinc-300">
                        <a href="#time-attack" class="px-3 py-1.5 hover:text-unerd-ink dark:hover:text-white rounded-md transition">Time Attack Challenge</a>
                        <a href="#timing-system" class="px-3 py-1.5 hover:text-unerd-ink dark:hover:text-white rounded-md transition">Cara Kerja & Timing</a>
                        <a href="#community-race" class="px-3 py-1.5 hover:text-unerd-ink dark:hover:text-white rounded-md transition">Komunitas & Kategori</a>
                        <a href="#footwear-performance" class="px-3 py-1.5 hover:text-unerd-ink dark:hover:text-white rounded-md transition">Sepatu UNERD</a>
                        <a href="#prizes-rewards" class="px-3 py-1.5 hover:text-unerd-ink dark:hover:text-white rounded-md transition">Hadiah Juara & Voucher</a>
                    </nav>
                </div>

                <!-- Right Cluster: Theme Switcher & Auth Buttons -->
                <div class="flex items-center gap-2 sm:gap-3">
                    <x-theme-toggle />

                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="inline-flex items-center justify-center h-10 px-4 sm:px-5 bg-unerd-black dark:bg-white hover:bg-unerd-black-active dark:hover:bg-zinc-200 text-white dark:text-unerd-black text-xs font-bold uppercase tracking-wider rounded-md transition">
                            <span class="hidden sm:inline">Masuk ke</span> Dashboard →
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center justify-center h-10 px-3 sm:px-4 text-xs font-bold uppercase tracking-wider text-unerd-ink dark:text-zinc-200 hover:bg-unerd-surface-card dark:hover:bg-zinc-800 rounded-md transition">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center justify-center h-10 px-4 sm:px-5 bg-unerd-black dark:bg-white hover:bg-unerd-black-active dark:hover:bg-zinc-200 text-white dark:text-unerd-black text-xs font-bold uppercase tracking-wider rounded-md transition shadow-xs">
                            Ikut Challenge
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1">
            <!-- ========================================================================= -->
            <!-- SECTION 1: HERO & TANTANGAN 1 KM SPRINT (Foto: gallery-1.jpg)            -->
            <!-- ========================================================================= -->
            <section id="time-attack" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16 lg:py-20">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    <!-- Left Hero Headline & Event Intro -->
                    <div class="lg:col-span-7 space-y-5 sm:space-y-6">
                        <div class="inline-flex items-center gap-2">
                            <span class="px-3 py-1 bg-unerd-volt text-unerd-ink font-display text-[11px] font-extrabold uppercase tracking-[2px] rounded-pill">
                                PILOT GBK SENAYAN • 21 NOV 2026
                            </span>
                            <span class="text-xs font-mono font-bold text-slate-400 dark:text-zinc-400">
                                1.000 Meter Sprint
                            </span>
                        </div>

                        <div class="space-y-2">
                            <div class="text-xs sm:text-sm font-bold tracking-[3px] uppercase text-unerd-muted dark:text-zinc-400 font-mono">
                                RACE. MOVE. SHARE.
                            </div>
                            <h1 class="font-display text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-[-2px] sm:tracking-[-3px] leading-[0.98] uppercase text-unerd-ink dark:text-white">
                                UNERD TIME <br>
                                <span class="text-unerd-volt">ATTACK</span>
                            </h1>
                        </div>

                        <p class="text-sm sm:text-base text-unerd-body dark:text-zinc-300 leading-relaxed font-sans max-w-xl">
                            Tantang batas kecepatanmu di lintasan resmi GBK Jakarta! Ikuti sprint 1.000 meter (1 KM), catat waktu resmimu dengan verifikasi stopwatch kru panitia, dan buktikan catatan waktu terbaikmu di papan peringkat live.
                        </p>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2">
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center justify-center h-12 px-6 sm:px-8 bg-unerd-black dark:bg-white hover:bg-unerd-black-active dark:hover:bg-zinc-200 text-white dark:text-unerd-black font-display text-xs sm:text-sm font-bold tracking-[0.5px] uppercase rounded-md transition shadow-md text-center">
                                Daftar Challenge 1 KM Sekarang →
                            </a>
                            <a href="{{ route('everyday-league.leaderboard') }}"
                               class="inline-flex items-center justify-center h-12 px-5 bg-white dark:bg-zinc-900 hover:bg-unerd-surface-card dark:hover:bg-zinc-800 text-unerd-ink dark:text-zinc-100 font-display text-xs sm:text-sm font-bold tracking-[0.5px] uppercase border border-unerd-hairline dark:border-zinc-700 rounded-md transition text-center">
                                Cek Leaderboard Live
                            </a>
                        </div>

                        <!-- Key Performance Fast Badges -->
                        <div class="grid grid-cols-3 gap-2 sm:gap-4 pt-6 border-t border-unerd-hairline dark:border-zinc-800 max-w-lg text-center sm:text-left">
                            <div class="p-2 sm:p-0">
                                <div class="text-[10px] sm:text-[11px] uppercase tracking-wider text-unerd-muted dark:text-zinc-400 font-bold">JARAK LARI</div>
                                <div class="font-display font-black text-sm sm:text-base text-unerd-ink dark:text-white mt-0.5">1.000 Meter</div>
                            </div>
                            <div class="p-2 sm:p-0">
                                <div class="text-[10px] sm:text-[11px] uppercase tracking-wider text-unerd-muted dark:text-zinc-400 font-bold">REWARD FINISHER</div>
                                <div class="font-display font-black text-sm sm:text-base text-unerd-volt mt-0.5">Voucher 10%</div>
                            </div>
                            <div class="p-2 sm:p-0">
                                <div class="text-[10px] sm:text-[11px] uppercase tracking-wider text-unerd-muted dark:text-zinc-400 font-bold">TIMING FORMAT</div>
                                <div class="font-display font-black text-sm sm:text-base text-unerd-ink dark:text-white mt-0.5">Stopwatch Kru</div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Showcase: Action Sprint Photo (gallery-1.jpg) & Result Mockup -->
                    <div id="result-card" class="lg:col-span-5">
                        <div class="p-5 sm:p-7 rounded-2xl bg-unerd-surface-card dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 relative overflow-hidden shadow-xl">
                            <!-- Card Header with Photo of Sprint Action -->
                            <div class="relative h-56 -mx-5 sm:-mx-7 -mt-5 sm:-mt-7 mb-4 overflow-hidden rounded-t-2xl">
                                <img src="{{ asset('images/gallery/gallery-1.jpg') }}"
                                     alt="Pelari Sprint GBK"
                                     class="w-full h-full object-cover filter brightness-95 contrast-105" />
                                <div class="absolute inset-0 bg-black/60"></div>
                                <div class="absolute top-3 left-3 right-3 flex items-center justify-between text-[11px] font-mono">
                                    <span class="px-2.5 py-1 rounded-full bg-black/75 backdrop-blur-xs font-bold text-unerd-volt border border-white/10">
                                        UNERD TIME ATTACK
                                    </span>
                                    <span class="px-2.5 py-1 rounded-full bg-black/75 backdrop-blur-xs text-white border border-white/10 font-bold">
                                        BIB #0482
                                    </span>
                                </div>
                                <div class="absolute bottom-2.5 left-4">
                                    <span class="text-[10px] font-mono uppercase tracking-wider text-zinc-300">
                                        Lintasan Resmi GBK Senayan
                                    </span>
                                </div>
                            </div>

                            <!-- Live Result Timing Display -->
                            <div class="p-4 rounded-xl bg-unerd-black text-white relative overflow-hidden border border-zinc-700 shadow-md">
                                <div class="text-center pb-2">
                                    <div class="text-[10px] uppercase tracking-[2px] text-zinc-400 font-bold font-mono">
                                        OFFICIAL STOPWATCH TIME
                                    </div>
                                    <div class="font-display font-black text-3xl sm:text-4xl text-white tracking-tight my-1">
                                        03:24,50
                                    </div>
                                    <div class="inline-block px-2.5 py-0.5 rounded-full bg-unerd-volt text-unerd-ink font-bold text-[10px] uppercase tracking-wider">
                                        Kategori Umum • Terverifikasi
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-2 pt-2.5 border-t border-zinc-800 text-center text-xs">
                                    <div>
                                        <div class="text-[10px] text-zinc-400 uppercase font-mono">Jarak</div>
                                        <div class="font-bold text-white mt-0.5">1.0 KM</div>
                                    </div>
                                    <div>
                                        <div class="text-[10px] text-zinc-400 uppercase font-mono">Pace</div>
                                        <div class="font-bold text-unerd-volt mt-0.5">03:24/km</div>
                                    </div>
                                    <div>
                                        <div class="text-[10px] text-zinc-400 uppercase font-mono">Ranking</div>
                                        <div class="font-bold text-white mt-0.5">#1 Periode</div>
                                    </div>
                                </div>
                            </div>

                            <p class="text-xs text-unerd-muted dark:text-zinc-400 text-center mt-3">
                                Tunjukkan BIB di garis finish, waktu langsung tayang di papan peringkat realtime.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ========================================================================= -->
            <!-- SECTION 2: CARA KERJA & TIMING STOPWATCH KRU (gallery-5.jpg & gallery-4.jpg)-->
            <!-- ========================================================================= -->
            <section id="timing-system" class="py-14 sm:py-20 bg-unerd-surface-card dark:bg-zinc-950/60 border-y border-unerd-hairline dark:border-zinc-800 transition-colors">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                        <!-- Left Explanation of 3 Steps -->
                        <div class="lg:col-span-6 space-y-6">
                            <div>
                                <span class="px-3 py-1 rounded-pill bg-unerd-black dark:bg-zinc-800 text-white text-[11px] font-bold uppercase tracking-[2px] inline-block mb-3">
                                    ALUR PARTISIPASI
                                </span>
                                <h2 class="font-display text-2xl sm:text-4xl font-extrabold uppercase tracking-tight text-unerd-ink dark:text-white">
                                    Cara Kerja & Verifikasi Stopwatch Kru
                                </h2>
                                <p class="text-xs sm:text-sm text-unerd-body dark:text-zinc-400 mt-2">
                                    Setiap milidetik lari dicatat secara objektif oleh kru operasional di lapangan untuk menjaga sportivitas dan akurasi peringkat.
                                </p>
                            </div>

                            <div class="space-y-4">
                                <!-- Step 1 -->
                                <div class="p-4 rounded-xl bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 flex items-start gap-4 shadow-xs">
                                    <div class="w-9 h-9 rounded-xl bg-unerd-black text-white dark:bg-unerd-volt dark:text-black flex items-center justify-center font-black font-display text-sm shrink-0">
                                        01
                                    </div>
                                    <div>
                                        <h3 class="font-display font-bold text-sm text-unerd-ink dark:text-white uppercase">
                                            Daftar & Dapatkan Nomor BIB
                                        </h3>
                                        <p class="text-xs text-unerd-body dark:text-zinc-400 mt-0.5">
                                            Daftar akun dan pilih kategori pelari. Kamu akan langsung menerima nomor BIB unik untuk identifikasi resmi di lintasan.
                                        </p>
                                    </div>
                                </div>

                                <!-- Step 2 -->
                                <div class="p-4 rounded-xl bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 flex items-start gap-4 shadow-xs">
                                    <div class="w-9 h-9 rounded-xl bg-unerd-black text-white dark:bg-unerd-volt dark:text-black flex items-center justify-center font-black font-display text-sm shrink-0">
                                        02
                                    </div>
                                    <div>
                                        <h3 class="font-display font-bold text-sm text-unerd-ink dark:text-white uppercase">
                                            Lari Sprint 1.000 Meter di GBK
                                        </h3>
                                        <p class="text-xs text-unerd-body dark:text-zinc-400 mt-0.5">
                                            Mulai dari garis start dan pacu ritme terbaikmu sepanjang 1 KM lintasan Gelora Bung Karno.
                                        </p>
                                    </div>
                                </div>

                                <!-- Step 3 -->
                                <div class="p-4 rounded-xl bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 flex items-start gap-4 shadow-xs">
                                    <div class="w-9 h-9 rounded-xl bg-unerd-black text-white dark:bg-unerd-volt dark:text-black flex items-center justify-center font-black font-display text-sm shrink-0">
                                        03
                                    </div>
                                    <div>
                                        <h3 class="font-display font-bold text-sm text-unerd-ink dark:text-white uppercase">
                                            Kru Input Waktu Stopwatch & Sahkan Hasil
                                        </h3>
                                        <p class="text-xs text-unerd-body dark:text-zinc-400 mt-0.5">
                                            Kru panitia di garis finish mencatat waktu menggunakan format resmi (mm:ss,ms). Hasil seketika terverifikasi di profilmu tanpa refresh.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Photos: 2 complementary images illustrating timing & focus -->
                        <div class="lg:col-span-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Photo 1: Timing & Marshal verification (gallery-5.jpg) -->
                            <div class="group relative overflow-hidden rounded-2xl bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-md h-80 sm:h-96">
                                <img src="{{ asset('images/gallery/gallery-5.jpg') }}"
                                     alt="Verifikasi Stopwatch Kru GBK"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                                <div class="absolute inset-0 bg-black/60"></div>
                                <div class="absolute top-3 left-3">
                                    <span class="px-2.5 py-0.5 rounded-full bg-unerd-volt text-unerd-ink font-mono font-bold text-[10px] uppercase">
                                        VERIFIKASI STOPWATCH
                                    </span>
                                </div>
                                <div class="absolute bottom-4 left-4 right-4 text-white">
                                    <span class="text-[10px] font-mono text-zinc-300 uppercase block">Kru Panitia di Lapangan</span>
                                    <h4 class="font-display font-bold text-base uppercase mt-0.5">Pencatatan Waktu Akurat</h4>
                                    <p class="text-[11px] text-zinc-300 mt-0.5">Format standar Indonesia dengan presisi dua digit milidetik.</p>
                                </div>
                            </div>

                            <!-- Photo 2: Running Focus & Rhythm (gallery-4.jpg) -->
                            <div class="group relative overflow-hidden rounded-2xl bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-md h-80 sm:h-96">
                                <img src="{{ asset('images/gallery/gallery-4.jpg') }}"
                                     alt="Fokus & Ritme Sprint"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                                <div class="absolute inset-0 bg-black/60"></div>
                                <div class="absolute top-3 left-3">
                                    <span class="px-2.5 py-0.5 rounded-full bg-black/60 backdrop-blur-xs text-white border border-white/20 font-mono font-bold text-[10px] uppercase">
                                        1 KM PACE FOCUS
                                    </span>
                                </div>
                                <div class="absolute bottom-4 left-4 right-4 text-white">
                                    <span class="text-[10px] font-mono text-zinc-300 uppercase block">Menjelang Garis Finish</span>
                                    <h4 class="font-display font-bold text-base uppercase mt-0.5">Ritme Maksimal di Lintasan</h4>
                                    <p class="text-[11px] text-zinc-300 mt-0.5">Jaga kestabilan tarikan nafas dan cadence hingga batas akhir.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ========================================================================= -->
            <!-- SECTION 3: KATEGORI & KOLABORASI KOMUNITAS (gallery-2.jpg & gallery-6.jpg)-->
            <!-- ========================================================================= -->
            <section id="community-race" class="py-14 sm:py-20 bg-white dark:bg-unerd-black transition-colors">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
                        <span class="px-3 py-1 rounded-pill bg-unerd-volt text-unerd-ink text-[11px] font-extrabold uppercase tracking-[2px] inline-block mb-3 font-display">
                            KATEGORI PESERTA
                        </span>
                        <h2 class="font-display text-2xl sm:text-4xl font-extrabold uppercase tracking-tight text-unerd-ink dark:text-white">
                            Papan Peringkat Sesuai Kategori Pelari
                        </h2>
                        <p class="text-xs sm:text-sm text-unerd-body dark:text-zinc-400 mt-2">
                            Setiap kategori memiliki leaderboard masing-masing agar persaingan tetap adil dan kompetitif bagi siapa pun yang turun ke lintasan.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                        <!-- Left: 2 Photos of Community & Runners (gallery-2.jpg & gallery-6.jpg) -->
                        <div class="lg:col-span-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Photo 1: Start Heat Komunitas (gallery-2.jpg) -->
                            <div class="group relative overflow-hidden rounded-2xl bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-md h-80 sm:h-96">
                                <img src="{{ asset('images/gallery/gallery-2.jpg') }}"
                                     alt="Start Heat Komunitas Pelari"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                                <div class="absolute inset-0 bg-black/60"></div>
                                <div class="absolute top-3 left-3">
                                    <span class="px-2.5 py-0.5 rounded-full bg-unerd-volt text-unerd-ink font-mono font-bold text-[10px] uppercase">
                                        START HEAT KOMUNITAS
                                    </span>
                                </div>
                                <div class="absolute bottom-4 left-4 right-4 text-white">
                                    <span class="text-[10px] font-mono text-zinc-300 uppercase block">Gengsi Tim & Mitra Lari</span>
                                    <h4 class="font-display font-bold text-base uppercase mt-0.5">Kekompakan di Lintasan</h4>
                                    <p class="text-[11px] text-zinc-300 mt-0.5">Komunitas saling adu catatan waktu tercepat di GBK.</p>
                                </div>
                            </div>

                            <!-- Photo 2: Finisher Bonding (gallery-6.jpg) -->
                            <div class="group relative overflow-hidden rounded-2xl bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-md h-80 sm:h-96">
                                <img src="{{ asset('images/gallery/gallery-6.jpg') }}"
                                     alt="Kebersamaan Pelari Finisher"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                                <div class="absolute inset-0 bg-black/60"></div>
                                <div class="absolute top-3 left-3">
                                    <span class="px-2.5 py-0.5 rounded-full bg-black/60 backdrop-blur-xs text-white border border-white/20 font-mono font-bold text-[10px] uppercase">
                                        SOLIDARITAS FINISHER
                                    </span>
                                </div>
                                <div class="absolute bottom-4 left-4 right-4 text-white">
                                    <span class="text-[10px] font-mono text-zinc-300 uppercase block">Semangat Post-Run</span>
                                    <h4 class="font-display font-bold text-base uppercase mt-0.5">Energi Positif Komunitas</h4>
                                    <p class="text-[11px] text-zinc-300 mt-0.5">Merayakan personal record bersama para pelari lainnya.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Category Cards Explanation -->
                        <div class="lg:col-span-6 space-y-4">
                            <!-- Category 1: UMUM -->
                            <div class="p-5 rounded-2xl bg-unerd-surface-card dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-xs">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="px-2.5 py-0.5 rounded-pill bg-slate-100 dark:bg-zinc-800 text-slate-800 dark:text-zinc-200 text-[10px] font-mono font-bold uppercase">
                                        KATEGORI 01
                                    </span>
                                    <span class="text-xs font-mono font-bold text-unerd-volt-dark dark:text-unerd-volt">Personal Best</span>
                                </div>
                                <h3 class="font-display font-bold text-lg text-unerd-ink dark:text-white uppercase">
                                    Pelari Umum (Independen)
                                </h3>
                                <p class="text-xs text-unerd-body dark:text-zinc-400 mt-1 leading-relaxed">
                                    Bagi siapa saja yang ingin menguji batas diri, mengukur kecepatan sprint 1 KM, dan melihat posisimu di antara ratusan pelari harian di GBK Jakarta.
                                </p>
                            </div>

                            <!-- Category 2: KOMUNITAS -->
                            <div class="p-5 rounded-2xl bg-unerd-surface-card dark:bg-zinc-900 border-2 border-unerd-volt/40 shadow-xs">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="px-2.5 py-0.5 rounded-pill bg-unerd-volt text-unerd-ink text-[10px] font-mono font-bold uppercase">
                                        KATEGORI 02 • RUN BY FIVE & MITRA
                                    </span>
                                    <span class="text-xs font-mono font-bold text-emerald-600 dark:text-emerald-400">Team Pace</span>
                                </div>
                                <h3 class="font-display font-bold text-lg text-unerd-ink dark:text-white uppercase">
                                    Pelari Komunitas Lari
                                </h3>
                                <p class="text-xs text-unerd-body dark:text-zinc-400 mt-1 leading-relaxed">
                                    Bawa nama komunitas larimu ke puncak klasemen. Catatan waktu anggota tim akan diakumulasi untuk menentukan komunitas lari tercepat di Jakarta.
                                </p>
                            </div>

                            <!-- Category 3: PROFESIONAL -->
                            <div class="p-5 rounded-2xl bg-unerd-surface-card dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-xs">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="px-2.5 py-0.5 rounded-pill bg-rose-500/10 text-rose-600 dark:text-rose-400 text-[10px] font-mono font-bold uppercase">
                                        KATEGORI 03
                                    </span>
                                    <span class="text-xs font-mono font-bold text-rose-500">Elite Pace</span>
                                </div>
                                <h3 class="font-display font-bold text-lg text-unerd-ink dark:text-white uppercase">
                                    Pelari Profesional & Atlet
                                </h3>
                                <p class="text-xs text-unerd-body dark:text-zinc-400 mt-1 leading-relaxed">
                                    Standar kompetisi lari presisi bagi pelari berkecepatan tinggi yang mengejar rekor waktu podium tercepat di bawah 3 menit.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ========================================================================= -->
            <!-- SECTION 4: SEPATU UNERD DI KAKI PELARI (Foto: gallery-3.jpg)             -->
            <!-- ========================================================================= -->
            <section id="footwear-performance" class="py-14 sm:py-20 bg-unerd-surface-card dark:bg-zinc-950/60 border-y border-unerd-hairline dark:border-zinc-800 transition-colors">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                        <!-- Left: Real Footwear on Track Photo (gallery-3.jpg) -->
                        <div class="lg:col-span-6 group relative overflow-hidden rounded-2xl bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-xl h-80 sm:h-[450px]">
                            <img src="{{ asset('images/gallery/gallery-3.jpg') }}"
                                 alt="Sepatu Lari UNERD on Track"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                            <div class="absolute inset-0 bg-black/60"></div>
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 rounded-full bg-unerd-volt text-unerd-ink font-mono font-bold text-xs uppercase tracking-wider">
                                    ON MY FEET • GBK TESTED
                                </span>
                            </div>
                            <div class="absolute bottom-5 left-5 right-5 text-white">
                                <span class="text-xs font-mono text-zinc-300 uppercase block">UNERD Performance Footwear</span>
                                <h3 class="font-display font-extrabold text-xl sm:text-2xl uppercase mt-0.5">
                                    Grip Tangguh & Responsivitas Maksimal
                                </h3>
                                <p class="text-xs text-zinc-300 mt-1">
                                    Diuji langsung di aspal lintasan GBK Jakarta untuk memastikan traksi dan bantalan yang stabil di setiap langkah.
                                </p>
                            </div>
                        </div>

                        <!-- Right: Engineered for Indonesian Runners -->
                        <div class="lg:col-span-6 space-y-6">
                            <div>
                                <span class="px-3 py-1 rounded-pill bg-unerd-black dark:bg-zinc-800 text-white text-[11px] font-bold uppercase tracking-[2px] inline-block mb-3">
                                    ENGINEERED FOR RUNNERS
                                </span>
                                <h2 class="font-display text-2xl sm:text-4xl font-extrabold uppercase tracking-tight text-unerd-ink dark:text-white">
                                    Dirancang Khusus untuk Bentuk Kaki Pelari Indonesia
                                </h2>
                                <p class="text-xs sm:text-sm text-unerd-body dark:text-zinc-400 mt-2 leading-relaxed">
                                    UNERD menghadirkan sepatu lari lokal dengan standar performa internasional. Fitting true-to-size yang pas di kaki tanpa rasa sempit atau lecet.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                                <div class="p-4 rounded-xl bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-xs">
                                    <div class="flex items-center gap-2 font-display font-bold text-sm text-unerd-ink dark:text-white mb-1.5">
                                        <svg class="w-4 h-4 text-unerd-volt-dark dark:text-unerd-volt shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        <span>Anatomi Lebar Nyaman</span>
                                    </div>
                                    <p class="text-unerd-body dark:text-zinc-400">
                                        Toe-box ergonomis yang memberi ruang jari kaki berpijak natural tanpa terjepit saat mendarat.
                                    </p>
                                </div>

                                <div class="p-4 rounded-xl bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-xs">
                                    <div class="flex items-center gap-2 font-display font-bold text-sm text-unerd-ink dark:text-white mb-1.5">
                                        <svg class="w-4 h-4 text-unerd-volt-dark dark:text-unerd-volt shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                        <span>Midsole Rebound Cepat</span>
                                    </div>
                                    <p class="text-unerd-body dark:text-zinc-400">
                                        Bantalan busa responsif yang mengembalikan energi dorong di setiap langkah sprint 1.000 meter.
                                    </p>
                                </div>

                                <div class="p-4 rounded-xl bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-xs">
                                    <div class="flex items-center gap-2 font-display font-bold text-sm text-unerd-ink dark:text-white mb-1.5">
                                        <svg class="w-4 h-4 text-unerd-volt-dark dark:text-unerd-volt shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                                        </svg>
                                        <span>Outsole Anti-Selip</span>
                                    </div>
                                    <p class="text-unerd-body dark:text-zinc-400">
                                        Pola kompon karet tahan aus yang mencengkeram aspal GBK saat akselerasi maupun pengereman mendadak.
                                    </p>
                                </div>

                                <div class="p-4 rounded-xl bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-xs">
                                    <div class="flex items-center gap-2 font-display font-bold text-sm text-unerd-ink dark:text-white mb-1.5">
                                        <svg class="w-4 h-4 text-unerd-volt-dark dark:text-unerd-volt shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                        </svg>
                                        <span>Ukuran Lengkap EU 38–45</span>
                                    </div>
                                    <p class="text-unerd-body dark:text-zinc-400">
                                        Ukuran standar pelari Indonesia, otomatis disesuaikan dengan profil dan hadiah voucher kamu.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3 Products Gallery Showcase -->
                    <div class="mt-12 pt-10 border-t border-unerd-hairline dark:border-zinc-800">
                        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 mb-8">
                            <div>
                                <span class="text-xs font-bold uppercase tracking-[2px] text-unerd-volt-dark dark:text-unerd-volt font-mono">
                                    KOLEKSI PILIHAN PELARI • SHOP THE MOVE
                                </span>
                                <h3 class="font-display text-xl sm:text-3xl font-extrabold uppercase text-unerd-ink dark:text-white mt-1">
                                    Koleksi Resmi Sepatu UNERD
                                </h3>
                            </div>
                            <span class="text-xs text-unerd-muted dark:text-zinc-400">
                                Dapatkan potongan 10% voucher resmi langsung di official store Shopee
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Product 1 -->
                            <div class="group rounded-3xl border border-unerd-hairline dark:border-zinc-800 bg-white dark:bg-zinc-900 overflow-hidden hover:border-unerd-volt transition-all duration-300 shadow-md hover:shadow-xl flex flex-col justify-between">
                                <div>
                                    <div class="aspect-4/3 w-full bg-zinc-100 dark:bg-zinc-800 overflow-hidden relative">
                                        <img src="{{ asset('images/products/unerd-beat-flow-performance.jpg') }}"
                                             alt="UNERD Beat Flow Performance"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" />
                                        <div class="absolute inset-0 bg-black/50"></div>
                                        <div class="absolute top-4 left-4">
                                            <span class="px-2.5 py-1 rounded bg-unerd-volt text-unerd-ink font-mono font-bold text-xs uppercase">
                                                PERFORMANCE
                                            </span>
                                        </div>
                                        <div class="absolute top-4 right-4">
                                            <span class="px-2.5 py-1 rounded-full bg-black/70 backdrop-blur text-[11px] font-mono font-bold text-white border border-white/20">
                                                EU 38–45
                                            </span>
                                        </div>
                                        <div class="absolute bottom-3 left-4 right-4 text-white">
                                            <span class="text-[11px] font-mono tracking-wider uppercase text-zinc-200">
                                                Nusantara Edition • Road Running
                                            </span>
                                        </div>
                                    </div>
                                    <div class="p-5 sm:p-6">
                                        <div class="text-xs font-mono font-bold text-unerd-volt-dark dark:text-unerd-volt uppercase tracking-wider mb-1">
                                            Performance Running
                                        </div>
                                        <h4 class="font-display font-extrabold text-lg sm:text-xl text-unerd-ink dark:text-white leading-tight">
                                            UNERD Beat Flow Performance
                                        </h4>
                                        <p class="text-xs sm:text-sm text-unerd-body dark:text-zinc-300 mt-2.5 leading-relaxed">
                                            Bantalan responsif dengan stabilitas pijakan optimal untuk akselerasi sprint 1 KM maupun long run di lintasan aspal.
                                        </p>
                                    </div>
                                </div>
                                <div class="p-5 sm:p-6 pt-0">
                                    <div class="pt-4 border-t border-unerd-hairline dark:border-zinc-800 flex items-center justify-between gap-3">
                                        <div>
                                            <span class="text-xs line-through text-unerd-muted dark:text-zinc-500 block">Rp 469.000</span>
                                            <div class="flex items-center gap-1.5">
                                                <span class="font-display font-black text-base sm:text-lg text-emerald-600 dark:text-unerd-volt">Rp 422.100</span>
                                                <span class="text-[10px] font-bold text-emerald-700 dark:text-emerald-300 bg-emerald-100 dark:bg-emerald-950 px-1.5 py-0.5 rounded">-10%</span>
                                            </div>
                                        </div>
                                        <a href="https://shopee.co.id/UNERD-PERFORMANCE-BEAT-FLOW-NUSANTARA-SEPATU-RUNNING-PRIA-WANITA-JOGJA-i.305818928.48571828579?extraParams=%7B%22display_model_id%22%3A303096235058%2C%22model_selection_logic%22%3A3%7D&image_ids=sg-11134201-8259u-mvmw40mkmz9h4a"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-unerd-black dark:bg-white text-white dark:text-unerd-black text-xs font-extrabold uppercase rounded-xl hover:bg-unerd-black-active dark:hover:bg-zinc-200 transition-all duration-200 shadow hover:shadow-md shrink-0">
                                            <span>Beli di Shopee</span>
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Product 2 -->
                            <div class="group rounded-3xl border border-unerd-hairline dark:border-zinc-800 bg-white dark:bg-zinc-900 overflow-hidden hover:border-unerd-volt transition-all duration-300 shadow-md hover:shadow-xl flex flex-col justify-between">
                                <div>
                                    <div class="aspect-4/3 w-full bg-zinc-100 dark:bg-zinc-800 overflow-hidden relative">
                                        <img src="{{ asset('images/products/unerd-women-swift-move.jpg') }}"
                                             alt="UNERD Women Swift Move"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" />
                                        <div class="absolute inset-0 bg-black/50"></div>
                                        <div class="absolute top-4 left-4">
                                            <span class="px-2.5 py-1 rounded bg-unerd-volt text-unerd-ink font-mono font-bold text-xs uppercase">
                                                WOMEN MOVE
                                            </span>
                                        </div>
                                        <div class="absolute top-4 right-4">
                                            <span class="px-2.5 py-1 rounded-full bg-black/70 backdrop-blur text-[11px] font-mono font-bold text-white border border-white/20">
                                                EU 36–41
                                            </span>
                                        </div>
                                        <div class="absolute bottom-3 left-4 right-4 text-white">
                                            <span class="text-[11px] font-mono tracking-wider uppercase text-zinc-200">
                                                Radiant Lotus • Sport Active
                                            </span>
                                        </div>
                                    </div>
                                    <div class="p-5 sm:p-6">
                                        <div class="text-xs font-mono font-bold text-unerd-volt-dark dark:text-unerd-volt uppercase tracking-wider mb-1">
                                            Women Sport & Running
                                        </div>
                                        <h4 class="font-display font-extrabold text-lg sm:text-xl text-unerd-ink dark:text-white leading-tight">
                                            UNERD Women Swift Move
                                        </h4>
                                        <p class="text-xs sm:text-sm text-unerd-body dark:text-zinc-300 mt-2.5 leading-relaxed">
                                            Siluet dinamis dan ringan khusus rancangan anatomi wanita, fleksibel untuk pemanasan lari santai hingga mobilitas harian.
                                        </p>
                                    </div>
                                </div>
                                <div class="p-5 sm:p-6 pt-0">
                                    <div class="pt-4 border-t border-unerd-hairline dark:border-zinc-800 flex items-center justify-between gap-3">
                                        <div>
                                            <span class="text-xs line-through text-unerd-muted dark:text-zinc-500 block">Rp 459.000</span>
                                            <div class="flex items-center gap-1.5">
                                                <span class="font-display font-black text-base sm:text-lg text-emerald-600 dark:text-unerd-volt">Rp 413.100</span>
                                                <span class="text-[10px] font-bold text-emerald-700 dark:text-emerald-300 bg-emerald-100 dark:bg-emerald-950 px-1.5 py-0.5 rounded">-10%</span>
                                            </div>
                                        </div>
                                        <a href="https://shopee.co.id/-UNERD-WOMEN-SWIFT-MOVE-Sepatu-Sport-Casual-Sport-Style-Wanita-Dewasa-Radiant-Lotus-i.305818928.45956395884?extraParams=%7B%22display_model_id%22%3A390575836112%2C%22model_selection_logic%22%3A3%7D&image_ids=id-11134207-8224y-ml3dar736a6e9b"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-unerd-black dark:bg-white text-white dark:text-unerd-black text-xs font-extrabold uppercase rounded-xl hover:bg-unerd-black-active dark:hover:bg-zinc-200 transition-all duration-200 shadow hover:shadow-md shrink-0">
                                            <span>Beli di Shopee</span>
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Product 3 -->
                            <div class="group rounded-3xl border border-unerd-hairline dark:border-zinc-800 bg-white dark:bg-zinc-900 overflow-hidden hover:border-unerd-volt transition-all duration-300 shadow-md hover:shadow-xl flex flex-col justify-between">
                                <div>
                                    <div class="aspect-4/3 w-full bg-zinc-100 dark:bg-zinc-800 overflow-hidden relative">
                                        <img src="{{ asset('images/products/unerd-thera-reco-lifestyle.jpg') }}"
                                             alt="UNERD Thera Reco Lifestyle"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" />
                                        <div class="absolute inset-0 bg-black/50"></div>
                                        <div class="absolute top-4 left-4">
                                            <span class="px-2.5 py-1 rounded bg-blue-600 text-white font-mono font-bold text-xs uppercase">
                                                RECOVERY & LIFESTYLE
                                            </span>
                                        </div>
                                        <div class="absolute top-4 right-4">
                                            <span class="px-2.5 py-1 rounded-full bg-black/70 backdrop-blur text-[11px] font-mono font-bold text-white border border-white/20">
                                                EU 38–45
                                            </span>
                                        </div>
                                        <div class="absolute bottom-3 left-4 right-4 text-white">
                                            <span class="text-[11px] font-mono tracking-wider uppercase text-zinc-200">
                                                Ergonomic Sandal Sepatu
                                            </span>
                                        </div>
                                    </div>
                                    <div class="p-5 sm:p-6">
                                        <div class="text-xs font-mono font-bold text-unerd-volt-dark dark:text-unerd-volt uppercase tracking-wider mb-1">
                                            Lifestyle & Recovery
                                        </div>
                                        <h4 class="font-display font-extrabold text-lg sm:text-xl text-unerd-ink dark:text-white leading-tight">
                                            UNERD Thera Reco Lifestyle
                                        </h4>
                                        <p class="text-xs sm:text-sm text-unerd-body dark:text-zinc-300 mt-2.5 leading-relaxed">
                                            Footwear pemulihan pasca lari dengan footbed ergonomis empuk yang merelaksasi telapak kaki setelah latihan lari intensif.
                                        </p>
                                    </div>
                                </div>
                                <div class="p-5 sm:p-6 pt-0">
                                    <div class="pt-4 border-t border-unerd-hairline dark:border-zinc-800 flex items-center justify-between gap-3">
                                        <div>
                                            <span class="text-xs line-through text-unerd-muted dark:text-zinc-500 block">Rp 299.000</span>
                                            <div class="flex items-center gap-1.5">
                                                <span class="font-display font-black text-base sm:text-lg text-emerald-600 dark:text-unerd-volt">Rp 269.100</span>
                                                <span class="text-[10px] font-bold text-emerald-700 dark:text-emerald-300 bg-emerald-100 dark:bg-emerald-950 px-1.5 py-0.5 rounded">-10%</span>
                                            </div>
                                        </div>
                                        <a href="https://shopee.co.id/UNERD-THERA-RECO-Sandal-Sepatu-Pria-Wanita-i.305818928.56018366974?extraParams=%7B%22display_model_id%22%3A366544255922%2C%22model_selection_logic%22%3A3%7D&image_ids=sg-11134201-82599-mthzt0pq8yrl86"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-unerd-black dark:bg-white text-white dark:text-unerd-black text-xs font-extrabold uppercase rounded-xl hover:bg-unerd-black-active dark:hover:bg-zinc-200 transition-all duration-200 shadow hover:shadow-md shrink-0">
                                            <span>Beli di Shopee</span>
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ========================================================================= -->
            <!-- SECTION 5: HADIAH PODIUM JUARA & VOUCHER (Foto: gallery-7.jpg)           -->
            <!-- ========================================================================= -->
            <section id="prizes-rewards" class="py-14 sm:py-20 bg-white dark:bg-unerd-black transition-colors">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                        <!-- Left: Explanation of Prizes & Vouchers -->
                        <div class="lg:col-span-7 space-y-6">
                            <div>
                                <span class="px-3 py-1 rounded-pill bg-unerd-volt text-unerd-ink text-[11px] font-extrabold uppercase tracking-[2px] inline-block mb-3 font-display">
                                    APRESIASI PELARI
                                </span>
                                <h2 class="font-display text-2xl sm:text-4xl font-extrabold uppercase tracking-tight text-unerd-ink dark:text-white">
                                    Hadiah Juara 1–10 & Voucher Belanja
                                </h2>
                                <p class="text-xs sm:text-sm text-unerd-body dark:text-zinc-400 mt-2">
                                    Kerja kerasmu di lintasan layak mendapatkan apresiasi terbaik dari UNERD.
                                </p>
                            </div>

                            <div class="space-y-3">
                                <!-- Juara 1 -->
                                <div class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 flex items-center justify-between gap-4 transition hover:border-unerd-volt">
                                    <div class="flex items-center gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center shrink-0 text-unerd-ink dark:text-white">
                                            <svg class="w-5 h-5 text-unerd-volt-dark dark:text-unerd-volt" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21h8m-4-4v4m-6-17h12a2 2 0 012 2v2a6 6 0 01-6 6h0a6 6 0 01-6-6V4a2 2 0 012-2zm-2 4H2a2 2 0 00-2 2v1a4 4 0 004 4h2m12-7h2a2 2 0 012 2v1a4 4 0 01-4 4h-2" />
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="font-mono text-[10px] uppercase font-bold text-unerd-muted dark:text-zinc-400">PODIUM 1</span>
                                            <h4 class="font-display font-extrabold text-sm sm:text-base uppercase text-unerd-ink dark:text-white">
                                                Sepatu UNERD Pilihan Sesuai Ukuran Kaki
                                            </h4>
                                        </div>
                                    </div>
                                    <span class="text-xs font-mono font-bold text-unerd-ink dark:text-white shrink-0">+ Voucher 10%</span>
                                </div>

                                <!-- Juara 2 & 3 -->
                                <div class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 flex items-center justify-between gap-4 transition hover:border-unerd-volt">
                                    <div class="flex items-center gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center shrink-0 text-unerd-ink dark:text-white">
                                            <svg class="w-5 h-5 text-unerd-ink dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <circle cx="12" cy="8" r="6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11" />
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="font-mono text-[10px] uppercase font-bold text-unerd-muted dark:text-zinc-400">PODIUM 2 & 3</span>
                                            <h4 class="font-display font-extrabold text-sm sm:text-base uppercase text-unerd-ink dark:text-white">
                                                Hadiah Uang Tunai Pembinaan
                                            </h4>
                                        </div>
                                    </div>
                                    <span class="text-xs font-mono font-bold text-unerd-ink dark:text-white shrink-0">+ Voucher 10%</span>
                                </div>

                                <!-- Top 10 Finisher -->
                                <div class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 flex items-center justify-between gap-4 transition hover:border-unerd-volt">
                                    <div class="flex items-center gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center shrink-0 text-unerd-ink dark:text-white">
                                            <svg class="w-5 h-5 text-unerd-ink dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="font-mono text-[10px] uppercase font-bold text-unerd-muted dark:text-zinc-400">PERINGKAT 4–10</span>
                                            <h4 class="font-display font-extrabold text-sm sm:text-base uppercase text-unerd-ink dark:text-white">
                                                Voucher Diskon Belanja Eksklusif 10%
                                            </h4>
                                            <span class="text-[11px] text-unerd-muted dark:text-zinc-400 font-mono block mt-0.5">
                                                *Masa berlaku voucher: 1 Minggu (7 Hari) sejak diterbitkan
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-2">
                                <a href="{{ route('register') }}"
                                   class="inline-flex items-center justify-center px-8 py-3.5 bg-unerd-black dark:bg-white text-white dark:text-unerd-black font-display text-xs font-bold uppercase tracking-wider rounded-xl hover:opacity-90 transition shadow-md">
                                    Daftar Sekarang & Rebut Hadiahnya →
                                </a>
                            </div>
                        </div>

                        <!-- Right: Podium Celebration Photo (gallery-7.jpg) -->
                        <div class="lg:col-span-5 group relative overflow-hidden rounded-2xl bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-xl h-80 sm:h-[450px]">
                            <img src="{{ asset('images/gallery/gallery-7.jpg') }}"
                                 alt="Selebrasi Podium & Hadiah Sepatu UNERD"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                            <div class="absolute inset-0 bg-black/60"></div>
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 rounded-full bg-unerd-volt text-unerd-ink font-mono font-bold text-xs uppercase tracking-wider">
                                    SELEBRASI PODIUM
                                </span>
                            </div>
                            <div class="absolute bottom-5 left-5 right-5 text-white">
                                <span class="text-xs font-mono text-zinc-300 uppercase block">Finisher & Champion Pride</span>
                                <h3 class="font-display font-extrabold text-xl uppercase mt-0.5">
                                    Apresiasi Kemenangan di GBK
                                </h3>
                                <p class="text-xs text-zinc-300 mt-1">
                                    Hadiah sepatu UNERD dan voucher langsung dapat diklaim pelari tercepat.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Signature UNERD MOVE Footer (Master Logo on Desktop, Icon on Mobile) -->
        <footer class="bg-unerd-surface-card dark:bg-zinc-950 border-t border-unerd-hairline dark:border-zinc-800 py-10 transition-colors">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
                    <x-application-logo />
                    <div>
                        <div class="text-xs font-mono font-bold uppercase text-unerd-ink dark:text-white">
                            UNERD MOVE SERIES • Race. Move. Share.
                        </div>
                        <div class="text-[11px] text-unerd-muted dark:text-zinc-400">
                            Pilot Activation: GBK Jakarta, 21 November 2026 • Official 1 KM Run Challenge
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-4 text-xs font-bold text-unerd-ink dark:text-zinc-300">
                    <a href="{{ route('everyday-league.leaderboard') }}" class="hover:underline">Leaderboard</a>
                    <a href="{{ route('login') }}" class="hover:underline">Portal Login →</a>
                </div>
            </div>
        </footer>
    </body>
</html>
