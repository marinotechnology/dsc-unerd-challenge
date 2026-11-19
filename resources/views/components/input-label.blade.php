@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-display text-xs font-bold uppercase tracking-[1.2px] text-unerd-body-strong dark:text-zinc-200 mb-1.5']) }}>
    {{ $value ?? $slot }}
</label>
