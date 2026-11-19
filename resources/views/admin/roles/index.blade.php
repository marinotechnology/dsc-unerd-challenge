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
                    Manajemen Tipe Pengguna (RBAC Roles)
                </h1>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
        <!-- Form Create New Role Type (Sticky on Desktop) -->
        <div class="lg:col-span-1">
            <x-card variant="white" class="sticky top-24">
                <div class="pb-4 border-b border-unerd-hairline dark:border-zinc-800 mb-5">
                    <span class="text-[11px] font-bold uppercase tracking-[1.5px] text-unerd-muted dark:text-zinc-400 block mb-1">RBAC Builder</span>
                    <h2 class="font-display text-lg font-bold text-unerd-ink dark:text-white">Buat Tipe User Baru</h2>
                    <p class="text-xs text-unerd-body dark:text-zinc-400 mt-1">
                        Daftarkan tipe wewenang baru dalam ekosistem UNERD MOVE (misal: Race Official, Community Leader).
                    </p>
                </div>

                <form method="POST" action="{{ route('admin.roles.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="role_name" value="Nama Tipe Role" />
                        <x-text-input id="role_name"
                                      class="block w-full"
                                      type="text"
                                      name="name"
                                      :value="old('name')"
                                      required
                                      placeholder="Contoh: Race Marshal / Official Timing" />
                    </div>

                    <div>
                        <x-input-label for="role_slug" value="Slug Identifikasi (Opsional)" />
                        <x-text-input id="role_slug"
                                      class="block w-full font-mono text-xs"
                                      type="text"
                                      name="slug"
                                      :value="old('slug')"
                                      placeholder="otomatis dibuat jika kosong" />
                        <p class="text-[11px] text-unerd-muted dark:text-zinc-500 mt-1">Digunakan untuk validasi middleware role.</p>
                    </div>

                    <div>
                        <x-input-label for="role_description" value="Deskripsi Wewenang & Tugas" />
                        <textarea id="role_description"
                                  name="description"
                                  rows="3"
                                  class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-700 text-unerd-ink dark:text-white text-sm rounded-md placeholder-unerd-muted dark:placeholder-zinc-500 focus:border-unerd-black dark:focus:border-white focus:ring-1 focus:ring-unerd-black dark:focus:ring-white transition shadow-none"
                                  placeholder="Jelaskan peran tugas tipe pengguna ini...">{{ old('description') }}</textarea>
                    </div>

                    <div class="pt-2">
                        <x-primary-button class="w-full text-center">
                            + Simpan Tipe Role Baru
                        </x-primary-button>
                    </div>
                </form>
            </x-card>
        </div>

        <!-- Right Column: List of All Roles -->
        <div class="lg:col-span-2 space-y-6">
            <x-card variant="white">
                <div class="flex items-center justify-between pb-4 border-b border-unerd-hairline dark:border-zinc-800 mb-4">
                    <div>
                        <h2 class="font-display text-lg font-bold text-unerd-ink dark:text-white">Daftar Tipe Role Terdaftar</h2>
                        <p class="text-xs text-unerd-muted dark:text-zinc-400">Seluruh peran core sistem dan peran kustom</p>
                    </div>
                    <span class="text-xs font-mono font-bold text-unerd-muted dark:text-zinc-400">
                        Total: {{ $roles->total() }} Tipe
                    </span>
                </div>

                <div class="space-y-3.5">
                    @foreach ($roles as $role)
                        <div class="p-4 sm:p-5 rounded-lg border border-unerd-hairline dark:border-zinc-800 hover:border-unerd-black dark:hover:border-zinc-600 transition bg-white dark:bg-zinc-900 flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="space-y-1.5 max-w-lg">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-display font-extrabold text-base text-unerd-ink dark:text-white">{{ $role->name }}</h3>
                                    @if ($role->is_system_reserved)
                                        <span class="text-[10px] px-2 py-0.5 rounded bg-zinc-900 dark:bg-zinc-800 text-white font-mono font-bold uppercase">
                                            CORE
                                        </span>
                                    @else
                                        <span class="text-[10px] px-2 py-0.5 rounded bg-lime-200 dark:bg-lime-950 text-lime-900 dark:text-lime-300 font-mono font-bold uppercase">
                                            CUSTOM
                                        </span>
                                    @endif
                                </div>
                                <div class="text-xs text-unerd-muted dark:text-zinc-400 font-mono">
                                    slug: <span class="font-bold text-unerd-body-strong dark:text-zinc-300">{{ $role->slug }}</span>
                                </div>
                                <p class="text-xs text-unerd-body dark:text-zinc-400 leading-relaxed">
                                    {{ $role->description ?: 'Tidak ada deskripsi wewenang tambahan.' }}
                                </p>
                            </div>

                            <div class="flex items-center gap-3 shrink-0 border-t md:border-t-0 pt-3 md:pt-0 border-unerd-hairline dark:border-zinc-800">
                                <a href="{{ route('admin.users.index', ['role' => $role->slug]) }}"
                                   class="px-3 py-1.5 rounded-md bg-unerd-surface-card dark:bg-zinc-800 hover:bg-unerd-surface-strong dark:hover:bg-zinc-700 text-unerd-ink dark:text-white text-xs font-bold transition">
                                    {{ $role->users_count }} User →
                                </a>

                                @if (! $role->is_system_reserved)
                                    <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tipe role ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1.5 rounded-md border border-rose-200 dark:border-rose-900 text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40 text-xs font-bold transition cursor-pointer">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $roles->links() }}
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
