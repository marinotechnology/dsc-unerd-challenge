@props([
    'variant' => 'concrete',
    'rounded' => 'xl',
])

@php
$baseClasses = match ($variant) {
    'white' => 'bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 shadow-xs text-unerd-ink dark:text-zinc-100',
    'concrete' => 'bg-unerd-surface-card dark:bg-zinc-900/80 border border-unerd-hairline-soft dark:border-zinc-800 text-unerd-ink dark:text-zinc-100',
    'soft' => 'bg-unerd-surface-soft dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 text-unerd-ink dark:text-zinc-100',
    'black' => 'bg-unerd-black dark:bg-zinc-950 border border-zinc-800 text-white',
    'volt' => 'bg-unerd-volt text-unerd-ink',
    'blaze' => 'bg-unerd-blaze text-white',
    'cobalt' => 'bg-unerd-cobalt text-white',
    default => 'bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 text-unerd-ink dark:text-zinc-100',
};

$roundedClass = match ($rounded) {
    'lg' => 'rounded-lg',
    'xl' => 'rounded-xl',
    'md' => 'rounded-md',
    default => 'rounded-xl',
};
@endphp

<div {{ $attributes->merge(['class' => "p-5 sm:p-6 {$baseClasses} {$roundedClass} transition-colors"]) }}>
    {{ $slot }}
</div>
