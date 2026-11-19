<div class="space-y-6">
    <!-- Live Notification Banner -->
    @if ($feedbackMessage)
        <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-300 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs font-semibold flex items-center justify-between gap-2 shadow-xs transition">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>{{ $feedbackMessage }}</span>
            </div>
            <button wire:click="$set('feedbackMessage', '')" type="button" class="text-xs text-emerald-600 dark:text-emerald-400 hover:opacity-75 font-bold cursor-pointer">
                &times;
            </button>
        </div>
    @endif

    <!-- Control Center: Periode & Pengaturan Operasional -->
    <div class="bg-white dark:bg-[#181818] p-5 sm:p-6 rounded-2xl border border-slate-200 dark:border-zinc-800 shadow-xs space-y-4">
        <!-- Top Row: Active Period Info & Actions -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-4 border-b border-slate-200 dark:border-zinc-800">
            <div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold tracking-wider {{ $currentPeriod?->is_open_for_registration ? 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-300 border border-emerald-500/20' : 'bg-slate-100 dark:bg-zinc-800 text-slate-600 dark:text-zinc-400 border border-slate-200 dark:border-zinc-700' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $currentPeriod?->is_open_for_registration ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
                        {{ $currentPeriod?->is_open_for_registration ? 'PENDAFTARAN DIBUKA' : 'PENDAFTARAN DITUTUP' }}
                    </span>
                    <span class="text-xs font-mono text-slate-500 dark:text-zinc-400">
                        {{ $currentPeriod?->period_code }}
                    </span>
                </div>
                <h1 class="text-xl sm:text-2xl font-black font-display uppercase tracking-tight text-slate-900 dark:text-white mt-1">
                    {{ $currentPeriod?->name ?? 'Operasional Time Attack Challenge' }}
                </h1>
                <p class="text-xs text-slate-500 dark:text-zinc-400 mt-0.5">
                    Lintasan 1 KM GBK Senayan &bull; Tanggal Event: {{ $currentPeriod?->event_date?->translatedFormat('d F Y') ?? '21 November 2026' }}
                </p>
            </div>

            <!-- Quick Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <!-- Manage Period Modal Button -->
                <button wire:click="openManagePeriodModal"
                        type="button"
                        class="px-3.5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-slate-900 text-white dark:bg-white dark:text-black hover:opacity-90 transition cursor-pointer flex items-center gap-1.5 shadow-xs">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Kelola & Tambah Periode</span>
                </button>

                <!-- Toggle Registration Open / Closed -->
                <button wire:click="toggleRegistrationOpen"
                        type="button"
                        class="px-3.5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition border cursor-pointer flex items-center gap-1.5 {{ $periodIsOpen ? 'bg-rose-50 dark:bg-rose-950/20 border-rose-300 dark:border-rose-800 text-rose-700 dark:text-rose-300 hover:bg-rose-100' : 'bg-emerald-50 dark:bg-emerald-950/20 border-emerald-300 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 hover:bg-emerald-100' }}">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        @if ($periodIsOpen)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        @endif
                    </svg>
                    <span>{{ $periodIsOpen ? 'Tutup Pendaftaran' : 'Buka Pendaftaran' }}</span>
                </button>

                <!-- Prize Configuration Button -->
                <button wire:click="openPrizeModal"
                        type="button"
                        class="px-3.5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-slate-100 dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 hover:border-unerd-volt text-slate-700 dark:text-zinc-200 transition cursor-pointer flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Atur Hadiah Juara (1–10)</span>
                </button>
            </div>
        </div>

        <!-- Bottom Row: Period Switcher & CSV Exports -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
            <div class="flex flex-wrap items-center gap-3">
                <span class="text-xs font-mono font-bold uppercase text-slate-500 dark:text-zinc-400">Pilih Periode:</span>
                <div class="flex items-center gap-2">
                    <input type="text"
                           wire:model.live.debounce.250ms="periodSearch"
                           placeholder="Filter periode..."
                           class="w-36 py-1.5 px-3 rounded-xl border border-slate-300 dark:border-zinc-700 bg-slate-50 dark:bg-zinc-900 text-slate-900 dark:text-white text-xs focus:border-unerd-volt" />

                    <select wire:model.live="selectedPeriodId"
                            class="py-1.5 px-3 rounded-xl border border-slate-300 dark:border-zinc-700 bg-slate-50 dark:bg-zinc-900 text-slate-900 dark:text-white text-xs font-bold focus:border-unerd-volt">
                        @foreach ($periods as $prd)
                            <option value="{{ $prd->id }}">
                                {{ $prd->cleanName() }} {{ $prd->is_active ? '(Aktif Sekarang)' : '' }}
                            </option>
                        @endforeach
                    </select>

                    @if (! $allPeriods->contains('is_active', true))
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-mono font-bold bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/30">
                            Tidak Ada Event Aktif
                        </span>
                    @endif
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.event.export-csv', ['period_id' => $selectedPeriodId]) }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-xs">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Export CSV Periode</span>
                </a>

                <a href="{{ route('admin.event.export-users-csv') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white dark:bg-zinc-800 dark:hover:bg-zinc-700 font-bold text-xs uppercase tracking-wider transition shadow-xs">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span>Export Direktori User</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 4 TABS ALUR OPERASIONAL DI LINTASAN GBK -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
        <!-- Tab 1: Menunggu Start di Lokasi (PENDING) -->
        <button type="button" wire:click="setRunnerMode('PENDING')"
                class="p-4 rounded-2xl text-left border transition cursor-pointer {{ $runnerMode === 'PENDING' ? 'bg-amber-500/10 border-amber-500 text-slate-900 dark:text-white shadow-sm' : 'bg-white dark:bg-[#181818] border-slate-200 dark:border-zinc-800 hover:border-amber-400 text-slate-700 dark:text-zinc-300' }}">
            <div class="flex items-center justify-between mb-2">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                <span class="px-2 py-0.5 rounded-full font-mono text-xs font-black {{ $runnerMode === 'PENDING' ? 'bg-amber-500 text-black' : 'bg-amber-500/15 text-amber-700 dark:text-amber-400' }}">
                    {{ $pendingCount }}
                </span>
            </div>
            <div class="text-xs font-black uppercase tracking-wider font-display">1. Menunggu Start</div>
            <div class="text-[11px] text-slate-500 dark:text-zinc-400 mt-0.5">Konfirmasi hadir di lokasi GBK</div>
        </button>

        <!-- Tab 2: Sedang Lari di Lintasan (ACTIVE) -->
        <button type="button" wire:click="setRunnerMode('ACTIVE')"
                class="p-4 rounded-2xl text-left border transition cursor-pointer {{ $runnerMode === 'ACTIVE' ? 'bg-rose-500/10 border-rose-500 text-slate-900 dark:text-white shadow-sm' : 'bg-white dark:bg-[#181818] border-slate-200 dark:border-zinc-800 hover:border-rose-400 text-slate-700 dark:text-zinc-300' }}">
            <div class="flex items-center justify-between mb-2">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-rose-500"></span>
                </span>
                <span class="px-2 py-0.5 rounded-full font-mono text-xs font-black {{ $runnerMode === 'ACTIVE' ? 'bg-rose-600 text-white' : 'bg-rose-500/15 text-rose-600 dark:text-rose-400' }}">
                    {{ $activeCount }}
                </span>
            </div>
            <div class="text-xs font-black uppercase tracking-wider font-display">2. Sedang Lari (Lintasan)</div>
            <div class="text-[11px] text-slate-500 dark:text-zinc-400 mt-0.5">Pelari aktif di lintasan 1 KM</div>
        </button>

        <!-- Tab 3: Sudah Selesai (FINISHED) -->
        <button type="button" wire:click="setRunnerMode('FINISHED')"
                class="p-4 rounded-2xl text-left border transition cursor-pointer {{ $runnerMode === 'FINISHED' ? 'bg-emerald-500/10 border-emerald-500 text-slate-900 dark:text-white shadow-sm' : 'bg-white dark:bg-[#181818] border-slate-200 dark:border-zinc-800 hover:border-emerald-400 text-slate-700 dark:text-zinc-300' }}">
            <div class="flex items-center justify-between mb-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                <span class="px-2 py-0.5 rounded-full font-mono text-xs font-black {{ $runnerMode === 'FINISHED' ? 'bg-emerald-600 text-white' : 'bg-emerald-500/15 text-emerald-600 dark:text-emerald-400' }}">
                    {{ $finishedCount }}
                </span>
            </div>
            <div class="text-xs font-black uppercase tracking-wider font-display">3. Selesai (Finisher)</div>
            <div class="text-[11px] text-slate-500 dark:text-zinc-400 mt-0.5">Waktu  & ranking terverifikasi</div>
        </button>

        <!-- Tab 4: Semua Pelari (ALL) -->
        <button type="button" wire:click="setRunnerMode('ALL')"
                class="p-4 rounded-2xl text-left border transition cursor-pointer {{ $runnerMode === 'ALL' ? 'bg-slate-900 text-white dark:bg-white dark:text-black shadow-sm' : 'bg-white dark:bg-[#181818] border-slate-200 dark:border-zinc-800 hover:border-slate-400 text-slate-700 dark:text-zinc-300' }}">
            <div class="flex items-center justify-between mb-2">
                <span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span>
                <span class="px-2 py-0.5 rounded-full font-mono text-xs font-black {{ $runnerMode === 'ALL' ? 'bg-white/20' : 'bg-slate-100 dark:bg-zinc-800 text-slate-600 dark:text-zinc-400' }}">
                    {{ $totalRegistered }}
                </span>
            </div>
            <div class="text-xs font-black uppercase tracking-wider font-display">4. Semua Pelari</div>
            <div class="text-[11px] text-slate-400 dark:text-zinc-400 mt-0.5">Seluruh database pelari terdaftar</div>
        </button>
    </div>

    <!-- Live Search & Category Filter Toolbar -->
    <div class="bg-white dark:bg-[#181818] p-4 sm:p-5 rounded-2xl border border-slate-200 dark:border-zinc-800 shadow-xs space-y-3">
        <div class="flex flex-col md:flex-row gap-3">
            <!-- Live Search Bar -->
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text"
                       wire:model.live.debounce.250ms="search"
                       placeholder="{{ $runnerMode === 'PENDING' ? 'Cari pelari menunggu start di lokasi (Ketik ID / Nama / No HP)...' : ($runnerMode === 'ACTIVE' ? 'Cari pelari yang sedang aktif lari di lintasan...' : ($runnerMode === 'FINISHED' ? 'Cari pelari yang sudah selesai lari...' : 'Cari ID, nama pelari, email, atau nomor WhatsApp...')) }}"
                       class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-slate-300 dark:border-zinc-700 bg-slate-50 dark:bg-zinc-900 text-slate-900 dark:text-white text-xs sm:text-sm focus:border-unerd-volt focus:ring-1 focus:ring-unerd-volt transition">

                @if ($search !== '')
                    <button wire:click="$set('search', '')" type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-white cursor-pointer font-bold">
                        &times;
                    </button>
                @endif
            </div>

            <!-- Kategori Filter -->
            <div class="w-full md:w-52">
                <select wire:model.live="categoryFilter"
                        class="w-full py-2.5 px-3 rounded-xl border border-slate-300 dark:border-zinc-700 bg-slate-50 dark:bg-zinc-900 text-slate-900 dark:text-white text-xs sm:text-sm focus:border-unerd-volt">
                    <option value="">Semua Kategori</option>
                    <option value="Umum">Pelari Umum</option>
                    <option value="Komunitas">Pelari Komunitas</option>
                    <option value="Profesional">Pelari Profesional</option>
                </select>
            </div>
        </div>

        <div class="flex items-center justify-between text-xs text-slate-500 dark:text-zinc-400 pt-1">
            <div class="flex items-center gap-2">
                <span class="inline-block w-2 h-2 rounded-full {{ $runnerMode === 'PENDING' ? 'bg-amber-500' : ($runnerMode === 'ACTIVE' ? 'bg-rose-500 animate-pulse' : 'bg-emerald-500') }}"></span>
                <span class="font-mono">
                    Mode Tampil: <strong>{{ $runnerMode === 'PENDING' ? 'Pelari Menunggu Start di Lokasi' : ($runnerMode === 'ACTIVE' ? 'Pelari Sedang Lari di Lintasan' : ($runnerMode === 'FINISHED' ? 'Pelari Sudah Selesai (Finisher)' : 'Semua Pelari')) }}</strong>
                </span>
            </div>
            <span class="font-mono font-bold">{{ $participants->total() }} Pelari Ditemukan</span>
        </div>
    </div>

    <!-- Tabel Pelari & Aksi Kru -->
    <div class="bg-white dark:bg-[#181818] rounded-2xl border border-slate-200 dark:border-zinc-800 shadow-xs overflow-hidden">
        <div class="p-4 sm:p-5 border-b border-slate-200 dark:border-zinc-800 flex items-center justify-between">
            <h2 class="text-sm font-black uppercase tracking-wider text-slate-900 dark:text-white">
                {{ $runnerMode === 'PENDING' ? 'Daftar Pelari Menunggu Start (Booth GBK)' : ($runnerMode === 'ACTIVE' ? 'Daftar Pelari Sedang Lari di Lintasan' : ($runnerMode === 'FINISHED' ? 'Daftar Finisher Terverifikasi' : 'Seluruh Data Pelari Terdaftar')) }}
            </h2>
            <div wire:loading class="text-xs text-emerald-600 dark:text-unerd-volt font-mono font-bold animate-pulse">
                Memperbarui data realtime...
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 dark:bg-zinc-900/50 border-b border-slate-200 dark:border-zinc-800 text-slate-500 dark:text-zinc-400 uppercase tracking-wider text-[10px] font-bold">
                        <th class="py-3.5 px-4">ID BIB</th>
                        <th class="py-3.5 px-4">Nama Pelari</th>
                        <th class="py-3.5 px-4 hidden md:table-cell">Kontak</th>
                        <th class="py-3.5 px-4">Kategori & Komunitas</th>
                        <th class="py-3.5 px-4 text-center">Ukuran Sepatu</th>
                        <th class="py-3.5 px-4 text-center">Status Lari</th>
                        <th class="py-3.5 px-4 text-right">Waktu </th>
                        <th class="py-3.5 px-4 text-center">Peringkat & Hadiah</th>
                        <th class="py-3.5 px-4 text-center">Aksi Kru di Lokasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-zinc-800/60">
                    @forelse ($participants as $p)
                        @php
                            $result = $p->results->first();
                            $isPending = $result && $result->isPendingCheckin();
                            $isRunning = $result && $result->isRunning();
                            $isFinished = $result && $result->isFinished();
                            $prize = $result ? $result->getPrize() : null;
                        @endphp
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-zinc-900/40 transition">
                            <!-- BIB ID -->
                            <td class="py-3.5 px-4 font-mono font-black text-slate-900 dark:text-unerd-volt">
                                {{ $p->participant_id }}
                            </td>

                            <!-- Nama -->
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900 dark:text-white">{{ $p->full_name }}</div>
                                <div class="text-[11px] text-slate-400 font-mono">Panggilan: {{ $p->display_name }}</div>
                            </td>

                            <!-- Kontak -->
                            <td class="py-3.5 px-4 hidden md:table-cell font-mono text-slate-600 dark:text-zinc-400">
                                <div>{{ $p->whatsapp }}</div>
                                <div class="text-[10px] text-slate-400">{{ $p->email }}</div>
                            </td>

                            <!-- Kategori -->
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-800 dark:text-zinc-200">{{ $p->participant_category }}</div>
                                <div class="text-[11px] text-slate-500 dark:text-zinc-400">
                                    {{ $p->community ? $p->community->name : 'Mandiri' }}
                                </div>
                            </td>

                            <!-- Ukuran Sepatu -->
                            <td class="py-3.5 px-4 text-center font-bold font-mono text-slate-900 dark:text-white">
                                EU {{ $p->shoe_size }}
                            </td>

                            <!-- Status Lari -->
                            <td class="py-3.5 px-4 text-center">
                                @if ($isRunning)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black bg-rose-500/10 text-rose-500 border border-rose-500/30">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                                        Sedang Lari
                                    </span>
                                @elseif ($isFinished)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">
                                        Selesai Finisher
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-500/20">
                                        Menunggu Start
                                    </span>
                                @endif
                            </td>

                            <!-- Waktu  -->
                            <td class="py-3.5 px-4 text-right font-mono font-bold">
                                @if ($result && $result->verified_time_seconds)
                                    <span class="text-emerald-600 dark:text-unerd-volt text-sm">{{ $result->formattedTime() }}</span>
                                    <span class="block text-[10px] text-slate-400 font-normal">Pace: {{ $result->formattedPace() }}</span>
                                @else
                                    <span class="text-slate-400 font-normal">--:--,--</span>
                                @endif
                            </td>

                            <!-- Peringkat & Hadiah -->
                            <td class="py-3.5 px-4 text-center">
                                @if ($result && $result->rank_in_period)
                                    <div class="font-mono font-black text-xs {{ $result->rank_in_period <= 3 ? 'text-amber-500' : ($result->rank_in_period <= 10 ? 'text-emerald-600 dark:text-unerd-volt' : 'text-slate-400') }}">
                                        #{{ $result->rank_in_period }}
                                    </div>
                                    @if ($prize)
                                        <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[9px] font-bold {{ $result->rank_in_period === 1 ? 'bg-unerd-volt/20 text-slate-900 dark:text-unerd-volt border border-unerd-volt/30' : ($result->rank_in_period <= 3 ? 'bg-emerald-500/20 text-emerald-700 dark:text-emerald-300' : 'bg-indigo-500/20 text-indigo-700 dark:text-indigo-300') }}">
                                            {{ $prize['title'] }}
                                        </span>
                                    @endif
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>

                            <!-- Aksi Kru di Lokasi -->
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    @if ($isRunning)
                                        <!-- Tombol Catat Waktu (Finish) -->
                                        <button wire:click="openTimeModal({{ $p->id }})"
                                                type="button"
                                                class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-[10px] uppercase tracking-wider transition cursor-pointer shadow-xs flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <circle cx="12" cy="12" r="10" stroke-width="2"/>
                                                <polyline points="12 6 12 12 16 14" stroke-width="2"/>
                                            </svg>
                                            <span>Catat Waktu (Finish)</span>
                                        </button>
                                    @elseif ($isFinished)
                                        <!-- Tombol Edit Waktu -->
                                        <button wire:click="openTimeModal({{ $p->id }})"
                                                type="button"
                                                class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-300 font-bold text-[10px] uppercase tracking-wider transition cursor-pointer">
                                            Edit Waktu
                                        </button>
                                    @else
                                        <!-- Tombol Konfirmasi Hadir & Mulai Lari -->
                                        <button wire:click="checkIn({{ $p->id }})"
                                                type="button"
                                                class="px-3 py-1.5 rounded-xl bg-slate-900 hover:bg-black text-white dark:bg-unerd-volt dark:text-black font-black text-[10px] uppercase tracking-wider transition cursor-pointer shadow-xs flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>Mulai Lari (Start)</span>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-10 text-center text-xs text-slate-500 dark:text-zinc-400">
                                @if ($search !== '')
                                    Tidak ada data peserta yang cocok dengan pencarian.
                                @elseif ($runnerMode === 'PENDING')
                                    Tidak ada pelari yang sedang menunggu start. Semua peserta telah start atau belum ada pendaftar baru.
                                @elseif ($runnerMode === 'ACTIVE')
                                    Tidak ada pelari yang sedang aktif di lintasan saat ini.
                                @elseif ($runnerMode === 'FINISHED')
                                    Belum ada pelari yang menyelesaikan lari di periode ini.
                                @else
                                    Belum ada data peserta yang cocok dengan filter.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-200 dark:border-zinc-800">
            {{ $participants->links() }}
        </div>
    </div>

    <!-- MODAL CATAT WAKTU STOPWATCH (Input Full Angka & Format Koma Indonesia) -->
    @if ($showTimeModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs"
             wire:keydown.escape="closeTimeModal">
            <div class="bg-white dark:bg-[#181818] rounded-2xl border border-slate-200 dark:border-zinc-800 p-6 w-full max-w-md text-left shadow-2xl space-y-4">
                <div class="flex items-center justify-between border-b border-slate-200 dark:border-zinc-800 pb-3">
                    <div>
                        <span class="text-[10px] uppercase font-mono font-bold text-slate-500 dark:text-zinc-400">
                            {{ $selectedParticipantCode }} &bull; {{ $currentPeriod?->name }}
                        </span>
                        <h3 class="font-black uppercase tracking-wider text-sm text-slate-900 dark:text-white">
                            Catat Waktu Stopwatch 
                        </h3>
                    </div>
                    <button wire:click="closeTimeModal" type="button" class="text-slate-400 hover:text-slate-600 dark:hover:text-white text-lg font-bold cursor-pointer">
                        &times;
                    </button>
                </div>

                <div class="text-xs text-slate-600 dark:text-zinc-300">
                    Nama Pelari: <strong class="text-slate-900 dark:text-white font-bold">{{ $selectedParticipantName }}</strong>
                </div>

                <!-- Input Instruksi Cepat -->
                <div class="p-3 bg-slate-50 dark:bg-zinc-900 rounded-xl border border-slate-200 dark:border-zinc-800 text-[11px] text-slate-600 dark:text-zinc-400 space-y-1">
                    <p class="font-bold text-slate-900 dark:text-zinc-200">Ketik Angka Saja Tanpa Titik Dua & Koma:</p>
                    <p>&bull; 3 menit 24 detik 50 ms &rarr; ketik <code class="font-mono font-bold text-slate-900 dark:text-white bg-slate-200 dark:bg-zinc-800 px-1 py-0.5 rounded">032450</code></p>
                    <p>&bull; 1 menit 15 detik 00 ms &rarr; ketik <code class="font-mono font-bold text-slate-900 dark:text-white bg-slate-200 dark:bg-zinc-800 px-1 py-0.5 rounded">011500</code></p>
                </div>

                <!-- Input Field -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-zinc-300 mb-1">
                        Input Waktu (Menit, Detik, Milidetik):
                    </label>
                    <input type="text"
                           wire:model.live="timeInput"
                           maxlength="6"
                           placeholder="Contoh: 032450"
                           class="w-full text-center font-mono font-black text-2xl tracking-widest py-3 px-4 rounded-xl border border-slate-300 dark:border-zinc-700 bg-slate-50 dark:bg-zinc-900 text-slate-900 dark:text-white focus:border-unerd-volt focus:ring-1 focus:ring-unerd-volt"
                           autofocus />
                    @error('timeInput')
                        <span class="text-rose-500 text-xs mt-1 block font-bold">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Realtime Preview Format Indonesia mm:ss,ms -->
                <div class="p-4 rounded-xl bg-slate-100 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-center">
                    <span class="text-[10px] uppercase font-mono text-slate-400 font-bold block">Preview Format Indonesia:</span>
                    <span class="text-3xl font-mono font-black text-emerald-600 dark:text-unerd-volt mt-1 block">
                        {{ $timePreview !== '' ? $timePreview : '--:--,--' }}
                    </span>
                    <span class="text-[10px] text-slate-400">Menit : Detik , Milidetik</span>
                </div>

                <div class="pt-3 border-t border-slate-200 dark:border-zinc-800 flex justify-end gap-2">
                    <button wire:click="closeTimeModal" type="button" class="px-4 py-2 rounded-xl border border-slate-200 dark:border-zinc-700 text-xs font-bold text-slate-500 cursor-pointer">
                        Batal
                    </button>
                    <button wire:click="saveTime" type="button" class="px-5 py-2 rounded-xl bg-slate-900 text-white dark:bg-unerd-volt dark:text-black font-black text-xs uppercase tracking-wider transition cursor-pointer">
                        Simpan & Selesaikan Lari &rarr;
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL ATUR HADIAH JUARA 1-10 -->
    @if ($showPrizeModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs"
             wire:keydown.escape="closePrizeModal">
            <div class="bg-white dark:bg-[#181818] rounded-2xl border border-slate-200 dark:border-zinc-800 p-6 w-full max-w-lg text-left shadow-2xl space-y-4">
                <div class="flex items-center justify-between border-b border-slate-200 dark:border-zinc-800 pb-3">
                    <div>
                        <span class="text-[10px] uppercase font-mono font-bold text-amber-500">
                            PENGATURAN HADIAH
                        </span>
                        <h3 class="font-black uppercase tracking-wider text-sm text-slate-900 dark:text-white">
                            Konfigurasi Hadiah Juara (1–10)
                        </h3>
                    </div>
                    <button wire:click="closePrizeModal" type="button" class="text-slate-400 hover:text-slate-600 dark:hover:text-white text-lg font-bold cursor-pointer">
                        &times;
                    </button>
                </div>

                <div class="space-y-3 text-xs">
                    <!-- Status Pendaftaran Toggle -->
                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 flex items-center justify-between">
                        <div>
                            <span class="font-bold text-slate-900 dark:text-white block">Akses Pendaftaran Peserta</span>
                            <span class="text-[11px] text-slate-500 dark:text-zinc-400">Izinkan pelari mendaftar di periode {{ $currentPeriod?->name }}</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="periodIsOpen" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-zinc-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                        </label>
                    </div>

                    <!-- Juara 1 -->
                    <div>
                        <label class="block font-bold text-slate-700 dark:text-zinc-300 mb-1">
                            Hadiah Juara 1 (Sepatu Pilihan + Voucher 10%)
                        </label>
                        <input type="text" wire:model="prize1"
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-zinc-700 bg-slate-50 dark:bg-zinc-900 text-slate-900 dark:text-white font-medium focus:border-unerd-volt">
                    </div>

                    <!-- Juara 2 -->
                    <div>
                        <label class="block font-bold text-slate-700 dark:text-zinc-300 mb-1">
                            Hadiah Juara 2 (Hadiah Uang Tunai + Voucher 10%)
                        </label>
                        <input type="text" wire:model="prize2"
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-zinc-700 bg-slate-50 dark:bg-zinc-900 text-slate-900 dark:text-white font-medium focus:border-unerd-volt">
                    </div>

                    <!-- Juara 3 -->
                    <div>
                        <label class="block font-bold text-slate-700 dark:text-zinc-300 mb-1">
                            Hadiah Juara 3 (Hadiah Uang Tunai + Voucher 10%)
                        </label>
                        <input type="text" wire:model="prize3"
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-zinc-700 bg-slate-50 dark:bg-zinc-900 text-slate-900 dark:text-white font-medium focus:border-unerd-volt">
                    </div>

                    <!-- Peringkat 4-10 -->
                    <div>
                        <label class="block font-bold text-slate-700 dark:text-zinc-300 mb-1">
                            Hadiah Peringkat 4–10 (Voucher Diskon Belanja 10%)
                        </label>
                        <input type="text" wire:model="prizeTop10"
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-zinc-700 bg-slate-50 dark:bg-zinc-900 text-slate-900 dark:text-white font-medium focus:border-unerd-volt">
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-200 dark:border-zinc-800 flex justify-end gap-2">
                    <button wire:click="closePrizeModal" type="button" class="px-4 py-2 rounded-xl border border-slate-200 dark:border-zinc-700 text-xs font-bold text-slate-500 cursor-pointer">
                        Batal
                    </button>
                    <button wire:click="savePrizeSettings" type="button" class="px-5 py-2 rounded-xl bg-slate-900 text-white dark:bg-unerd-volt dark:text-black font-black text-xs uppercase tracking-wider transition cursor-pointer">
                        Simpan Pengaturan Hadiah &rarr;
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL KELOLA PERIODE EVENT (CRUD) -->
    @if ($showManagePeriodModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4 z-50 overflow-y-auto">
            <div class="bg-white dark:bg-[#181818] rounded-2xl max-w-2xl w-full p-6 space-y-5 border border-slate-200 dark:border-zinc-800 shadow-2xl my-8">
                <!-- Modal Header -->
                <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-zinc-800">
                    <div>
                        <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-slate-400">
                            MANAJEMEN EVENT
                        </span>
                        <h3 class="text-lg font-black font-display uppercase tracking-tight text-slate-900 dark:text-white">
                            Kelola Periode Event & Tanggal (CRUD)
                        </h3>
                    </div>
                    <button wire:click="closeManagePeriodModal" type="button" class="text-slate-400 hover:text-slate-600 dark:hover:text-white text-lg font-bold cursor-pointer">
                        &times;
                    </button>
                </div>

                <!-- Form Tambah / Edit Periode -->
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-zinc-900/60 border border-slate-200 dark:border-zinc-800 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-mono font-bold uppercase text-slate-700 dark:text-zinc-300">
                            {{ $editingPeriodId ? 'Edit Data Periode' : 'Tambah Periode Event Baru' }}
                        </span>
                        @if ($editingPeriodId)
                            <button wire:click="resetPeriodForm" type="button" class="text-[11px] font-mono text-rose-500 hover:underline cursor-pointer">
                                Batal Edit / Buat Baru
                            </button>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                        <div>
                            <label class="block font-bold text-slate-700 dark:text-zinc-300 mb-1">
                                Nama Periode
                            </label>
                            <input type="text" wire:model="periodFormName"
                                   placeholder="Contoh: Periode 2 — GBK Night Sprint"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-slate-900 dark:text-white font-medium focus:border-unerd-volt" />
                            @error('periodFormName') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 dark:text-zinc-300 mb-1">
                                Kode Unik Periode
                            </label>
                            <input type="text" wire:model="periodFormCode"
                                   placeholder="Contoh: PERIODE-2026-11-28"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-slate-900 dark:text-white font-medium focus:border-unerd-volt" />
                            @error('periodFormCode') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 dark:text-zinc-300 mb-1">
                                Tanggal Event
                            </label>
                            <input type="date" wire:model="periodFormDate"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-slate-900 dark:text-white font-medium focus:border-unerd-volt" />
                            @error('periodFormDate') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col justify-end space-y-1.5 pt-1">
                            <label class="flex items-center gap-2 cursor-pointer text-xs text-slate-700 dark:text-zinc-300">
                                <input type="checkbox" wire:model="periodFormIsActive" class="rounded border-slate-300 text-slate-900 dark:text-unerd-volt focus:ring-unerd-volt" />
                                <span class="font-bold">Jadikan Periode Aktif Saat Ini</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer text-xs text-slate-700 dark:text-zinc-300">
                                <input type="checkbox" wire:model="periodFormIsOpen" class="rounded border-slate-300 text-slate-900 dark:text-unerd-volt focus:ring-unerd-volt" />
                                <span class="font-bold">Buka Akses Pendaftaran</span>
                            </label>
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button wire:click="savePeriod" type="button"
                                class="px-4 py-2 rounded-xl bg-slate-900 text-white dark:bg-unerd-volt dark:text-black font-bold text-xs uppercase tracking-wider hover:opacity-90 transition cursor-pointer">
                            {{ $editingPeriodId ? 'Simpan Perubahan Periode' : 'Tambah Periode Baru' }} &rarr;
                        </button>
                    </div>
                </div>

                <!-- Daftar Semua Periode (Tabel CRUD) -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-mono font-bold uppercase text-slate-700 dark:text-zinc-300 block">
                            Daftar Periode Tersedia
                        </span>
                        @if ($allPeriods->contains('is_active', true))
                            <button wire:click="deactivateAllPeriods" type="button" class="px-2.5 py-1 rounded-lg bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/40 dark:hover:bg-rose-900/60 text-rose-600 dark:text-rose-300 text-[10px] font-bold uppercase tracking-wider transition cursor-pointer border border-rose-200 dark:border-rose-800/60">
                                Nonaktifkan Semua Event
                            </button>
                        @endif
                    </div>
                    <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-zinc-800">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-100 dark:bg-zinc-900 font-mono uppercase text-slate-500 dark:text-zinc-400 text-[10px]">
                                <tr>
                                    <th class="p-2.5">Periode</th>
                                    <th class="p-2.5">Tanggal</th>
                                    <th class="p-2.5 text-center">Status Aktif</th>
                                    <th class="p-2.5 text-center">Pendaftaran</th>
                                    <th class="p-2.5 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-zinc-800/60">
                                @foreach ($allPeriods as $item)
                                    <tr class="hover:bg-slate-50/50 dark:hover:bg-zinc-900/40">
                                        <td class="p-2.5 font-bold text-slate-900 dark:text-white">
                                            {{ $item->name }}
                                            <div class="text-[10px] text-slate-400 font-mono">{{ $item->period_code }}</div>
                                        </td>
                                        <td class="p-2.5 font-mono text-slate-600 dark:text-zinc-400">
                                            {{ $item->event_date?->format('d M Y') ?? '-' }}
                                        </td>
                                        <td class="p-2.5 text-center">
                                            @if ($item->is_active)
                                                <div class="inline-flex items-center gap-1.5 justify-center">
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-500/10 text-emerald-600 dark:text-unerd-volt border border-emerald-500/30">
                                                        Aktif
                                                    </span>
                                                    <button wire:click="togglePeriodActive({{ $item->id }})" type="button" class="text-[10px] text-rose-500 hover:text-rose-700 underline cursor-pointer" title="Nonaktifkan periode ini">
                                                        Nonaktifkan
                                                    </button>
                                                </div>
                                            @else
                                                <button wire:click="setActivePeriod({{ $item->id }})" type="button" class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 hover:bg-slate-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-300 transition cursor-pointer">
                                                    Set Aktif
                                                </button>
                                            @endif
                                        </td>
                                        <td class="p-2.5 text-center">
                                            @if ($item->is_open_for_registration)
                                                <span class="text-emerald-600 dark:text-emerald-400 font-bold">Buka</span>
                                            @else
                                                <span class="text-rose-500 font-bold">Tutup</span>
                                            @endif
                                        </td>
                                        <td class="p-2.5 text-right space-x-1">
                                            <button wire:click="editPeriod({{ $item->id }})" type="button" class="px-2 py-1 rounded bg-slate-100 dark:bg-zinc-800 text-slate-700 dark:text-zinc-200 text-[10px] font-bold cursor-pointer">
                                                Edit
                                            </button>
                                            <button wire:click="deletePeriod({{ $item->id }})"
                                                    wire:confirm="Yakin ingin menghapus periode ini?"
                                                    type="button"
                                                    class="px-2 py-1 rounded bg-rose-50 dark:bg-rose-950/20 text-rose-600 text-[10px] font-bold cursor-pointer">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-200 dark:border-zinc-800 flex justify-end">
                    <button wire:click="closeManagePeriodModal" type="button" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-zinc-800 text-slate-700 dark:text-zinc-300 font-bold text-xs cursor-pointer">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
