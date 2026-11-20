<x-app-layout>
    <x-slot name="header">
        @include('customer.partials.profile-header', ['user' => $user, 'participant' => $participant])
    </x-slot>

    <!-- DYNAMIC EVENT REWARD VOUCHER BANNER (Based on Active Challenge & Prize List) -->
    @if (! $isEventActive)
        <div class="p-5 sm:p-7 rounded-2xl bg-slate-900/90 dark:bg-[#181818] text-white border border-rose-500/30 mb-8 shadow-md">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-5">
                <div class="space-y-2 max-w-xl">
                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-rose-500/20 text-rose-300 border border-rose-500/40 font-display text-[10px] font-extrabold uppercase tracking-wider">
                        TANTANGAN NON-AKTIF / DITUTUP
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-extrabold uppercase tracking-tight text-white">
                        Voucher Hadiah Tidak Berlaku
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-400 dark:text-zinc-400 leading-relaxed font-sans">
                        Saat ini tidak ada periode tantangan lari yang sedang aktif atau periode event telah berakhir. Seluruh kode promo dan voucher hadiah pada periode ini otomatis dinonaktifkan dan ditutup. Pantau pembukaan periode baru berikutnya!
                    </p>
                </div>
                <div class="p-4 rounded-xl bg-rose-950/30 border border-rose-500/30 text-center shrink-0">
                    <div class="text-[10px] uppercase font-mono tracking-widest text-slate-400">STATUS VOUCHER:</div>
                    <div class="font-mono font-bold text-sm text-rose-400 my-1">
                        KODE TIDAK AKTIF
                    </div>
                    <div class="text-[10px] text-slate-400">Menunggu Event Dibuka</div>
                </div>
            </div>
        </div>
    @elseif ($unlockedVoucher)
        <div class="p-5 sm:p-7 rounded-2xl bg-slate-900 dark:bg-[#181818] text-white border border-slate-800 dark:border-zinc-800 mb-8 shadow-md">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-5">
                <div class="space-y-2 max-w-xl">
                    <div class="flex items-center gap-2">
                        <span class="inline-block px-2.5 py-0.5 rounded-full bg-unerd-volt text-unerd-ink font-display text-[10px] font-extrabold uppercase tracking-wider">
                            EVENT REWARD UNLOCKED • PERINGKAT #{{ $currentResult->rank_in_period }}
                        </span>
                        <span class="text-xs font-mono text-slate-400">{{ $activePeriod?->cleanName() }}</span>
                    </div>
                    <h2 class="font-display text-xl sm:text-2xl lg:text-3xl font-extrabold uppercase tracking-tight text-white">
                        {{ $prize['title'] ?? 'Voucher Hadiah Tantangan' }}
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-300 dark:text-zinc-300 leading-relaxed font-sans">
                        {{ $prize['description'] ?? 'Selamat! Catatan waktumu berhasil masuk dalam jajaran penerima apresiasi hadiah.' }} Sebagai pelari terdaftar kategori <strong class="text-white">{{ $user->role?->name ?? 'Umum' }}</strong>, kamu berhak menggunakan kode voucher ini untuk pembelian sepatu UNERD pilihan dengan ukuran <strong class="text-unerd-volt">EU {{ $user->shoe_size ?? 42 }}</strong>.
                    </p>
                </div>

                <div x-data="{ copied: false }" class="p-4 rounded-xl bg-white/10 dark:bg-black/40 border border-white/20 dark:border-zinc-700 text-center shrink-0">
                    <div class="text-[10px] uppercase font-mono tracking-widest text-slate-400">KODE PROMO / VOUCHER:</div>
                    <div @click="navigator.clipboard.writeText('{{ $unlockedVoucher }}'); copied = true; setTimeout(() => copied = false, 2000)"
                         class="font-mono font-black text-xl sm:text-2xl text-unerd-volt my-1 cursor-pointer select-all hover:opacity-90 transition"
                         title="Klik untuk menyalin">
                        {{ $unlockedVoucher }}
                    </div>
                    <div class="text-[10px] text-slate-300 dark:text-zinc-300">Potongan Belanja di Official Store UNERD</div>
                    <div class="text-[10px] font-mono font-bold text-amber-300 dark:text-amber-400 mt-1">Masa Berlaku: 1 Minggu (7 Hari)</div>
                    <div x-show="copied" class="text-[10px] text-emerald-400 font-bold mt-1" style="display: none;">
                        Kode voucher berhasil disalin!
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="p-5 sm:p-7 rounded-2xl bg-slate-900 dark:bg-[#181818] text-white border border-slate-800 dark:border-zinc-800 mb-8 shadow-md">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-5">
                <div class="space-y-2 max-w-xl">
                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-amber-400/20 text-amber-300 border border-amber-400/30 font-display text-[10px] font-extrabold uppercase tracking-wider">
                        VOUCHER HADIAH TANTANGAN ({{ $activePeriod?->cleanName() }})
                    </span>
                    <h2 class="font-display text-xl sm:text-2xl font-extrabold uppercase tracking-tight text-white">
                        Masuk Daftar Peringkat Hadiah untuk Membuka Voucher
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-300 dark:text-zinc-300 leading-relaxed font-sans">
                        @if (! $currentResult || ! $currentResult->verified_time_seconds)
                            Selesaikan sprint di lintasan {{ $activePeriod ? $activePeriod->formattedDistance() : '3 KM' }} dan verifikasi catatan waktumu dengan panitia booth. Setiap pelari yang masuk ke dalam list peringkat hadiah akan otomatis membuka kode voucher promo di sini!
                        @else
                            Catatan waktu kamu saat ini berada di peringkat <strong class="text-unerd-volt">#{{ $currentResult->rank_in_period }}</strong>. Terus pertajam catatan waktumu di lintasan untuk menembus rentang peringkat hadiah dan membuka kode promo!
                        @endif
                    </p>
                </div>

                <div class="p-4 rounded-xl bg-white/5 border border-white/10 text-center shrink-0">
                    <div class="text-[10px] uppercase font-mono tracking-widest text-slate-400">KODE VOUCHER:</div>
                    <div class="font-mono font-bold text-sm text-slate-400 my-1 py-1 px-3 bg-white/5 rounded border border-white/10">
                        TERKUNCI
                    </div>
                    <div class="text-[10px] text-slate-400">Berdasarkan Peringkat Hadiah</div>
                </div>
            </div>
        </div>
    @endif

    <!-- POST-RUN RECOVERY FOOTWEAR HIGHLIGHT -->
    @if (! empty($recoveryFootwear))
        <div class="mb-10 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-unerd-volt-dark dark:text-unerd-volt font-mono">
                        POST-RUN RECOVERY FOOTWEAR
                    </span>
                    <h2 class="font-display text-lg sm:text-xl font-black uppercase text-slate-900 dark:text-white">
                        Sandal Sepatu Recovery Setelah Lari
                    </h2>
                </div>
                <span class="text-xs text-slate-500 dark:text-zinc-400 hidden sm:inline font-mono">
                    Diskon 10% Otomatis Diterapkan
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ($recoveryFootwear as $drop)
                    <div class="rounded-2xl border border-slate-200 dark:border-zinc-800 bg-white dark:bg-[#181818] overflow-hidden hover:border-unerd-volt transition flex flex-col justify-between shadow-xs group">
                        <div>
                            <div class="aspect-4/3 w-full bg-slate-100 dark:bg-zinc-800 overflow-hidden relative">
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
                                    <span class="text-[11px] font-mono font-bold text-slate-500 dark:text-zinc-400 uppercase">
                                        {{ $drop['category'] }}
                                    </span>
                                    <span class="text-[10px] font-bold text-emerald-600 dark:text-unerd-volt bg-emerald-50 dark:bg-emerald-950/60 px-2 py-0.5 rounded-full border border-emerald-500/20">
                                        Tersedia EU {{ $user->shoe_size ?? 42 }}
                                    </span>
                                </div>
                                <h3 class="font-display font-bold text-base text-slate-900 dark:text-white leading-snug">
                                    {{ $drop['name'] }}
                                </h3>
                                <div class="text-xs text-slate-500 dark:text-zinc-400 mt-1">
                                    {{ $drop['colorway'] }}
                                </div>
                            </div>
                        </div>

                        <div class="p-4 sm:p-5 pt-0">
                            <div class="pt-3 border-t border-slate-100 dark:border-zinc-800 flex items-center justify-between">
                                <div>
                                    <span class="text-[11px] line-through text-slate-400 dark:text-zinc-500 block">
                                        Rp {{ number_format($drop['retail_price'], 0, ',', '.') }}
                                    </span>
                                    <span class="font-display font-extrabold text-sm sm:text-base text-emerald-600 dark:text-unerd-volt">
                                        Rp {{ number_format($drop['discounted_price'] ?? ($drop['retail_price'] * 0.9), 0, ',', '.') }}
                                    </span>
                                </div>
                                <a href="{{ $drop['shopee_url'] }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-900 dark:bg-white text-white dark:text-black text-xs font-bold uppercase rounded-xl hover:opacity-90 transition">
                                    <span>Beli Sepatu</span>
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
                <h2 class="font-display text-lg sm:text-xl font-black uppercase text-slate-900 dark:text-white">
                    Koleksi Sepatu Lari & Performance
                </h2>
            </div>
            <span class="text-xs text-slate-500 dark:text-zinc-400 hidden sm:inline font-mono">
                Diskon 10% Otomatis Diterapkan
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($runningFootwear as $drop)
                <div class="rounded-2xl border border-slate-200 dark:border-zinc-800 bg-white dark:bg-[#181818] overflow-hidden hover:border-unerd-volt transition flex flex-col justify-between shadow-xs group">
                    <div>
                        <div class="aspect-4/3 w-full bg-slate-100 dark:bg-zinc-800 overflow-hidden relative">
                            <img src="{{ asset($drop['image']) }}"
                                 alt="{{ $drop['name'] }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                            <div class="absolute top-3 left-3">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-mono font-bold bg-slate-900 text-white dark:bg-unerd-volt dark:text-black uppercase tracking-wider">
                                    {{ $drop['badge'] }}
                                </span>
                            </div>
                        </div>
                        <div class="p-4 sm:p-5">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-[11px] font-mono font-bold text-slate-500 dark:text-zinc-400 uppercase">
                                    {{ $drop['category'] }}
                                </span>
                                <span class="text-[10px] font-bold text-emerald-600 dark:text-unerd-volt bg-emerald-50 dark:bg-emerald-950/60 px-2 py-0.5 rounded-full border border-emerald-500/20">
                                    Tersedia EU {{ $user->shoe_size ?? 42 }}
                                </span>
                            </div>
                            <h3 class="font-display font-bold text-base text-slate-900 dark:text-white leading-snug">
                                {{ $drop['name'] }}
                            </h3>
                            <div class="text-xs text-slate-500 dark:text-zinc-400 mt-1">
                                {{ $drop['colorway'] }}
                            </div>
                        </div>
                    </div>

                    <div class="p-4 sm:p-5 pt-0">
                        <div class="pt-3 border-t border-slate-100 dark:border-zinc-800 flex items-center justify-between">
                            <div>
                                <span class="text-[11px] line-through text-slate-400 dark:text-zinc-500 block">
                                    Rp {{ number_format($drop['retail_price'], 0, ',', '.') }}
                                </span>
                                <span class="font-display font-extrabold text-sm sm:text-base text-emerald-600 dark:text-unerd-volt">
                                    Rp {{ number_format($drop['discounted_price'] ?? ($drop['retail_price'] * 0.9), 0, ',', '.') }}
                                </span>
                            </div>
                            <a href="{{ $drop['shopee_url'] }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-900 dark:bg-white text-white dark:text-black text-xs font-bold uppercase rounded-xl hover:opacity-90 transition">
                                <span>Beli Sepatu</span>
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
