@props(['type' => 'submit'])

<button {{ $attributes->merge([
    'type' => $type,
    'class' => 'inline-flex items-center justify-center h-12 px-6 bg-unerd-black dark:bg-white hover:bg-unerd-black-active dark:hover:bg-zinc-200 active:bg-zinc-800 text-white dark:text-unerd-black font-display text-sm font-bold tracking-[0.5px] uppercase rounded-md transition duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-unerd-black dark:focus:ring-white'
]) }}>
    {{ $slot }}
</button>
