<x-guest-layout>
    <div class="py-6 sm:py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6">
            <!-- Back to Challenge Navigation -->
            <div class="mb-6 flex items-center justify-between">
                <a href="{{ route('everyday-league.index') }}" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Beranda Challenge
                </a>

                <div class="flex items-center gap-2">
                    <span class="text-xs text-slate-500 dark:text-slate-400 hidden sm:inline">Masuk sebagai:</span>
                    <span class="font-bold text-xs text-slate-900 dark:text-white truncate max-w-[120px] sm:max-w-none">{{ $user->name }}</span>
                    <x-badge :variant="$roleCategory === 'Profesional' ? 'blaze' : ($roleCategory === 'Komunitas' ? 'volt' : 'concrete')">
                        {{ $roleCategory }}
                    </x-badge>
                </div>
            </div>

            @if (! $activePeriod)
                <!-- KONDISI: BELUM ADA EVENT AKTIF SAMA SEKALI -->
                <div class="space-y-6">
                    <div class="p-6 sm:p-8 rounded-2xl bg-white dark:bg-[#181818] border border-slate-200 dark:border-zinc-800 text-center space-y-3 shadow-xs">
                        <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-zinc-800 text-slate-500 dark:text-zinc-400 mx-auto flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-slate-100 dark:bg-zinc-800 text-slate-600 dark:text-zinc-400 font-mono text-[11px] font-bold uppercase tracking-wider inline-block">
                            Status Event
                        </span>
                        <h2 class="font-display font-extrabold text-2xl uppercase text-slate-900 dark:text-white">
                            Belum Ada Event Aktif Saat Ini
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-zinc-400 max-w-md mx-auto leading-relaxed">
                            Panitia sedang menyiapkan periode tantangan berikutnya. Pendaftaran lari akan dibuka kembali saat jadwal rilis diumumkan.
                        </p>
                        <div class="pt-3 flex flex-col sm:flex-row items-center justify-center gap-3">
                            <a href="{{ route('customer.dashboard') }}"
                               class="w-full sm:w-auto px-6 py-3 rounded-xl bg-slate-900 text-white dark:bg-white dark:text-black font-bold text-xs uppercase tracking-wider hover:opacity-90 transition">
                                Buka Dashboard Pelari &rarr;
                            </a>
                            <a href="{{ route('everyday-league.leaderboard') }}"
                               class="w-full sm:w-auto px-6 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-200 font-bold text-xs uppercase tracking-wider transition">
                                Lihat Klasemen Leaderboard
                            </a>
                        </div>
                    </div>

                    <!-- Profil Ringkas Pelari -->
                    <div class="bg-white dark:bg-[#181818] rounded-2xl border border-slate-200 dark:border-zinc-800 p-5 sm:p-6 shadow-xs">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-zinc-800 mb-4">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span>
                                <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-slate-900 dark:text-white">
                                    Data Profil Akun Pelari
                                </h3>
                            </div>
                            <span class="text-[11px] font-mono text-slate-400">Terdaftar</span>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                            <div>
                                <span class="block text-[10px] uppercase font-mono text-slate-400">Nama Pelari</span>
                                <span class="font-bold text-slate-900 dark:text-white block truncate">{{ $user->name }}</span>
                            </div>
                            <div>
                                <span class="block text-[10px] uppercase font-mono text-slate-400">Email Akun</span>
                                <span class="font-bold text-slate-900 dark:text-white block truncate">{{ $user->email }}</span>
                            </div>
                            <div>
                                <span class="block text-[10px] uppercase font-mono text-slate-400">Ukuran Sepatu</span>
                                <span class="font-bold text-unerd-volt-dark dark:text-unerd-volt block">EU {{ $user->shoe_size ?? 42 }}</span>
                            </div>
                            <div>
                                <span class="block text-[10px] uppercase font-mono text-slate-400">Kategori Role</span>
                                <span class="font-bold text-slate-900 dark:text-white block">{{ $roleCategory }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- KONDISI: ADA EVENT / PERIODE AKTIF -->

                <!-- Registration Closed Banner (if active period is closed for registration) -->
                @if (! $isOpenForRegistration)
                    <div class="mb-6 p-5 rounded-2xl bg-amber-50 dark:bg-amber-950/40 border border-amber-300 dark:border-amber-800 text-amber-900 dark:text-amber-200 shadow-xs">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span class="font-black text-sm uppercase font-display">Pendaftaran Periode Ini Sedang Ditutup</span>
                        </div>
                        <p class="text-xs text-amber-800 dark:text-amber-300 mt-1">
                            Panitia sedang menutup pendaftaran untuk <strong>{{ $activePeriod->cleanName() }}</strong>. Nantikan pembukaan sesi pendaftaran berikutnya!
                        </p>
                    </div>
                @endif

                <!-- Existing Registration Warning & Status in Active Period -->
                @if ($existingResultInPeriod)
                    @if ($existingResultInPeriod->isRunning())
                        <div class="mb-6 p-5 sm:p-6 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border-2 border-rose-500/40 text-slate-900 dark:text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="relative flex h-3 w-3">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500"></span>
                                    </span>
                                    <span class="font-black text-sm uppercase font-display text-rose-600 dark:text-rose-400">Kamu Sedang Aktif Lari di Lintasan!</span>
                                </div>
                                <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">
                                    ID Pelari: <strong class="font-mono text-emerald-600 dark:text-unerd-volt">{{ $existingParticipant?->participant_id }}</strong> &bull; Kru di garis finish siap mencatat waktu resmimu.
                                </p>
                            </div>
                            <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider bg-rose-600 hover:bg-rose-700 text-white transition shadow-xs text-center shrink-0">
                                Lihat Live Status &rarr;
                            </a>
                        </div>
                    @elseif ($existingResultInPeriod->isPendingCheckin())
                        <div class="mb-6 p-5 sm:p-6 rounded-2xl bg-amber-50 dark:bg-amber-950/40 border-2 border-amber-500/40 text-slate-900 dark:text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
                            <div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-black text-sm uppercase font-display text-amber-700 dark:text-amber-400">Kamu Sudah Terdaftar • Menunggu Start</span>
                                </div>
                                <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">
                                    BIB ID: <strong class="font-mono text-slate-900 dark:text-white">{{ $existingParticipant?->participant_id }}</strong> &bull; Datang ke booth start dan sampaikan ke kru: <em>"Kak, ini saya sudah daftar, saya mau lari"</em>.
                                </p>
                            </div>
                            <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider bg-amber-600 hover:bg-amber-700 text-white transition shadow-xs text-center shrink-0">
                                Buka Status Pelari &rarr;
                            </a>
                        </div>
                    @else
                        <div class="mb-6 p-5 sm:p-6 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border-2 border-emerald-500/40 text-slate-900 dark:text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
                            <div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span class="font-black text-sm uppercase font-display">Kamu Sudah Selesai di Periode Ini</span>
                                </div>
                                <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">
                                    Catatan waktu resmimu: <strong class="font-mono text-emerald-600 dark:text-unerd-volt">{{ $existingResultInPeriod->formattedTime() }}</strong> &bull; Setiap pelari memiliki 1 kesempatan resmi per periode.
                                </p>
                            </div>
                            <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider bg-slate-900 text-white dark:bg-white dark:text-black hover:opacity-90 transition shadow-xs text-center shrink-0">
                                Buka Dashboard &rarr;
                            </a>
                        </div>
                    @endif
                @endif

                <!-- User Auto-Filled Identity Summary Card -->
                <div class="bg-white dark:bg-[#181818] rounded-2xl border border-slate-200 dark:border-zinc-800 p-5 sm:p-6 shadow-xs mb-6">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-zinc-800 mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-xs font-mono font-bold uppercase tracking-wider text-slate-900 dark:text-white">
                                Data Profil Akun Pelari
                            </span>
                        </div>
                        <span class="inline-flex items-center gap-1 text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold font-mono">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Terhubung Otomatis</span>
                        </span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                        <div>
                            <span class="block text-[10px] uppercase font-mono text-slate-400">Nama Pelari</span>
                            <span class="font-bold text-slate-900 dark:text-white block truncate">{{ $user->name }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase font-mono text-slate-400">Email Akun</span>
                            <span class="font-bold text-slate-900 dark:text-white block truncate">{{ $user->email }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase font-mono text-slate-400">Ukuran Sepatu</span>
                            <span class="font-bold text-unerd-volt-dark dark:text-unerd-volt block">EU {{ $user->shoe_size ?? 42 }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase font-mono text-slate-400">Kategori Role</span>
                            <span class="font-bold text-slate-900 dark:text-white block">{{ $roleCategory }}</span>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-100 dark:border-zinc-800 flex items-center gap-2 text-[11px] text-slate-500 dark:text-slate-400">
                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Data dirimu langsung sinkron dari profil akun. Klik tombol konfirmasi di bawah untuk mulai sesi lari.</span>
                    </div>
                </div>

                <!-- Form: Challenge Entry Confirmation -->
                <form method="POST" action="{{ route('everyday-league.store') }}" class="space-y-6">
                    @csrf
                    <!-- Automatic Performance Category Interest -->
                    <input type="hidden" name="product_interest" value="Performance">
                    <input type="hidden" name="challenge_slug" value="unerd-run-challenge">

                    <!-- UNERD RUN CHALLENGE (ACTIVE & FOCUSED) -->
                    <div>
                        <h2 class="text-base sm:text-lg font-black uppercase tracking-tight text-slate-900 dark:text-white font-display mb-1">
                            Tantangan Lari Resmi
                        </h2>
                        <p class="text-xs text-slate-600 dark:text-slate-400 mb-3">
                            Tantangan sprint {{ $activeChallenge ? number_format($activeChallenge->distance_meter ?? 1000, 0, ',', '.') . ' Meter' : '1 KM' }} terverifikasi di lintasan resmi {{ $activeChallenge->location ?? 'GBK Senayan' }}.
                        </p>

                        <div class="rounded-2xl p-5 sm:p-6 transition border-2 border-slate-900 dark:border-unerd-volt bg-white dark:bg-[#181818] shadow-sm space-y-4">
                            <!-- Top Highlight Badge based on user role -->
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-slate-100 dark:bg-zinc-800 text-slate-900 dark:text-unerd-volt">
                                    DIREKOMENDASIKAN UNTUK KATEGORI {{ strtoupper($roleCategory) }}
                                </span>

                                <span class="px-2.5 py-0.5 rounded-md bg-emerald-500/10 text-emerald-700 dark:text-unerd-volt font-mono text-[10px] font-bold uppercase border border-emerald-500/30">
                                    {{ $activePeriod->cleanName() }}
                                </span>
                            </div>

                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h3 class="text-lg sm:text-xl font-black uppercase tracking-tight text-slate-900 dark:text-white font-display">
                                        {{ $activeChallenge->name ?? 'UNERD Run Challenge 1 KM' }}
                                    </h3>
                                    <p class="text-xs text-slate-600 dark:text-slate-300 mt-1 leading-relaxed">
                                        Time attack sprint {{ $activeChallenge ? number_format($activeChallenge->distance_meter ?? 1000, 0, ',', '.') . ' meter' : '1.000 meter' }} di lintasan resmi {{ $activeChallenge->location ?? 'GBK Senayan' }}. Catat waktu stopwatch terbaikmu dan bawa namamu ke puncak leaderboard kategori <strong class="text-slate-900 dark:text-white">{{ $roleCategory }}</strong>.
                                    </p>
                                </div>
                                <div class="w-7 h-7 rounded-full bg-slate-900 text-white dark:bg-unerd-volt dark:text-black flex items-center justify-center shrink-0 mt-1 shadow-xs">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Fast Specs Grid -->
                            <div class="grid grid-cols-3 gap-2 pt-3 border-t border-slate-200 dark:border-zinc-800 text-[11px]">
                                <div>
                                    <span class="text-slate-400 block text-[10px] uppercase font-mono">Jarak Lintasan</span>
                                    <span class="font-bold text-slate-900 dark:text-white">{{ $activeChallenge ? number_format($activeChallenge->distance_meter ?? 1000, 0, ',', '.') . ' M' : '1 KM (1.000m)' }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block text-[10px] uppercase font-mono">Lokasi</span>
                                    <span class="font-bold text-slate-900 dark:text-white">{{ $activeChallenge->location ?? 'GBK Senayan' }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block text-[10px] uppercase font-mono">Format Timing</span>
                                    <span class="font-bold text-emerald-600 dark:text-unerd-volt">Stopwatch Verified</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Community Selection (Only relevant / displayed if user is Komunitas role) -->
                    @if ($roleCategory === 'Komunitas')
                        <div class="bg-white dark:bg-[#181818] p-5 rounded-2xl border border-slate-200 dark:border-zinc-800 shadow-xs">
                            <label for="community_id" class="block text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white mb-1.5">
                                Pilih Komunitas Lari Afiliasimu
                            </label>
                            <select id="community_id" name="community_id" class="block w-full rounded-xl border border-slate-300 dark:border-zinc-700 bg-white dark:bg-[#121212] text-slate-900 dark:text-white px-3.5 py-2.5 text-xs sm:text-sm focus:border-unerd-volt focus:ring-1 focus:ring-unerd-volt transition">
                                <option value="">-- Pilih Komunitas Mitra --</option>
                                @foreach ($communities as $community)
                                    <option value="{{ $community->id }}">{{ $community->name }} ({{ $community->city }})</option>
                                @endforeach
                            </select>
                            <p class="text-[11px] text-slate-500 dark:text-zinc-400 mt-1.5">
                                Catatan waktumu akan masuk ke perhitungan rata-rata leaderboard komunitas (top 3 finisher tercepat).
                            </p>
                        </div>
                    @endif

                    <!-- Submit 1-Click Confirmation -->
                    <div class="pt-2">
                        @if (! $isOpenForRegistration)
                            <button type="button" disabled class="w-full py-4 rounded-xl bg-slate-200 dark:bg-white/10 text-slate-500 font-black text-sm uppercase tracking-wider cursor-not-allowed">
                                Pendaftaran Ditutup oleh Panitia
                            </button>
                        @elseif ($existingResultInPeriod && $existingResultInPeriod->isRunning())
                            <a href="{{ route('customer.dashboard') }}" class="w-full py-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-black text-sm uppercase tracking-wider transition shadow-lg text-center flex items-center justify-center gap-2">
                                <span>Statusmu Saat Ini Sedang Aktif Lari di Lintasan &rarr; Buka Dashboard</span>
                            </a>
                        @elseif ($existingResultInPeriod && $existingResultInPeriod->isFinished())
                            <a href="{{ route('customer.dashboard') }}" class="w-full py-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white dark:bg-white dark:text-black font-black text-sm uppercase tracking-wider transition shadow-lg text-center flex items-center justify-center gap-2">
                                <span>Kamu Sudah Finish di Periode Ini &rarr; Buka Dashboard</span>
                            </a>
                        @else
                            <button type="submit" class="w-full py-4 rounded-xl bg-slate-900 text-white dark:bg-unerd-volt dark:text-black font-black text-sm uppercase tracking-wider hover:opacity-90 transition shadow-lg text-center flex items-center justify-center gap-2 cursor-pointer">
                                <span>Konfirmasi & Mulai Lari Sekarang</span>
                                <span>&rarr;</span>
                            </button>
                        @endif
                        <p class="text-center text-[11px] text-slate-400 mt-2">
                            Tanpa biaya pendaftaran. Kamu langsung mendapatkan nomor pelari resmi untuk diverifikasi oleh kru panitia.
                        </p>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-guest-layout>
