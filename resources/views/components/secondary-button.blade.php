@props(['type' => 'button'])

<button {{ $attributes->merge([
    'type' => $type,
    'class' => 'inline-flex items-center justify-center h-12 px-6 bg-white dark:bg-zinc-900 hover:bg-unerd-surface-soft dark:hover:bg-zinc-800 text-unerd-ink dark:text-zinc-100 font-display text-sm font-bold tracking-[0.5px] uppercase border border-unerd-hairline dark:border-zinc-700 hover:border-unerd-black dark:hover:border-white rounded-md transition duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-unerd-hairline dark:focus:ring-zinc-700'
]) }}>
    {{ $slot }}
</button>
