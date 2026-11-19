@props([
    'variant' => 'concrete',
])

@php
$classes = match ($variant) {
    'black' => 'bg-unerd-black dark:bg-zinc-800 text-white border border-unerd-black dark:border-zinc-700',
    'volt' => 'bg-unerd-volt text-unerd-ink font-bold border border-unerd-volt',
    'blaze' => 'bg-unerd-blaze text-white font-bold border border-unerd-blaze',
    'cobalt' => 'bg-unerd-cobalt text-white font-bold border border-unerd-cobalt',
    'gum' => 'bg-unerd-gum-soft dark:bg-amber-950/40 text-unerd-ink dark:text-amber-200 border border-unerd-gum dark:border-amber-800',
    'success' => 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800',
    'error' => 'bg-rose-50 dark:bg-rose-950/50 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800',
    'warning' => 'bg-amber-50 dark:bg-amber-950/50 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800',
    default => 'bg-unerd-surface-card dark:bg-zinc-800 text-unerd-ink dark:text-zinc-200 border border-unerd-hairline dark:border-zinc-700',
};
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center px-2.5 sm:px-3 py-1 rounded-pill text-[10px] sm:text-[11px] font-bold uppercase tracking-[1.2px] transition-colors ' . $classes]) }}>
    {{ $slot }}
</span>
