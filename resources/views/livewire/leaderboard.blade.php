<div wire:poll.4s class="space-y-6">
    <!-- Filter Controls Card: Searchable Period, Category Dropdown, & Live Search -->
    <div class="bg-white dark:bg-[#181818] p-4 sm:p-5 rounded-2xl border border-slate-200 dark:border-zinc-800 shadow-xs">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <!-- 1. Searchable Period Dropdown (Mirip Komunitas Search) -->
            <div wire:key="period-searchable-select"
                 x-data="{
                    open: false,
                    search: '',
                    selectedId: @js($selectedPeriodId),
                    selectedName: @js($currentPeriod ? $currentPeriod->name : ''),
                    selectedIsActive: @js((bool) ($currentPeriod?->is_active)),
                    periods: @js($periodsList),

                    get filtered() {
                        if (!this.search.trim()) return this.periods;
                        const q = this.search.toLowerCase().trim();
                        return this.periods.filter(p =>
                            (p.name && p.name.toLowerCase().includes(q)) ||
                            (p.clean_name && p.clean_name.toLowerCase().includes(q)) ||
                            (p.code && p.code.toLowerCase().includes(q)) ||
                            (p.date && p.date.toLowerCase().includes(q))
                        );
                    },

                    openDropdown() {
                        this.open = true;
                        this.$nextTick(() => {
                            this.$refs.periodSearchInput?.focus();
                        });
                    },

                    select(prd) {
                        this.selectedId = prd.id;
                        this.selectedName = prd.name;
                        this.selectedIsActive = Boolean(prd.is_active);
                        this.open = false;
                        this.search = '';
                        $wire.selectPeriod(prd.id);
                    }
                 }"
                 x-init="
                    $watch('$wire.selectedPeriodId', val => {
                        if (!val) return;
                        selectedId = val;
                        const p = periods.find(x => x.id == val);
                        if (p) {
                            selectedName = p.name;
                            selectedIsActive = Boolean(p.is_active);
                        }
                    });
                 "
                 @click.outside="open = false"
                 class="relative space-y-1.5 text-left">
                <label class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-700 dark:text-zinc-300">
                    Periode Event
                </label>

                <div class="relative">
                    <!-- Selected Card Display (when not open) -->
                    <template x-if="selectedId && !open">
                        <div @click="openDropdown()"
                             class="flex items-center justify-between p-2.5 rounded-xl border border-unerd-volt/40 bg-unerd-volt/5 dark:bg-unerd-volt/10 transition cursor-pointer hover:border-unerd-volt">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="w-7 h-7 rounded-lg bg-unerd-volt text-unerd-ink font-bold flex items-center justify-center shrink-0 text-xs">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </span>
                                <div class="truncate">
                                    <div class="flex items-center gap-1.5 truncate">
                                        <span class="text-xs font-bold text-slate-900 dark:text-white truncate" x-text="selectedName"></span>
                                        <template x-if="selectedIsActive">
                                            <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-emerald-500/10 text-emerald-600 dark:text-unerd-volt border border-emerald-500/20 shrink-0">
                                                Aktif
                                            </span>
                                        </template>
                                    </div>
                                    <span class="block text-[10px] text-slate-500 dark:text-zinc-400">Periode Event Terpilih</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5 shrink-0 ml-2">
                                <button type="button"
                                        @click.stop="openDropdown()"
                                        class="px-2.5 py-1 text-[11px] font-bold rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-200 transition cursor-pointer">
                                    Ganti
                                </button>
                            </div>
                        </div>
                    </template>

                    <!-- Search Input (when open or nothing selected) -->
                    <template x-if="!selectedId || open">
                        <div class="relative">
                            <input type="text"
                                   x-ref="periodSearchInput"
                                   x-model="search"
                                   @focus="open = true"
                                   @keydown.escape="open = false"
                                   placeholder="Cari nama periode event..."
                                   class="block w-full rounded-xl border border-slate-300 dark:border-zinc-700 bg-white dark:bg-[#121212] text-slate-900 dark:text-white px-3.5 py-2.5 pl-9 text-xs sm:text-sm focus:border-unerd-volt focus:ring-1 focus:ring-unerd-volt transition">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <template x-if="search">
                                <button type="button" @click="search = ''" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-zinc-200 cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </template>
                        </div>
                    </template>
                </div>

                <!-- Dropdown Options List -->
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute z-50 left-0 right-0 mt-1 max-h-60 overflow-y-auto rounded-xl border border-slate-200 dark:border-zinc-700 bg-white dark:bg-[#181818] shadow-2xl p-1.5 text-xs space-y-1">
                    
                    <template x-for="prd in filtered" :key="prd.id">
                        <button type="button"
                                @click="select(prd)"
                                class="w-full text-left p-2.5 rounded-lg hover:bg-slate-100 dark:hover:bg-zinc-800 flex items-center justify-between group transition cursor-pointer">
                            <div>
                                <span class="font-bold text-slate-900 dark:text-white block group-hover:text-unerd-volt-dark dark:group-hover:text-unerd-volt" x-text="prd.name"></span>
                                <span class="text-[10px] text-slate-400 dark:text-zinc-500" x-text="prd.date || prd.code"></span>
                            </div>
                            <div class="flex items-center gap-1.5 shrink-0">
                                <template x-if="prd.is_active">
                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-emerald-500/10 text-emerald-600 dark:text-unerd-volt border border-emerald-500/20">
                                        Aktif
                                    </span>
                                </template>
                                <template x-if="selectedId == prd.id">
                                    <span class="text-emerald-500 dark:text-unerd-volt font-bold text-xs">&#10003;</span>
                                </template>
                            </div>
                        </button>
                    </template>

                    <template x-if="filtered.length === 0">
                        <div class="p-3 text-center text-slate-400 dark:text-zinc-500 text-xs">
                            Tidak ada periode event yang cocok dengan pencarian.
                        </div>
                    </template>
                </div>
            </div>

            <!-- 2. Kategori Klasemen Dropdown -->
            <div>
                <label class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-700 dark:text-zinc-300 mb-1.5">
                    Kategori Klasemen
                </label>
                <select wire:model.live="activeRoleTab"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-zinc-700 bg-white dark:bg-[#121212] text-slate-900 dark:text-white text-xs sm:text-sm font-bold focus:border-unerd-volt focus:ring-1 focus:ring-unerd-volt transition">
                    <option value="Women">Pelari Women ({{ $countWomen }})</option>
                    <option value="Umum">Pelari Umum ({{ $countUmum }})</option>
                    <option value="Komunitas">Pelari Komunitas (Community) ({{ $countKomunitas }})</option>
                    <option value="Profesional">Pelari Profesional (Pro) ({{ $countProfesional }})</option>
                    <option value="CommunityAvg">Klasemen Komunitas (Top 3 Avg)</option>
                </select>
            </div>

            <!-- 3. Cari Pelari / ID  -->
            <div>
                <label class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-700 dark:text-zinc-300 mb-1.5">
                    Cari Pelari / ID 
                </label>
                <div class="relative">
                    <input type="text"
                           wire:model.live.debounce.250ms="search"
                           placeholder="Cari nama pelari atau ID  (UMS-xxxx)..."
                           class="block w-full pl-9 pr-8 py-2.5 rounded-xl border border-slate-300 dark:border-zinc-700 bg-white dark:bg-[#121212] text-slate-900 dark:text-white text-xs sm:text-sm focus:border-unerd-volt focus:ring-1 focus:ring-unerd-volt transition">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    @if (! empty($search))
                        <button type="button" wire:click="$set('search', '')" class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-white">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Category Tabs (Women, Umum, Community, Pro, Komunitas Avg) -->
    <!-- <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
        <button type="button" wire:click="setRoleTab('Women')"
                class="px-3.5 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap cursor-pointer flex items-center gap-1.5 {{ $activeRoleTab === 'Women' ? 'bg-slate-900 text-white dark:bg-unerd-volt dark:text-black shadow-xs' : 'bg-white dark:bg-[#181818] border border-slate-200 dark:border-zinc-800 text-slate-700 dark:text-zinc-300 hover:border-slate-400' }}">
            <span>Women</span>
            <span class="px-1.5 py-0.2 rounded font-mono text-[10px] {{ $activeRoleTab === 'Women' ? 'bg-white/20 dark:bg-black/20 text-white dark:text-black' : 'bg-slate-100 dark:bg-zinc-800 text-slate-500 dark:text-zinc-400' }}">{{ $countWomen }}</span>
        </button>
        <button type="button" wire:click="setRoleTab('Umum')"
                class="px-3.5 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap cursor-pointer flex items-center gap-1.5 {{ $activeRoleTab === 'Umum' ? 'bg-slate-900 text-white dark:bg-unerd-volt dark:text-black shadow-xs' : 'bg-white dark:bg-[#181818] border border-slate-200 dark:border-zinc-800 text-slate-700 dark:text-zinc-300 hover:border-slate-400' }}">
            <span>Umum</span>
            <span class="px-1.5 py-0.2 rounded font-mono text-[10px] {{ $activeRoleTab === 'Umum' ? 'bg-white/20 dark:bg-black/20 text-white dark:text-black' : 'bg-slate-100 dark:bg-zinc-800 text-slate-500 dark:text-zinc-400' }}">{{ $countUmum }}</span>
        </button>
        <button type="button" wire:click="setRoleTab('Komunitas')"
                class="px-3.5 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap cursor-pointer flex items-center gap-1.5 {{ $activeRoleTab === 'Komunitas' ? 'bg-slate-900 text-white dark:bg-unerd-volt dark:text-black shadow-xs' : 'bg-white dark:bg-[#181818] border border-slate-200 dark:border-zinc-800 text-slate-700 dark:text-zinc-300 hover:border-slate-400' }}">
            <span>Community</span>
            <span class="px-1.5 py-0.2 rounded font-mono text-[10px] {{ $activeRoleTab === 'Komunitas' ? 'bg-white/20 dark:bg-black/20 text-white dark:text-black' : 'bg-slate-100 dark:bg-zinc-800 text-slate-500 dark:text-zinc-400' }}">{{ $countKomunitas }}</span>
        </button>
        <button type="button" wire:click="setRoleTab('Profesional')"
                class="px-3.5 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap cursor-pointer flex items-center gap-1.5 {{ $activeRoleTab === 'Profesional' ? 'bg-slate-900 text-white dark:bg-unerd-volt dark:text-black shadow-xs' : 'bg-white dark:bg-[#181818] border border-slate-200 dark:border-zinc-800 text-slate-700 dark:text-zinc-300 hover:border-slate-400' }}">
            <span>Pro</span>
            <span class="px-1.5 py-0.2 rounded font-mono text-[10px] {{ $activeRoleTab === 'Profesional' ? 'bg-white/20 dark:bg-black/20 text-white dark:text-black' : 'bg-slate-100 dark:bg-zinc-800 text-slate-500 dark:text-zinc-400' }}">{{ $countProfesional }}</span>
        </button>
        <button type="button" wire:click="setRoleTab('CommunityAvg')"
                class="px-3.5 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap cursor-pointer flex items-center gap-1.5 {{ $activeRoleTab === 'CommunityAvg' ? 'bg-slate-900 text-white dark:bg-unerd-volt dark:text-black shadow-xs' : 'bg-white dark:bg-[#181818] border border-slate-200 dark:border-zinc-800 text-slate-700 dark:text-zinc-300 hover:border-slate-400' }}">
            <span>Klasemen Komunitas (Avg)</span>
        </button>
    </div> -->

    <!-- MAIN LEADERBOARD DISPLAY -->
    @if ($activeRoleTab === 'CommunityAvg')
        <!-- KLASEMEN KOMUNITAS (TOP 3 AVG) -->
        <div class="bg-white dark:bg-[#1a1a1a] rounded-2xl border border-slate-200 dark:border-white/10 overflow-hidden shadow-sm">
            <div class="p-4 sm:p-5 border-b border-slate-200 dark:border-white/10 flex items-center justify-between bg-slate-50/50 dark:bg-white/[0.01]">
                <div>
                    <h2 class="text-sm font-black uppercase tracking-tight text-slate-900 dark:text-white font-display">
                        Klasemen Rata-Rata Komunitas ({{ $currentPeriod ? $currentPeriod->formattedDistance() : '3 KM' }})
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
                                <th class="py-3 px-4 text-right">Rata-Rata Waktu ({{ $currentPeriod ? $currentPeriod->formattedDistance() : '3 KM' }})</th>
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

            @if ($results->isEmpty())
                <div class="p-8 text-center text-xs text-slate-500 dark:text-slate-400">
                    @if (! empty($search))
                        Tidak ada pelari yang cocok dengan pencarian "<strong class="text-slate-900 dark:text-white">{{ $search }}</strong>" pada kategori {{ $activeRoleTab }}.
                    @else
                        Belum ada pelari dengan catatan waktu  untuk kategori {{ $activeRoleTab }}.
                    @endif
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
                                <th class="py-3 px-4 text-right">Waktu ({{ $currentPeriod ? $currentPeriod->formattedDistance() : '3 KM' }})</th>
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
