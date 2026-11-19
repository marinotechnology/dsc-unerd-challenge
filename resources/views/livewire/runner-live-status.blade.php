<div wire:poll.3s class="space-y-6">
    @if ($activePeriod)
        <!-- Active Period Header & Realtime Sync Indicator (Clean Runner UI) -->
        <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-[#181818] p-5 sm:p-6 border border-slate-200 dark:border-zinc-800 shadow-xs">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="space-y-1.5">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold tracking-wider bg-emerald-500/10 text-emerald-600 dark:text-unerd-volt border border-emerald-500/20 dark:border-unerd-volt/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 dark:bg-unerd-volt animate-ping"></span>
                            LIVE SYNC REALTIME
                        </span>
                        <span class="text-[11px] font-mono text-slate-400 dark:text-zinc-500">
                            &bull; Status otomatis diperbarui tanpa refresh
                        </span>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-baseline gap-1 sm:gap-3">
                        <h2 class="text-lg sm:text-xl font-black font-display uppercase tracking-tight text-slate-900 dark:text-white">
                            {{ $activePeriod->cleanName() }}
                        </h2>
                        <span class="text-xs font-mono text-slate-500 dark:text-zinc-400">
                            @if ($activePeriod->event_date)
                                {{ $activePeriod->event_date->translatedFormat('d F Y') }} &bull; {{ $activeChallenge->location ?? 'Lintasan Lari Resmi' }}
                            @endif
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-3 shrink-0">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl border text-xs font-mono font-extrabold uppercase tracking-wider {{ $activePeriod->is_open_for_registration ? 'bg-emerald-500/10 text-emerald-700 dark:text-unerd-volt border-emerald-500/30 dark:border-unerd-volt/40' : 'bg-slate-100 dark:bg-zinc-800 text-slate-500 dark:text-zinc-400 border-slate-200 dark:border-zinc-700' }}">
                        <span class="w-2 h-2 rounded-full {{ $activePeriod->is_open_for_registration ? 'bg-emerald-500 dark:bg-unerd-volt animate-pulse' : 'bg-slate-400' }}"></span>
                        <span>{{ $activePeriod->is_open_for_registration ? 'PENDAFTARAN BUKA' : 'PENDAFTARAN TUTUP' }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- KONDISI STATUS PELARI PADA PERIODE AKTIF -->
    @if ($activePeriod && ! $activePeriod->is_open_for_registration)
        <!-- PENDAFTARAN PERIODE TELAH DITUTUP -->
        <div class="p-6 rounded-2xl bg-white dark:bg-[#181818] border border-slate-200 dark:border-zinc-800 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold bg-slate-100 dark:bg-zinc-800 text-slate-600 dark:text-zinc-400 border border-slate-200 dark:border-zinc-700 uppercase">
                        Periode Berakhir
                    </span>
                    <span class="text-xs font-mono text-slate-400">Time Attack Challenge &bull; Lintasan 1 KM GBK Senayan, Jakarta</span>
                </div>
                <h3 class="text-base sm:text-lg font-black uppercase text-slate-900 dark:text-white font-display">
                    Pendaftaran dan Sesi Lari {{ $activePeriod->name }} Telah Ditutup
                </h3>
                <p class="text-xs text-slate-500 dark:text-zinc-400">
                    Sesi pencatatan waktu untuk periode ini telah selesai. Anda dapat meninjau riwayat keikutsertaan Anda di bawah ini dan memantau klasemen akhir pada papan leaderboard resmi.
                </p>
            </div>
            <a href="{{ route('everyday-league.leaderboard') }}"
               class="px-5 py-2.5 rounded-xl bg-slate-900 text-white dark:bg-white dark:text-black font-black text-xs uppercase tracking-wider hover:opacity-90 transition shadow-xs text-center shrink-0">
                Lihat Leaderboard Resmi &rarr;
            </a>
        </div>
    @elseif ($currentResult && $currentResult->isPendingCheckin())
        <!-- STATUS 1: SUDAH DAFTAR, MENUNGGU VERIFIKASI START DI BOOTH GBK -->
        <div class="p-6 sm:p-7 rounded-2xl bg-white dark:bg-[#181818] border-2 border-amber-500/40 text-slate-900 dark:text-white space-y-4 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-amber-200 dark:border-zinc-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-amber-500/15 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-mono font-bold uppercase text-amber-600 dark:text-amber-400 tracking-wider">
                            TERDAFTAR DI TIME ATTACK CHALLENGE
                        </span>
                        <h2 class="text-xl sm:text-2xl font-black font-display uppercase tracking-tight text-slate-900 dark:text-white">
                            MENUNGGU VERIFIKASI START DI LOKASI GBK
                        </h2>
                    </div>
                </div>
                <div class="font-mono text-xs font-black text-slate-900 dark:text-white bg-slate-100 dark:bg-zinc-800 px-3.5 py-1.5 rounded-xl border border-slate-200 dark:border-zinc-700">
                    BIB ID: {{ $participant?->participant_id }}
                </div>
            </div>

            <!-- Petunjuk Datang ke Kru Admin di Lokasi -->
            <div class="p-4 rounded-xl bg-amber-50 dark:bg-zinc-900/80 border border-amber-200 dark:border-zinc-800 text-xs text-slate-700 dark:text-zinc-300 space-y-2">
                <div class="flex items-center gap-2 font-bold text-slate-900 dark:text-white text-sm">
                    <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Langkah Selanjutnya: Konfirmasi Start di Booth Kru UNERD GBK</span>
                </div>
                <p class="leading-relaxed">
                    Silakan datangi kru atau admin UNERD di booth start lintasan GBK Senayan dan sampaikan:
                </p>
                <div class="p-3 bg-white dark:bg-black rounded-lg border border-amber-300 dark:border-zinc-700 font-medium text-slate-900 dark:text-white">
                    <span class="font-bold text-amber-700 dark:text-unerd-volt">"Kak, ini saya sudah daftar, saya mau lari"</span>
                    <span class="block text-[11px] text-slate-500 dark:text-zinc-400 mt-1">Sebutkan ID BIB Anda: <strong class="text-slate-900 dark:text-white">{{ $participant?->participant_id }}</strong> ({{ $participant?->full_name }})</span>
                </div>
                <p class="text-[11px] text-slate-500 dark:text-zinc-400">
                    Kru panitia akan menekan tombol <strong>Mulai Lari</strong> di sistem operasional untuk mengaktifkan sesi lari Anda di lintasan. Halaman ini akan otomatis berubah menjadi status lari aktif tanpa perlu refresh.
                </p>
            </div>
        </div>
    @elseif ($currentResult && $currentResult->isRunning())
        <!-- STATUS 2: SEDANG LARI DI LINTASAN GBK (ACTIVE) -->
        <div class="p-6 sm:p-7 rounded-2xl bg-white dark:bg-[#181818] border-2 border-rose-500/50 text-slate-900 dark:text-white space-y-4 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-rose-200 dark:border-zinc-800">
                <div class="flex items-center gap-3">
                    <span class="relative flex h-4 w-4">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-500 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-4 w-4 bg-rose-600"></span>
                    </span>
                    <div>
                        <span class="text-xs font-mono font-bold uppercase text-rose-600 dark:text-rose-400 tracking-wider">
                            STATUS LIVE PELARI &bull; TIME ATTACK CHALLENGE
                        </span>
                        <h2 class="text-xl sm:text-2xl font-black font-display uppercase tracking-tight text-slate-900 dark:text-white">
                            SEDANG LARI DI LINTASAN GBK (AKTIF)
                        </h2>
                    </div>
                </div>
                <div class="font-mono text-xs font-black text-rose-700 dark:text-rose-300 bg-rose-50 dark:bg-zinc-900 px-3.5 py-1.5 rounded-xl border border-rose-200 dark:border-rose-900/50">
                    BIB ID: {{ $participant?->participant_id }}
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                <div class="bg-slate-50 dark:bg-zinc-900 p-3.5 rounded-xl border border-slate-200 dark:border-zinc-800">
                    <span class="block text-[10px] uppercase font-mono text-slate-400 font-bold">Jarak Lintasan</span>
                    <span class="font-bold text-sm text-slate-900 dark:text-white">1.000 Meter (1 KM Sprint)</span>
                </div>
                <div class="bg-slate-50 dark:bg-zinc-900 p-3.5 rounded-xl border border-slate-200 dark:border-zinc-800">
                    <span class="block text-[10px] uppercase font-mono text-slate-400 font-bold">Pencatatan Waktu</span>
                    <span class="font-bold text-sm text-slate-900 dark:text-white">Stopwatch Kru di Finish</span>
                </div>
                <div class="bg-slate-50 dark:bg-zinc-900 p-3.5 rounded-xl border border-slate-200 dark:border-zinc-800">
                    <span class="block text-[10px] uppercase font-mono text-slate-400 font-bold">Status Timer</span>
                    <span class="font-bold text-sm text-rose-600 dark:text-rose-400 animate-pulse">Menuju Garis Finish...</span>
                </div>
            </div>

            <div class="p-3.5 bg-slate-50 dark:bg-zinc-900 rounded-xl text-xs text-slate-600 dark:text-zinc-300 flex items-center gap-2 border border-slate-200 dark:border-zinc-800">
                <svg class="w-4 h-4 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Saat mencapai garis finish, sampaikan <strong>BIB ID: {{ $participant?->participant_id }}</strong> kepada kru pencatat waktu stopwatch. Waktu resmimu akan langsung terverifikasi!</span>
            </div>
        </div>
    @elseif ($currentResult && $currentResult->isFinished())
        <!-- STATUS 3: FINISHER PADA PERIODE AKTIF (1 Kesempatan Resmi) -->
        <div class="p-6 sm:p-8 rounded-2xl bg-white dark:bg-[#181818] border-2 border-emerald-500/40 shadow-sm space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-200 dark:border-zinc-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-unerd-volt flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] uppercase font-mono font-bold text-emerald-600 dark:text-unerd-volt tracking-wider">
                            HASIL RESMI TERVERIFIKASI &bull; TIME ATTACK CHALLENGE
                        </span>
                        <h2 class="text-xl sm:text-2xl font-black font-display uppercase tracking-tight text-slate-900 dark:text-white">
                            SELESAI LARI (FINISHER)
                        </h2>
                    </div>
                </div>

                @if ($currentResult->rank_in_period)
                    <div class="flex items-center gap-2">
                        <span class="px-3.5 py-1.5 rounded-xl font-display font-extrabold text-xs uppercase tracking-wider {{ $currentResult->rank_in_period === 1 ? 'bg-unerd-volt text-black font-black' : ($currentResult->rank_in_period <= 3 ? 'bg-amber-400 text-black font-bold' : ($currentResult->rank_in_period <= 10 ? 'bg-emerald-600 text-white' : 'bg-slate-100 dark:bg-zinc-800 text-slate-700 dark:text-zinc-300')) }}">
                            {{ $currentResult->rank_in_period <= 3 ? 'Juara '.$currentResult->rank_in_period : ($currentResult->rank_in_period <= 10 ? 'Top 10 (Peringkat #'.$currentResult->rank_in_period.')' : 'Peringkat #'.$currentResult->rank_in_period) }}
                        </span>
                    </div>
                @endif
            </div>

            <!-- Stats Highlight Grid (Time with comma format, Pace, Rank) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-center">
                    <span class="block text-[10px] uppercase font-mono text-slate-400 font-bold">Waktu Resmi (Stopwatch)</span>
                    <span class="text-3xl font-mono font-black text-slate-900 dark:text-white mt-1 block">
                        {{ $currentResult->formattedTime() }}
                    </span>
                    <span class="text-[11px] text-slate-400">Format Indonesia mm:ss,ms</span>
                </div>

                <div class="p-4 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-center">
                    <span class="block text-[10px] uppercase font-mono text-slate-400 font-bold">Pace Rata-rata</span>
                    <span class="text-3xl font-mono font-black text-emerald-600 dark:text-unerd-volt mt-1 block">
                        {{ $currentResult->formattedPace() }}
                    </span>
                    <span class="text-[11px] text-slate-400">Menit per kilometer</span>
                </div>

                <div class="p-4 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-center">
                    <span class="block text-[10px] uppercase font-mono text-slate-400 font-bold">Posisi Klasemen Periode</span>
                    <span class="text-3xl font-mono font-black text-slate-900 dark:text-white mt-1 block">
                        #{{ $currentResult->rank_in_period ?? '-' }}
                    </span>
                    <span class="text-[11px] text-slate-400">{{ $activePeriod?->name }}</span>
                </div>
            </div>

            <!-- HADIAH JUARA & VOUCHER TOP 10 -->
            @php
                $prize = $currentResult->getPrize();
            @endphp
            @if ($prize)
                <div class="p-5 rounded-2xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <div class="flex items-center gap-1.5 text-emerald-600 dark:text-unerd-volt font-mono font-bold text-[10px] uppercase tracking-wider mb-1">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                                </svg>
                                <span>HADIAH RESMI TOP 10 TERVERIFIKASI</span>
                            </div>
                            <h3 class="text-lg font-black uppercase text-slate-900 dark:text-white font-display mt-0.5">
                                {{ $prize['title'] ?? 'Hadiah Top 10 Finisher' }}
                            </h3>
                            <p class="text-xs text-slate-600 dark:text-zinc-300 mt-1">
                                {{ $prize['description'] ?? 'Selamat! Catatan waktumu berhasil masuk dalam jajaran 10 besar tercepat.' }}
                            </p>
                        </div>
                        @if (! empty($prize['voucher_code']))
                            <div class="text-left sm:text-right shrink-0">
                                <span class="block text-[10px] uppercase font-mono text-slate-400">Kode Voucher Hadiah</span>
                                <span class="font-mono font-black text-sm px-3 py-1.5 rounded-lg bg-black text-white dark:bg-white dark:text-black inline-block mt-1">
                                    {{ $prize['voucher_code'] }}
                                </span>
                                <span class="block text-[10px] font-mono font-bold text-amber-600 dark:text-amber-400 mt-1">
                                    *Masa berlaku: 1 Minggu (7 Hari)
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Info 1 Kesempatan Lari per Periode (No duplicate / No replay button) -->
            <div class="p-3.5 rounded-xl bg-slate-100 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-xs text-slate-600 dark:text-zinc-400 flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Catatan waktu resmi telah tersimpan di periode ini. Setiap peserta memiliki 1 kesempatan resmi per periode. Untuk tantangan berikutnya, pantau pembukaan periode baru!</span>
            </div>
        </div>
    @elseif ($activePeriod)
        <!-- BELUM MENDAFTAR PADA PERIODE AKTIF -->
        <div class="p-6 rounded-2xl bg-white dark:bg-[#181818] border border-slate-200 dark:border-zinc-800 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="text-[10px] uppercase font-mono font-bold text-emerald-600 dark:text-unerd-volt">
                    {{ $activePeriod->cleanName() }}
                </span>
                <h3 class="text-base font-black uppercase text-slate-900 dark:text-white font-display mt-0.5">
                    Time Attack Challenge (1 KM Sprint) Sedang Berlangsung!
                </h3>
                <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1">
                    Daftar sekarang untuk mendapatkan nomor BIB dan catatkan waktu sprint resmi di {{ $activeChallenge->location ?? 'lintasan resmi' }}.
                </p>
            </div>
            <a href="{{ route('everyday-league.register') }}"
               class="px-5 py-2.5 rounded-xl bg-slate-900 text-white dark:bg-white dark:text-black font-black text-xs uppercase tracking-wider hover:opacity-90 transition shadow-xs text-center shrink-0">
                Masuk Time Attack Challenge &rarr;
            </a>
        </div>
    @else
        <!-- TIDAK ADA EVENT AKTIF SAMA SEKALI -->
        <div class="p-6 rounded-2xl bg-white dark:bg-[#181818] border border-slate-200 dark:border-zinc-800 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="space-y-1">
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold bg-slate-100 dark:bg-zinc-800 text-slate-600 dark:text-zinc-400 border border-slate-200 dark:border-zinc-700 uppercase">
                    Status Event
                </span>
                <h3 class="text-base sm:text-lg font-black uppercase text-slate-900 dark:text-white font-display">
                    Belum Ada Event Aktif Saat Ini
                </h3>
                <p class="text-xs text-slate-500 dark:text-zinc-400">
                    Panitia sedang menyiapkan periode tantangan berikutnya. Rekor lari dari periode sebelumnya tetap tersimpan di riwayat akunmu di bawah.
                </p>
            </div>
            <a href="{{ route('everyday-league.leaderboard') }}"
               class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-slate-800 dark:text-zinc-200 font-bold text-xs uppercase tracking-wider transition shadow-xs text-center shrink-0">
                Lihat Leaderboard &rarr;
            </a>
        </div>
    @endif

    <!-- RIWAYAT PERLOMBAAN TIAP USER PER PERIODE (LIST VIEW BERSIH DENGAN PENANDA EVENT & LOKASI) -->
    <div class="bg-white dark:bg-[#181818] rounded-2xl border border-slate-200 dark:border-zinc-800 shadow-xs overflow-hidden">
        <div class="p-4 sm:p-5 border-b border-slate-200 dark:border-zinc-800 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-black uppercase tracking-wider text-slate-900 dark:text-white">
                    Riwayat Perlombaan & Rekor Lari per Periode
                </h3>
                <p class="text-[11px] text-slate-400 mt-0.5">
                    Daftar seluruh keikutsertaan resmi di Time Attack Challenge
                </p>
            </div>
            <span class="text-xs font-mono font-bold text-slate-500 dark:text-zinc-400">{{ count($historyResults) }} Perlombaan</span>
        </div>

        <div class="divide-y divide-slate-100 dark:divide-zinc-800/60">
            @forelse ($historyResults as $hr)
                @php
                    $histPrize = $hr->getPrize();
                @endphp
                <div class="p-4 sm:p-5 hover:bg-slate-50/50 dark:hover:bg-zinc-900/30 transition flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <!-- Event & Location Identifier -->
                    <div class="space-y-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-2 py-0.5 rounded font-mono font-bold text-[10px] bg-slate-100 dark:bg-zinc-800 text-slate-700 dark:text-zinc-300">
                                {{ $hr->period?->period_code ?? 'EVENT' }}
                            </span>
                            <span class="text-xs font-black uppercase font-display text-slate-900 dark:text-white">
                                {{ $hr->period?->name ?? 'Time Attack Challenge' }}
                            </span>
                            @if ($hr->period?->is_active)
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-500/10 text-emerald-600 dark:text-unerd-volt border border-emerald-500/20">
                                    Periode Aktif
                                </span>
                            @endif
                        </div>
                        <div class="flex items-center gap-1.5 text-xs text-slate-500 dark:text-zinc-400">
                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $hr->period?->cleanName() ?? 'Lintasan Lari' }} &bull; {{ $hr->period?->event_date?->translatedFormat('d F Y') ?? $hr->created_at->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>

                    <!-- Performance Stats Cluster & Actions -->
                    <div class="flex flex-wrap items-center gap-4 sm:gap-6">
                        <!-- Waktu Resmi -->
                        <div class="text-left sm:text-right">
                            <span class="block text-[10px] uppercase font-mono text-slate-400 font-bold">Waktu Resmi</span>
                            <span class="font-mono font-black text-lg text-slate-900 dark:text-white">
                                {{ $hr->verified_time_seconds ? $hr->formattedTime() : '--:--,--' }}
                            </span>
                            <span class="block text-[10px] text-slate-400 font-mono">Pace: {{ $hr->formattedPace() }}</span>
                        </div>

                        <!-- Ranking Klasemen -->
                        <div class="text-left sm:text-center min-w-[70px]">
                            <span class="block text-[10px] uppercase font-mono text-slate-400 font-bold">Klasemen</span>
                            @if ($hr->rank_in_period)
                                <span class="font-mono font-black text-lg {{ $hr->rank_in_period <= 3 ? 'text-amber-500' : ($hr->rank_in_period <= 10 ? 'text-emerald-600 dark:text-unerd-volt' : 'text-slate-600 dark:text-zinc-300') }}">
                                    #{{ $hr->rank_in_period }}
                                </span>
                                <span class="block text-[10px] font-bold text-slate-400">
                                    {{ $hr->rank_in_period <= 3 ? 'Podium' : ($hr->rank_in_period <= 10 ? 'Top 10' : 'Finisher') }}
                                </span>
                            @else
                                <span class="font-mono font-black text-lg text-slate-400">-</span>
                                <span class="block text-[10px] text-slate-400">{{ $hr->isRunning() ? 'Sedang Lari' : 'Belum Selesai' }}</span>
                            @endif
                        </div>

                        <!-- Hadiah yang Didapat -->
                        <div class="text-left sm:text-right min-w-[130px]">
                            <span class="block text-[10px] uppercase font-mono text-slate-400 font-bold">Hadiah / Apresiasi</span>
                            @if ($histPrize)
                                <span class="inline-block mt-0.5 px-2.5 py-1 rounded font-bold text-xs {{ $hr->rank_in_period === 1 ? 'bg-unerd-volt/20 text-slate-900 dark:text-unerd-volt border border-unerd-volt/30' : ($hr->rank_in_period <= 3 ? 'bg-emerald-500/20 text-emerald-700 dark:text-emerald-300' : 'bg-slate-100 dark:bg-zinc-800 text-slate-700 dark:text-zinc-200') }}">
                                    {{ $histPrize['title'] }}
                                </span>
                                @if (! empty($histPrize['voucher_code']))
                                    <div class="text-[10px] font-mono text-slate-500 dark:text-zinc-400 mt-0.5">
                                        Kode: <strong class="text-slate-900 dark:text-white">{{ $histPrize['voucher_code'] }}</strong>
                                    </div>
                                @endif
                            @else
                                <span class="text-slate-400 text-xs">Finisher Resmi</span>
                            @endif
                        </div>

                        <!-- Button Detail & Share -->
                        @if ($participant)
                            <div class="shrink-0">
                                <a href="{{ route('everyday-league.result', $participant->participant_id) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-slate-900 text-white dark:bg-white dark:text-black font-bold text-xs uppercase tracking-wider hover:opacity-90 transition shadow-xs">
                                    <span>Detail & Share</span>
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-xs text-slate-400">
                    Belum ada riwayat lari. Masuk ke Time Attack Challenge untuk mencatat rekor pertamamu!
                </div>
            @endforelse
        </div>
    </div>
</div>
