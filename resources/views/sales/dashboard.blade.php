<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <x-badge variant="volt">ON-EVENT CREW</x-badge>
                    <span class="text-xs uppercase tracking-widest text-unerd-muted dark:text-zinc-400 font-bold font-mono">
                        GBK Activation Hub PWA
                    </span>
                </div>
                <h1 class="font-display text-2xl lg:text-3xl font-extrabold text-unerd-ink dark:text-white tracking-tight mt-1">
                    Titik Aktivasi Lapangan & Check-in Peserta
                </h1>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-xs font-mono font-bold text-unerd-ink dark:text-white">GPS GEOFENCE ACTIVE</span>
            </div>
        </div>
    </x-slot>

    <!-- Top Metrics Banner -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-5 mb-8">
        <x-card variant="black" class="flex flex-col justify-between">
            <span class="text-xs font-bold uppercase tracking-widest text-zinc-400">Target Partisipasi Peserta GBK</span>
            <div class="my-3 sm:my-4">
                <div class="font-display font-black text-3xl text-white">
                    500 Peserta
                </div>
                <div class="text-xs text-zinc-400 mt-1">Target akuisisi lari Time Attack 1.0 km</div>
            </div>
            <div class="w-full bg-zinc-800 rounded-full h-2 overflow-hidden">
                <div class="bg-unerd-volt h-2 rounded-full" style="width: 44%"></div>
            </div>
        </x-card>

        <x-card variant="volt" class="flex flex-col justify-between">
            <span class="text-xs font-extrabold uppercase tracking-widest text-unerd-ink">Peserta Selesai Finis (Finishers)</span>
            <div class="my-3 sm:my-4">
                <div class="font-display font-black text-3xl text-unerd-ink">
                    220 Finisher
                </div>
                <div class="text-xs text-zinc-900 font-semibold mt-1">Hasil terverifikasi & kartu digital aktif</div>
            </div>
            <span class="text-xs font-bold uppercase tracking-wider text-unerd-ink">
                Status: Waktu Race Tervalidasi
            </span>
        </x-card>

        <x-card variant="concrete" class="flex flex-col justify-between">
            <span class="text-xs font-bold uppercase tracking-widest text-unerd-muted dark:text-zinc-400">Radius Toleransi Geofence</span>
            <div class="my-3 sm:my-4">
                <div class="font-display font-black text-3xl text-unerd-ink dark:text-white">50.0 Meter</div>
                <div class="text-xs text-unerd-muted dark:text-zinc-400 mt-1">Titik Gate GBK Ring Road Senayan</div>
            </div>
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 dark:text-emerald-400">
                Akurasi Lokasi Titik Start OK
            </span>
        </x-card>
    </div>

    <!-- Activation Points & Route List -->
    <x-card variant="white">
        <div class="flex items-center justify-between pb-4 border-b border-unerd-hairline dark:border-zinc-800 mb-5">
            <div>
                <h2 class="font-display text-lg font-bold text-unerd-ink dark:text-white">Pos Titik Aktivasi & Check-in Offline</h2>
                <p class="text-xs text-unerd-muted dark:text-zinc-400">Pemindaian QR code untuk verifikasi nomor  dan start peserta</p>
            </div>
            <span class="text-xs font-mono font-bold text-unerd-muted dark:text-zinc-400">
                3 Titik Pos Aktif
            </span>
        </div>

        <div class="space-y-3.5">
            @foreach ($assignedOutlets as $outlet)
                <div class="p-4 sm:p-5 rounded-lg border border-unerd-hairline dark:border-zinc-800 hover:border-unerd-black dark:hover:border-zinc-600 transition bg-unerd-surface-soft dark:bg-zinc-850 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <h3 class="font-display font-bold text-base text-unerd-ink dark:text-white">{{ $outlet['outlet_name'] }}</h3>
                            @if ($outlet['status'] === 'COMPLETED')
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300">
                                    SELESAI SESI
                                </span>
                            @elseif ($outlet['status'] === 'CHECKED_IN')
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-unerd-volt text-unerd-ink">
                                    AKTIF BERJALAN
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-zinc-200 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">
                                    SIAGA
                                </span>
                            @endif
                        </div>
                        <div class="text-xs text-unerd-body dark:text-zinc-400 flex flex-wrap items-center gap-2">
                            <span>{{ $outlet['address'] }}</span>
                            <span>•</span>
                            <span class="font-mono text-emerald-700 dark:text-emerald-400 font-bold">Radius: {{ $outlet['geofence_distance_meters'] }}m (Akurat)</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        @if ($outlet['status'] === 'PENDING_VISIT')
                            <button type="button" class="px-4 py-2 bg-unerd-black dark:bg-white text-white dark:text-unerd-black text-xs font-bold uppercase tracking-wider rounded-md transition cursor-pointer">
                                Buka Scan QR Check-in
                            </button>
                        @elseif ($outlet['status'] === 'CHECKED_IN')
                            <button type="button" class="px-4 py-2 bg-unerd-volt text-unerd-ink font-bold text-xs uppercase tracking-wider rounded-md transition cursor-pointer">
                                Input Waktu Finis Peserta
                            </button>
                        @else
                            <button type="button" class="px-4 py-2 bg-unerd-surface-card dark:bg-zinc-800 text-unerd-muted dark:text-zinc-400 text-xs font-bold uppercase tracking-wider rounded-md cursor-default">
                                Data Terverifikasi
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </x-card>
</x-app-layout>
