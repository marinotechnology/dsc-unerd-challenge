<div wire:poll.3s class="space-y-6">
    @if ($showLiveStatus)
        @if ($activePeriod)
            <!-- Active Period Header (Clean & Minimalist) -->
            <div class="rounded-2xl bg-white dark:bg-[#181818] p-5 sm:p-6 border border-slate-200 dark:border-zinc-800 shadow-xs">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded font-mono font-bold text-[10px] tracking-wider uppercase bg-slate-100 dark:bg-zinc-800 text-slate-700 dark:text-zinc-300 border border-slate-200 dark:border-zinc-700">
                                {{ $activePeriod->period_code ?? 'TIME ATTACK' }}
                            </span>
                            <span class="text-xs font-mono font-bold uppercase tracking-wider text-slate-500 dark:text-zinc-400">
                                Time Attack Challenge
                            </span>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-baseline gap-1 sm:gap-3 pt-1">
                            <h2 class="text-lg sm:text-xl font-black font-display uppercase tracking-tight text-slate-900 dark:text-white">
                                {{ $activePeriod->cleanName() }}
                            </h2>
                            <span class="text-xs font-mono text-slate-500 dark:text-zinc-400">
                                @if ($activePeriod->event_date)
                                    {{ $activePeriod->event_date->translatedFormat('d F Y') }} &bull; {{ $activePeriod->formattedTimeRange() }} &bull; {{ $activePeriod->location ?? $activeChallenge->location ?? 'Lintasan Lari' }}
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 shrink-0">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl border text-xs font-mono font-bold uppercase tracking-wider {{ $activePeriod->is_open_for_registration ? 'bg-emerald-500/10 text-emerald-700 dark:text-unerd-volt border-emerald-500/30 dark:border-unerd-volt/40' : 'bg-slate-100 dark:bg-zinc-800 text-slate-500 dark:text-zinc-400 border-slate-200 dark:border-zinc-700' }}">
                            <span class="w-2 h-2 rounded-full {{ $activePeriod->is_open_for_registration ? 'bg-emerald-500 dark:bg-unerd-volt' : 'bg-slate-400' }}"></span>
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
                        <span class="text-xs font-mono text-slate-400">Time Attack Challenge &bull; Lintasan {{ $activePeriod->formattedDistance() }}</span>
                    </div>
                    <h3 class="text-base sm:text-lg font-black uppercase text-slate-900 dark:text-white font-display">
                        Pendaftaran dan Sesi Lari {{ $activePeriod->name }} Telah Ditutup
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-zinc-400">
                        Sesi pencatatan waktu untuk periode ini telah selesai. Anda dapat meninjau riwayat keikutsertaan Anda di bawah ini dan memantau klasemen akhir pada papan leaderboard.
                    </p>
                </div>
                <a href="{{ route('everyday-league.leaderboard') }}"
                   class="px-5 py-2.5 rounded-xl bg-slate-900 text-white dark:bg-white dark:text-black font-black text-xs uppercase tracking-wider hover:opacity-90 transition shadow-xs text-center shrink-0">
                    Lihat Leaderboard  &rarr;
                </a>
            </div>
        @elseif ($currentResult && $currentResult->isPendingCheckin())
        <!-- STATUS 1: SUDAH DAFTAR, MENUNGGU VERIFIKASI START DI BOOTH -->
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
                            MENUNGGU START DI VENUE
                        </h2>
                    </div>
                </div>
                <div class="font-mono text-xs font-black text-slate-900 dark:text-white bg-slate-100 dark:bg-zinc-800 px-3.5 py-1.5 rounded-xl border border-slate-200 dark:border-zinc-700">
                     ID: {{ $participant?->participant_id }}
                </div>
            </div>

            <!-- Petunjuk Datang ke Kru Admin di Lokasi -->
            <div class="p-4 rounded-xl bg-amber-50 dark:bg-zinc-900/80 border border-amber-200 dark:border-zinc-800 text-xs text-slate-700 dark:text-zinc-300 space-y-2">
                <div class="flex items-center gap-2 font-bold text-slate-900 dark:text-white text-sm">
                    <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Langkah Selanjutnya: Konfirmasi Start di Booth Kru Venue ({{ $activePeriod->location ?? 'Venue Lintasan' }})</span>
                </div>
                <p class="leading-relaxed">
                    Silakan datangi kru atau panitia di booth start lintasan dan sampaikan:
                </p>
                <div class="p-3 bg-white dark:bg-black rounded-lg border border-amber-300 dark:border-zinc-700 font-medium text-slate-900 dark:text-white">
                    <span class="font-bold text-amber-700 dark:text-unerd-volt">"Kak, ini saya sudah daftar, saya mau lari"</span>
                    <span class="block text-[11px] text-slate-500 dark:text-zinc-400 mt-1">Sebutkan ID  Anda: <strong class="text-slate-900 dark:text-white">{{ $participant?->participant_id }}</strong> ({{ $participant?->full_name }})</span>
                </div>
                <p class="text-[11px] text-slate-500 dark:text-zinc-400">
                    Kru panitia akan menekan tombol <strong>Mulai Lari (Start)</strong> di sistem operasional untuk mengaktifkan sesi lari Anda di lintasan {{ $activePeriod ? $activePeriod->formattedDistance() : '3 KM' }}. Status akan otomatis diperbarui secara live.
                </p>
            </div>
        </div>
    @elseif ($currentResult && $currentResult->isRunning())
        <!-- STATUS 2: SEDANG LARI DI LINTASAN (ACTIVE) -->
        <div class="p-6 sm:p-7 rounded-2xl bg-white dark:bg-[#181818] border-2 border-rose-500/50 dark:border-unerd-volt text-slate-900 dark:text-white space-y-4 shadow-sm animate-pulse">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-rose-200 dark:border-zinc-800">
                <div class="flex items-center gap-3">
                    <span class="relative flex h-4 w-4">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-500 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-4 w-4 bg-rose-600"></span>
                    </span>
                    <div>
                        <span class="text-xs font-mono font-bold uppercase text-rose-600 dark:text-unerd-volt tracking-wider">
                            STATUS LIVE PELARI &bull; SEDANG AKTIF
                        </span>
                        <h2 class="text-xl sm:text-2xl font-black font-display uppercase tracking-tight text-slate-900 dark:text-white">
                            SILAKAN MULAI LARI!
                        </h2>
                    </div>
                </div>
                <div class="font-mono text-xs font-black text-rose-700 dark:text-unerd-volt bg-rose-50 dark:bg-zinc-900 px-3.5 py-1.5 rounded-xl border border-rose-200 dark:border-zinc-800">
                     ID: {{ $participant?->participant_id }}
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                <div class="bg-slate-50 dark:bg-zinc-900 p-3.5 rounded-xl border border-slate-200 dark:border-zinc-800">
                    <span class="block text-[10px] uppercase font-mono text-slate-400 font-bold">Jarak Lintasan</span>
                    <span class="font-bold text-sm text-slate-900 dark:text-white">
                        {{ $activePeriod ? $activePeriod->formattedDistance() : '3 KM' }} ({{ $activePeriod?->distance_meter ?? 3000 }} Meter)
                    </span>
                </div>
                <div class="bg-slate-50 dark:bg-zinc-900 p-3.5 rounded-xl border border-slate-200 dark:border-zinc-800">
                    <span class="block text-[10px] uppercase font-mono text-slate-400 font-bold">Pencatatan Waktu</span>
                    <span class="font-bold text-sm text-slate-900 dark:text-white">Stopwatch Kru di Finish</span>
                </div>
                <div class="bg-slate-50 dark:bg-zinc-900 p-3.5 rounded-xl border border-slate-200 dark:border-zinc-800">
                    <span class="block text-[10px] uppercase font-mono text-slate-400 font-bold">Status Timer</span>
                    <span class="font-bold text-sm text-rose-600 dark:text-unerd-volt animate-pulse">Menuju Garis Finish...</span>
                </div>
            </div>

            <div class="p-3.5 bg-slate-50 dark:bg-zinc-900 rounded-xl text-xs text-slate-600 dark:text-zinc-300 flex items-center justify-between flex-wrap gap-3 border border-slate-200 dark:border-zinc-800">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Pacu kecepatan terbaikmu! Saat mencapai garis finish, sampaikan <strong> ID: {{ $participant?->participant_id }}</strong> kepada kru pencatat stopwatch.</span>
                </div>
                <a href="{{ route('everyday-league.result', $participant?->participant_id) }}"
                   class="px-4 py-2 rounded-xl bg-slate-900 text-white dark:bg-unerd-volt dark:text-black font-black text-xs uppercase tracking-wider hover:opacity-90 transition">
                    Lihat Hasil &rarr;
                </a>
            </div>
        </div>
    @elseif ($currentResult && $currentResult->isFinished())
        <!-- STATUS 3: FINISHER PADA PERIODE AKTIF (1 Kesempatan ) -->
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
                            HASIL  TERVERIFIKASI &bull; TIME ATTACK CHALLENGE
                        </span>
                        <h2 class="text-xl sm:text-2xl font-black font-display uppercase tracking-tight text-slate-900 dark:text-white">
                            SELESAI LARI (FINISHER)
                        </h2>
                    </div>
                </div>

                @if ($currentResult->rank_in_period)
                    @php
                        $segmentName = in_array($participant?->participant_category, ['Umum', 'Komunitas'], true) ? 'Umum & Komunitas' : ($participant?->participant_category ?? 'Umum');
                    @endphp
                    <div class="flex items-center gap-2">
                        <span class="px-3.5 py-1.5 rounded-xl font-display font-extrabold text-xs uppercase tracking-wider {{ $currentResult->rank_in_period === 1 ? 'bg-unerd-volt text-black font-black' : ($currentResult->rank_in_period <= 3 ? 'bg-amber-400 text-black font-bold' : ($currentResult->rank_in_period <= 10 ? 'bg-emerald-600 text-white' : 'bg-slate-100 dark:bg-zinc-800 text-slate-700 dark:text-zinc-300')) }}">
                            {{ $currentResult->rank_in_period <= 3 ? 'Juara '.$currentResult->rank_in_period.' ('.$segmentName.')' : ($currentResult->rank_in_period <= 10 ? 'Top 10 '.$segmentName.' (Peringkat #'.$currentResult->rank_in_period.')' : 'Peringkat #'.$currentResult->rank_in_period.' '.$segmentName) }}
                        </span>
                    </div>
                @endif
            </div>

            <!-- Stats Highlight Grid (Time with comma format, Pace, Rank) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-center">
                    <span class="block text-[10px] uppercase font-mono text-slate-400 font-bold">Waktu  (Stopwatch)</span>
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
                    <span class="block text-[10px] uppercase font-mono text-slate-400 font-bold">Posisi Klasemen Leaderboard</span>
                    <span class="text-3xl font-mono font-black text-slate-900 dark:text-white mt-1 block">
                        #{{ $currentResult->rank_in_period ?? '-' }}
                    </span>
                    <span class="text-[11px] text-slate-400 block truncate">{{ $activePeriod?->name }} • {{ in_array($participant?->participant_category, ['Umum', 'Komunitas'], true) ? 'Umum & Komunitas' : ($participant?->participant_category ?? 'Umum') }}</span>
                </div>
            </div>

            <!-- HADIAH JUARA & VOUCHER KLASEMEN -->
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
                                <span>HADIAH  TOP 10 TERVERIFIKASI</span>
                            </div>
                            <h3 class="text-lg font-black uppercase text-slate-900 dark:text-white font-display mt-0.5">
                                {{ $prize['title'] ?? 'Hadiah Peringkat Tantangan' }}
                            </h3>
                            <p class="text-xs text-slate-600 dark:text-zinc-300 mt-1">
                                {{ $prize['description'] ?? 'Selamat! Catatan waktumu berhasil masuk dalam jajaran penerima apresiasi hadiah.' }}
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

            <!-- Tombol Cepat Menuju Kartu Hasil Resmi & Detail Lari -->
            <div class="pt-1 flex flex-col sm:flex-row items-center gap-3">
                <a href="{{ route('everyday-league.result', $participant?->participant_id) }}"
                   class="w-full sm:flex-1 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-slate-900 text-white dark:bg-unerd-volt dark:text-black font-black text-xs uppercase tracking-wider hover:opacity-90 transition shadow-xs cursor-pointer">
                    <span>Buka Detail Hasil Lari & Share</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
                <a href="{{ route('everyday-league.leaderboard') }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-slate-800 dark:text-zinc-200 font-bold text-xs uppercase tracking-wider transition cursor-pointer">
                    <span>Lihat Leaderboard Live</span>
                </a>
            </div>

            <!-- Info 1 Kesempatan Lari per Periode (No duplicate / No replay button) -->
            <div class="p-3.5 rounded-xl bg-slate-100 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-xs text-slate-600 dark:text-zinc-400 flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Catatan waktu telah tersimpan di periode ini. Setiap peserta memiliki 1 kesempatan per periode. Untuk tantangan berikutnya, pantau pembukaan periode baru!</span>
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
                    Daftar sekarang untuk mendapatkan nomor  dan catatkan waktu sprint  di {{ $activeChallenge->location ?? 'lintasan ' }}.
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
    @endif

    @if ($showHistory)
        <!-- RIWAYAT PERLOMBAAN TIAP USER PER PERIODE (LIST VIEW BERSIH DENGAN PENANDA EVENT & LOKASI) -->
        <div class="bg-white dark:bg-[#181818] rounded-2xl border border-slate-200 dark:border-zinc-800 shadow-xs overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-200 dark:border-zinc-800 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-black uppercase tracking-wider text-slate-900 dark:text-white font-display">
                        Riwayat Perlombaan & Rekor Lari per Periode
                    </h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">
                        Daftar seluruh keikutsertaan  di Time Attack Challenge
                    </p>
                </div>
                <span class="text-xs font-mono font-bold text-slate-500 dark:text-zinc-400">{{ count($historyResults) }} Perlombaan</span>
            </div>

            <div class="divide-y divide-slate-100 dark:divide-zinc-800/60">
                @forelse ($historyResults as $hr)
                    <div class="p-4 sm:p-5 hover:bg-slate-50/50 dark:hover:bg-zinc-900/30 transition flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
                        <!-- Periode & Tanggal Info -->
                        <div class="space-y-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="px-2 py-0.5 rounded font-mono font-bold text-[10px] bg-slate-100 dark:bg-zinc-800 text-slate-700 dark:text-zinc-300">
                                    {{ $hr->period?->period_code ?? 'EVENT' }}
                                </span>
                                <span class="text-xs sm:text-sm font-black uppercase font-display text-slate-900 dark:text-white truncate">
                                    {{ $hr->period?->name ?? 'Time Attack Challenge' }}
                                </span>
                                @if ($hr->period?->is_active)
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-500/10 text-emerald-600 dark:text-unerd-volt border border-emerald-500/20">
                                        Aktif
                                    </span>
                                @endif
                            </div>
                            <div class="text-xs text-slate-500 dark:text-zinc-400 flex items-center gap-1.5">
                                <span>{{ $hr->period?->cleanName() ?? 'Lintasan Lari' }}</span>
                                <span>&bull;</span>
                                <span>{{ $hr->period?->event_date?->translatedFormat('d F Y') ?? $hr->created_at->translatedFormat('d F Y') }}</span>
                            </div>
                        </div>

                        <!-- Ringkasan Waktu, Ranking & Tombol Detail -->
                        <div class="flex items-center justify-between sm:justify-end gap-3 sm:gap-5 shrink-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-100 dark:border-zinc-800">
                            <div class="text-left sm:text-right">
                                <span class="font-mono font-black text-sm sm:text-base text-slate-900 dark:text-white block leading-tight">
                                    {{ $hr->verified_time_seconds ? $hr->formattedTime() : '--:--,--' }}
                                </span>
                                <span class="text-[10px] font-mono text-slate-400 block">Pace {{ $hr->formattedPace() }}</span>
                            </div>

                            <div class="text-center min-w-[50px]">
                                @if ($hr->rank_in_period)
                                    <span class="font-mono font-black text-sm sm:text-base {{ $hr->rank_in_period <= 3 ? 'text-amber-500' : 'text-slate-900 dark:text-white' }} block leading-tight">
                                        #{{ $hr->rank_in_period }}
                                    </span>
                                    <span class="text-[10px] font-bold text-slate-400 block">
                                        {{ $hr->rank_in_period <= 3 ? 'Podium' : 'Rank' }}
                                    </span>
                                @else
                                    <span class="font-mono font-bold text-sm text-slate-400 block leading-tight">-</span>
                                    <span class="text-[10px] text-slate-400 block">Finisher</span>
                                @endif
                            </div>

                            @if ($participant)
                                <a href="{{ route('everyday-league.result', ['participant' => $participant->participant_id, 'result_id' => $hr->id]) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-900 text-white dark:bg-white dark:text-black font-bold text-xs uppercase tracking-wider hover:opacity-90 transition shadow-xs shrink-0">
                                    <span>Detail & Share</span>
                                    <span>&rarr;</span>
                                </a>
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
    @endif
</div>
