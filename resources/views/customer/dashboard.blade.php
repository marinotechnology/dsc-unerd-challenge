<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <x-badge :variant="$user->role?->slug === 'profesional' ? 'blaze' : ($user->role?->slug === 'komunitas' ? 'volt' : 'concrete')">
                        {{ $user->role?->name ?? 'Pelari' }}
                    </x-badge>
                    <span class="text-xs uppercase tracking-widest text-unerd-muted dark:text-zinc-400 font-bold font-mono">
                        UNERD Move Series &bull; Time Attack Challenge
                    </span>
                </div>
                <h1 class="font-display text-2xl lg:text-3xl font-extrabold text-unerd-ink dark:text-white tracking-tight mt-1">
                    Dashboard Pelari {{ $user->role?->name ?? 'Umum' }}
                </h1>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-mono font-bold text-unerd-ink dark:text-zinc-300 bg-unerd-surface-card dark:bg-zinc-800 px-3 py-1.5 rounded border border-unerd-hairline dark:border-zinc-700">
                    Ukuran Sepatu: EU {{ $user->shoe_size ?? 42 }}
                </span>
                <a href="{{ route('everyday-league.leaderboard') }}" class="px-3 py-1.5 rounded bg-slate-900 text-white dark:bg-white dark:text-black font-bold text-xs uppercase tracking-wider hover:opacity-90 transition">
                    Leaderboard Realtime &rarr;
                </a>
            </div>
        </div>
    </x-slot>

    <!-- UNLOCKED EVENT REWARD VOUCHER 10% BANNER -->
    <div class="p-6 sm:p-8 rounded-2xl bg-unerd-black dark:bg-zinc-900 text-white border border-zinc-800 relative overflow-hidden mb-8 shadow-md">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative z-10">
            <div class="space-y-2 max-w-xl">
                <span class="px-2.5 py-0.5 rounded-full bg-unerd-volt text-unerd-ink font-display text-[10px] font-extrabold uppercase tracking-wider">
                    EVENT REWARD UNLOCKED
                </span>
                <h2 class="font-display text-2xl sm:text-3xl font-extrabold uppercase tracking-tight text-white">
                    Voucher Diskon 10% UNERD Footwear
                </h2>
                <p class="text-xs sm:text-sm text-zinc-300 leading-relaxed font-sans">
                    Sebagai pelari terdaftar kategori <strong class="text-white">{{ $user->role?->name ?? 'Umum' }}</strong>, kamu berhak atas diskon 10% untuk seluruh koleksi sepatu UNERD favoritmu dengan ukuran <strong class="text-unerd-volt">EU {{ $user->shoe_size ?? 42 }}</strong>.
                </p>
            </div>

            <div class="p-4 rounded-xl bg-white/10 backdrop-blur-xs border border-white/20 text-center shrink-0">
                <div class="text-[10px] uppercase font-mono tracking-widest text-zinc-400">KODE PROMO:</div>
                <div class="font-mono font-black text-2xl text-unerd-volt my-1 select-all cursor-pointer">
                    MOVE-GBK-10%
                </div>
                <div class="text-[10px] text-zinc-300">Potongan 10% di Official Store</div>
                <div class="text-[10px] font-mono font-bold text-amber-300 dark:text-amber-400 mt-1">Masa Berlaku: 1 Minggu (7 Hari)</div>
            </div>
        </div>
    </div>

    <!-- Live Runner Hub & History across Periods (Realtime Livewire Sync) -->
    <div class="mb-8">
        <livewire:runner-live-status />
    </div>

    <!-- Runner EU Shoe Size Preference (Clean & Compact) -->
    <div class="mb-8">
        <div class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-[#181818] border border-slate-200 dark:border-zinc-800 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-slate-100 dark:bg-zinc-800 text-slate-900 dark:text-unerd-volt flex items-center justify-center font-mono font-black text-sm shrink-0 border border-slate-200 dark:border-zinc-700">
                    EU {{ $user->shoe_size ?? 42 }}
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="font-display text-sm font-bold text-slate-900 dark:text-white uppercase tracking-tight">Ukuran Sepatu Tersimpan</h3>
                        <span class="text-[10px] font-mono text-emerald-600 dark:text-emerald-400 font-bold bg-emerald-50 dark:bg-emerald-950/60 px-2 py-0.5 rounded-full border border-emerald-500/20">True to size</span>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-zinc-400 mt-0.5">Rekomendasi sepatu di bawah otomatis disesuaikan dengan ukuran kakimu (EU {{ $user->shoe_size ?? 42 }}).</p>
                </div>
            </div>
            <a href="{{ route('profile.edit') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-200 text-xs font-bold uppercase tracking-wider transition shrink-0 text-center">
                Ubah di Profil &rarr;
            </a>
        </div>
    </div>

    <!-- POST-RUN RECOVERY FOOTWEAR HIGHLIGHT -->
    @if (! empty($recoveryFootwear))
        <div class="mb-8 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-unerd-volt-dark dark:text-unerd-volt font-mono">
                        POST-RUN RECOVERY FOOTWEAR
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-black uppercase text-unerd-ink dark:text-white">
                        Sandal Sepatu Recovery Setelah Lari
                    </h2>
                </div>
                <span class="text-xs text-unerd-muted dark:text-zinc-400 hidden sm:inline font-mono">
                    Diskon 10% Otomatis Diterapkan
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ($recoveryFootwear as $drop)
                    <div class="rounded-2xl border-2 border-unerd-volt/40 bg-white dark:bg-zinc-900 overflow-hidden hover:border-unerd-volt transition flex flex-col justify-between shadow-xs group">
                        <div>
                            <div class="aspect-4/3 w-full bg-zinc-100 dark:bg-zinc-800 overflow-hidden relative">
                                <img src="{{ asset($drop['image']) }}"
                                     alt="{{ $drop['name'] }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                                <div class="absolute top-3 left-3">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-mono font-bold bg-unerd-volt text-unerd-ink uppercase tracking-wider">
                                        RECOVERY FOOTWEAR
                                    </span>
                                </div>
                                <div class="absolute bottom-3 left-3 right-3 text-white">
                                    <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-black/70 backdrop-blur-xs">
                                        Meredakan & Melemaskan Otot Kaki
                                    </span>
                                </div>
                            </div>
                            <div class="p-4 sm:p-5">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-[11px] font-mono font-bold text-unerd-muted dark:text-zinc-400 uppercase">
                                        {{ $drop['category'] }}
                                    </span>
                                    <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 px-2 py-0.5 rounded-full border border-emerald-500/20">
                                        Tersedia EU {{ $user->shoe_size ?? 42 }}
                                    </span>
                                </div>
                                <h3 class="font-display font-bold text-base text-unerd-ink dark:text-white leading-snug">
                                    {{ $drop['name'] }}
                                </h3>
                                <div class="text-xs text-unerd-muted dark:text-zinc-400 mt-1">
                                    {{ $drop['colorway'] }}
                                </div>
                            </div>
                        </div>

                        <div class="p-4 sm:p-5 pt-0">
                            <div class="pt-3 border-t border-unerd-hairline dark:border-zinc-800 flex items-center justify-between">
                                <div>
                                    <span class="text-[11px] line-through text-unerd-muted dark:text-zinc-500 block">
                                        Rp {{ number_format($drop['retail_price'], 0, ',', '.') }}
                                    </span>
                                    <span class="font-display font-extrabold text-sm sm:text-base text-emerald-600 dark:text-unerd-volt">
                                        Rp {{ number_format($drop['discounted_price'] ?? ($drop['retail_price'] * 0.9), 0, ',', '.') }}
                                    </span>
                                </div>
                                <a href="{{ $drop['shopee_url'] }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-unerd-black dark:bg-white text-white dark:text-unerd-black text-xs font-bold uppercase rounded-lg hover:opacity-90 transition">
                                    <span>Beli di Shopee</span>
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- RECOMMENDED RUNNING & PERFORMANCE SHOES -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-unerd-volt-dark dark:text-unerd-volt font-mono">
                    DISCOVER UNERD FOOTWEAR
                </span>
                <h2 class="font-display text-xl sm:text-2xl font-black uppercase text-unerd-ink dark:text-white">
                    Koleksi Sepatu Lari & Performance
                </h2>
            </div>
            <span class="text-xs text-unerd-muted dark:text-zinc-400 hidden sm:inline font-mono">
                Diskon 10% Otomatis Diterapkan
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($runningFootwear as $drop)
                <div class="rounded-2xl border border-unerd-hairline dark:border-zinc-800 bg-white dark:bg-zinc-900 overflow-hidden hover:border-unerd-volt/60 transition flex flex-col justify-between shadow-xs group">
                    <div>
                        <div class="aspect-4/3 w-full bg-zinc-100 dark:bg-zinc-800 overflow-hidden relative">
                            <img src="{{ asset($drop['image']) }}"
                                 alt="{{ $drop['name'] }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                            <div class="absolute top-3 left-3">
                                <x-badge :variant="$drop['badge_color']">
                                    {{ $drop['badge'] }}
                                </x-badge>
                            </div>
                        </div>
                        <div class="p-4 sm:p-5">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-[11px] font-mono font-bold text-unerd-muted dark:text-zinc-400 uppercase">
                                    {{ $drop['category'] }}
                                </span>
                                <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 px-2 py-0.5 rounded-full border border-emerald-500/20">
                                    Tersedia EU {{ $user->shoe_size ?? 42 }}
                                </span>
                            </div>
                            <h3 class="font-display font-bold text-base text-unerd-ink dark:text-white leading-snug">
                                {{ $drop['name'] }}
                            </h3>
                            <div class="text-xs text-unerd-muted dark:text-zinc-400 mt-1">
                                {{ $drop['colorway'] }}
                            </div>
                        </div>
                    </div>

                    <div class="p-4 sm:p-5 pt-0">
                        <div class="pt-3 border-t border-unerd-hairline dark:border-zinc-800 flex items-center justify-between">
                            <div>
                                <span class="text-[11px] line-through text-unerd-muted dark:text-zinc-500 block">
                                    Rp {{ number_format($drop['retail_price'], 0, ',', '.') }}
                                </span>
                                <span class="font-display font-extrabold text-sm sm:text-base text-emerald-600 dark:text-unerd-volt">
                                    Rp {{ number_format($drop['discounted_price'] ?? ($drop['retail_price'] * 0.9), 0, ',', '.') }}
                                </span>
                            </div>
                            <a href="{{ $drop['shopee_url'] }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-unerd-black dark:bg-white text-white dark:text-unerd-black text-xs font-bold uppercase rounded-lg hover:opacity-90 transition">
                                <span>Beli di Shopee</span>
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
