<x-guest-layout>
    <div class="py-6 sm:py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <!-- Header Section -->
            <div class="text-center mb-8">
                <h1 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white uppercase tracking-tight font-display">
                    Leaderboard
                </h1>
                <p class="text-sm text-slate-600 dark:text-slate-400 mt-2 max-w-xl mx-auto">
                    Catatan waktu resmi 1.000 meter UNERD Move Series Run Challenge. Papan peringkat otomatis diperbarui secara live per kategori.
                </p>
            </div>

            <!-- LIVEWIRE COMPONENT LEADERBOARD -->
            <livewire:leaderboard />

            <!-- Bottom Floating Action -->
            <div class="mt-8 text-center">
                <a href="{{ route('everyday-league.register') }}" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl font-black text-xs uppercase tracking-wider bg-slate-900 text-white dark:bg-unerd-volt dark:text-black hover:opacity-90 transition shadow">
                    <span>Daftarkan Diri Sekarang</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
