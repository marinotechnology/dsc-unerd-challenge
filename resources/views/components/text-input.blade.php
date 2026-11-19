@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge([
    'class' => 'h-12 px-4 bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-700 text-unerd-ink dark:text-white text-sm rounded-md placeholder-unerd-muted dark:placeholder-zinc-500 focus:border-unerd-black dark:focus:border-white focus:ring-1 focus:ring-unerd-black dark:focus:ring-white transition duration-150 ease-in-out disabled:bg-unerd-surface-soft dark:disabled:bg-zinc-800 disabled:text-unerd-muted disabled:cursor-not-allowed shadow-none'
]) }}>
