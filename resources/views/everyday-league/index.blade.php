<x-guest-layout>
    <!-- Top Nav Header (72px) with Collapsible Mobile Navbar -->
    <header x-data="{ mobileNavOpen: false }" class="sticky top-0 z-40 bg-white/95 dark:bg-zinc-900/95 backdrop-blur-md border-b border-unerd-hairline dark:border-zinc-800 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-[68px] sm:h-[72px] flex items-center justify-between">
            <div class="flex items-center gap-4 sm:gap-8">
                <!-- Master Logo (Desktop) & Icon (Mobile) -->
                <a href="{{ route('everyday-league.index') }}" class="flex items-center gap-2">
                    <x-application-logo />
                </a>

                <nav class="hidden md:flex items-center space-x-1 text-xs font-bold uppercase tracking-wider text-unerd-body dark:text-zinc-300">
                    <a href="#timing-system" class="px-3 py-1.5 hover:text-unerd-ink dark:hover:text-white rounded-md transition">Cara Ikut</a>
                    <a href="#event-experience" class="px-3 py-1.5 hover:text-unerd-ink dark:hover:text-white rounded-md transition">Aktivitas Event</a>
                    <a href="#challenges" class="px-3 py-1.5 hover:text-unerd-ink dark:hover:text-white rounded-md transition">Join Challenge</a>
                    <a href="#prizes-rewards" class="px-3 py-1.5 hover:text-unerd-ink dark:hover:text-white rounded-md transition">Hadiah & Voucher</a>
                    <a href="#products" class="px-3 py-1.5 hover:text-unerd-ink dark:hover:text-white rounded-md transition">Koleksi Sepatu</a>
                    <a href="{{ route('everyday-league.leaderboard') }}" class="px-3 py-1.5 hover:text-unerd-ink dark:hover:text-white rounded-md transition">Leaderboard Live</a>
                </nav>
            </div>

            <!-- Right Cluster -->
            <div class="flex items-center gap-2 sm:gap-3">
                <x-theme-toggle />

                @auth
                    <a href="{{ route('dashboard') }}"
                       class="hidden sm:inline-flex items-center justify-center h-10 px-4 sm:px-5 bg-unerd-black dark:bg-white hover:bg-unerd-black-active dark:hover:bg-zinc-200 text-white dark:text-unerd-black text-xs font-bold uppercase tracking-wider rounded-md transition">
                        Dashboard →
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="hidden sm:inline-flex items-center justify-center h-10 px-3 sm:px-4 text-xs font-bold uppercase tracking-wider text-unerd-ink dark:text-zinc-200 hover:bg-unerd-surface-card dark:hover:bg-zinc-800 rounded-md transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="hidden sm:inline-flex items-center justify-center h-10 px-4 sm:px-5 bg-unerd-black dark:bg-white hover:bg-unerd-black-active dark:hover:bg-zinc-200 text-white dark:text-unerd-black text-xs font-bold uppercase tracking-wider rounded-md transition shadow-xs">
                        Daftar Akun
                    </a>
                @endauth

                <!-- Mobile Hamburger Toggle Button -->
                <button type="button"
                        @click="mobileNavOpen = !mobileNavOpen"
                        class="md:hidden p-2 rounded-xl text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800 transition flex items-center justify-center"
                        aria-label="Toggle Menu">
                    <svg x-show="!mobileNavOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileNavOpen" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Collapsible Mobile Menu Drawer -->
        <div x-show="mobileNavOpen"
             x-cloak
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden border-t border-unerd-hairline dark:border-zinc-800 bg-white dark:bg-zinc-900 px-4 py-4 space-y-3 shadow-xl">

            <nav class="flex flex-col space-y-1 text-xs font-bold uppercase tracking-wider text-unerd-body dark:text-zinc-300">
                <a href="#timing-system" @click="mobileNavOpen = false" class="px-3.5 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-zinc-800 transition">
                    Cara Ikut
                </a>
                <a href="#event-experience" @click="mobileNavOpen = false" class="px-3.5 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-zinc-800 transition">
                    Aktivitas Event
                </a>
                <a href="#challenges" @click="mobileNavOpen = false" class="px-3.5 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-zinc-800 transition">
                    Join Challenge
                </a>
                <a href="#prizes-rewards" @click="mobileNavOpen = false" class="px-3.5 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-zinc-800 transition">
                    Hadiah & Voucher
                </a>
                <a href="#products" @click="mobileNavOpen = false" class="px-3.5 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-zinc-800 transition">
                    Koleksi Sepatu
                </a>
                <a href="{{ route('everyday-league.leaderboard') }}" @click="mobileNavOpen = false" class="px-3.5 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-zinc-800 transition flex items-center justify-between">
                    <span>Leaderboard Live</span>
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                </a>
            </nav>

            <div class="pt-3 border-t border-slate-100 dark:border-zinc-800 flex flex-col gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="w-full text-center py-3 bg-unerd-black dark:bg-white text-white dark:text-unerd-black text-xs font-bold uppercase tracking-wider rounded-xl transition">
                        Buka Dashboard &rarr;
                    </a>
                @else
                    <a href="{{ route('register') }}" class="w-full text-center py-3 bg-unerd-black dark:bg-white text-white dark:text-unerd-black text-xs font-bold uppercase tracking-wider rounded-xl transition shadow-xs">
                        Daftar Akun Baru
                    </a>
                    <a href="{{ route('login') }}" class="w-full text-center py-2.5 text-xs font-bold uppercase tracking-wider text-unerd-ink dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800 rounded-xl transition">
                        Masuk ke Akun
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main class="flex-1">
        <!-- HERO SECTION (Natural Runner Copywriting) -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16 lg:py-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                <!-- Left Hero Content -->
                <div class="lg:col-span-7 space-y-4 sm:space-y-6">
                    <div class="space-y-2">
                        <h1 class="font-display text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-[-2px] sm:tracking-[-3px] leading-[0.98] uppercase text-unerd-ink dark:text-white">
                            TIME ATTACK <br>
                            <span class="text-unerd-volt">CHALLENGE.</span>
                        </h1>
                    </div>

                    <p class="text-sm sm:text-base text-unerd-body dark:text-zinc-300 leading-relaxed font-sans max-w-xl">
                        Daftarkan dirimu dan Ikuti tantangan lari 3000 Meter dari UNERD Performance, Buktikan bahwa dirimu yang tercepat di live leaderboard!
                    </p>

                    <!-- CTAs -->
                    <div class="flex flex-col sm:flex-row flex-wrap items-stretch sm:items-center gap-2.5 sm:gap-3 pt-2">
                        @auth
                            <a href="{{ route('dashboard') }}"
                               class="inline-flex items-center justify-center h-12 px-6 sm:px-7 bg-unerd-black dark:bg-white hover:bg-unerd-black-active dark:hover:bg-zinc-200 text-white dark:text-unerd-black font-display text-xs sm:text-sm font-bold tracking-[0.5px] uppercase rounded-md transition shadow-md text-center">
                                DASHBOARD
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center justify-center h-12 px-6 sm:px-7 bg-unerd-black dark:bg-white hover:bg-unerd-black-active dark:hover:bg-zinc-200 text-white dark:text-unerd-black font-display text-xs sm:text-sm font-bold tracking-[0.5px] uppercase rounded-md transition shadow-md text-center">
                                DAFTAR SEKARANG
                            </a>
                        @endauth

                        <a href="{{ auth()->check() ? route('everyday-league.register') : route('register') }}"
                           class="inline-flex items-center justify-center h-12 px-6 sm:px-7 bg-unerd-volt hover:bg-unerd-volt-dark text-unerd-ink font-display text-xs sm:text-sm font-extrabold tracking-[0.5px] uppercase rounded-md transition shadow-md text-center">
                            JOIN CHALLENGE
                        </a>

                        <a href="{{ route('everyday-league.leaderboard') }}"
                           class="inline-flex items-center justify-center h-12 px-5 bg-white dark:bg-zinc-900 hover:bg-unerd-surface-card dark:hover:bg-zinc-800 text-unerd-ink dark:text-zinc-100 font-display text-xs sm:text-sm font-bold tracking-[0.5px] uppercase border border-unerd-hairline dark:border-zinc-700 rounded-md transition text-center">
                            LIHAT LEADERBOARD
                        </a>
                    </div>

                    <!-- Fast Facts for Runners -->
                    <div class="grid grid-cols-3 gap-2 sm:gap-4 pt-6 border-t border-unerd-hairline dark:border-zinc-800 max-w-lg text-center sm:text-left">
                        <div class="p-2 sm:p-0">
                            <div class="text-[10px] sm:text-[11px] uppercase tracking-wider text-unerd-muted dark:text-zinc-400 font-bold">JARAK</div>
                            <div class="font-display font-black text-sm sm:text-base text-unerd-ink dark:text-white mt-0.5">
                                3000M
                            </div>
                        </div>
                        <div class="p-2 sm:p-0">
                            <div class="text-[10px] sm:text-[11px] uppercase tracking-wider text-unerd-muted dark:text-zinc-400 font-bold">LOKASI</div>
                            <div class="font-display font-black text-sm sm:text-base text-unerd-ink dark:text-white mt-0.5">
                                {{ $activePeriod ? explode(',', $activePeriod->location ?? 'GBK Jakarta')[0] : 'GBK Jakarta' }}
                            </div>
                        </div>
                        <div class="p-2 sm:p-0">
                            <div class="text-[10px] sm:text-[11px] uppercase tracking-wider text-unerd-muted dark:text-zinc-400 font-bold">TANGGAL</div>
                            <div class="font-display font-black text-sm sm:text-base text-unerd-volt mt-0.5">
                                {{ ($activePeriod && $activePeriod->event_date) ? $activePeriod->event_date->translatedFormat('d M Y') : '21 Nov 2026' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Hero: Live Top 3 Runners Preview -->
                <div class="lg:col-span-5">
                    <div class="p-6 sm:p-8 rounded-xl bg-unerd-surface-card dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 relative overflow-hidden shadow-lg">
                        <!-- Hero Photo Banner with GBK Runner -->
                        <div class="relative h-36 -mx-6 sm:-mx-8 -mt-6 sm:-mt-8 mb-4 overflow-hidden border-b border-unerd-hairline dark:border-zinc-800">
                            <img src="{{ asset('images/gallery/gallery-1.jpg') }}" alt="Top 3 GBK Sprint" class="w-full h-full object-cover filter brightness-90 contrast-110" />
                            <div class="absolute inset-0 bg-black/60"></div>
                            <div class="absolute bottom-2.5 left-4 right-4 flex items-center justify-between">
                                <span class="px-2 py-0.5 rounded-full bg-unerd-volt text-unerd-ink font-mono font-bold text-[10px] uppercase">
                                    {{ $activeChallenge ? 'LEADERBOARD • ' . strtoupper(explode(',', $activeChallenge->location ?? 'LIVE')[0]) : 'LIVE LEADERBOARD' }}
                                </span>
                                <span class="text-[11px] font-mono font-bold text-white">
                                    {{ $activePeriod ? $activePeriod->formattedDistance() : ($activeChallenge ? $activeChallenge->formattedDistance() : '3 KM Sprint') }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pb-4 border-b border-unerd-hairline dark:border-zinc-800">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span class="text-xs font-mono font-bold uppercase tracking-wider text-unerd-ink dark:text-zinc-200">
                                    Top 3 Run Challenge
                                </span>
                            </div>
                            <span class="text-[11px] text-unerd-muted dark:text-zinc-400 font-mono">
                                {{ $activeChallenge ? explode(',', $activeChallenge->location ?? 'Live')[0] : 'Live' }}
                            </span>
                        </div>

                        <!-- Podium List -->
                        <div class="my-4 divide-y divide-unerd-hairline dark:divide-zinc-800">
                            @forelse ($topRunners as $index => $runner)
                                <div class="py-3 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-7 h-7 rounded-full flex items-center justify-center font-display font-extrabold text-xs {{ $index === 0 ? 'bg-unerd-volt text-unerd-ink font-black' : 'bg-unerd-surface-soft dark:bg-zinc-800 text-unerd-ink dark:text-white' }}">
                                            #{{ $index + 1 }}
                                        </div>
                                        <div>
                                            <div class="font-display font-bold text-sm text-unerd-ink dark:text-white leading-tight">
                                                {{ $runner->participant?->display_name }}
                                            </div>
                                            <div class="text-[11px] text-unerd-muted dark:text-zinc-400">
                                                {{ $runner->participant?->community?->name ?? 'Independen' }} • {{ $runner->participant?->participant_category }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-mono font-bold text-sm text-unerd-ink dark:text-white">
                                            {{ $runner->formattedTime() }}
                                        </div>
                                        <div class="text-[10px] font-mono text-emerald-600 dark:text-emerald-400">
                                            {{ $runner->formattedPace() }}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="py-6 text-center text-xs text-unerd-muted dark:text-zinc-400">
                                    Jadilah yang pertama mencatatkan waktu di lintasan!
                                </div>
                            @endforelse
                        </div>

                        <div class="pt-2">
                            <a href="{{ route('everyday-league.leaderboard') }}"
                               class="block w-full py-2.5 text-center text-xs font-bold uppercase tracking-wider rounded-md bg-unerd-black dark:bg-white text-white dark:text-unerd-black hover:bg-unerd-black-active dark:hover:bg-zinc-200 transition">
                                Buka Leaderboard Lengkap →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 2: CARA IKUT UNERD PERFORMANCE TIME ATTACK CHALLENGE (1 IMAGE) -->
        <section id="timing-system" class="py-14 sm:py-20 bg-unerd-surface-card dark:bg-zinc-950/60 border-y border-unerd-hairline dark:border-zinc-800 transition-colors">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-stretch">
                    <!-- Left: 6 Steps to Join -->
                    <div class="lg:col-span-6 space-y-6 flex flex-col justify-between">
                        <div>
                            <h2 class="font-display text-2xl sm:text-4xl font-extrabold uppercase tracking-tight text-unerd-ink dark:text-white">
                                Cara Ikut UNERD Time Attack Challenge
                            </h2>
                        </div>

                        <div class="space-y-3">
                            <div class="p-3.5 sm:p-4 rounded-xl bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 flex items-center gap-3.5 shadow-xs">
                                <div class="w-8 h-8 rounded-lg bg-unerd-black text-white dark:bg-unerd-volt dark:text-black flex items-center justify-center font-black font-display text-xs shrink-0">
                                    01
                                </div>
                                <div class="text-xs sm:text-sm font-medium text-unerd-ink dark:text-zinc-200">
                                    Buat akun gratis <a href="{{ route('register') }}" class="underline font-bold text-unerd-volt hover:text-unerd-volt/80 transition">disini</a>
                                </div>
                            </div>

                            <div class="p-3.5 sm:p-4 rounded-xl bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 flex items-center gap-3.5 shadow-xs">
                                <div class="w-8 h-8 rounded-lg bg-unerd-black text-white dark:bg-unerd-volt dark:text-black flex items-center justify-center font-black font-display text-xs shrink-0">
                                    02
                                </div>
                                <div class="text-xs sm:text-sm font-medium text-unerd-ink dark:text-zinc-200">
                                    Datang ke booth UNERD Performance di GBK
                                </div>
                            </div>

                            <div class="p-3.5 sm:p-4 rounded-xl bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 flex items-center gap-3.5 shadow-xs">
                                <div class="w-8 h-8 rounded-lg bg-unerd-black text-white dark:bg-unerd-volt dark:text-black flex items-center justify-center font-black font-display text-xs shrink-0">
                                    03
                                </div>
                                <div class="text-xs sm:text-sm font-medium text-unerd-ink dark:text-zinc-200">
                                    Tunjukan kode unik ke panitia untuk mulai Time Attack Challenge
                                </div>
                            </div>

                            <div class="p-3.5 sm:p-4 rounded-xl bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 flex items-center gap-3.5 shadow-xs">
                                <div class="w-8 h-8 rounded-lg bg-unerd-black text-white dark:bg-unerd-volt dark:text-black flex items-center justify-center font-black font-display text-xs shrink-0">
                                    04
                                </div>
                                <div class="text-xs sm:text-sm font-medium text-unerd-ink dark:text-zinc-200">
                                    Lari!
                                </div>
                            </div>

                            <div class="p-3.5 sm:p-4 rounded-xl bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 flex items-center gap-3.5 shadow-xs">
                                <div class="w-8 h-8 rounded-lg bg-unerd-black text-white dark:bg-unerd-volt dark:text-black flex items-center justify-center font-black font-display text-xs shrink-0">
                                    05
                                </div>
                                <div class="text-xs sm:text-sm font-medium text-unerd-ink dark:text-zinc-200">
                                    Kembali ke booth UNERD Performance
                                </div>
                            </div>

                            <div class="p-3.5 sm:p-4 rounded-xl bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 flex items-center gap-3.5 shadow-xs">
                                <div class="w-8 h-8 rounded-lg bg-unerd-black text-white dark:bg-unerd-volt dark:text-black flex items-center justify-center font-black font-display text-xs shrink-0">
                                    06
                                </div>
                                <div class="text-xs sm:text-sm font-medium text-unerd-ink dark:text-zinc-200">
                                    Tunjukan hasil strava mu ke panitia, catat waktu tercepat & jadilah juara!
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Single Clean Prominent Photo -->
                    <div class="lg:col-span-6 relative overflow-hidden rounded-2xl bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-md h-full min-h-[380px] sm:min-h-[480px] group flex flex-col justify-end p-6 sm:p-8">
                        <img src="{{ asset('images/gallery/gallery-2.jpg') }}" alt="UNERD Time Attack Track GBK" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 filter brightness-95" />
                        <div class="absolute inset-0 bg-black/60"></div>
                        <div class="absolute top-4 left-4">
                            <!-- <span class="px-3 py-1 rounded-full bg-unerd-volt text-unerd-ink font-mono font-bold text-xs uppercase tracking-wider">
                                RESMI UNERD PERFORMANCE
                            </span> -->
                        </div>
                        <div class="relative z-10 text-white max-w-md">
                            <!-- <span class="text-xs font-mono text-zinc-300 uppercase block tracking-wider">Lintasan Resmi GBK Jakarta</span> -->
                            <h3 class="font-display font-extrabold text-xl sm:text-2xl uppercase mt-1">
                                Catat Waktu Tercepatmu di GBK & Dapatkan Hadiah Menarik!
                            </h3>
                            <!-- <p class="text-xs sm:text-sm text-zinc-300 mt-1.5 leading-relaxed">
                                Tunjukkan nomor unik  pelari di booth panitia, lari 3.000 meter, dan pantau rekor waktumu secara langsung di live leaderboard.
                            </p> -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 3: ENGINEERED FOR EVERY WEEK PERFORMANCE (4 IMAGES: DRINKING, RECOVERY, LUCKY DRAW, TRIAL) -->
        <section id="event-experience" class="py-14 sm:py-20 bg-white dark:bg-unerd-black transition-colors">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mb-10 sm:mb-12">
                    <!-- <span class="px-3 py-1 bg-unerd-volt text-unerd-ink font-display text-[11px] font-extrabold uppercase tracking-[2px] rounded-pill inline-block mb-3">
                        EVENT ACTIVATION & EXPERIENCE
                    </span> -->
                    <h2 class="font-display text-2xl sm:text-4xl font-extrabold uppercase tracking-tight text-unerd-ink dark:text-white">
                        Run, relax, recharge, and get prizes!
                    </h2>
                    <!-- <p class="text-xs sm:text-sm text-unerd-body dark:text-zinc-400 mt-2">
                        Suasana dan fasilitas pendukung di booth UNERD untuk kenyamanan dan performa maksimal setiap pelari.
                    </p> -->
                </div>

                <!-- 3 Photo Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                    <!-- 1. Water stations -->
                    <div class="group relative overflow-hidden rounded-2xl bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-md h-80 sm:h-96 flex flex-col justify-end p-5">
                        <img src="{{ asset('images/gallery/water.jpeg') }}" alt="Water stations" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                        <div class="absolute inset-0 bg-black/60"></div>
                        <div class="absolute top-3 left-3">
                            <!-- <span class="px-2.5 py-0.5 rounded-full bg-unerd-volt text-unerd-ink font-mono font-bold text-[10px] uppercase">
                                WATER STATIONS
                            </span> -->
                        </div>
                        <div class="relative z-10 text-white">
                            <!-- <span class="text-[10px] font-mono text-zinc-300 uppercase block tracking-wider">Hidrasi Resmi</span> -->
                            <h4 class="font-display font-bold text-base uppercase mt-0.5">Water Stations</h4>
                            <!-- <p class="text-[11px] text-zinc-300 mt-1 leading-snug">Stasiun air mineral gratis untuk menjaga hidrasi dan stamina optimal seluruh pelari.</p> -->
                        </div>
                    </div>

                    <!-- 2. Free Massage stations -->
                    <div class="group relative overflow-hidden rounded-2xl bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-md h-80 sm:h-96 flex flex-col justify-end p-5">
                        <img src="{{ asset('images/gallery/massage.jpeg') }}" alt="Free Massage stations" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                        <div class="absolute inset-0 bg-black/60"></div>
                        <div class="absolute top-3 left-3">
                            <!-- <span class="px-2.5 py-0.5 rounded-full bg-unerd-volt text-unerd-ink font-mono font-bold text-[10px] uppercase">
                                FREE MASSAGE STATIONS
                            </span> -->
                        </div>
                        <div class="relative z-10 text-white">
                            <!-- <span class="text-[10px] font-mono text-zinc-300 uppercase block tracking-wider">Pemulihan Otot</span> -->
                            <h4 class="font-display font-bold text-base uppercase mt-0.5">Free Massage Stations</h4>
                            <!-- <p class="text-[11px] text-zinc-300 mt-1 leading-snug">Layanan fisioterapi dan relaksasi otot gratis pasca race untuk pemulihan tubuh.</p> -->
                        </div>
                    </div>

                    <!-- 3. Live Leaderboard -->
                    <div class="group relative overflow-hidden rounded-2xl bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-md h-80 sm:h-96 flex flex-col justify-end p-5">
                        <img src="{{ asset('images/gallery/gallery-1.jpg') }}" alt="Live Leaderboard" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                        <div class="absolute inset-0 bg-black/60"></div>
                        <div class="absolute top-3 left-3">
                            <!-- <span class="px-2.5 py-0.5 rounded-full bg-unerd-volt text-unerd-ink font-mono font-bold text-[10px] uppercase">
                                LIVE LEADERBOARD
                            </span> -->
                        </div>
                        <div class="relative z-10 text-white">
                            <!-- <span class="text-[10px] font-mono text-zinc-300 uppercase block tracking-wider">Peringkat Realtime</span> -->
                            <h4 class="font-display font-bold text-base uppercase mt-0.5">Live Leaderboard</h4>
                            <!-- <p class="text-[11px] text-zinc-300 mt-1 leading-snug">Pantau rekor catatan waktu tercepat dan posisi peringkat pelari secara realtime.</p> -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION: JOIN TIME ATTACK CHALLENGE & LOKASI BOOTH (MAPS) -->
        <section id="challenges" class="py-14 sm:py-20 bg-unerd-surface-card dark:bg-zinc-950/60 border-t border-unerd-hairline dark:border-zinc-800 transition-colors">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mb-8 sm:mb-12">
                    <!-- <span class="px-3 py-1 bg-unerd-volt text-unerd-ink font-display text-[11px] font-extrabold uppercase tracking-[2px] rounded-pill inline-block mb-3">
                        LOKASI BOOTH & TANTANGAN AKTIF
                    </span> -->
                    <h2 class="font-display text-2xl sm:text-4xl font-extrabold uppercase tracking-tight text-unerd-ink dark:text-white">
                        Info Booth {{ $activePeriod ? $activePeriod->cleanName() : 'UNERD Performance Time Attack Challenge' }}
                    </h2>
                    <!-- <p class="text-xs sm:text-sm text-unerd-body dark:text-zinc-400 mt-2">
                        Kunjungi booth resmi UNERD di lintasan untuk konfirmasi pendaftaran, mulai tantangan lari, dan raih posisi teratas di live leaderboard.
                    </p> -->
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-stretch">
                    <!-- Left: Challenge Info Cards -->
                    <div class="lg:col-span-6 flex flex-col justify-between space-y-6">
                        <div class="space-y-4">
                            <!-- Info Bar -->
                            <div class="flex items-center gap-3 flex-wrap">
                                <span class="px-3 py-1 rounded-xl bg-unerd-black text-white dark:bg-white dark:text-black font-mono font-black text-xs uppercase tracking-wider">
                                    {{ $activePeriod?->period_code ?? 'PERIODE-2026-11-19' }}
                                </span>
                                @if ($activePeriod?->is_open_for_registration)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-unerd-volt border border-emerald-500/20 font-mono font-bold text-xs uppercase">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 dark:bg-unerd-volt animate-ping"></span>
                                        Pendaftaran Dibuka
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-xl bg-slate-100 dark:bg-zinc-800 text-slate-500 dark:text-zinc-400 font-mono font-bold text-xs uppercase">
                                        Pendaftaran Ditutup
                                    </span>
                                @endif
                            </div>

                            <!-- 4 Key Fast Facts Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                <!-- Lokasi / Venue Booth -->
                                <div class="p-4 rounded-2xl bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-xs">
                                    <span class="block text-[10px] font-mono uppercase font-bold text-unerd-muted dark:text-zinc-400">Lokasi / Venue Lintasan</span>
                                    <span class="font-display font-extrabold text-sm sm:text-base text-unerd-ink dark:text-white mt-1 block">
                                        {{ $activePeriod?->location ?? 'Gelora Bung Karno, Jakarta' }}
                                    </span>
                                    <!-- <span class="text-[11px] text-amber-600 dark:text-unerd-volt font-medium mt-0.5 block">
                                        *Booth UNERD Performance
                                    </span> -->
                                </div>

                                <!-- Jarak Lintasan -->
                                <div class="p-4 rounded-2xl bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-xs">
                                    <span class="block text-[10px] font-mono uppercase font-bold text-unerd-muted dark:text-zinc-400">Jarak Tantangan</span>
                                    <span class="font-display font-extrabold text-sm sm:text-base text-unerd-ink dark:text-white mt-1 block">
                                        {{ $activePeriod ? $activePeriod->formattedDistance() : '3000M' }}
                                    </span>
                                    <!-- <span class="text-[11px] text-unerd-muted dark:text-zinc-400 mt-0.5 block">
                                        {{ $activePeriod?->distance_meter ?? 3000 }} Meter Sprint
                                    </span> -->
                                </div>

                                <!-- Tanggal Event -->
                                <div class="p-4 rounded-2xl bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-xs">
                                    <span class="block text-[10px] font-mono uppercase font-bold text-unerd-muted dark:text-zinc-400">Tanggal Challenge</span>
                                    <span class="font-display font-extrabold text-sm sm:text-base text-unerd-ink dark:text-white mt-1 block">
                                        {{ $activePeriod?->event_date ? $activePeriod->event_date->translatedFormat('d F Y') : '19 November 2026' }}
                                    </span>
                                    <!-- <span class="text-[11px] text-unerd-muted dark:text-zinc-400 mt-0.5 block">
                                        Sesi Terbuka
                                    </span> -->
                                </div>

                                <!-- Durasi Challenge -->
                                <div class="p-4 rounded-2xl bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-xs">
                                    <span class="block text-[10px] font-mono uppercase font-bold text-unerd-muted dark:text-zinc-400">Batas Durasi Sesi</span>
                                    <span class="font-display font-extrabold text-sm sm:text-base text-unerd-ink dark:text-white mt-1 block">
                                        {{ $activePeriod?->duration_minutes ?? 60 }} Menit
                                    </span>
                                    <!-- <span class="text-[11px] text-unerd-muted dark:text-zinc-400 mt-0.5 block">
                                        Pencatatan Stopwatch Akurat
                                    </span> -->
                                </div>
                            </div>

                            <!-- Petunjuk Booth -->
                            <!-- <div class="p-4 rounded-2xl bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 text-xs text-unerd-body dark:text-zinc-300">
                                <span class="font-display font-bold text-unerd-ink dark:text-white block mb-1">
                                    Cara Menuju Booth UNERD:
                                </span>
                                Datang langsung ke venue <strong class="text-unerd-ink dark:text-white">{{ $activePeriod?->location ?? 'Gelora Bung Karno, Jakarta' }}</strong>, temukan booth UNERD Performance sesuai peta di samping, lalu perlihatkan kode unik registrasi akunmu ke panitia untuk memulai stopwatch!
                            </div> -->
                        </div>

                        <!-- CTA Action Buttons -->
                        <!-- <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2">
                            @auth
                                <a href="{{ route('dashboard') }}"
                                   class="px-6 py-3.5 rounded-xl bg-unerd-volt text-unerd-ink font-display font-extrabold text-xs sm:text-sm uppercase tracking-wider text-center hover:bg-unerd-yellow transition shadow-md">
                                    Buka Dashboard & Konfirmasi Start →
                                </a>
                            @else
                                <a href="{{ route('register') }}"
                                   class="px-6 py-3.5 rounded-xl bg-unerd-volt text-unerd-ink font-display font-extrabold text-xs sm:text-sm uppercase tracking-wider text-center hover:bg-unerd-yellow transition shadow-md">
                                    Daftar Time Attack Sekarang →
                                </a>
                                <a href="{{ route('login') }}"
                                   class="px-5 py-3.5 rounded-xl bg-white dark:bg-zinc-900 text-unerd-ink dark:text-white border border-unerd-hairline dark:border-zinc-800 font-display font-bold text-xs uppercase tracking-wider text-center hover:border-unerd-volt transition">
                                    Sudah Ada Akun? Masuk
                                </a>
                            @endauth
                        </div> -->
                    </div>

                    <!-- Right: Foto Maps / Denah Lokasi Booth -->
                    <div class="lg:col-span-6 rounded-3xl bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-lg overflow-hidden relative min-h-[360px] sm:min-h-[440px] flex flex-col justify-between p-6 group">
                        @php
                            $mapsPhoto = $activePeriod?->banner_image ? asset(ltrim($activePeriod->banner_image, '/')) : asset('images/gallery/gallery-2.jpg');
                        @endphp
                        <img src="{{ $mapsPhoto }}"
                             alt="Peta Denah Lokasi Booth UNERD Performance"
                             class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 filter brightness-95" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-black/40"></div>

                        <!-- Top Floating Badge -->
                        <div class="relative z-10 flex items-center justify-between">
                            <!-- <span class="px-3 py-1.5 rounded-full bg-unerd-volt text-unerd-ink font-mono font-bold text-xs uppercase tracking-wider flex items-center gap-1.5 shadow-md">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                PETA LOKASI BOOTH UNERD
                            </span> -->

                            <a href="{{ $mapsPhoto }}" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 rounded-full bg-black/75 backdrop-blur-xs text-white text-xs font-mono font-bold border border-white/20 hover:border-unerd-volt transition">
                                Perbesar Peta ↗
                            </a>
                        </div>

                        <!-- Bottom Location Details Overlay -->
                        <div class="relative z-10 text-white max-w-md pt-6">
                            <!-- <span class="text-[11px] font-mono text-zinc-300 uppercase block tracking-wider">
                                Venue Lintasan Resmi
                            </span> -->
                            <h3 class="font-display font-extrabold text-xl sm:text-2xl uppercase mt-1">
                                {{ $activePeriod?->location ?? 'Gelora Bung Karno, Jakarta' }}
                            </h3>
                            <!-- <p class="text-xs sm:text-sm text-zinc-300 mt-1.5 leading-relaxed">
                                Temukan booth UNERD Performance di area lintasan untuk verifikasi stopwatch dan pengambilan refreshment.
                            </p> -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 4: APRESIASI PELARI - THIS WEEK WINNERS -->
        <section id="prizes-rewards" class="py-14 sm:py-20 bg-unerd-surface-card dark:bg-zinc-950/60 border-t border-unerd-hairline dark:border-zinc-800 transition-colors">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    <!-- Left: Rewards List -->
                    <div class="lg:col-span-7 space-y-6">
                        <div>
                            <!-- <span class="px-3 py-1 rounded-pill bg-unerd-volt text-unerd-ink text-[11px] font-extrabold uppercase tracking-[2px] inline-block mb-3 font-display">
                                APRESIASI PELARI
                            </span> -->
                            <h2 class="font-display text-2xl sm:text-4xl font-extrabold uppercase tracking-tight text-unerd-ink dark:text-white">
                                This week winners get exiting shoes from UNERD!
                            </h2>
                            <!-- <p class="text-xs sm:text-sm text-unerd-body dark:text-zinc-400 mt-2">
                                Catat waktu terbaikmu di lintasan dan menangkan sepatu UNERD, sendal recovery, serta voucher diskon.
                            </p> -->
                        </div>

                        <div class="space-y-3">
                            <!-- Poin 1 -->
                            <div class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 flex items-center justify-between gap-4 transition hover:border-unerd-volt">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-10 h-10 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center shrink-0 text-unerd-ink dark:text-white">
                                        <svg class="w-5 h-5 text-amber-500 dark:text-unerd-volt" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21h8m-4-4v4m-6-17h12a2 2 0 012 2v2a6 6 0 01-6 6h0a6 6 0 01-6-6V4a2 2 0 012-2zm-2 4H2a2 2 0 00-2 2v1a4 4 0 004 4h2m12-7h2a2 2 0 012 2v1a4 4 0 01-4 4h-2" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-display font-extrabold text-sm sm:text-base uppercase text-unerd-ink dark:text-white">
                                            Sepatu UNERD Performance
                                        </h4>
                                        <p class="text-xs text-unerd-body dark:text-zinc-400 mt-0.5">
                                            Sesuai ukuran kaki pemenang sebanyak 1 pcs dan Voucher diskon <a href="https://www.unerd.co.id" target="_blank" rel="noopener noreferrer" class="font-bold underline text-amber-500 dark:text-unerd-volt hover:opacity-80">website</a> 10%
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Poin 2 -->
                            <div class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 flex items-center justify-between gap-4 transition hover:border-unerd-volt">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-10 h-10 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center shrink-0 text-unerd-ink dark:text-white">
                                        <svg class="w-5 h-5 text-unerd-ink dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <circle cx="12" cy="8" r="6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-display font-extrabold text-sm sm:text-base uppercase text-unerd-ink dark:text-white">
                                            Sendal Recovery UNERD
                                        </h4>
                                        <p class="text-xs text-unerd-body dark:text-zinc-400 mt-0.5">
                                            Sesuai ukuran kaki pemenang sebanyak 1 pcs dan Voucher diskon <a href="https://www.unerd.co.id" target="_blank" rel="noopener noreferrer" class="font-bold underline text-amber-500 dark:text-unerd-volt hover:opacity-80">website</a> 10%
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Poin 3 -->
                            <div class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 flex items-center justify-between gap-4 transition hover:border-unerd-volt">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-10 h-10 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center shrink-0 text-unerd-ink dark:text-white">
                                        <svg class="w-5 h-5 text-amber-500 dark:text-unerd-volt" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-display font-extrabold text-sm sm:text-base uppercase text-unerd-ink dark:text-white">
                                            Semua Partisipan Challenge
                                        </h4>
                                        <p class="text-xs text-unerd-body dark:text-zinc-400 mt-0.5">
                                            Semua partisipan dapat voucher 10% jika belanja di <a href="https://www.unerd.co.id" target="_blank" rel="noopener noreferrer" class="font-bold underline text-amber-500 dark:text-unerd-volt hover:opacity-80">website</a> resmi UNERD.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Two Photos (gallery-7.jpg & gallery-1.jpg) -->
                    <div class="lg:col-span-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="group relative overflow-hidden rounded-2xl bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-md h-72 sm:h-96">
                            <img src="{{ asset('images/gallery/gallery-7.jpg') }}" alt="Podium Juara" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                            <div class="absolute inset-0 bg-black/60"></div>
                            <div class="absolute top-3 left-3">
                                <span class="px-2.5 py-0.5 rounded-full bg-unerd-volt text-unerd-ink font-mono font-bold text-[10px] uppercase">
                                    PODIUM JUARA
                                </span>
                            </div>
                            <div class="absolute bottom-4 left-4 right-4 text-white">
                                <h4 class="font-display font-bold text-sm uppercase">Apresiasi Kemenangan</h4>
                                <span class="text-[11px] text-zinc-300">Hadiah sepatu UNERD & voucher diskon</span>
                            </div>
                        </div>

                        <div class="group relative overflow-hidden rounded-2xl bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-md h-72 sm:h-96">
                            <img src="{{ asset('images/gallery/gallery-1.jpg') }}" alt="Solidaritas Finisher" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                            <div class="absolute inset-0 bg-black/60"></div>
                            <div class="absolute top-3 left-3">
                                <span class="px-2.5 py-0.5 rounded-full bg-black/60 backdrop-blur-xs text-white border border-white/20 font-mono font-bold text-[10px] uppercase">
                                    FINISHER VIBE
                                </span>
                            </div>
                            <div class="absolute bottom-4 left-4 right-4 text-white">
                                <h4 class="font-display font-bold text-sm uppercase">Semangat Komunitas</h4>
                                <span class="text-[11px] text-zinc-300">Merayakan pencapaian personal record di lintasan lari</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 5: KOLEKSI SEPATU UNERD PERFORMANCE (PRODUK DI PALING BAWAH) -->
        <section id="products" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20 border-t border-unerd-hairline dark:border-zinc-800">
            <div class="max-w-3xl mb-8 sm:mb-10">
                <!-- <span class="px-3 py-1 bg-unerd-volt text-unerd-ink font-display text-[11px] font-extrabold uppercase tracking-[2px] rounded-pill inline-block mb-3">
                    KOLEKSI RESMI UNERD
                </span> -->
                <h2 class="font-display text-2xl sm:text-4xl font-extrabold uppercase text-unerd-ink dark:text-white">
                    Pilihan Sepatu UNERD Performance
                </h2>
                <p class="text-xs sm:text-sm text-unerd-body dark:text-zinc-400 mt-2">
                    Gunakan voucher diskon belanja 10% milikmu untuk mendapatkan produk sepatu lari UNERD terbaik di <a href="https://www.unerd.co.id" target="_blank" rel="noopener noreferrer" class="font-bold underline text-amber-500 dark:text-unerd-volt hover:opacity-80">Official Website</a>.
                </p>
            </div>

            <!-- 3 Physical Display Articles Gallery Showcase -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                @foreach ($featuredFootwear as $shoe)
                    <div class="group rounded-3xl border border-unerd-hairline dark:border-zinc-800 bg-white dark:bg-zinc-900 overflow-hidden hover:border-unerd-volt transition-all duration-300 shadow-md hover:shadow-xl flex flex-col justify-between">
                        <div>
                            <!-- Product Image Container with Gallery Hover -->
                            <div class="aspect-4/3 w-full bg-zinc-100 dark:bg-zinc-800 overflow-hidden relative">
                                <img src="{{ asset($shoe['image']) }}"
                                     alt="{{ $shoe['name'] }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" />
                                <div class="absolute inset-0 bg-black/50 group-hover:opacity-40 transition-opacity"></div>

                                <div class="absolute top-4 left-4 flex items-center gap-2">
                                    <x-badge :variant="$shoe['color']">
                                        {{ $shoe['tag'] }}
                                    </x-badge>
                                </div>
                                <div class="absolute top-4 right-4">
                                    <span class="px-2.5 py-1 rounded-full bg-black/70 backdrop-blur text-[11px] font-mono font-bold text-white border border-white/20">
                                        EU 38–45
                                    </span>
                                </div>
                                <div class="absolute bottom-3 left-4 right-4 text-white">
                                    <span class="text-[11px] font-mono tracking-wider uppercase text-zinc-200">
                                        {{ $shoe['subtitle'] ?? $shoe['category'] }}
                                    </span>
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="p-5 sm:p-6">
                                <div class="text-xs font-mono font-bold text-unerd-volt-dark dark:text-unerd-volt uppercase tracking-wider mb-1">
                                    {{ $shoe['category'] }}
                                </div>
                                <h3 class="font-display font-extrabold text-lg sm:text-xl text-unerd-ink dark:text-white leading-tight">
                                    {{ $shoe['name'] }}
                                </h3>
                                <p class="text-xs sm:text-sm text-unerd-body dark:text-zinc-300 mt-2.5 leading-relaxed">
                                    {{ $shoe['description'] }}
                                </p>
                            </div>
                        </div>

                        <!-- Price & CTA Card Footer -->
                        <div class="p-5 sm:p-6 pt-0">
                            <div class="pt-4 border-t border-unerd-hairline dark:border-zinc-800 flex items-center justify-between gap-3">
                                <div>
                                    <span class="text-xs line-through text-unerd-muted dark:text-zinc-500 block">
                                        Rp {{ number_format($shoe['price'], 0, ',', '.') }}
                                    </span>
                                    <div class="flex items-center gap-1.5">
                                        <span class="font-display font-black text-base sm:text-lg text-emerald-600 dark:text-unerd-volt">
                                            Rp {{ number_format($shoe['discounted_price'] ?? ($shoe['price'] * 0.9), 0, ',', '.') }}
                                        </span>
                                        <span class="text-[10px] font-bold text-emerald-700 dark:text-emerald-300 bg-emerald-100 dark:bg-emerald-950 px-1.5 py-0.5 rounded">
                                            -10%
                                        </span>
                                    </div>
                                </div>

                                <a href="{{ $shoe['shopee_url'] }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-unerd-black dark:bg-white text-white dark:text-unerd-black text-xs font-extrabold uppercase rounded-xl hover:bg-unerd-black-active dark:hover:bg-zinc-200 transition-all duration-200 shadow hover:shadow-md cursor-pointer shrink-0">
                                    <span>Beli di Shopee</span>
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-zinc-950 border-t border-unerd-hairline dark:border-zinc-800 py-10 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
                <x-application-logo />
                <div>
                    <div class="text-xs font-mono font-bold uppercase text-unerd-ink dark:text-white">
                        UNERD EVERY WEEK LEAGUE • EVERY WEEK COUNTS
                    </div>
                    <div class="text-[11px] text-unerd-muted dark:text-zinc-400">
                        @if ($activeChallenge)
                            {{ $activeChallenge->name }} • {{ $activeChallenge->location ?? 'GBK Jakarta' }} • Official Time Attack Run Challenge
                        @else
                            Official Time Attack Run Challenge
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </footer>
</x-guest-layout>
