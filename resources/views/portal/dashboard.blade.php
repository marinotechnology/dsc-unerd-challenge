<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <x-badge variant="cobalt">COMMUNITY PARTNER</x-badge>
                    <span class="text-xs uppercase tracking-widest text-unerd-muted dark:text-zinc-400 font-bold font-mono">
                        Run by Five & Running Clubs
                    </span>
                </div>
                <h1 class="font-display text-2xl lg:text-3xl font-extrabold text-unerd-ink dark:text-white tracking-tight mt-1">
                    Portal Kemitraan Komunitas Lari
                </h1>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 rounded border border-emerald-200 dark:border-emerald-800 text-xs font-mono font-bold">
                    TERDAFTAR SEBAGAI MITRA AKTIF
                </span>
            </div>
        </div>
    </x-slot>

    <!-- Community Metric Matrix -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-5 mb-8">
        <x-card variant="black" class="flex flex-col justify-between">
            <span class="text-xs font-bold uppercase tracking-widest text-zinc-400">Peringkat Komunitas di Time Attack</span>
            <div class="my-3 sm:my-4">
                <div class="font-display font-black text-3xl sm:text-4xl text-white">
                    #2 Overall
                </div>
                <div class="text-xs text-zinc-400 mt-1">Kategori: Community Competition GBK</div>
            </div>
            <span class="text-xs font-bold uppercase tracking-wider text-unerd-volt">
                Avg Pace Klub: 04:12/km (64 Anggota Lari)
            </span>
        </x-card>

        <x-card variant="cobalt" class="flex flex-col justify-between">
            <span class="text-xs font-extrabold uppercase tracking-widest text-white">Anggota Komunitas Terverifikasi</span>
            <div class="my-3 sm:my-4">
                <div class="font-display font-black text-3xl sm:text-4xl text-white">
                    142 Pelari
                </div>
                <div class="text-xs text-blue-100 font-medium mt-1">+28 anggota baru bergabung lewat UNERD MOVE</div>
            </div>
            <span class="text-xs font-bold uppercase tracking-wider text-white">
                Pertumbuhan: +24.5% vs Bulan Lalu
            </span>
        </x-card>

        <x-card variant="concrete" class="flex flex-col justify-between">
            <span class="text-xs font-bold uppercase tracking-widest text-unerd-muted dark:text-zinc-400">Total Voucher Terklaim Anggota</span>
            <div class="my-3 sm:my-4">
                <div class="font-display font-black text-3xl sm:text-4xl text-unerd-ink dark:text-white">
                    86 Voucher
                </div>
                <div class="text-xs text-unerd-muted dark:text-zinc-400 mt-1">Kode Spesial: MOVE-RUNBYFIVE-10</div>
            </div>
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 dark:text-emerald-400">
                Tingkat Konversi Finisher: 60.5%
            </span>
        </x-card>
    </div>

    <!-- Community Roster & Activation Table -->
    <x-card variant="white">
        <div class="flex items-center justify-between pb-4 border-b border-unerd-hairline dark:border-zinc-800 mb-4">
            <div>
                <h2 class="font-display text-lg font-bold text-unerd-ink dark:text-white">Daftar Pelari Komunitas (Time Attack GBK)</h2>
                <p class="text-xs text-unerd-muted dark:text-zinc-400">Anggota klub yang telah terdaftar dengan nomor BIB resmi</p>
            </div>
            <span class="text-xs font-mono font-bold text-unerd-muted dark:text-zinc-400">
                Batch 1 Selesai
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-unerd-hairline dark:border-zinc-800 text-[11px] font-bold uppercase tracking-wider text-unerd-muted dark:text-zinc-400">
                        <th class="pb-3">Nomor BIB & Nama</th>
                        <th class="pb-3">Kategori</th>
                        <th class="pb-3">Waktu Finis</th>
                        <th class="pb-3">Pace Rata-rata</th>
                        <th class="pb-3 text-right">Status Voucher</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-unerd-hairline dark:divide-zinc-800">
                    <tr class="hover:bg-unerd-surface-soft dark:hover:bg-zinc-800/60 transition">
                        <td class="py-3.5">
                            <div class="font-display font-bold text-unerd-ink dark:text-white">BIB #0112 • Kevin Sanjaya</div>
                            <div class="text-xs text-unerd-muted dark:text-zinc-400 font-mono">kevin@runbyfive.club</div>
                        </td>
                        <td class="py-3.5 text-xs text-unerd-body dark:text-zinc-300">1.0 km Sprint</td>
                        <td class="py-3.5 font-mono font-bold text-unerd-ink dark:text-white">00:17:42</td>
                        <td class="py-3.5 font-mono text-emerald-700 dark:text-emerald-400 font-bold">03:32/km</td>
                        <td class="py-3.5 text-right">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300">
                                DIBELANJAKAN
                            </span>
                        </td>
                    </tr>
                    <tr class="hover:bg-unerd-surface-soft dark:hover:bg-zinc-800/60 transition">
                        <td class="py-3.5">
                            <div class="font-display font-bold text-unerd-ink dark:text-white">BIB #0118 • Nadia Safitri</div>
                            <div class="text-xs text-unerd-muted dark:text-zinc-400 font-mono">nadia@runbyfive.club</div>
                        </td>
                        <td class="py-3.5 text-xs text-unerd-body dark:text-zinc-300">1.0 km Sprint</td>
                        <td class="py-3.5 font-mono font-bold text-unerd-ink dark:text-white">00:19:15</td>
                        <td class="py-3.5 font-mono text-emerald-700 dark:text-emerald-400 font-bold">03:51/km</td>
                        <td class="py-3.5 text-right">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-unerd-volt text-unerd-ink">
                                VOUCHER AKTIF
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </x-card>
</x-app-layout>
