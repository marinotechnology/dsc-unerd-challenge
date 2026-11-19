<x-guest-layout>
    <div class="py-6 sm:py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6">
            <!-- Back to Challenge Navigation & User Quick Identity -->
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <a href="{{ route('everyday-league.index') }}" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-900 dark:text-zinc-400 dark:hover:text-white transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Beranda Challenge</span>
                </a>

                <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500 dark:text-zinc-400">
                    <span>Masuk sebagai:</span>
                    <span class="font-bold text-slate-900 dark:text-white">{{ $user->name }}</span>
                    <span class="font-mono font-bold text-slate-900 dark:text-white bg-slate-100 dark:bg-zinc-800 px-1.5 py-0.2 rounded border border-slate-200 dark:border-zinc-700">EU {{ $user->shoe_size ?? 42 }}</span>
                    <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase {{ $roleCategory === 'Profesional' ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20' : ($roleCategory === 'Komunitas' ? 'bg-emerald-500/10 text-emerald-600 dark:text-unerd-volt border border-emerald-500/20' : 'bg-slate-100 dark:bg-zinc-800 text-slate-700 dark:text-zinc-300 border border-slate-200 dark:border-zinc-700') }}">
                        {{ $roleCategory }}
                    </span>
                </div>
            </div>

            @if (! $activePeriod)
                <!-- KONDISI: BELUM ADA EVENT AKTIF SAMA SEKALI -->
                <div class="p-6 sm:p-8 rounded-2xl bg-white dark:bg-[#181818] border border-slate-200 dark:border-zinc-800 text-center space-y-3 shadow-xs">
                    <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-zinc-800 text-slate-500 dark:text-zinc-400 mx-auto flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-slate-100 dark:bg-zinc-800 text-slate-600 dark:text-zinc-400 font-mono text-[11px] font-bold uppercase tracking-wider inline-block">
                        Status Event
                    </span>
                    <h2 class="font-display font-black text-2xl uppercase text-slate-900 dark:text-white">
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
            @else
                <!-- KONDISI: ADA EVENT / PERIODE AKTIF (INTEGRATED SINGLE CLEAN CARD) -->
                <form method="POST" action="{{ route('everyday-league.store') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="product_interest" value="Performance">
                    <input type="hidden" name="challenge_slug" value="unerd-run-challenge">

                    <!-- Section Header -->
                    <div>
                        <h2 class="text-base sm:text-lg font-black uppercase tracking-tight text-slate-900 dark:text-white font-display mb-1">
                            Time Attack Challenge
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-zinc-400">
                            Tantangan sprint {{ $activeChallenge ? number_format($activeChallenge->distance_meter ?? 1000, 0, ',', '.') . ' Meter' : '1.000 Meter' }} di lintasan  {{ $activeChallenge->location ?? 'Gelora Bung Karno, Jakarta' }}.
                        </p>
                    </div>

                    <!-- Main Challenge Card (Combined with Status) -->
                    <div class="rounded-2xl p-5 sm:p-6 transition border-2 border-slate-900 dark:border-unerd-volt bg-white dark:bg-[#181818] shadow-sm space-y-4">
                        <!-- Top Badges: Category Recommendation & Period Status -->
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-mono font-bold uppercase tracking-wider bg-slate-100 dark:bg-zinc-800 text-slate-900 dark:text-unerd-volt border border-slate-200 dark:border-zinc-700">
                                Kategori {{ strtoupper($roleCategory) }}
                            </span>

                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-md font-mono text-[10px] font-bold uppercase bg-slate-100 dark:bg-zinc-800 text-slate-700 dark:text-zinc-300">
                                    {{ $activePeriod->cleanName() }}
                                </span>
                                @if (! $isOpenForRegistration)
                                    <span class="px-2.5 py-0.5 rounded-md bg-amber-500/10 text-amber-600 dark:text-amber-400 font-mono text-[10px] font-bold uppercase border border-amber-500/20">
                                        Pendaftaran Ditutup
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-md bg-emerald-500/10 text-emerald-600 dark:text-unerd-volt font-mono text-[10px] font-bold uppercase border border-emerald-500/20">
                                        Pendaftaran Dibuka
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Challenge Title & Description -->
                        <div class="space-y-1">
                            <h3 class="text-xl sm:text-2xl font-black uppercase tracking-tight text-slate-900 dark:text-white font-display">
                                Time Attack Challenge
                            </h3>
                            <p class="text-xs text-slate-600 dark:text-zinc-300 leading-relaxed">
                                {{ $activeChallenge->description ?? 'Time attack sprint 1.000 meter di lintasan  Gelora Bung Karno, Jakarta. Catat waktu stopwatch terbaikmu dan bawa namamu ke puncak leaderboard.' }}
                            </p>
                        </div>

                        <!-- Real Challenge Specs Grid -->
                        <div class="grid grid-cols-3 gap-2.5 p-3 rounded-xl bg-slate-50 dark:bg-black/40 border border-slate-100 dark:border-zinc-800 text-xs">
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-mono font-bold">Jarak Lintasan</span>
                                <span class="font-bold text-slate-900 dark:text-white font-mono mt-0.5 block">
                                    {{ $activeChallenge ? number_format($activeChallenge->distance_meter ?? 1000, 0, ',', '.') . ' M' : '1.000 M' }}
                                </span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-mono font-bold">Lokasi</span>
                                <span class="font-bold text-slate-900 dark:text-white truncate mt-0.5 block">
                                    {{ $activeChallenge->location ?? 'Gelora Bung Karno, Jakarta' }}
                                </span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-mono font-bold">Format Timing</span>
                                <span class="font-bold text-emerald-600 dark:text-unerd-volt mt-0.5 block">
                                    Stopwatch Verified
                                </span>
                            </div>
                        </div>

                        <!-- GABUNGAN: Status & Peringatan Registrasi Langsung di Dalam Card -->
                        @if ($existingResultInPeriod && $existingResultInPeriod->isFinished())
                            <div class="p-4 rounded-xl bg-slate-100 dark:bg-zinc-800/80 border border-slate-200 dark:border-zinc-700 space-y-1">
                                <div class="flex items-center gap-2 font-bold text-xs uppercase font-display text-slate-900 dark:text-white">
                                    <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Kamu Sudah Selesai di Periode Ini</span>
                                </div>
                                <p class="text-xs text-slate-600 dark:text-zinc-400">
                                    Catatan waktu :  <strong class="font-mono text-emerald-600 dark:text-unerd-volt">{{ $existingResultInPeriod->formattedTime() }}</strong> &bull; Setiap pelari memiliki 1 kesempatan per periode.
                                </p>
                            </div>
                        @elseif ($existingResultInPeriod && $existingResultInPeriod->isRunning())
                            <div class="p-4 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-300 dark:border-rose-800 text-rose-900 dark:text-rose-200 space-y-1">
                                <div class="flex items-center gap-2 font-bold text-xs uppercase font-display">
                                    <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                                    <span>Kamu Sedang Aktif Lari di Lintasan!</span>
                                </div>
                                <p class="text-xs text-rose-800 dark:text-rose-300">
                                    ID Pelari: <strong class="font-mono">{{ $existingParticipant?->participant_id }}</strong> &bull; Kru di garis finish siap mencatat waktu mu.
                                </p>
                            </div>
                        @elseif ($existingResultInPeriod && $existingResultInPeriod->isPendingCheckin())
                            <div class="p-4 rounded-xl bg-amber-50 dark:bg-amber-950/40 border border-amber-300 dark:border-amber-800 text-amber-900 dark:text-amber-200 space-y-1">
                                <div class="flex items-center gap-2 font-bold text-xs uppercase font-display">
                                    <svg class="w-4 h-4 text-amber-600 dark:text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Kamu Sudah Terdaftar &bull; Menunggu Start di GBK</span>
                                </div>
                                <p class="text-xs text-amber-800 dark:text-amber-300">
                                    BIB ID: <strong class="font-mono">{{ $existingParticipant?->participant_id }}</strong> &bull; Silakan datang ke booth kru di lintasan untuk konfirmasi start.
                                </p>
                            </div>
                        @elseif (! $isOpenForRegistration)
                            <div class="p-4 rounded-xl bg-amber-50 dark:bg-amber-950/40 border border-amber-300 dark:border-amber-800 text-amber-900 dark:text-amber-200 space-y-1">
                                <div class="flex items-center gap-2 font-bold text-xs uppercase font-display">
                                    <svg class="w-4 h-4 text-amber-600 dark:text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <span>Pendaftaran Periode Ini Sedang Ditutup</span>
                                </div>
                                <p class="text-xs text-amber-800 dark:text-amber-300">
                                    Panitia sedang menutup pendaftaran untuk <strong>{{ $activePeriod->cleanName() }}</strong>. Nantikan pembukaan sesi pendaftaran berikutnya!
                                </p>
                            </div>
                        @endif

                        <!-- Community Selection (Only relevant if user is Komunitas role and not registered yet) -->
                        @if ($roleCategory === 'Komunitas' && ! $existingResultInPeriod)
                            <div class="pt-3 border-t border-slate-200 dark:border-zinc-800 space-y-2">
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">
                                    Pilih Komunitas Lari Afiliasimu
                                </label>
                                <x-community-select :communities="$communities"
                                                    :selected-id="old('community_id', $participant?->community_id ?? auth()->user()->community_id)"
                                                    :selected-name="$participant?->community?->name ?? auth()->user()->community?->name ?? ''"
                                                    placeholder="Cari nama komunitas..." />
                                <p class="text-[11px] text-slate-500 dark:text-zinc-400">
                                    Waktumu akan dihitung ke rata-rata klasemen komunitas (top 3 tercepat).
                                </p>
                            </div>
                        @endif

                        <!-- Action Button directly inside the card -->
                        <div class="pt-3 border-t border-slate-200 dark:border-zinc-800">
                            @if ($existingResultInPeriod && $existingResultInPeriod->isFinished())
                                <a href="{{ route('customer.dashboard') }}"
                                   class="w-full py-3.5 rounded-xl bg-slate-900 text-white dark:bg-white dark:text-black font-black text-xs uppercase tracking-wider hover:opacity-90 transition shadow-xs text-center flex items-center justify-center gap-2">
                                    <span>Buka Dashboard &rarr;</span>
                                </a>
                            @elseif ($existingResultInPeriod && ($existingResultInPeriod->isRunning() || $existingResultInPeriod->isPendingCheckin()))
                                <a href="{{ route('customer.dashboard') }}"
                                   class="w-full py-3.5 rounded-xl bg-slate-900 text-white dark:bg-unerd-volt dark:text-black font-black text-xs uppercase tracking-wider hover:opacity-90 transition shadow-xs text-center flex items-center justify-center gap-2">
                                    <span>Buka Status Pelari &rarr;</span>
                                </a>
                            @elseif (! $isOpenForRegistration)
                                <button type="button" disabled
                                        class="w-full py-3.5 rounded-xl bg-slate-200 dark:bg-zinc-800 text-slate-400 dark:text-zinc-500 font-black text-xs uppercase tracking-wider cursor-not-allowed">
                                    Pendaftaran Ditutup oleh Panitia
                                </button>
                            @else
                                <button type="submit"
                                        class="w-full py-3.5 rounded-xl bg-slate-900 text-white dark:bg-unerd-volt dark:text-black font-black text-xs uppercase tracking-wider hover:opacity-90 transition shadow-xs text-center flex items-center justify-center gap-2 cursor-pointer">
                                    <span>Konfirmasi & Mulai Lari Sekarang</span>
                                    <span>&rarr;</span>
                                </button>
                                <p class="text-center text-[11px] text-slate-400 mt-2">
                                    Tanpa biaya pendaftaran. Kamu langsung mendapatkan nomor pelari  untuk diverifikasi oleh kru panitia.
                                </p>
                            @endif
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-guest-layout>
