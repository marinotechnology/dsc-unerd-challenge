<x-app-layout>
    <x-slot name="header">
        @include('customer.partials.profile-header', ['user' => $user, 'participant' => $participant])
    </x-slot>

    <!-- Sesi Live & Status Tantangan Lari (Realtime Livewire Sync) -->
    <div class="mb-6">
        <livewire:runner-live-status :show-history="false" />
    </div>

    <!-- Quick Navigation Cards to Other Sections (Clean & Mobile-Friendly) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        <!-- Riwayat Balapan Card -->
        <a href="{{ route('customer.history') }}"
           class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-[#181818] border border-slate-200 dark:border-zinc-800 hover:border-unerd-volt dark:hover:border-unerd-volt transition shadow-xs group flex items-center justify-between gap-3">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-zinc-800 text-slate-900 dark:text-unerd-volt flex items-center justify-center shrink-0 border border-slate-200 dark:border-zinc-700">
                    <svg class="w-5 h-5 text-slate-700 dark:text-unerd-volt" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="truncate">
                    <h3 class="font-display text-sm font-bold text-slate-900 dark:text-white uppercase tracking-tight truncate group-hover:text-unerd-volt-dark dark:group-hover:text-unerd-volt">
                        Riwayat Lari & Rekor
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-zinc-400 truncate mt-0.5">
                        {{ $historyCount > 0 ? "Kamu memiliki {$historyCount} catatan rekor lari." : 'Belum ada rekor lari tercatat.' }}
                    </p>
                </div>
            </div>
            <span class="text-slate-400 group-hover:text-slate-900 dark:group-hover:text-white shrink-0 text-sm font-bold">
                &rarr;
            </span>
        </a>

        <!-- Voucher & Katalog Sepatu Card -->
        <a href="{{ route('customer.rewards') }}"
           class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-[#181818] border border-slate-200 dark:border-zinc-800 hover:border-unerd-volt dark:hover:border-unerd-volt transition shadow-xs group flex items-center justify-between gap-3">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-zinc-800 text-slate-900 dark:text-unerd-volt flex items-center justify-center shrink-0 border border-slate-200 dark:border-zinc-700">
                    <svg class="w-5 h-5 text-slate-700 dark:text-unerd-volt" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <div class="truncate">
                    <div class="flex items-center gap-1.5">
                        <h3 class="font-display text-sm font-bold text-slate-900 dark:text-white uppercase tracking-tight truncate group-hover:text-unerd-volt-dark dark:group-hover:text-unerd-volt">
                            Voucher & Katalog Sepatu
                        </h3>
                        <span class="text-[9px] font-mono text-emerald-600 dark:text-unerd-volt font-bold bg-emerald-50 dark:bg-emerald-950/60 px-1.5 py-0.2 rounded border border-emerald-500/20 shrink-0">10% OFF</span>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-zinc-400 truncate mt-0.5">
                        Koleksi sepatu UNERD ukuran EU {{ $user->shoe_size ?? 42 }}.
                    </p>
                </div>
            </div>
            <span class="text-slate-400 group-hover:text-slate-900 dark:group-hover:text-white shrink-0 text-sm font-bold">
                &rarr;
            </span>
        </a>
    </div>

    <!-- Runner Preferences: Shoe Size & Community Affiliation (Clean & Compact) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Shoe Size Card -->
        <div class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-[#181818] border border-slate-200 dark:border-zinc-800 shadow-xs flex items-center justify-between gap-3">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-zinc-800 text-slate-900 dark:text-unerd-volt flex items-center justify-center font-mono font-black text-xs shrink-0 border border-slate-200 dark:border-zinc-700">
                    EU {{ $user->shoe_size ?? 42 }}
                </div>
                <div class="truncate">
                    <div class="flex items-center gap-1.5">
                        <h3 class="font-display text-xs sm:text-sm font-bold text-slate-900 dark:text-white uppercase tracking-tight truncate">Ukuran Sepatu</h3>
                        <span class="text-[9px] font-mono text-emerald-600 dark:text-unerd-volt font-bold bg-emerald-50 dark:bg-emerald-950/60 px-1.5 py-0.2 rounded border border-emerald-500/20 shrink-0">True size</span>
                    </div>
                    <p class="text-[11px] text-slate-500 dark:text-zinc-400 truncate mt-0.5">Rekomendasi disesuaikan dengan EU {{ $user->shoe_size ?? 42 }}</p>
                </div>
            </div>
            <a href="{{ route('profile.edit') }}" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-200 text-[11px] font-bold uppercase tracking-wider transition shrink-0">
                Ubah
            </a>
        </div>

        <!-- Community Card -->
        <div class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-[#181818] border border-slate-200 dark:border-zinc-800 shadow-xs flex items-center justify-between gap-3">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-zinc-800 text-slate-900 dark:text-unerd-volt flex items-center justify-center font-mono font-bold text-xs shrink-0 border border-slate-200 dark:border-zinc-700">
                    <svg class="w-5 h-5 text-slate-700 dark:text-unerd-volt" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="truncate">
                    <div class="flex items-center gap-1.5">
                        <h3 class="font-display text-xs sm:text-sm font-bold text-slate-900 dark:text-white uppercase tracking-tight truncate">
                            {{ $participant?->community?->name ?? $user->community?->name ?? 'Mandiri (Individu)' }}
                        </h3>
                        <span class="text-[9px] font-mono text-slate-500 dark:text-zinc-400 bg-slate-100 dark:bg-zinc-800 px-1.5 py-0.2 rounded border border-slate-200 dark:border-zinc-700 shrink-0">
                            {{ $participant?->participant_category ?? $user->role?->name ?? 'Umum' }}
                        </span>
                    </div>
                    <p class="text-[11px] text-slate-500 dark:text-zinc-400 truncate mt-0.5">
                        {{ $participant?->community ? 'Afiliasi: ' . $participant->community->name . ' (' . $participant->community->city . ')' : ($user->community ? 'Afiliasi: ' . $user->community->name : 'Belum bergabung dengan komunitas') }}
                    </p>
                </div>
            </div>
            <a href="{{ route('profile.edit') }}" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-200 text-[11px] font-bold uppercase tracking-wider transition shrink-0">
                {{ $participant?->community || $user->community ? 'Ubah' : 'Pilih' }}
            </a>
        </div>
    </div>
</x-app-layout>
