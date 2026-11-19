<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <span class="text-xs font-mono font-bold uppercase tracking-wider text-slate-400">
                    ADMIN HQ • UNERD MOVE
                </span>
                <h1 class="text-2xl font-black font-display uppercase tracking-tight text-slate-900 dark:text-white mt-0.5">
                    Katalog Produk
                </h1>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-mono font-bold text-slate-500 dark:text-zinc-400">
                    Lifestyle • Performance • Women
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <livewire:admin.product-manager />
        </div>
    </div>
</x-app-layout>
