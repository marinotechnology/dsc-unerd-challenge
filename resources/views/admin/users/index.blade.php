<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.dashboard') }}" class="text-xs uppercase tracking-widest text-unerd-muted dark:text-zinc-400 hover:text-unerd-ink dark:hover:text-white font-bold">
                        ← Kembali ke Overview
                    </a>
                </div>
                <h1 class="font-display text-2xl lg:text-3xl font-extrabold text-unerd-ink dark:text-white tracking-tight mt-1">
                    Direktori Pengguna & Peserta
                </h1>
            </div>
            <div>
                <button type="button"
                        onclick="document.getElementById('modal-create-user').classList.remove('hidden')"
                        class="inline-flex items-center justify-center h-10 px-4 sm:px-5 bg-unerd-black dark:bg-white hover:bg-unerd-black-active dark:hover:bg-zinc-200 text-white dark:text-unerd-black text-xs font-bold uppercase tracking-wider rounded-md transition cursor-pointer shadow-xs">
                    + Tambah Pengguna Baru
                </button>
            </div>
        </div>
    </x-slot>

    <!-- Filters & Search Toolbar -->
    <x-card variant="white" class="mb-6 p-4">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                <span class="text-xs font-bold uppercase tracking-wider text-unerd-muted dark:text-zinc-400 mr-1">Role:</span>
                <a href="{{ route('admin.users.index', array_filter(['search' => $searchQuery])) }}"
                   class="px-3 py-1.5 rounded-pill text-xs font-bold transition {{ empty($selectedRoleSlug) ? 'bg-unerd-black text-white dark:bg-white dark:text-unerd-black' : 'bg-unerd-surface-card dark:bg-zinc-800 text-unerd-ink dark:text-zinc-200 hover:bg-unerd-surface-strong dark:hover:bg-zinc-700' }}">
                    Semua
                </a>
                @foreach ($roles as $roleOption)
                    <a href="{{ route('admin.users.index', array_filter(['role' => $roleOption->slug, 'search' => $searchQuery])) }}"
                       class="px-3 py-1.5 rounded-pill text-xs font-bold transition {{ $selectedRoleSlug === $roleOption->slug ? 'bg-unerd-black text-white dark:bg-white dark:text-unerd-black' : 'bg-unerd-surface-card dark:bg-zinc-800 text-unerd-ink dark:text-zinc-200 hover:bg-unerd-surface-strong dark:hover:bg-zinc-700' }}">
                        {{ $roleOption->name }}
                    </a>
                @endforeach
            </div>

            <div class="w-full md:w-72">
                <input type="text"
                       name="search"
                       value="{{ $searchQuery }}"
                       placeholder="Cari nama, email, hp..."
                       class="w-full h-10 px-3.5 bg-unerd-surface-soft dark:bg-zinc-800 border border-unerd-hairline dark:border-zinc-700 text-unerd-ink dark:text-white text-xs rounded-md placeholder-unerd-muted dark:placeholder-zinc-500 focus:border-unerd-black dark:focus:border-white focus:ring-1 focus:ring-unerd-black dark:focus:ring-white transition">
            </div>
        </form>
    </x-card>

    <!-- User Table -->
    <x-card variant="white">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-unerd-hairline dark:border-zinc-800 text-[11px] font-bold uppercase tracking-wider text-unerd-muted dark:text-zinc-400">
                        <th class="pb-3.5">Nama & Kontak</th>
                        <th class="pb-3.5">Alamat Email</th>
                        <th class="pb-3.5">Tipe Role / Wewenang</th>
                        <th class="pb-3.5">Komunitas</th>
                        <th class="pb-3.5">Status Akun</th>
                        <th class="pb-3.5">Terdaftar</th>
                        <th class="pb-3.5 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-unerd-hairline dark:divide-zinc-800">
                    @forelse ($users as $userItem)
                        <tr class="hover:bg-unerd-surface-soft dark:hover:bg-zinc-800/60 transition">
                            <td class="py-4">
                                <div class="font-display font-bold text-unerd-ink dark:text-white">{{ $userItem->name }}</div>
                                <div class="text-xs text-unerd-muted dark:text-zinc-400 font-mono mt-0.5">{{ $userItem->phone_number ?: 'Tanpa nomor HP' }}</div>
                            </td>
                            <td class="py-4 font-mono text-xs text-unerd-body-strong dark:text-zinc-300">
                                {{ $userItem->email }}
                            </td>
                            <td class="py-4">
                                @php
                                    $badgeVariant = match($userItem->role?->slug) {
                                        'administrator' => 'black',
                                        'field-sales' => 'volt',
                                        'b2b-client' => 'cobalt',
                                        default => 'concrete',
                                    };
                                @endphp
                                <x-badge :variant="$badgeVariant">
                                    {{ $userItem->role?->name ?? 'None' }}
                                </x-badge>
                            </td>
                            <td class="py-4 text-xs font-medium text-slate-700 dark:text-zinc-300">
                                @if ($userItem->community)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-unerd-volt border border-emerald-200 dark:border-emerald-800/40 font-mono text-[11px]">
                                        {{ $userItem->community->name }}
                                    </span>
                                @else
                                    <span class="text-slate-400 dark:text-zinc-500 font-mono">—</span>
                                @endif
                            </td>
                            <td class="py-4">
                                @if ($userItem->is_blocked)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-rose-100 dark:bg-rose-950 text-rose-800 dark:text-rose-300">
                                        Diblokir
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300">
                                        Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 text-xs text-unerd-muted dark:text-zinc-400">
                                {{ $userItem->created_at->format('d M Y') }}
                            </td>
                            <td class="py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <!-- Toggle Block Action -->
                                    <form method="POST" action="{{ route('admin.users.toggle-block', $userItem) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        @if ($userItem->is_blocked)
                                            <button type="submit"
                                                    class="px-2.5 py-1 text-xs font-bold text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/50 hover:bg-emerald-100 dark:hover:bg-emerald-900 border border-emerald-200 dark:border-emerald-800 rounded transition cursor-pointer">
                                                Aktifkan
                                            </button>
                                        @else
                                            <button type="submit"
                                                    class="px-2.5 py-1 text-xs font-bold text-rose-700 dark:text-rose-300 bg-rose-50 dark:bg-rose-950/50 hover:bg-rose-100 dark:hover:bg-rose-900 border border-rose-200 dark:border-rose-800 rounded transition cursor-pointer">
                                                Blokir
                                            </button>
                                        @endif
                                    </form>

                                    <!-- Edit Role Modal Trigger -->
                                    <button type="button"
                                            onclick="openEditUserModal({{ $userItem->id }}, '{{ addslashes($userItem->name) }}', '{{ addslashes($userItem->email) }}', '{{ addslashes($userItem->phone_number ?? '') }}', {{ $userItem->role_id ?? 'null' }}, {{ $userItem->community_id ?? 'null' }})"
                                            class="px-2.5 py-1 text-xs font-bold text-unerd-ink dark:text-white bg-unerd-surface-card dark:bg-zinc-800 hover:bg-unerd-surface-strong dark:hover:bg-zinc-700 border border-unerd-hairline dark:border-zinc-700 rounded transition cursor-pointer">
                                        Ubah Data
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-unerd-muted dark:text-zinc-500 text-sm">
                                Tidak ada data pengguna yang sesuai dengan kriteria pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </x-card>

    <!-- Modal Create User -->
    <div id="modal-create-user" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-unerd-hairline dark:border-zinc-800 shadow-2xl max-w-lg w-full p-6">
            <div class="flex items-center justify-between pb-4 border-b border-unerd-hairline dark:border-zinc-800">
                <div>
                    <h3 class="font-display text-lg font-bold text-unerd-ink dark:text-white">Tambah Pengguna Baru</h3>
                    <p class="text-xs text-unerd-muted dark:text-zinc-400">Tetapkan role wewenang akun dan komunitas</p>
                </div>
                <button type="button" onclick="document.getElementById('modal-create-user').classList.add('hidden')" class="text-unerd-muted dark:text-zinc-400 hover:text-unerd-ink dark:hover:text-white p-1 rounded-lg">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4 mt-5">
                @csrf

                <div>
                    <x-input-label for="new_name" value="Nama Lengkap" />
                    <x-text-input id="new_name" class="block w-full" type="text" name="name" required placeholder="Nama Lengkap" />
                </div>

                <div>
                    <x-input-label for="new_email" value="Alamat Email" />
                    <x-text-input id="new_email" class="block w-full" type="email" name="email" required placeholder="email@unerd.com" />
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <x-input-label for="new_phone" value="Nomor HP" />
                        <x-text-input id="new_phone" class="block w-full" type="text" name="phone_number" placeholder="0812345678" />
                    </div>

                    <div>
                        <x-input-label for="new_role" value="Tipe Role" />
                        <select id="new_role" name="role_id" required class="h-12 w-full px-3 bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-700 text-unerd-ink dark:text-white text-sm rounded-md focus:border-unerd-black dark:focus:border-white focus:ring-1 focus:ring-unerd-black dark:focus:ring-white">
                            @foreach ($roles as $roleOption)
                                <option value="{{ $roleOption->id }}">{{ $roleOption->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <x-input-label for="new_community" value="Komunitas Lari (Opsional)" />
                    <select id="new_community" name="community_id" class="h-12 w-full px-3 bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-700 text-unerd-ink dark:text-white text-sm rounded-md focus:border-unerd-black dark:focus:border-white focus:ring-1 focus:ring-unerd-black dark:focus:ring-white">
                        <option value="">-- Tanpa Komunitas / Mandiri --</option>
                        @foreach ($communities as $com)
                            <option value="{{ $com->id }}">{{ $com->name }} ({{ $com->city }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="new_password" value="Kata Sandi Sementara" />
                    <x-text-input id="new_password" class="block w-full" type="password" name="password" required placeholder="Minimal 8 karakter" />
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-unerd-hairline dark:border-zinc-800">
                    <x-secondary-button type="button" onclick="document.getElementById('modal-create-user').classList.add('hidden')">
                        Batal
                    </x-secondary-button>
                    <x-primary-button>
                        Simpan Pengguna
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit User Role -->
    <div id="modal-edit-user" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-unerd-hairline dark:border-zinc-800 shadow-2xl max-w-lg w-full p-6">
            <div class="flex items-center justify-between pb-4 border-b border-unerd-hairline dark:border-zinc-800">
                <div>
                    <h3 class="font-display text-lg font-bold text-unerd-ink dark:text-white">Ubah Data & Tipe Role</h3>
                    <p class="text-xs text-unerd-muted dark:text-zinc-400">Perbarui wewenang akun pengguna</p>
                </div>
                <button type="button" onclick="document.getElementById('modal-edit-user').classList.add('hidden')" class="text-unerd-muted dark:text-zinc-400 hover:text-unerd-ink dark:hover:text-white p-1 rounded-lg">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="form-edit-user" method="POST" action="" class="space-y-4 mt-5">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="edit_name" value="Nama Lengkap" />
                    <x-text-input id="edit_name" class="block w-full" type="text" name="name" required />
                </div>

                <div>
                    <x-input-label for="edit_email" value="Alamat Email" />
                    <x-text-input id="edit_email" class="block w-full" type="email" name="email" required />
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <x-input-label for="edit_phone" value="Nomor HP" />
                        <x-text-input id="edit_phone" class="block w-full" type="text" name="phone_number" />
                    </div>

                    <div>
                        <x-input-label for="edit_role" value="Tipe Role" />
                        <select id="edit_role" name="role_id" required class="h-12 w-full px-3 bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-700 text-unerd-ink dark:text-white text-sm rounded-md focus:border-unerd-black dark:focus:border-white focus:ring-1 focus:ring-unerd-black dark:focus:ring-white">
                            @foreach ($roles as $roleOption)
                                <option value="{{ $roleOption->id }}">{{ $roleOption->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <x-input-label for="edit_community" value="Komunitas Lari (Opsional)" />
                    <select id="edit_community" name="community_id" class="h-12 w-full px-3 bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-700 text-unerd-ink dark:text-white text-sm rounded-md focus:border-unerd-black dark:focus:border-white focus:ring-1 focus:ring-unerd-black dark:focus:ring-white">
                        <option value="">-- Tanpa Komunitas / Mandiri --</option>
                        @foreach ($communities as $com)
                            <option value="{{ $com->id }}">{{ $com->name }} ({{ $com->city }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-unerd-hairline dark:border-zinc-800">
                    <x-secondary-button type="button" onclick="document.getElementById('modal-edit-user').classList.add('hidden')">
                        Batal
                    </x-secondary-button>
                    <x-primary-button>
                        Perbarui Data
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditUserModal(id, name, email, phone, roleId, communityId) {
            document.getElementById('form-edit-user').action = '/admin/users/' + id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_phone').value = phone;
            document.getElementById('edit_role').value = roleId;
            document.getElementById('edit_community').value = communityId || '';
            document.getElementById('modal-edit-user').classList.remove('hidden');
        }
    </script>
            document.getElementById('modal-edit-user').classList.remove('hidden');
        }
    </script>
</x-app-layout>
