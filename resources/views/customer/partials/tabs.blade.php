@props(['active' => 'dashboard', 'historyCount' => 0])

<div class="border-b border-slate-200 dark:border-zinc-800 pb-3 mb-6">
    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar">
        <!-- Tab 1: Tantangan Aktif -->
        <a href="{{ route('customer.dashboard') }}"
           class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl text-xs font-black uppercase tracking-wider transition whitespace-nowrap {{ $active === 'dashboard' ? 'bg-slate-900 text-white dark:bg-unerd-volt dark:text-black shadow-xs' : 'bg-white dark:bg-[#181818] text-slate-600 dark:text-zinc-400 border border-slate-200 dark:border-zinc-800 hover:text-slate-900 dark:hover:text-white' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            <span>Tantangan Aktif</span>
        </a>

        <!-- Tab 2: Riwayat Lari -->
        <a href="{{ route('customer.history') }}"
           class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl text-xs font-black uppercase tracking-wider transition whitespace-nowrap {{ $active === 'history' ? 'bg-slate-900 text-white dark:bg-unerd-volt dark:text-black shadow-xs' : 'bg-white dark:bg-[#181818] text-slate-600 dark:text-zinc-400 border border-slate-200 dark:border-zinc-800 hover:text-slate-900 dark:hover:text-white' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Riwayat Lari</span>
            @if ($historyCount > 0)
                <span class="px-1.5 py-0.2 rounded-full text-[10px] font-mono {{ $active === 'history' ? 'bg-white/20 dark:bg-black/20 text-white dark:text-black' : 'bg-slate-100 dark:bg-zinc-800 text-slate-700 dark:text-zinc-300' }}">
                    {{ $historyCount }}
                </span>
            @endif
        </a>

        <!-- Tab 3: Voucher & Sepatu -->
        <a href="{{ route('customer.rewards') }}"
           class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl text-xs font-black uppercase tracking-wider transition whitespace-nowrap {{ $active === 'rewards' ? 'bg-slate-900 text-white dark:bg-unerd-volt dark:text-black shadow-xs' : 'bg-white dark:bg-[#181818] text-slate-600 dark:text-zinc-400 border border-slate-200 dark:border-zinc-800 hover:text-slate-900 dark:hover:text-white' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <span>Voucher & Sepatu</span>
        </a>
    </div>
</div>
