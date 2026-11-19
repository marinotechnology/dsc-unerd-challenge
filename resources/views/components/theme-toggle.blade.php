<div x-data="{
        currentTheme: localStorage.theme || 'dark',
        setMode(mode) {
            this.currentTheme = mode;
            if (typeof applyTheme === 'function') {
                applyTheme(mode);
            }
        },
        cycle() {
            if (this.currentTheme === 'dark') {
                this.setMode('light');
            } else {
                this.setMode('dark');
            }
        }
     }"
     @theme-changed.window="currentTheme = $event.detail.theme"
     class="relative inline-flex items-center">
    <button type="button"
            @click="cycle()"
            class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg border border-unerd-hairline dark:border-zinc-700 bg-white dark:bg-zinc-900 text-unerd-ink dark:text-zinc-200 hover:bg-unerd-surface-card dark:hover:bg-zinc-800 transition cursor-pointer shadow-xs text-xs font-bold"
            :title="currentTheme === 'system' ? 'Mode: Otomatis Sistem (Klik ganti ke Terang)' : (currentTheme === 'light' ? 'Mode: Terang (Klik ganti ke Gelap)' : 'Mode: Gelap (Klik ganti ke Otomatis Sistem)')">
        <!-- Sun icon (Light mode active) -->
        <span x-show="currentTheme === 'light'" class="inline-flex items-center gap-1 text-amber-500">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <span class="text-[10px] uppercase font-mono hidden sm:inline">Light</span>
        </span>

        <!-- Moon icon (Dark mode active) -->
        <span x-show="currentTheme === 'dark'" style="display: none;" class="inline-flex items-center gap-1 text-unerd-volt">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
            <span class="text-[10px] uppercase font-mono hidden sm:inline">Dark</span>
        </span>

        <!-- Monitor icon (System mode active) -->
        <span x-show="currentTheme === 'system'" style="display: none;" class="inline-flex items-center gap-1 text-slate-500 dark:text-zinc-400">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            <span class="text-[10px] uppercase font-mono hidden sm:inline">Auto</span>
        </span>
    </button>
</div>
