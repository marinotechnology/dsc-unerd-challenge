<div wire:poll.2s class="py-6 sm:py-10">
    <div class="max-w-xl mx-auto px-4 sm:px-6">
        @php
            $isRunning = $currentResult && $currentResult->isRunning();
            $isFinished = $currentResult && $currentResult->isFinished();
            $isCheckedIn = $currentResult && ($isRunning || $isFinished || $currentResult->checkin_status === 'CHECKED_IN');
        @endphp

        @if ($isRunning)
            <!-- TAMPILAN BERUBAH: SAAT STATUS SEDANG MULAI LARI (RUNNING) -->
            <div class="text-center mb-6 animate-pulse">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-rose-500/20 text-rose-600 dark:bg-unerd-volt/20 dark:text-unerd-volt mb-3 border-2 border-rose-500 dark:border-unerd-volt">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div class="inline-block px-3 py-1 rounded-full bg-rose-600 text-white dark:bg-unerd-volt dark:text-black text-[11px] font-mono font-black uppercase tracking-widest mb-2">
                    LARI AKTIF DI LINTASAN
                </div>
                <h1 class="text-2xl sm:text-4xl font-black text-slate-900 dark:text-white uppercase tracking-tight font-display">
                    Silakan Mulai Lari!
                </h1>
                <!-- <p class="text-xs sm:text-sm text-slate-600 dark:text-zinc-300 mt-2 max-w-md mx-auto leading-relaxed">
                    Petugas telah mengaktifkan sesimu di lintasan <strong class="text-slate-900 dark:text-white">{{ $distance }}</strong>. Pacu ritme terbaikmu dan petugas di garis finish siap mencatat waktu stopwatch resmimu!
                </p> -->
            </div>
        @elseif ($isFinished)
            <!-- TAMPILAN FINISH: SELESAI LARI -->
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-emerald-100 text-emerald-600 dark:bg-emerald-950/60 dark:text-emerald-400 mb-3 border border-emerald-300/40">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white uppercase tracking-tight font-display">
                    Selamat, Kamu Telah Finish!
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-zinc-400 mt-1">
                    Waktu lari resmi telah dicatat. Buka kartu hasilmu untuk melihat rekor dan hadiahmu!
                </p>
            </div>
        @else
            <!-- TAMPILAN AWAL: REGISTRASI BERHASIL, MENUNGGU DI VENUE -->
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 dark:bg-emerald-950/60 dark:text-emerald-400 mb-3 border border-emerald-300/40">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white uppercase tracking-tight font-display">
                    Registrasi Berhasil!
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-1">
                    ID Pelarimu telah diterbitkan untuk gelaran UNERD Move Series di {{ $venueLocation }}.
                </p>
            </div>
        @endif

        <!-- Digital  / Runner Card (High-Impact Design) -->
        <div class="relative bg-zinc-950 rounded-3xl border-2 {{ $isRunning ? 'border-rose-500 dark:border-unerd-volt' : 'border-slate-800 dark:border-unerd-volt/40' }} p-6 sm:p-8 shadow-2xl text-white overflow-hidden mb-6">
            @if ($period?->banner_image)
                <div class="absolute inset-0 opacity-15 bg-cover bg-center pointer-events-none" style="background-image: url('{{ $period->banner_image }}');"></div>
            @endif

            <!-- Decorative Graphic -->
            <div class="absolute right-4 top-4 opacity-10 font-black text-7xl select-none">
                RUN
            </div>

            <!-- Top Row: Logos & Status -->
            <div class="flex items-center justify-between border-b border-white/10 pb-4 mb-6 relative z-10">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full {{ $isRunning ? 'bg-rose-500 animate-ping' : 'bg-unerd-volt' }}"></span>
                    <span class="text-xs font-black tracking-widest uppercase {{ $isRunning ? 'text-rose-400 dark:text-unerd-volt' : 'text-unerd-volt' }}">
                        UNERD MOVE SERIES
                    </span>
                </div>
                <span class="px-2.5 py-0.5 rounded-md bg-white/10 text-[11px] font-semibold text-slate-300 border border-white/10">
                    {{ $distance }} &bull; {{ $period?->event_date?->format('d M Y') ?? '2026' }}
                </span>
            </div>

            <!-- Big Participant ID ( Number) -->
            <div class="text-center py-4 my-2 relative z-10">
                <span class="text-[11px] uppercase tracking-widest font-mono text-slate-400">
                    OFFICIAL RUNNER ID
                </span>
                <div class="text-4xl sm:text-5xl font-black tracking-wider text-unerd-volt font-mono mt-1 select-all">
                    {{ $participant->participant_id }}
                </div>
                <p class="text-[11px] text-slate-400 mt-1">
                    {{ $isRunning ? 'Sebutkan ID ini kepada kru pencatat waktu saat menyentuh garis finish' : 'Tunjukkan kode ini kepada petugas UNERD di titik check-in venue' }}
                </p>
            </div>

            <!-- Participant Details Grid -->
            <div class="grid grid-cols-2 gap-3 pt-4 border-t border-white/10 text-xs relative z-10">
                <div>
                    <span class="block text-[10px] uppercase tracking-wider text-slate-400">Nama Pelari</span>
                    <span class="font-bold text-white text-sm truncate block">{{ $participant->display_name }}</span>
                </div>

                <div>
                    <span class="block text-[10px] uppercase tracking-wider text-slate-400">Kategori Peserta</span>
                    <span class="font-bold text-white text-sm block">{{ $participant->participant_category }}</span>
                </div>

                <div>
                    <span class="block text-[10px] uppercase tracking-wider text-slate-400">Ukuran Sepatu</span>
                    <span class="font-bold text-unerd-volt text-sm block">EU {{ $participant->shoe_size }}</span>
                </div>

                <div>
                    <span class="block text-[10px] uppercase tracking-wider text-slate-400">Lokasi Venue</span>
                    <span class="font-bold text-white text-sm truncate block">
                        {{ $venueLocation }}
                    </span>
                </div>
            </div>

            <!-- Bottom Status Pill -->
            <div class="mt-6 pt-4 border-t border-white/10 flex items-center justify-between text-[11px] text-slate-400 relative z-10">
                <span>Status Lari:</span>
                @if ($isRunning)
                    <span class="inline-flex items-center gap-1.5 font-bold text-rose-400 dark:text-unerd-volt">
                        <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                        Sedang Lari di Lintasan ({{ $distance }})
                    </span>
                @elseif ($isFinished)
                    <span class="inline-flex items-center gap-1 font-bold text-emerald-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Selesai Lari (Finish)
                    </span>
                @elseif ($isCheckedIn)
                    <span class="inline-flex items-center gap-1 font-bold text-emerald-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Checked-In di Venue
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 font-bold text-amber-300">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                        Menunggu di Venue
                    </span>
                @endif
            </div>
        </div>

        <!-- Guidance Card -->
        <div class="bg-white dark:bg-[#181818] rounded-2xl border border-slate-200 dark:border-zinc-800 p-6 shadow-sm mb-6">
            <h2 class="text-sm font-black uppercase tracking-wider text-slate-900 dark:text-white mb-4 flex items-center gap-2 font-display">
                <svg class="w-4 h-4 text-slate-900 dark:text-unerd-volt" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Panduan Pelari di Venue ({{ $venueLocation }})
            </h2>

            <ol class="space-y-3.5 text-xs text-slate-600 dark:text-zinc-300">
                <li class="flex items-start gap-3">
                    <span class="flex-shrink-0 w-5 h-5 rounded-full bg-slate-900 dark:bg-white text-white dark:text-black font-bold flex items-center justify-center text-[10px]">1</span>
                    <span><strong>Kunjungi Booth Aktivasi UNERD</strong> di lokasi venue <strong>{{ $venueLocation }}</strong> dan tunjukkan <strong>ID {{ $participant->participant_id }}</strong> kepada petugas.</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="flex-shrink-0 w-5 h-5 rounded-full bg-slate-900 dark:bg-white text-white dark:text-black font-bold flex items-center justify-center text-[10px]">2</span>
                    <span><strong>Siapkan Dirimu:</strong> Lakukan pemanasan. Kamu bisa mencoba trial produk sepatu lari UNERD sesuai ukuranmu (EU {{ $participant->shoe_size }}).</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="flex-shrink-0 w-5 h-5 rounded-full bg-slate-900 dark:bg-white text-white dark:text-black font-bold flex items-center justify-center text-[10px]">3</span>
                    <span><strong>Mulai Lari {{ $distance }}:</strong> Berlari di lintasan {{ $distance }} sesuai instruksi petugas. Petugas akan mencatat catatan waktumu menggunakan stopwatch resmi.</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="flex-shrink-0 w-5 h-5 rounded-full bg-slate-900 dark:bg-white text-white dark:text-black font-bold flex items-center justify-center text-[10px]">4</span>
                    <span><strong>Cek Hasil & Leaderboard:</strong> Segera setelah finish, cek hasil hingga selesai dan raih hadiah podium serta voucher belanja eksklusif!</span>
                </li>
            </ol>
        </div>

        <!-- Action Buttons: When Running or Finished, show "Lihat Hasil", otherwise only show the 2 navigation buttons -->
        <div class="space-y-3">
            @if ($isRunning || $isFinished)
                <a href="{{ route('everyday-league.result', $participant->participant_id) }}"
                   class="w-full inline-flex items-center justify-center px-4 py-3.5 rounded-xl font-black text-xs uppercase tracking-wider bg-slate-900 text-white dark:bg-unerd-volt dark:text-black hover:opacity-90 transition shadow text-center">
                    Lihat Hasil &rarr;
                </a>
            @endif

            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('everyday-league.leaderboard') }}"
                   class="inline-flex items-center justify-center px-4 py-3 rounded-xl font-bold text-xs uppercase tracking-wider bg-white dark:bg-[#181818] text-slate-900 dark:text-white border border-slate-200 dark:border-zinc-800 hover:border-slate-900 dark:hover:border-unerd-volt transition text-center">
                    Papan Peringkat Live
                </a>
                <a href="{{ route('everyday-league.index') }}"
                   class="inline-flex items-center justify-center px-4 py-3 rounded-xl font-bold text-xs uppercase tracking-wider bg-white dark:bg-[#181818] text-slate-900 dark:text-white border border-slate-200 dark:border-zinc-800 hover:border-slate-900 dark:hover:border-unerd-volt transition text-center">
                    Beranda Challenge
                </a>
            </div>
        </div>
    </div>
</div>
