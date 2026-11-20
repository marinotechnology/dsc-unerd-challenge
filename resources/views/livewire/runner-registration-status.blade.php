<div wire:poll.2s class="py-6 sm:py-10">
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        @php
            $isRunning = $currentResult && $currentResult->isRunning();
            $isFinished = $currentResult && $currentResult->isFinished();
            $isCheckedIn = $currentResult && ($isRunning || $isFinished || $currentResult->checkin_status === 'CHECKED_IN');
            $mapsPhoto = $period?->banner_image ? asset(ltrim($period->banner_image, '/')) : asset('images/gallery/gallery-2.jpg');
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
                    Waktu lari resmi telah dicatat oleh panitia. Buka kartu hasilmu untuk melihat rekor dan hadiahmu!
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
                <!-- <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-1">
                    ID Pelarimu telah diterbitkan untuk gelaran UNERD Move Series di {{ $venueLocation }}.
                </p> -->
            </div>
        @endif

        <!-- Digital Runner Card (High-Impact Design) -->
        <div class="relative bg-zinc-950 rounded-3xl border-2 {{ $isRunning ? 'border-rose-500 dark:border-unerd-volt' : 'border-slate-800 dark:border-unerd-volt/40' }} p-6 sm:p-8 shadow-2xl text-white overflow-hidden mb-6">
            <!-- Subtle Logo Watermark (Polos Bersih Tanpa Foto Background) -->
            <img src="{{ asset('images/logos/master-dark.png') }}"
                 alt="UNERD Watermark"
                 class="absolute right-4 top-1/2 -translate-y-1/2 h-20 sm:h-28 opacity-[0.06] pointer-events-none select-none filter grayscale contrast-200" />

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

            <!-- Big Participant ID -->
            <div class="text-center py-4 my-2 relative z-10">
                <span class="text-[11px] uppercase tracking-widest font-mono text-slate-400">
                    OFFICIAL RUNNER ID
                </span>
                <div class="text-4xl sm:text-5xl font-black tracking-wider text-unerd-volt font-mono mt-1 select-all">
                    {{ $participant->participant_id }}
                </div>
                <p class="text-[11px] text-slate-400 mt-1">
                    {{ $isRunning ? 'Sebutkan ID ini kepada panitia pencatat waktu saat menyentuh garis finish' : 'Tunjukkan kode ini kepada panitia UNERD di booth' }}
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
                    <span class="block text-[10px] uppercase tracking-wider text-slate-400">Lokasi Booth</span>
                    <span class="font-bold text-white text-sm truncate block">
                        {{ $venueLocation }}
                    </span>
                </div>
            </div>

            <!-- Bottom Status Pill -->
            <div class="mt-6 pt-4 border-t border-white/10 flex items-center justify-between text-[11px] text-slate-400 relative z-10">
                <span>Status:</span>
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
                        Checked-In di Booth
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 font-bold text-amber-300">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                        Perlu ke lokasi booth
                    </span>
                @endif
            </div>
        </div>

        <!-- Guidance Card (Wording Panitia & Booth) -->
        <div class="bg-white dark:bg-[#181818] rounded-2xl border border-slate-200 dark:border-zinc-800 p-5 sm:p-6 shadow-sm mb-6">
            <h2 class="text-sm font-black uppercase tracking-wider text-slate-900 dark:text-white mb-4 flex items-center gap-2 font-display">
                <svg class="w-4 h-4 text-slate-900 dark:text-unerd-volt" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Panduan Challenger di Booth ({{ $venueLocation }})
            </h2>

            <ol class="space-y-3.5 text-xs text-slate-600 dark:text-zinc-300">
                <li class="flex items-start gap-3">
                    <span class="flex-shrink-0 w-5 h-5 rounded-full bg-slate-900 dark:bg-white text-white dark:text-black font-bold flex items-center justify-center text-[10px]">1</span>
                    <span><strong>Kunjungi Booth UNERD</strong> di lokasi <strong>{{ $venueLocation }}</strong> dan tunjukkan <strong>ID {{ $participant->participant_id }}</strong> kepada panitia.</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="flex-shrink-0 w-5 h-5 rounded-full bg-slate-900 dark:bg-white text-white dark:text-black font-bold flex items-center justify-center text-[10px]">2</span>
                    <span><strong>Siapkan Dirimu:</strong> Lakukan pemanasan. Kamu bisa mencoba trial produk sepatu lari UNERD sesuai ukuranmu (EU {{ $participant->shoe_size }}).</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="flex-shrink-0 w-5 h-5 rounded-full bg-slate-900 dark:bg-white text-white dark:text-black font-bold flex items-center justify-center text-[10px]">3</span>
                    <span><strong>Mulai Lari {{ $distance }}:</strong> Berlari di lintasan {{ $distance }} sesuai instruksi panitia. Panitia akan mencatat catatan waktumu menggunakan stopwatch. Gunakan strava sebagai pelacak rute lari anda, akan ditunjukan kepanitia di akhir sesi lari.</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="flex-shrink-0 w-5 h-5 rounded-full bg-slate-900 dark:bg-white text-white dark:text-black font-bold flex items-center justify-center text-[10px]">4</span>
                    <span><strong>Cek Hasil & Leaderboard:</strong> Segera setelah finish, cek hasil lari dan raih hadiah podium serta voucher diskon belanja 10%!</span>
                </li>
            </ol>
        </div>

        <!-- PETA & TITIK LOKASI BOOTH LINTASAN (1-PAGE TERINTEGRASI) -->
        <div class="bg-white dark:bg-[#181818] rounded-2xl border border-slate-200 dark:border-zinc-800 p-5 sm:p-6 shadow-sm mb-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-zinc-800 pb-3">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <h2 class="text-sm font-black uppercase tracking-wider text-slate-900 dark:text-white font-display">
                        Titik lokasi booth
                    </h2>
                </div>
                <span class="text-[10px] font-mono font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-slate-100 dark:bg-zinc-800 text-slate-600 dark:text-zinc-300">
                    {{ $period?->cleanName() ?? 'Event Aktif' }}
                </span>
            </div>

            <!-- Foto Maps / Denah Lokasi Booth -->
            <a href="{{ $mapsPhoto }}" target="_blank" class="group relative block overflow-hidden rounded-xl bg-zinc-900 border border-slate-200 dark:border-zinc-800 h-48 sm:h-64 shadow-xs">
                <img src="{{ $mapsPhoto }}"
                     alt="Denah Lokasi Booth {{ $venueLocation }}"
                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                <div class="absolute inset-0 bg-black/40 group-hover:bg-black/20 transition-colors"></div>

                <div class="absolute bottom-3 right-3">
                    <span class="px-3 py-1.5 rounded-lg bg-black/80 backdrop-blur-xs text-white text-[11px] font-mono font-bold border border-white/20 group-hover:border-unerd-volt transition flex items-center gap-1.5">
                        <span>Perbesar peta</span>
                        <span>↗</span>
                    </span>
                </div>
            </a>

            <!-- 4 Clean Fast Facts Boxes -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 pt-1">
                <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800">
                    <div class="text-[9px] font-mono text-slate-400 font-bold uppercase">JARAK</div>
                    <div class="font-display font-extrabold text-xs sm:text-sm text-slate-900 dark:text-white uppercase mt-0.5">
                        {{ $distance }}
                    </div>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800">
                    <div class="text-[9px] font-mono text-slate-400 font-bold uppercase">LOKASI BOOTH</div>
                    <div class="font-display font-extrabold text-xs sm:text-sm text-slate-900 dark:text-white uppercase mt-0.5 truncate">
                        {{ explode(',', $venueLocation)[0] }}
                    </div>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800">
                    <div class="text-[9px] font-mono text-slate-400 font-bold uppercase">TANGGAL</div>
                    <div class="font-display font-extrabold text-xs sm:text-sm text-slate-900 dark:text-white uppercase mt-0.5">
                        {{ $period?->event_date ? $period->event_date->format('d/m/Y') : '-' }}
                    </div>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800">
                    <div class="text-[9px] font-mono text-slate-400 font-bold uppercase">WAKTU (WIB)</div>
                    <div class="font-display font-extrabold text-xs sm:text-sm text-slate-900 dark:text-white uppercase mt-0.5 truncate">
                        {{ $period?->formattedTimeRange() ?? '06:00 - 09:00 WIB' }}
                    </div>
                </div>
            </div>

            <!-- Petunjuk Konfirmasi di Booth -->
            <!-- <div class="p-3 rounded-xl bg-slate-50 dark:bg-zinc-900/60 border border-slate-200 dark:border-zinc-800 text-xs text-slate-600 dark:text-zinc-300 flex items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <span class="text-base">📍</span>
                    <span>Tunjukkan ID <strong class="font-mono text-slate-900 dark:text-white">{{ $participant->participant_id }}</strong> kepada panitia di booth untuk aktivasi start.</span>
                </div>
                <a href="{{ $mapsPhoto }}" target="_blank" class="shrink-0 text-xs font-bold text-unerd-volt-dark dark:text-unerd-volt hover:underline">
                    Perbesar Peta ↗
                </a>
            </div> -->
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
