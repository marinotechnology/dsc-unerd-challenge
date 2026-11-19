<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <x-badge variant="black">ADMIN HQ</x-badge>
                    <span class="text-xs uppercase tracking-widest text-unerd-muted dark:text-zinc-400 font-bold font-mono">
                        UNERD MOVE Control Center
                    </span>
                </div>
                <h1 class="font-display text-2xl lg:text-3xl font-extrabold text-unerd-ink dark:text-white tracking-tight mt-1">
                    Event Operations & RBAC Administration
                </h1>
            </div>
            <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                <a href="{{ route('admin.roles.index') }}"
                   class="inline-flex items-center justify-center h-10 px-3.5 bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-700 hover:border-unerd-black dark:hover:border-white text-unerd-ink dark:text-white text-xs font-bold uppercase tracking-wider rounded-md transition">
                    + Kelola Tipe User
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="inline-flex items-center justify-center h-10 px-3.5 bg-unerd-black dark:bg-white hover:bg-unerd-black-active dark:hover:bg-zinc-200 text-white dark:text-unerd-black text-xs font-bold uppercase tracking-wider rounded-md transition shadow-xs">
                    + Tambah Pengguna
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Top KPI Matrix (Mobile-first grid: 1-col on mobile, 2-col on sm, 4-col on lg) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mb-8">
        <!-- Total Users (Black Anchor) -->
        <x-card variant="black" class="flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-widest text-zinc-400">Total Akun Terdaftar</span>
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
            </div>
            <div class="my-3 sm:my-4">
                <div class="font-display font-black text-3xl sm:text-4xl text-white tracking-tight">{{ $totalUsersCount }}</div>
                <div class="text-xs text-zinc-400 mt-1">Peserta, Mitra & Kru Terverifikasi</div>
            </div>
            <a href="{{ route('admin.users.index') }}" class="text-xs font-bold uppercase tracking-wider text-unerd-volt hover:underline inline-flex items-center gap-1">
                Buka Direktori Pengguna →
            </a>
        </x-card>

        <!-- Total Role Types (Concrete Surface) -->
        <x-card variant="concrete" class="flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-widest text-unerd-muted dark:text-zinc-400">Tipe Role Wewenang</span>
                <x-badge variant="concrete">{{ $totalRolesCount }} Tipe</x-badge>
            </div>
            <div class="my-3 sm:my-4">
                <div class="font-display font-black text-3xl sm:text-4xl text-unerd-ink dark:text-white tracking-tight">{{ $totalRolesCount }}</div>
                <div class="text-xs text-unerd-muted dark:text-zinc-400 mt-1">Struktur peran & hierarki izin</div>
            </div>
            <a href="{{ route('admin.roles.index') }}" class="text-xs font-bold uppercase tracking-wider text-unerd-ink dark:text-white hover:underline inline-flex items-center gap-1">
                Kelola & Tambah Role →
            </a>
        </x-card>

        <!-- Field Activation Crew (Volt Accent) -->
        <x-card variant="volt" class="flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold uppercase tracking-widest text-unerd-ink">Kru On-Event GBK</span>
                <span class="px-2 py-0.5 rounded-pill bg-black text-unerd-volt text-[10px] font-bold uppercase">Activation</span>
            </div>
            <div class="my-3 sm:my-4">
                <div class="font-display font-black text-3xl sm:text-4xl text-unerd-ink tracking-tight">{{ $fieldSalesCount }}</div>
                <div class="text-xs text-zinc-900 font-medium mt-1">Kru verifikasi waktu & titik start</div>
            </div>
            <a href="{{ route('admin.users.index', ['role' => 'field-sales']) }}" class="text-xs font-extrabold uppercase tracking-wider text-unerd-ink hover:underline inline-flex items-center gap-1">
                Filter Kru Lapangan →
            </a>
        </x-card>

        <!-- Community Partners (Cobalt Accent) -->
        <x-card variant="cobalt" class="flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold uppercase tracking-widest text-white">komunitas Lari</span>
                <span class="px-2 py-0.5 rounded-pill bg-white text-unerd-cobalt text-[10px] font-bold uppercase">Community</span>
            </div>
            <div class="my-3 sm:my-4">
                <div class="font-display font-black text-3xl sm:text-4xl text-white tracking-tight">{{ $b2bClientsCount }}</div>
                <div class="text-xs text-blue-100 font-medium mt-1">Run by Five & partner clubs</div>
            </div>
            <a href="{{ route('admin.users.index', ['role' => 'b2b-client']) }}" class="text-xs font-extrabold uppercase tracking-wider text-white hover:underline inline-flex items-center gap-1">
                Filter Rekanan Komunitas →
            </a>
        </x-card>
    </div>

    <!-- Main Content Split: Role Types Overview + Recent Registrations -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
        <!-- Left: Role Types Breakdown -->
        <div class="lg:col-span-1 space-y-6">
            <x-card variant="white">
                <div class="flex items-center justify-between pb-4 border-b border-unerd-hairline dark:border-zinc-800">
                    <div>
                        <h2 class="font-display text-base font-bold text-unerd-ink dark:text-white">Tipe Pengguna (Roles)</h2>
                        <p class="text-xs text-unerd-muted dark:text-zinc-400">Matriks wewenang platform UNERD MOVE</p>
                    </div>
                    <a href="{{ route('admin.roles.index') }}" class="text-xs font-bold text-unerd-ink dark:text-white hover:underline">
                        + Baru
                    </a>
                </div>

                <div class="divide-y divide-unerd-hairline dark:divide-zinc-800 mt-4">
                    @foreach ($rolesList as $roleItem)
                        <div class="py-3 flex items-center justify-between">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-display text-sm font-bold text-unerd-ink dark:text-white">{{ $roleItem->name }}</span>
                                    @if ($roleItem->is_system_reserved)
                                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 font-mono font-semibold">CORE</span>
                                    @else
                                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-lime-100 dark:bg-lime-950 text-lime-800 dark:text-lime-300 font-mono font-bold">CUSTOM</span>
                                    @endif
                                </div>
                                <div class="text-[11px] text-unerd-muted dark:text-zinc-500 font-mono mt-0.5">slug: {{ $roleItem->slug }}</div>
                            </div>
                            <div class="text-right">
                                <span class="font-display font-extrabold text-sm text-unerd-ink dark:text-white">{{ $roleItem->users_count }}</span>
                                <span class="text-xs text-unerd-muted dark:text-zinc-400">user</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 pt-4 border-t border-unerd-hairline dark:border-zinc-800 text-center">
                    <a href="{{ route('admin.roles.index') }}" class="text-xs font-bold uppercase tracking-wider text-unerd-ink dark:text-white hover:underline">
                        Kelola Tipe Role Selengkapnya →
                    </a>
                </div>
            </x-card>
        </div>

        <!-- Right: Recent Registered Users -->
        <div class="lg:col-span-2 space-y-6">
            <x-card variant="white">
                <div class="flex items-center justify-between pb-4 border-b border-unerd-hairline dark:border-zinc-800">
                    <div>
                        <h2 class="font-display text-base font-bold text-unerd-ink dark:text-white">Registrasi Peserta & Akun Terbaru</h2>
                        <p class="text-xs text-unerd-muted dark:text-zinc-400">Peserta Time Attack dan kru aktivasi</p>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-unerd-ink dark:text-white hover:underline">
                        Lihat Semua ({{ $totalUsersCount }}) →
                    </a>
                </div>

                <div class="overflow-x-auto mt-4">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b border-unerd-hairline dark:border-zinc-800 text-[11px] font-bold uppercase tracking-wider text-unerd-muted dark:text-zinc-400">
                                <th class="pb-3">Nama Peserta</th>
                                <th class="pb-3">Tipe Role</th>
                                <th class="pb-3">Status</th>
                                <th class="pb-3 text-right">Terdaftar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-unerd-hairline dark:divide-zinc-800">
                            @foreach ($recentUsers as $recentUser)
                                <tr class="hover:bg-unerd-surface-soft dark:hover:bg-zinc-800/60 transition">
                                    <td class="py-3">
                                        <div class="font-display font-bold text-unerd-ink dark:text-white">{{ $recentUser->name }}</div>
                                        <div class="text-xs text-unerd-muted dark:text-zinc-400 font-mono">{{ $recentUser->email }}</div>
                                    </td>
                                    <td class="py-3">
                                        @php
                                            $badgeVariant = match($recentUser->role?->slug) {
                                                'administrator' => 'black',
                                                'field-sales' => 'volt',
                                                'b2b-client' => 'cobalt',
                                                default => 'concrete',
                                            };
                                        @endphp
                                        <x-badge :variant="$badgeVariant">
                                            {{ $recentUser->role?->name ?? 'None' }}
                                        </x-badge>
                                    </td>
                                    <td class="py-3">
                                        @if ($recentUser->is_blocked)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-rose-100 dark:bg-rose-950 text-rose-800 dark:text-rose-300">
                                                Diblokir
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300">
                                                Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-right text-xs text-unerd-muted dark:text-zinc-400">
                                        {{ $recentUser->created_at->format('d M Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
