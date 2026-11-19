<div wire:poll.4s class="space-y-6">
    <!-- Period Selector Dropdown (Leaderboard per Periode) -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white dark:bg-[#1a1a1a] p-4 rounded-2xl border border-slate-200 dark:border-white/10 shadow-xs">
        <div class="flex items-center gap-2">
            <span class="text-xs uppercase font-mono font-bold text-slate-500 dark:text-slate-400">PILIH PERIODE EVENT:</span>
            <span class="text-xs font-bold text-slate-900 dark:text-white">{{ $currentPeriod?->cleanName() }}</span>
        </div>
        <div class="w-full sm:w-auto flex items-center gap-2">
            <input type="text"
                   wire:model.live.debounce.250ms="periodSearch"
                   placeholder="Cari periode..."
                   class="w-32 py-2 px-2.5 rounded-xl border border-slate-300 dark:border-white/10 bg-slate-50 dark:bg-[#121212] text-slate-900 dark:text-white text-xs focus:border-unerd-volt" />
            <select wire:model.live="selectedPeriodId"
                    class="w-full sm:w-72 py-2 px-3 rounded-xl border border-slate-300 dark:border-white/10 bg-slate-50 dark:bg-[#121212] text-slate-900 dark:text-white text-xs font-bold focus:border-unerd-volt focus:ring-1 focus:ring-unerd-volt">
                @foreach ($periods as $prd)
                    <option value="{{ $prd->id }}">
                        {{ $prd->cleanName() }} {{ $prd->is_active ? '(Aktif)' : '' }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Category Tabs Navigation (Umum, Komunitas, Profesional, Akumulasi Komunitas) -->
    <div class="flex flex-wrap items-center justify-center gap-2">
        <!-- Tab Pelari Umum -->
        <button type="button" wire:click="setRoleTab('Umum')"
                class="px-4 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider transition flex items-center gap-2 {{ $activeRoleTab === 'Umum' ? 'bg-slate-900 text-white dark:bg-unerd-volt dark:text-black shadow-md' : 'bg-white dark:bg-[#1a1a1a] text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 hover:border-unerd-volt' }}">
            <span>Pelari Umum</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] font-mono {{ $activeRoleTab === 'Umum' ? 'bg-white/20 dark:bg-black/20' : 'bg-slate-100 dark:bg-white/10' }}">
                {{ $countUmum }}
            </span>
        </button>

        <!-- Tab Pelari Komunitas -->
        <button type="button" wire:click="setRoleTab('Komunitas')"
                class="px-4 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider transition flex items-center gap-2 {{ $activeRoleTab === 'Komunitas' ? 'bg-slate-900 text-white dark:bg-unerd-volt dark:text-black shadow-md' : 'bg-white dark:bg-[#1a1a1a] text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 hover:border-unerd-volt' }}">
            <span>Pelari Komunitas</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] font-mono {{ $activeRoleTab === 'Komunitas' ? 'bg-white/20 dark:bg-black/20' : 'bg-slate-100 dark:bg-white/10' }}">
                {{ $countKomunitas }}
            </span>
        </button>

        <!-- Tab Pelari Profesional -->
        <button type="button" wire:click="setRoleTab('Profesional')"
                class="px-4 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider transition flex items-center gap-2 {{ $activeRoleTab === 'Profesional' ? 'bg-slate-900 text-white dark:bg-unerd-volt dark:text-black shadow-md' : 'bg-white dark:bg-[#1a1a1a] text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 hover:border-unerd-volt' }}">
            <span>Pelari Profesional</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] font-mono {{ $activeRoleTab === 'Profesional' ? 'bg-white/20 dark:bg-black/20' : 'bg-slate-100 dark:bg-white/10' }}">
                {{ $countProfesional }}
            </span>
        </button>

        <!-- Tab Akumulasi Komunitas -->
        <button type="button" wire:click="setRoleTab('CommunityAvg')"
                class="px-4 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider transition flex items-center gap-2 {{ $activeRoleTab === 'CommunityAvg' ? 'bg-slate-900 text-white dark:bg-unerd-volt dark:text-black shadow-md' : 'bg-white dark:bg-[#1a1a1a] text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 hover:border-unerd-volt' }}">
            <span>Klasemen Komunitas (Top 3 Avg)</span>
        </button>
    </div>

    <!-- Search Personal Record -->
    <div class="bg-white dark:bg-[#1a1a1a] p-4 sm:p-5 rounded-2xl border border-slate-200 dark:border-white/10 shadow-xs">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="text"
                   wire:model.live.debounce.300ms="search"
                   placeholder="Cari catatan personal: ketik ID Peserta (UMS-xxxx) atau nama pelari..."
                   class="block w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 dark:border-white/10 bg-slate-50 dark:bg-[#121212] text-slate-900 dark:text-white text-xs sm:text-sm focus:border-unerd-volt focus:ring-1 focus:ring-unerd-volt transition">
        </div>

        <!-- Personal Search Result Popup Card -->
        @if ($personalResult)
            <div class="mt-4 p-4 rounded-xl bg-slate-50 dark:bg-white/[0.03] border border-slate-200 dark:border-white/10 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="font-mono text-xs font-black text-unerd-volt-dark dark:text-unerd-volt">
                            {{ $personalResult->participant_id }}
                        </span>
                        <span class="text-xs text-slate-400">&bull;</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-slate-200 dark:bg-white/10 text-slate-700 dark:text-slate-300">
                            {{ $personalResult->participant_category }}
                        </span>
                    </div>
                    <div class="text-sm font-bold text-slate-900 dark:text-white mt-1">
                        {{ $personalResult->full_name }} ({{ $personalResult->display_name }})
                    </div>
                    <div class="text-xs text-slate-500 dark:text-slate-400">
                        {{ $personalResult->community ? $personalResult->community->name : 'Mandiri' }} &bull; Ukuran: EU {{ $personalResult->shoe_size }}
                    </div>
                </div>

                <div class="text-right flex sm:flex-col items-center sm:items-end justify-between gap-2">
                    @if ($personalResult->latestResult && $personalResult->latestResult->is_verified)
                        <div>
                            <span class="block text-[10px] uppercase font-bold text-slate-400">Waktu Resmi 1 KM</span>
                            <span class="text-lg font-black font-mono text-emerald-600 dark:text-unerd-volt">
                                {{ $personalResult->latestResult->formatted_time }}
                            </span>
                        </div>
                        <a href="{{ route('everyday-league.result', $personalResult->participant_id) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-black uppercase tracking-wider bg-slate-900 text-white dark:bg-white dark:text-black hover:opacity-90 transition shadow-xs">
                            <span>Detail & Share</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    @else
                        <span class="text-xs font-semibold text-amber-500">Menunggu waktu dicatat kru GBK</span>
                    @endif
                </div>
            </div>
        @elseif (! empty(trim($search)))
            <div class="mt-4 p-4 text-center text-xs text-slate-500 dark:text-slate-400">
                Tidak ditemukan data pelari untuk "<span class="font-bold text-slate-900 dark:text-white">{{ $search }}</span>".
            </div>
        @endif
    </div>

    <!-- MAIN LEADERBOARD DISPLAY -->
    @if ($activeRoleTab === 'CommunityAvg')
        <!-- KLASEMEN KOMUNITAS (TOP 3 AVG) -->
        <div class="bg-white dark:bg-[#1a1a1a] rounded-2xl border border-slate-200 dark:border-white/10 overflow-hidden shadow-sm">
            <div class="p-4 sm:p-5 border-b border-slate-200 dark:border-white/10 flex items-center justify-between bg-slate-50/50 dark:bg-white/[0.01]">
                <div>
                    <h2 class="text-sm font-black uppercase tracking-tight text-slate-900 dark:text-white font-display">
                        Klasemen Rata-Rata Komunitas (1 KM)
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Dihitung dari rata-rata waktu 3 pelari tercepat per komunitas (min. 3 finisher).
                    </p>
                </div>
            </div>

            @if (empty($communityRankings))
                <div class="p-8 text-center text-xs text-slate-500 dark:text-slate-400">
                    Belum ada komunitas yang memenuhi kuota minimal 3 pelari terverifikasi.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs sm:text-sm">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-white/[0.02] border-b border-slate-200 dark:border-white/10 text-slate-500 dark:text-slate-400 uppercase tracking-wider text-[10px] sm:text-xs font-bold">
                                <th class="py-3 px-4 text-center w-16">Peringkat</th>
                                <th class="py-3 px-4">Nama Komunitas</th>
                                <th class="py-3 px-4 hidden sm:table-cell">Kota Basis</th>
                                <th class="py-3 px-4 text-center">Finisher</th>
                                <th class="py-3 px-4 text-right">Rata-Rata Waktu (1 KM)</th>
                                <th class="py-3 px-4 text-right hidden sm:table-cell">Pace Rata-Rata</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                            @foreach ($communityRankings as $comm)
                                <tr class="hover:bg-slate-50/70 dark:hover:bg-white/[0.02] transition">
                                    <td class="py-3 px-4 text-center">
                                        @if ($comm['rank'] === 1)
                                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-unerd-volt text-slate-950 font-black text-xs shadow-sm">1</span>
                                        @elseif ($comm['rank'] === 2)
                                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-300 text-slate-950 font-black text-xs">2</span>
                                        @elseif ($comm['rank'] === 3)
                                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-amber-700 text-white font-black text-xs">3</span>
                                        @else
                                            <span class="font-bold text-slate-500 dark:text-slate-400">#{{ $comm['rank'] }}</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="font-bold text-slate-900 dark:text-white">{{ $comm['community']->name }}</div>
                                    </td>
                                    <td class="py-3 px-4 hidden sm:table-cell text-slate-500 dark:text-slate-400">
                                        {{ $comm['community']->city }}
                                    </td>
                                    <td class="py-3 px-4 text-center font-bold text-slate-700 dark:text-slate-300">
                                        {{ $comm['finishers_count'] }} Pelari
                                    </td>
                                    <td class="py-3 px-4 text-right font-mono font-black text-slate-900 dark:text-unerd-volt">
                                        {{ $comm['formatted_avg_time'] }}
                                    </td>
                                    <td class="py-3 px-4 text-right font-mono text-slate-500 dark:text-slate-400 hidden sm:table-cell">
                                        {{ $comm['formatted_avg_pace'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @else
        <!-- LEADERBOARD INDIVIDU SPESIFIK ROLE (Umum, Komunitas, atau Profesional) -->
        <div class="bg-white dark:bg-[#1a1a1a] rounded-2xl border border-slate-200 dark:border-white/10 overflow-hidden shadow-sm">
            <div class="p-4 sm:p-5 border-b border-slate-200 dark:border-white/10 flex items-center justify-between bg-slate-50/50 dark:bg-white/[0.01]">
                <div>
                    <h2 class="text-sm font-black uppercase tracking-tight text-slate-900 dark:text-white font-display">
                        Leaderboard Resmi &bull; Kategori {{ $activeRoleTab }} (1 KM)
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Peringkat berdasarkan catatan waktu lari 1.000 meter terverifikasi tercepat.
                    </p>
                </div>
                <span class="text-xs font-mono font-bold text-unerd-volt-dark dark:text-unerd-volt">
                    Live Rank
                </span>
            </div>

            @if ($results->isEmpty())
                <div class="p-8 text-center text-xs text-slate-500 dark:text-slate-400">
                    Belum ada pelari dengan catatan waktu resmi untuk kategori {{ $activeRoleTab }}.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs sm:text-sm">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-white/[0.02] border-b border-slate-200 dark:border-white/10 text-slate-500 dark:text-slate-400 uppercase tracking-wider text-[10px] sm:text-xs font-bold">
                                <th class="py-3 px-4 text-center w-16">Rank</th>
                                <th class="py-3 px-4">Nama Pelari</th>
                                <th class="py-3 px-4 hidden sm:table-cell">Kategori</th>
                                <th class="py-3 px-4 hidden md:table-cell">Komunitas</th>
                                <th class="py-3 px-4 text-right">Waktu 1 KM</th>
                                <th class="py-3 px-4 text-right hidden sm:table-cell">Pace</th>
                                <th class="py-3 px-4 text-center w-28">Detail & Share</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                            @foreach ($results as $index => $res)
                                @php
                                    $rankNum = $results->firstItem() + $index;
                                @endphp
                                <tr class="hover:bg-slate-50/70 dark:hover:bg-white/[0.02] transition">
                                    <td class="py-3.5 px-4 text-center">
                                        @if ($rankNum === 1)
                                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-unerd-volt text-slate-950 font-black text-xs shadow-sm">1</span>
                                        @elseif ($rankNum === 2)
                                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-300 text-slate-950 font-black text-xs">2</span>
                                        @elseif ($rankNum === 3)
                                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-amber-700 text-white font-black text-xs">3</span>
                                        @else
                                            <span class="font-bold text-slate-500 dark:text-slate-400 font-mono">#{{ $rankNum }}</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <div class="font-bold text-slate-900 dark:text-white">
                                            {{ $res->participant?->display_name }}
                                        </div>
                                        <div class="text-[11px] font-mono text-slate-400">
                                            {{ $res->participant?->participant_id }}
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 hidden sm:table-cell">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-slate-100 dark:bg-white/5 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10">
                                            {{ $res->participant?->participant_category }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 hidden md:table-cell text-slate-600 dark:text-slate-400">
                                        {{ $res->participant?->community ? $res->participant->community->name : '-' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-right font-mono font-black text-slate-900 dark:text-unerd-volt">
                                        {{ $res->formatted_time }}
                                    </td>
                                    <td class="py-3.5 px-4 text-right font-mono text-slate-500 dark:text-slate-400 hidden sm:table-cell">
                                        {{ $res->formatted_pace }}
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        @if ($res->participant)
                                            <a href="{{ route('everyday-league.result', $res->participant->participant_id) }}"
                                               class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-slate-100 hover:bg-slate-200 dark:bg-white/5 dark:hover:bg-white/10 text-slate-800 dark:text-zinc-200 transition"
                                               title="Buka Detail & Share">
                                                <span>Detail & Share</span>
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                </svg>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-slate-200 dark:border-white/10">
                    {{ $results->links() }}
                </div>
            @endif
        </div>
    @endif
</div>
