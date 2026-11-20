<nav x-data="{ open: false }" class="bg-white dark:bg-zinc-900 border-b border-unerd-hairline dark:border-zinc-800 sticky top-0 z-40 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-[68px] sm:h-[72px]">
            <!-- Brand & Navigation Cluster -->
            <div class="flex items-center gap-4 sm:gap-8">
                <!-- UNERD MOVE Brand Anchor with Master Logo (Desktop) & Icon (Mobile) -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <x-application-logo />
                </a>

                <!-- Navigation Links per Role (Desktop) -->
                <div class="hidden md:flex items-center space-x-1">
                    @if (Auth::user()->isAdministrator())
                        <a href="{{ route('admin.dashboard') }}"
                           class="px-3 py-1.5 text-xs font-bold uppercase tracking-[1px] rounded-md transition {{ request()->routeIs('admin.dashboard') ? 'bg-unerd-black text-white dark:bg-white dark:text-unerd-black' : 'text-unerd-body dark:text-zinc-300 hover:text-unerd-ink dark:hover:text-white hover:bg-unerd-surface-card dark:hover:bg-zinc-800' }}">
                            HQ Overview
                        </a>
                        <a href="{{ route('admin.event.index') }}"
                           class="px-3 py-1.5 text-xs font-bold uppercase tracking-[1px] rounded-md transition {{ request()->routeIs('admin.event.*') ? 'bg-unerd-black text-white dark:bg-white dark:text-unerd-black' : 'text-unerd-body dark:text-zinc-300 hover:text-unerd-ink dark:hover:text-white hover:bg-unerd-surface-card dark:hover:bg-zinc-800' }}">
                            Operasional Event
                        </a>
                        <a href="{{ route('admin.roles.index') }}"
                           class="px-3 py-1.5 text-xs font-bold uppercase tracking-[1px] rounded-md transition {{ request()->routeIs('admin.roles.*') ? 'bg-unerd-black text-white dark:bg-white dark:text-unerd-black' : 'text-unerd-body dark:text-zinc-300 hover:text-unerd-ink dark:hover:text-white hover:bg-unerd-surface-card dark:hover:bg-zinc-800' }}">
                            Tipe Role
                        </a>
                        <a href="{{ route('admin.users.index') }}"
                           class="px-3 py-1.5 text-xs font-bold uppercase tracking-[1px] rounded-md transition {{ request()->routeIs('admin.users.*') ? 'bg-unerd-black text-white dark:bg-white dark:text-unerd-black' : 'text-unerd-body dark:text-zinc-300 hover:text-unerd-ink dark:hover:text-white hover:bg-unerd-surface-card dark:hover:bg-zinc-800' }}">
                            Direktori User
                        </a>
                        <a href="{{ route('admin.products.index') }}"
                           class="px-3 py-1.5 text-xs font-bold uppercase tracking-[1px] rounded-md transition {{ request()->routeIs('admin.products.*') ? 'bg-unerd-black text-white dark:bg-white dark:text-unerd-black' : 'text-unerd-body dark:text-zinc-300 hover:text-unerd-ink dark:hover:text-white hover:bg-unerd-surface-card dark:hover:bg-zinc-800' }}">
                            Katalog Produk
                        </a>
                        <a href="{{ route('admin.communities.index') }}"
                           class="px-3 py-1.5 text-xs font-bold uppercase tracking-[1px] rounded-md transition {{ request()->routeIs('admin.communities.*') ? 'bg-unerd-black text-white dark:bg-white dark:text-unerd-black' : 'text-unerd-body dark:text-zinc-300 hover:text-unerd-ink dark:hover:text-white hover:bg-unerd-surface-card dark:hover:bg-zinc-800' }}">
                            Komunitas
                        </a>
                    @elseif (Auth::user()->isFieldSales())
                        <a href="{{ route('admin.event.index') }}"
                           class="px-3 py-1.5 text-xs font-bold uppercase tracking-[1px] rounded-md transition {{ request()->routeIs('admin.event.*') ? 'bg-unerd-black text-white dark:bg-white dark:text-unerd-black' : 'text-unerd-body dark:text-zinc-300 hover:text-unerd-ink dark:hover:text-white hover:bg-unerd-surface-card dark:hover:bg-zinc-800' }}">
                            Operasional Kru GBK
                        </a>
                        <a href="{{ route('sales.dashboard') }}"
                           class="px-3 py-1.5 text-xs font-bold uppercase tracking-[1px] rounded-md transition {{ request()->routeIs('sales.dashboard') ? 'bg-unerd-black text-white dark:bg-white dark:text-unerd-black' : 'text-unerd-body dark:text-zinc-300 hover:text-unerd-ink dark:hover:text-white hover:bg-unerd-surface-card dark:hover:bg-zinc-800' }}">
                            Summary Sales
                        </a>
                    @elseif (Auth::user()->isB2bClient())
                        <a href="{{ route('portal.dashboard') }}"
                           class="px-3 py-1.5 text-xs font-bold uppercase tracking-[1px] rounded-md transition {{ request()->routeIs('portal.dashboard') ? 'bg-unerd-black text-white dark:bg-white dark:text-unerd-black' : 'text-unerd-body dark:text-zinc-300 hover:text-unerd-ink dark:hover:text-white hover:bg-unerd-surface-card dark:hover:bg-zinc-800' }}">
                            Komunitas & Partner Portal
                        </a>
                    @else
                        <a href="{{ route('customer.dashboard') }}"
                           class="px-3 py-1.5 text-xs font-bold uppercase tracking-[1px] rounded-md transition {{ request()->routeIs('customer.dashboard') ? 'bg-unerd-black text-white dark:bg-white dark:text-unerd-black' : 'text-unerd-body dark:text-zinc-300 hover:text-unerd-ink dark:hover:text-white hover:bg-unerd-surface-card dark:hover:bg-zinc-800' }}">
                            Hub Pelari
                        </a>
                        @if (Auth::user()->participant)
                            <a href="{{ route('everyday-league.success', Auth::user()->participant->participant_id) }}"
                               class="px-3 py-1.5 text-xs font-black uppercase tracking-[1px] rounded-md transition flex items-center gap-1.5 {{ request()->is('everyday-league/success*') ? 'bg-unerd-volt text-unerd-ink' : 'text-unerd-ink dark:text-unerd-volt hover:bg-unerd-volt/15 border border-unerd-volt/40' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span>Tiket Lari ({{ Auth::user()->participant->participant_id }})</span>
                            </a>
                        @endif
                        <a href="{{ route('customer.history') }}"
                           class="px-3 py-1.5 text-xs font-bold uppercase tracking-[1px] rounded-md transition {{ request()->routeIs('customer.history') ? 'bg-unerd-black text-white dark:bg-white dark:text-unerd-black' : 'text-unerd-body dark:text-zinc-300 hover:text-unerd-ink dark:hover:text-white hover:bg-unerd-surface-card dark:hover:bg-zinc-800' }}">
                            Riwayat Lari
                        </a>
                        <a href="{{ route('customer.rewards') }}"
                           class="px-3 py-1.5 text-xs font-bold uppercase tracking-[1px] rounded-md transition {{ request()->routeIs('customer.rewards') ? 'bg-unerd-black text-white dark:bg-white dark:text-unerd-black' : 'text-unerd-body dark:text-zinc-300 hover:text-unerd-ink dark:hover:text-white hover:bg-unerd-surface-card dark:hover:bg-zinc-800' }}">
                            Voucher & Sepatu
                        </a>
                        <a href="{{ route('everyday-league.register') }}"
                           class="px-3 py-1.5 text-xs font-bold uppercase tracking-[1px] rounded-md transition {{ request()->routeIs('everyday-league.register') ? 'bg-unerd-black text-white dark:bg-white dark:text-unerd-black' : 'text-unerd-body dark:text-zinc-300 hover:text-unerd-ink dark:hover:text-white hover:bg-unerd-surface-card dark:hover:bg-zinc-800' }}">
                            Time Attack Challenge
                        </a>
                        <a href="{{ route('everyday-league.leaderboard') }}"
                           class="px-3 py-1.5 text-xs font-bold uppercase tracking-[1px] rounded-md transition {{ request()->routeIs('everyday-league.leaderboard') ? 'bg-unerd-black text-white dark:bg-white dark:text-unerd-black' : 'text-unerd-body dark:text-zinc-300 hover:text-unerd-ink dark:hover:text-white hover:bg-unerd-surface-card dark:hover:bg-zinc-800' }}">
                            Leaderboard
                        </a>
                    @endif
                </div>
            </div>

            <!-- Right Profile, Dark Mode Toggle & Role Badge Cluster -->
            <div class="flex items-center gap-2 sm:gap-3">
                <!-- Link Website Resmi unerd.co.id (Clean & Minimalist) -->
                <a href="https://unerd.co.id"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-bold uppercase tracking-wider text-slate-600 hover:text-slate-900 dark:text-zinc-400 dark:hover:text-white rounded-md hover:bg-slate-100 dark:hover:bg-zinc-800 transition group"
                   title="Kunjungi Website Resmi unerd.co.id">
                    <span>unerd.co.id</span>
                    <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-slate-700 dark:group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>

                <!-- Theme Toggle Button (Light / Dark) -->
                <x-theme-toggle />

                <!-- Role Badge Display (Hidden on very small screens, visible sm+) -->
                @php
                    $roleBadge = Auth::user()->role?->slug === 'administrator' ? 'black' :
                        (Auth::user()->role?->slug === 'field-sales' ? 'volt' :
                        (Auth::user()->role?->slug === 'b2b-client' ? 'cobalt' : 'concrete'));
                @endphp

                <div class="hidden sm:inline-flex">
                    <x-badge :variant="$roleBadge">
                        {{ Auth::user()->role?->name ?? 'User' }}
                    </x-badge>
                </div>

                <!-- Profile Dropdown (Desktop) -->
                <div class="hidden md:block">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2 px-2.5 py-1.5 border border-unerd-hairline dark:border-zinc-700 rounded-md text-xs font-bold text-unerd-ink dark:text-zinc-200 bg-white dark:bg-zinc-900 hover:bg-unerd-surface-card dark:hover:bg-zinc-800 transition cursor-pointer">
                                <div class="w-5 h-5 rounded-full bg-unerd-surface-card dark:bg-zinc-800 flex items-center justify-center font-bold text-[11px] text-unerd-ink dark:text-white">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                                <svg class="w-3.5 h-3.5 text-unerd-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 border-b border-unerd-hairline dark:border-zinc-800">
                                <div class="text-xs font-bold text-unerd-ink dark:text-white">{{ Auth::user()->name }}</div>
                                <div class="text-[11px] text-unerd-muted font-mono truncate">{{ Auth::user()->email }}</div>
                            </div>

                            @if (Auth::user()->participant)
                                <x-dropdown-link :href="route('everyday-league.success', Auth::user()->participant->participant_id)" class="font-bold text-unerd-ink dark:text-unerd-volt flex items-center justify-between">
                                    <span>Tiket Lari Saya</span>
                                    <span class="font-mono text-[10px] px-1.5 py-0.5 rounded bg-unerd-volt/20 text-unerd-ink dark:text-unerd-volt font-black">{{ Auth::user()->participant->participant_id }}</span>
                                </x-dropdown-link>
                                <div class="border-t border-unerd-hairline dark:border-zinc-800"></div>
                            @endif

                            <x-dropdown-link :href="route('profile.edit')">
                                Profil Akun
                            </x-dropdown-link>

                            <div class="border-t border-unerd-hairline dark:border-zinc-800"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault(); this.closest('form').submit();"
                                                 class="text-rose-600 dark:text-rose-400">
                                    Keluar / Sign Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Mobile Hamburger Button -->
                <div class="flex items-center md:hidden">
                    <button @click="open = ! open" class="p-2 rounded-md text-unerd-ink dark:text-zinc-200 hover:bg-unerd-surface-card dark:hover:bg-zinc-800 focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Drawer Menu (Mobile-first, compact & fast) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden border-t border-unerd-hairline dark:border-zinc-800 bg-white dark:bg-zinc-900 px-4 pt-3 pb-6 space-y-3">
        <div class="flex items-center justify-between pb-3 border-b border-unerd-hairline dark:border-zinc-800">
            <div>
                <div class="font-bold text-sm text-unerd-ink dark:text-white">{{ Auth::user()->name }}</div>
                <div class="text-xs text-unerd-muted font-mono truncate">{{ Auth::user()->email }}</div>
            </div>
            <x-badge :variant="$roleBadge">
                {{ Auth::user()->role?->name ?? 'User' }}
            </x-badge>
        </div>

        @if (Auth::user()->isAdministrator())
            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-sm font-bold rounded-md bg-unerd-surface-card dark:bg-zinc-800 dark:text-white">HQ Overview</a>
            <a href="{{ route('admin.event.index') }}" class="block px-3 py-2 text-sm font-bold rounded-md hover:bg-unerd-surface-card dark:hover:bg-zinc-800 dark:text-zinc-200">Operasional Event</a>
            <a href="{{ route('admin.roles.index') }}" class="block px-3 py-2 text-sm font-bold rounded-md hover:bg-unerd-surface-card dark:hover:bg-zinc-800 dark:text-zinc-200">Tipe Role</a>
            <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 text-sm font-bold rounded-md hover:bg-unerd-surface-card dark:hover:bg-zinc-800 dark:text-zinc-200">Direktori User</a>
            <a href="{{ route('admin.products.index') }}" class="block px-3 py-2 text-sm font-bold rounded-md hover:bg-unerd-surface-card dark:hover:bg-zinc-800 dark:text-zinc-200">Katalog Produk</a>
            <a href="{{ route('admin.communities.index') }}" class="block px-3 py-2 text-sm font-bold rounded-md hover:bg-unerd-surface-card dark:hover:bg-zinc-800 dark:text-zinc-200">Komunitas</a>
        @elseif (Auth::user()->isFieldSales())
            <a href="{{ route('admin.event.index') }}" class="block px-3 py-2 text-sm font-bold rounded-md bg-unerd-surface-card dark:bg-zinc-800 dark:text-white">Operasional Kru GBK</a>
            <a href="{{ route('sales.dashboard') }}" class="block px-3 py-2 text-sm font-bold rounded-md hover:bg-unerd-surface-card dark:hover:bg-zinc-800 dark:text-zinc-200">Summary Sales</a>
        @elseif (Auth::user()->isB2bClient())
            <a href="{{ route('portal.dashboard') }}" class="block px-3 py-2 text-sm font-bold rounded-md bg-unerd-surface-card dark:bg-zinc-800 dark:text-white">Komunitas & Partner</a>
        @else
            @if (Auth::user()->participant)
                <a href="{{ route('everyday-league.success', Auth::user()->participant->participant_id) }}" class="flex items-center justify-between px-3 py-2 text-sm font-black rounded-md bg-unerd-volt text-unerd-ink shadow-xs">
                    <span class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-black animate-ping"></span>
                        <span>Tiket & ID Pelari</span>
                    </span>
                    <span class="font-mono text-xs">{{ Auth::user()->participant->participant_id }} &rarr;</span>
                </a>
            @endif
            <a href="{{ route('customer.dashboard') }}" class="block px-3 py-2 text-sm font-bold rounded-md {{ request()->routeIs('customer.dashboard') ? 'bg-unerd-surface-card dark:bg-zinc-800 dark:text-white' : 'hover:bg-unerd-surface-card dark:hover:bg-zinc-800 dark:text-zinc-200' }}">Hub Pelari (Tantangan Aktif)</a>
            <a href="{{ route('customer.history') }}" class="block px-3 py-2 text-sm font-bold rounded-md {{ request()->routeIs('customer.history') ? 'bg-unerd-surface-card dark:bg-zinc-800 dark:text-white' : 'hover:bg-unerd-surface-card dark:hover:bg-zinc-800 dark:text-zinc-200' }}">Riwayat Lari & Rekor</a>
            <a href="{{ route('customer.rewards') }}" class="block px-3 py-2 text-sm font-bold rounded-md {{ request()->routeIs('customer.rewards') ? 'bg-unerd-surface-card dark:bg-zinc-800 dark:text-white' : 'hover:bg-unerd-surface-card dark:hover:bg-zinc-800 dark:text-zinc-200' }}">Voucher & Hadiah Sepatu</a>
            <a href="{{ route('everyday-league.register') }}" class="block px-3 py-2 text-sm font-bold rounded-md {{ request()->routeIs('everyday-league.register') ? 'bg-unerd-surface-card dark:bg-zinc-800 dark:text-white' : 'hover:bg-unerd-surface-card dark:hover:bg-zinc-800 dark:text-zinc-200' }}">Time Attack Challenge</a>
            <a href="{{ route('everyday-league.leaderboard') }}" class="block px-3 py-2 text-sm font-bold rounded-md {{ request()->routeIs('everyday-league.leaderboard') ? 'bg-unerd-surface-card dark:bg-zinc-800 dark:text-white' : 'hover:bg-unerd-surface-card dark:hover:bg-zinc-800 dark:text-zinc-200' }}">Leaderboard</a>
        @endif

        <div class="pt-3 border-t border-unerd-hairline dark:border-zinc-800 space-y-1">
            <a href="https://unerd.co.id" target="_blank" rel="noopener noreferrer" class="flex items-center justify-between px-3 py-2 text-sm font-bold text-slate-700 dark:text-zinc-200 hover:bg-unerd-surface-card dark:hover:bg-zinc-800 rounded-md">
                <span>Website Resmi UNERD</span>
                <span class="text-xs font-mono text-slate-400">unerd.co.id ↗</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-sm text-unerd-body dark:text-zinc-300 hover:bg-unerd-surface-card dark:hover:bg-zinc-800 rounded-md">Profil Akun</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-3 py-2 text-sm font-bold text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/30 rounded-md">
                    Keluar / Sign Out
                </button>
            </form>
        </div>
    </div>
</nav>
