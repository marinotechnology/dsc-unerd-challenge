<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <x-badge :variant="$user->role?->slug === 'profesional' ? 'blaze' : ($user->role?->slug === 'komunitas' ? 'volt' : 'concrete')">
                        Kategori {{ $user->role?->name ?? 'Pelari' }}
                    </x-badge>
                    <span class="text-xs font-mono font-bold text-slate-400 dark:text-zinc-500 uppercase tracking-wider">
                        UNERD Move Series
                    </span>
                </div>
                <h1 class="font-display text-2xl lg:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight mt-1">
                    Pengaturan Profil & Akun
                </h1>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('customer.dashboard') }}"
                   class="px-3.5 py-2 rounded-xl bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 text-slate-700 dark:text-slate-300 font-bold text-xs uppercase tracking-wider hover:border-unerd-volt transition">
                    &larr; Kembali ke Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto space-y-6">
            <!-- Informational Banner for Runner's Registered Role & Category -->
            <div class="p-5 rounded-2xl bg-white dark:bg-[#1a1a1a] border border-slate-200 dark:border-white/10 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-unerd-volt/10 text-slate-900 dark:text-unerd-volt flex items-center justify-center font-black font-display text-lg">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="text-xs font-mono uppercase text-slate-400 font-bold">Kategori Terdaftar</div>
                        <div class="text-base font-black text-slate-900 dark:text-white font-display">
                            {{ $user->name }} &bull; Pelari {{ $user->role?->name ?? 'Umum' }}
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-xs font-mono font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/40 px-3 py-1.5 rounded-xl border border-emerald-200 dark:border-emerald-800">
                        Ukuran Sepatu: EU {{ $user->shoe_size ?? 42 }}
                    </span>
                </div>
            </div>

            <!-- Profile & Shoe Size Edit Card -->
            <div class="p-6 sm:p-8 bg-white dark:bg-[#1a1a1a] border border-slate-200 dark:border-white/10 rounded-2xl shadow-xs">
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Password Update Card -->
            <div class="p-6 sm:p-8 bg-white dark:bg-[#1a1a1a] border border-slate-200 dark:border-white/10 rounded-2xl shadow-xs">
                @include('profile.partials.update-password-form')
            </div>

            <!-- Delete Account Card -->
            <div class="p-6 sm:p-8 bg-white dark:bg-[#1a1a1a] border border-rose-200 dark:border-rose-900/30 rounded-2xl shadow-xs">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
