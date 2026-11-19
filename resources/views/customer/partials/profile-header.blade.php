@props(['user', 'participant' => null])

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div class="flex items-center gap-3">
        <!-- Avatar Initial -->
        <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-slate-900 text-white dark:bg-unerd-volt dark:text-black flex items-center justify-center font-display font-black text-lg sm:text-xl shrink-0 shadow-xs">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div class="min-w-0">
            <div class="flex flex-wrap items-center gap-2">
                <h1 class="font-display text-lg sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight truncate">
                    Dashboard Pelari {{ $user->role?->name ?? 'Umum' }}
                </h1>
                <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase tracking-wider {{ $user->role?->slug === 'profesional' ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20' : ($user->role?->slug === 'komunitas' ? 'bg-emerald-500/10 text-emerald-600 dark:text-unerd-volt border border-emerald-500/20' : 'bg-slate-100 dark:bg-zinc-800 text-slate-700 dark:text-zinc-300 border border-slate-200 dark:border-zinc-700') }}">
                    {{ $user->name }}
                </span>
            </div>
            <div class="flex flex-wrap items-center gap-1.5 sm:gap-2 text-xs text-slate-500 dark:text-zinc-400 mt-0.5">
                <span class="font-mono">Ukuran EU {{ $user->shoe_size ?? 42 }}</span>
                <span>&bull;</span>
                <span class="truncate">{{ $participant?->community?->name ?? $user->community?->name ?? 'Mandiri (Individu)' }}</span>
            </div>
        </div>
    </div>
    <div class="flex items-center gap-2 shrink-0">
        <!-- <a href="{{ route('profile.edit') }}" class="px-3 py-1.5 rounded-xl border border-slate-300 dark:border-zinc-700 bg-white dark:bg-[#121212] text-slate-700 dark:text-zinc-300 font-bold text-xs hover:border-unerd-volt transition">
            Edit Profil
        </a>
        <a href="{{ route('everyday-league.leaderboard') }}" class="px-3.5 py-1.5 rounded-xl bg-slate-900 text-white dark:bg-unerd-volt dark:text-black font-black text-xs uppercase tracking-wider hover:opacity-90 transition shadow-xs">
            Leaderboard &rarr;
        </a> -->
    </div>
</div>
