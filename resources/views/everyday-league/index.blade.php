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
                    @if ($activeChallenge)
                        <a href="#challenges" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-unerd-volt text-unerd-ink font-black text-xs uppercase tracking-wider transition shadow-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-unerd-ink animate-pulse"></span>
                            <span>Time Attack Challenge</span>
                        </a>
                    @else
                        <a href="#challenges" class="px-3 py-1.5 hover:text-unerd-ink dark:hover:text-white rounded-md transition">Time Attack Challenge</a>
                    @endif
                    <a href="#timing-system" class="px-3 py-1.5 hover:text-unerd-ink dark:hover:text-white rounded-md transition">Cara Kerja</a>
                    <a href="#products" class="px-3 py-1.5 hover:text-unerd-ink dark:hover:text-white rounded-md transition">Koleksi Sepatu</a>
                    <a href="#prizes-rewards" class="px-3 py-1.5 hover:text-unerd-ink dark:hover:text-white rounded-md transition">Hadiah & Voucher</a>
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
                <a href="#challenges" @click="mobileNavOpen = false" class="px-3.5 py-2.5 rounded-xl bg-unerd-volt text-unerd-ink font-black flex items-center justify-between">
                    <span>Time Attack Challenge</span>
                    <span>&rarr;</span>
                </a>
                <a href="#timing-system" @click="mobileNavOpen = false" class="px-3.5 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-zinc-800 transition">
                    Cara Kerja
                </a>
                <a href="#products" @click="mobileNavOpen = false" class="px-3.5 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-zinc-800 transition">
                    Koleksi Sepatu
                </a>
                <a href="#prizes-rewards" @click="mobileNavOpen = false" class="px-3.5 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-zinc-800 transition">
                    Hadiah & Voucher
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
                        Tantangan sprint 1.000 meter dari UNERD. Daftarkan diri, pacu ritme terbaikmu di lintasan, dan buktikan catatan waktumu di leaderboard!
                    </p>

                    <!-- CTAs -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2">
                        <a href="{{ auth()->check() ? route('everyday-league.register') : route('register') }}"
                           class="inline-flex items-center justify-center h-12 px-6 sm:px-8 bg-unerd-black dark:bg-white hover:bg-unerd-black-active dark:hover:bg-zinc-200 text-white dark:text-unerd-black font-display text-xs sm:text-sm font-bold tracking-[0.5px] uppercase rounded-md transition shadow-md text-center">
                            {{ auth()->check() ? 'JOIN CHALLENGE →' : 'DAFTAR AKUN & JOIN →' }}
                        </a>
                        <a href="{{ route('everyday-league.leaderboard') }}"
                           class="inline-flex items-center justify-center h-12 px-5 bg-white dark:bg-zinc-900 hover:bg-unerd-surface-card dark:hover:bg-zinc-800 text-unerd-ink dark:text-zinc-100 font-display text-xs sm:text-sm font-bold tracking-[0.5px] uppercase border border-unerd-hairline dark:border-zinc-700 rounded-md transition text-center">
                            VIEW LEADERBOARD
                        </a>
                    </div>

                    <!-- Fast Facts for Runners -->
                    <div class="grid grid-cols-3 gap-2 sm:gap-4 pt-6 border-t border-unerd-hairline dark:border-zinc-800 max-w-lg text-center sm:text-left">
                        <div class="p-2 sm:p-0">
                            <div class="text-[10px] sm:text-[11px] uppercase tracking-wider text-unerd-muted dark:text-zinc-400 font-bold">TANTANGAN LARI</div>
                            <div class="font-display font-black text-sm sm:text-base text-unerd-ink dark:text-white mt-0.5">
                                {{ $activeChallenge ? number_format($activeChallenge->distance_meter ?? 1000, 0, ',', '.') . ' M Sprint' : '1.000 M Sprint' }}
                            </div>
                        </div>
                        <div class="p-2 sm:p-0">
                            <div class="text-[10px] sm:text-[11px] uppercase tracking-wider text-unerd-muted dark:text-zinc-400 font-bold">LOKASI SESI</div>
                            <div class="font-display font-black text-sm sm:text-base text-unerd-ink dark:text-white mt-0.5">
                                {{ $activeChallenge ? explode(',', $activeChallenge->location ?? 'Lintasan')[0] : 'GBK Senayan' }}
                            </div>
                        </div>
                        <div class="p-2 sm:p-0">
                            <div class="text-[10px] sm:text-[11px] uppercase tracking-wider text-unerd-muted dark:text-zinc-400 font-bold">SISTEM PERINGKAT</div>
                            <div class="font-display font-black text-sm sm:text-base text-unerd-volt mt-0.5">Leaderboard Live</div>
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
                                    {{ $activeChallenge ? number_format($activeChallenge->distance_meter ?? 1000, 0, ',', '.') . ' Meter' : '1.000 Meter Sprint' }}
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

        <!-- THE CHALLENGE & ACTIVATION -->
        <section id="challenges" class="py-12 sm:py-20 bg-unerd-surface-card dark:bg-zinc-950/60 border-y border-unerd-hairline dark:border-zinc-800 transition-colors">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-14">
                    <h2 class="font-display text-2xl sm:text-4xl font-extrabold uppercase tracking-tight text-unerd-ink dark:text-white">
                        UNERD TIME ATTACK
                    </h2>
                    <p class="text-xs sm:text-sm text-unerd-body dark:text-zinc-400 mt-2">
                        Challenge time attack dari unerd performance, untuk mendapatkan hadiah.
                    </p>
                </div>

                @if ($activeChallenge)
                    <!-- Featured 1 KM Run Challenge Banner with Authentic Photo -->
                    <div class="rounded-2xl bg-white dark:bg-zinc-900 border-2 border-unerd-black dark:border-unerd-volt overflow-hidden shadow-lg grid grid-cols-1 lg:grid-cols-12">
                        <div class="lg:col-span-7 p-6 sm:p-10 flex flex-col justify-between space-y-6">
                            <div class="space-y-4">
                                <h3 class="font-display font-extrabold text-3xl sm:text-4xl uppercase text-unerd-ink dark:text-white leading-tight">
                                    {{ $activeChallenge->name }}
                                </h3>
                                <p class="text-sm text-unerd-body dark:text-zinc-300 leading-relaxed">
                                    Time attack 1 KM di lintasan {{ $activeChallenge->location ?? 'GBK' }}. Catat waktu terbaikmu dan puncaki leaderboard!
                                </p>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-3 border-t border-unerd-hairline dark:border-zinc-800 text-xs text-unerd-body dark:text-zinc-300">
                                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-white/5 border border-unerd-hairline dark:border-white/5">
                                        <span class="block font-mono text-[10px] text-zinc-400 uppercase">Lokasi</span>
                                        <strong class="text-unerd-ink dark:text-white">{{ $activeChallenge->location ?? 'GBK Senayan, Jkt' }}</strong>
                                    </div>
                                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-white/5 border border-unerd-hairline dark:border-white/5">
                                        <span class="block font-mono text-[10px] text-zinc-400 uppercase">Tanggal</span>
                                        <strong class="text-unerd-ink dark:text-white">{{ $activePeriod?->event_date?->translatedFormat('d F Y') ?? ($activeChallenge->event_date?->translatedFormat('d F Y') ?? '21 November 2026') }}</strong>
                                    </div>
                                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-white/5 border border-unerd-hairline dark:border-white/5">
                                        <span class="block font-mono text-[10px] text-zinc-400 uppercase">Format</span>
                                        <strong class="text-unerd-ink dark:text-white">Time Attack</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-2 flex flex-col sm:flex-row items-center gap-3">
                                <a href="{{ auth()->check() ? route('everyday-league.register') : route('register') }}"
                                   class="w-full sm:w-auto px-8 py-3.5 text-center text-xs font-black uppercase tracking-wider rounded-xl bg-unerd-black dark:bg-white text-white dark:text-unerd-black hover:opacity-90 transition shadow-md">
                                    {{ auth()->check() ? 'JOIN CHALLENGE →' : 'DAFTAR AKUN & JOIN →' }}
                                </a>
                                <a href="{{ route('everyday-league.leaderboard') }}"
                                   class="w-full sm:w-auto px-6 py-3.5 text-center text-xs font-bold uppercase tracking-wider rounded-xl bg-slate-100 dark:bg-zinc-800 text-slate-800 dark:text-zinc-200 hover:bg-slate-200 dark:hover:bg-zinc-700 transition">
                                    CEK KLASEMEN LIVE
                                </a>
                            </div>
                        </div>

                        <div class="lg:col-span-5 relative min-h-[260px] lg:min-h-full overflow-hidden bg-zinc-900 border-t lg:border-t-0 lg:border-l border-unerd-hairline dark:border-zinc-800">
                            <img src="{{ asset('images/gallery/gallery-2.jpg') }}" alt="Runners Track" class="w-full h-full object-cover filter brightness-95" />
                            <div class="absolute inset-0 bg-black/60"></div>
                            <div class="absolute bottom-4 left-4 right-4 text-white">
                                <span class="px-2.5 py-0.5 rounded-full bg-unerd-volt text-unerd-ink text-[10px] font-mono font-bold uppercase">SUASANA LINTASAN</span>
                                <div class="font-display font-bold text-sm mt-1">{{ $activeChallenge->location ?? 'Lintasan Lari ' }}</div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Fallback State When No Challenge is Active -->
                    <div class="rounded-2xl bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 p-8 sm:p-14 text-center space-y-4 max-w-2xl mx-auto shadow-xs">
                        <div class="w-14 h-14 rounded-full bg-slate-100 dark:bg-zinc-800 text-slate-500 dark:text-zinc-400 mx-auto flex items-center justify-center">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="space-y-1.5">
                            <span class="px-3 py-1 rounded-full bg-slate-100 dark:bg-zinc-800 text-slate-600 dark:text-zinc-400 font-mono text-[11px] font-bold uppercase tracking-wider inline-block">
                                Status Event
                            </span>
                            <h3 class="font-display font-extrabold text-2xl uppercase text-slate-900 dark:text-white">
                                Belum Ada Challenge Aktif Saat Ini
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-500 dark:text-zinc-400 max-w-md mx-auto">
                                Panitia sedang menyiapkan periode tantangan berikutnya. Pantau terus jadwal rilis dan pembukaan registrasi di halaman ini!
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- CARA KERJA & VERIFIKASI STOPWATCH KRU (Photos: gallery-5.jpg & gallery-4.jpg) -->
        <section id="timing-system" class="py-14 sm:py-20 bg-white dark:bg-unerd-black transition-colors">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    <!-- Left: 4 Steps of Timing & Verification -->
                    <div class="lg:col-span-6 space-y-6">
                        <div>
                            <span class="px-3 py-1 bg-unerd-volt text-unerd-ink font-display text-[11px] font-extrabold uppercase tracking-[2px] rounded-pill inline-block mb-3">
                                Cara Kerja Time Attack
                            </span>
                            <h2 class="font-display text-2xl sm:text-4xl font-extrabold uppercase tracking-tight text-unerd-ink dark:text-white">
                                Cara Kerja Challenge Time Attack
                            </h2>
                            <p class="text-xs sm:text-sm text-unerd-body dark:text-zinc-400 mt-2">
                                Tata cara registrasi dan challenge time attack dari Unerd Performace
                            </p>
                        </div>

                        <div class="space-y-3.5">
                            <div class="p-4 rounded-xl bg-unerd-surface-card dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 flex items-start gap-3.5 shadow-xs">
                                <div class="w-8 h-8 rounded-lg bg-unerd-black text-white dark:bg-unerd-volt dark:text-black flex items-center justify-center font-black font-display text-xs shrink-0">
                                    01
                                </div>
                                <div>
                                    <h4 class="font-display font-bold text-sm text-unerd-ink dark:text-white uppercase">Daftar Akun</h4>
                                    <p class="text-xs text-unerd-body dark:text-zinc-400 mt-0.5">Daftarkan akun anda melalui halaman register, pilih tipe pengguna sesuai preferensi</p>
                                </div>
                            </div>

                            <div class="p-4 rounded-xl bg-unerd-surface-card dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 flex items-start gap-3.5 shadow-xs">
                                <div class="w-8 h-8 rounded-lg bg-unerd-black text-white dark:bg-unerd-volt dark:text-black flex items-center justify-center font-black font-display text-xs shrink-0">
                                    02
                                </div>
                                <div>
                                    <h4 class="font-display font-bold text-sm text-unerd-ink dark:text-white uppercase">Join Challenge</h4>
                                    <p class="text-xs text-unerd-body dark:text-zinc-400 mt-0.5">Join challenge untuk mendaftarkan diri anda dan dapatkan nomor peserta unik.</p>
                                </div>
                            </div>

                             <div class="p-4 rounded-xl bg-unerd-surface-card dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 flex items-start gap-3.5 shadow-xs">
                                <div class="w-8 h-8 rounded-lg bg-unerd-black text-white dark:bg-unerd-volt dark:text-black flex items-center justify-center font-black font-display text-xs shrink-0">
                                    03
                                </div>
                                <div>
                                    <h4 class="font-display font-bold text-sm text-unerd-ink dark:text-white uppercase">Datang ke booth unerd performance & mulai lari</h4>
                                    <p class="text-xs text-unerd-body dark:text-zinc-400 mt-0.5">Datang & silahkan konfirmasi dulu ke petugas unerd, lalu lari sesuai arahan petugas</p>
                                </div>
                            </div>

                             <div class="p-4 rounded-xl bg-unerd-surface-card dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 flex items-start gap-3.5 shadow-xs">
                                <div class="w-8 h-8 rounded-lg bg-unerd-black text-white dark:bg-unerd-volt dark:text-black flex items-center justify-center font-black font-display text-xs shrink-0">
                                    04
                                </div>
                                <div>
                                    <h4 class="font-display font-bold text-sm text-unerd-ink dark:text-white uppercase">Catat waktu lari anda & jadi juara</h4>
                                    <p class="text-xs text-unerd-body dark:text-zinc-400 mt-0.5">Catat waktu tercepat & jadilah juara, dapatkan hadiah menarik.</p>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Right Photos illustrating Timing & Pace Focus -->
                    <div class="lg:col-span-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="group relative overflow-hidden rounded-2xl bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-md h-80 sm:h-96">
                            <img src="{{ asset('images/gallery/gallery-5.jpg') }}" alt="Stopwatch Kru GBK" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
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

                        <div class="group relative overflow-hidden rounded-2xl bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-md h-80 sm:h-96">
                            <img src="{{ asset('images/gallery/gallery-4.jpg') }}" alt="Sprint Finish Focus" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                            <div class="absolute inset-0 bg-black/60"></div>
                            <div class="absolute top-3 left-3">
                                <span class="px-2.5 py-0.5 rounded-full bg-black/60 backdrop-blur-xs text-white border border-white/20 font-mono font-bold text-[10px] uppercase">
                                    PACE & CADENCE
                                </span>
                            </div>
                            <div class="absolute bottom-4 left-4 right-4 text-white">
                                <span class="text-[10px] font-mono text-zinc-300 uppercase block">Sprint {{ $activeChallenge ? number_format($activeChallenge->distance_meter ?? 1000, 0, ',', '.') . ' Meter' : '1.000 Meter' }}</span>
                                <h4 class="font-display font-bold text-base uppercase mt-0.5">Fokus Ritme Hingga Finish</h4>
                                <p class="text-[11px] text-zinc-300 mt-0.5">Menjaga kecepatan stabil untuk meraih peringkat puncak.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- PRODUCT DISCOVERY & ON-TRACK PERFORMANCE (Photo: gallery-3.jpg) -->
        <section id="products" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20">
            <div class="mb-8">
                <h2 class="font-display text-2xl sm:text-4xl font-extrabold uppercase text-unerd-ink dark:text-white">
                    Engineered for Everyday Performance
                </h2>
            </div>

            <!-- Featured On-Track Photo Card -->
            <div class="mb-10 rounded-2xl bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 overflow-hidden relative shadow-lg h-64 sm:h-80 group">
                <img src="{{ asset('images/gallery/gallery-3.jpg') }}"
                     alt="Engineered for Everyday Performance"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 filter brightness-95" />
                <div class="absolute inset-0 bg-black/60"></div>
                <div class="absolute bottom-5 left-5 right-5 text-white max-w-xl">
                    <h3 class="font-display font-extrabold text-xl sm:text-2xl uppercase mt-0.5">
                        Dirancang Khusus untuk Performa Lari dan Kenyamanan Harian
                    </h3>
                </div>
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

        <!-- HADIAH JUARA 1–10 & VOUCHER BELANJA (Photos: gallery-7.jpg & gallery-6.jpg) -->
        <section id="prizes-rewards" class="py-14 sm:py-20 bg-unerd-surface-card dark:bg-zinc-950/60 border-t border-unerd-hairline dark:border-zinc-800 transition-colors">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    <!-- Left: Rewards List -->
                    <div class="lg:col-span-7 space-y-6">
                        <div>
                            <span class="px-3 py-1 rounded-pill bg-unerd-volt text-unerd-ink text-[11px] font-extrabold uppercase tracking-[2px] inline-block mb-3 font-display">
                                APRESIASI PELARI
                            </span>
                            <h2 class="font-display text-2xl sm:text-4xl font-extrabold uppercase tracking-tight text-unerd-ink dark:text-white">
                                Hadiah Juara 1–10 & Voucher Belanja
                            </h2>
                            <p class="text-xs sm:text-sm text-unerd-body dark:text-zinc-400 mt-2">
                                Setiap catatan waktu  di lintasan berkesempatan memenangkan hadiah sepatu, uang tunai, dan voucher belanja.
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
                    </div>

                    <!-- Right: Two Photos (gallery-7.jpg & gallery-6.jpg) -->
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
                            <img src="{{ asset('images/gallery/gallery-6.jpg') }}" alt="Solidaritas Finisher" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
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
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-zinc-950 border-t border-unerd-hairline dark:border-zinc-800 py-10 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
                <x-application-logo />
                <div>
                    <div class="text-xs font-mono font-bold uppercase text-unerd-ink dark:text-white">
                        UNERD EVERYDAY LEAGUE • EVERYDAY COUNTS
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
