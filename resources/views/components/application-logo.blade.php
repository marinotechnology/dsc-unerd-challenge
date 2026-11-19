@props(['mode' => 'responsive'])

<div {{ $attributes->merge(['class' => 'inline-flex items-center gap-2']) }}>
    @if ($mode === 'icon-only')
        <!-- Icon Only (Mobile and Compact) -->
        <img src="/images/logos/icon-light.png" alt="UNERD MOVE" class="h-8 w-auto dark:hidden">
        <img src="/images/logos/icon-dark.png" alt="UNERD MOVE" class="h-8 w-auto hidden dark:block">
    @elseif ($mode === 'master-only')
        <!-- Master Logo Only (Desktop) -->
        <img src="/images/logos/master-light.png" alt="UNERD MOVE" class="h-9 w-auto dark:hidden">
        <img src="/images/logos/master-dark.png" alt="UNERD MOVE" class="h-9 w-auto hidden dark:block">
    @else
        <!-- Responsive: Icon on Mobile, Master Logo on Desktop -->
        <div class="block md:hidden">
            <img src="/images/logos/icon-light.png" alt="UNERD MOVE" class="h-8 w-auto dark:hidden">
            <img src="/images/logos/icon-dark.png" alt="UNERD MOVE" class="h-8 w-auto hidden dark:block">
        </div>
        <div class="hidden md:block">
            <img src="/images/logos/master-light.png" alt="UNERD MOVE" class="h-9 w-auto dark:hidden">
            <img src="/images/logos/master-dark.png" alt="UNERD MOVE" class="h-9 w-auto hidden dark:block">
        </div>
    @endif
</div>
