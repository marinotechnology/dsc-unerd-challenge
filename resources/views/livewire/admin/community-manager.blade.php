<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded font-mono font-bold text-[10px] uppercase tracking-wider bg-slate-100 dark:bg-zinc-800 text-slate-700 dark:text-zinc-300 border border-slate-200 dark:border-zinc-700">
                    MASTER DATA
                </span>
                <span class="text-xs font-mono font-bold text-emerald-600 dark:text-unerd-volt uppercase">
                    KOMUNITAS LARI
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black font-display uppercase tracking-tight text-slate-900 dark:text-white mt-1">
                Manajemen Komunitas Lari
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-zinc-400 mt-0.5">
                Kelola daftar komunitas mitra, kota afiliasi, dan pantau pelari aktif yang terhubung.
            </p>
        </div>

        <button wire:click="openCreateModal"
                type="button"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 text-white dark:bg-unerd-volt dark:text-black font-black text-xs uppercase tracking-wider hover:opacity-90 transition shadow-xs cursor-pointer shrink-0">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Komunitas</span>
        </button>
    </div>

    <!-- Feedback Message Alert -->
    @if ($feedbackMessage)
        <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-900 dark:text-emerald-200 text-xs flex items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 dark:text-unerd-volt shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ $feedbackMessage }}</span>
            </div>
            <button wire:click="$set('feedbackMessage', '')" type="button" class="text-emerald-600 dark:text-emerald-400 font-bold text-sm cursor-pointer">&times;</button>
        </div>
    @endif

    <!-- Search & Filter Card -->
    <div class="p-4 rounded-2xl bg-white dark:bg-[#181818] border border-slate-200 dark:border-zinc-800 shadow-xs">
        <div class="relative">
            <input type="text"
                   wire:model.live.debounce.300ms="search"
                   placeholder="Cari nama komunitas, kota, atau deskripsi..."
                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-zinc-700 bg-slate-50 dark:bg-zinc-900 text-slate-900 dark:text-white placeholder-slate-400 text-xs font-medium focus:border-slate-900 dark:focus:border-unerd-volt focus:ring-0" />
            <svg class="w-4 h-4 absolute left-3.5 top-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>

    <!-- Community Table Card -->
    <div class="rounded-2xl bg-white dark:bg-[#181818] border border-slate-200 dark:border-zinc-800 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 dark:bg-zinc-900/60 font-mono uppercase text-slate-500 dark:text-zinc-400 text-[10px] border-b border-slate-200 dark:border-zinc-800">
                    <tr>
                        <th class="p-4">Komunitas Lari</th>
                        <th class="p-4">Kota Basis</th>
                        <th class="p-4">Deskripsi</th>
                        <th class="p-4 text-center">Anggota Pelari</th>
                        <th class="p-4 text-center">User Akun</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-zinc-800/60">
                    @forelse ($communities as $item)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-zinc-900/40 transition">
                            <td class="p-4">
                                <div class="font-bold text-sm text-slate-900 dark:text-white font-display">
                                    {{ $item->name }}
                                </div>
                                <div class="text-[10px] font-mono text-slate-400 mt-0.5">
                                    {{ $item->slug }}
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold bg-slate-100 dark:bg-zinc-800 text-slate-700 dark:text-zinc-300 border border-slate-200 dark:border-zinc-700">
                                    {{ $item->city ?? 'Jakarta' }}
                                </span>
                            </td>
                            <td class="p-4 max-w-xs text-slate-600 dark:text-zinc-300 truncate">
                                {{ $item->description ?? '—' }}
                            </td>
                            <td class="p-4 text-center font-mono font-bold text-slate-900 dark:text-white">
                                <span class="px-2 py-0.5 rounded bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-unerd-volt border border-emerald-200 dark:border-emerald-800/40">
                                    {{ $item->participants_count }} Pelari
                                </span>
                            </td>
                            <td class="p-4 text-center font-mono text-slate-600 dark:text-zinc-400">
                                {{ $item->users_count }}
                            </td>
                            <td class="p-4 text-right space-x-1.5 whitespace-nowrap">
                                <button wire:click="editCommunity({{ $item->id }})"
                                        type="button"
                                        class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-200 font-bold text-[10px] uppercase tracking-wider transition cursor-pointer">
                                    Edit
                                </button>
                                <button wire:click="deleteCommunity({{ $item->id }})"
                                        wire:confirm="Yakin ingin menghapus komunitas {{ $item->name }}?"
                                        type="button"
                                        class="px-2.5 py-1 rounded-lg bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/40 dark:hover:bg-rose-900/60 text-rose-600 dark:text-rose-300 font-bold text-[10px] uppercase tracking-wider transition cursor-pointer border border-rose-200 dark:border-rose-800/50">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400 text-xs">
                                Tidak ada data komunitas yang sesuai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-200 dark:border-zinc-800">
            {{ $communities->links() }}
        </div>
    </div>

    <!-- Modal Form (Tambah / Edit Komunitas) -->
    @if ($showModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4 z-50 overflow-y-auto">
            <div class="bg-white dark:bg-[#181818] rounded-2xl max-w-lg w-full p-6 space-y-5 border border-slate-200 dark:border-zinc-800 shadow-2xl my-8">
                <!-- Modal Header -->
                <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-zinc-800">
                    <div>
                        <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-slate-400">
                            KOMUNITAS MITRA
                        </span>
                        <h3 class="text-lg font-black font-display uppercase tracking-tight text-slate-900 dark:text-white">
                            {{ $editingCommunityId ? 'Edit Komunitas' : 'Tambah Komunitas Baru' }}
                        </h3>
                    </div>
                    <button wire:click="closeModal" type="button" class="text-slate-400 hover:text-slate-600 dark:hover:text-white text-lg font-bold cursor-pointer">
                        &times;
                    </button>
                </div>

                <!-- Modal Body Form -->
                <div class="space-y-3.5 text-xs">
                    <div>
                        <label class="block font-bold text-slate-700 dark:text-zinc-300 mb-1">
                            Nama Komunitas Lari
                        </label>
                        <input type="text" wire:model.live="name"
                               placeholder="Contoh: Senayan Striders"
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-slate-900 dark:text-white font-medium focus:border-unerd-volt" />
                        @error('name') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 dark:text-zinc-300 mb-1">
                                Slug URL
                            </label>
                            <input type="text" wire:model="slug"
                                   placeholder="senayan-striders"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-slate-900 dark:text-white font-mono text-xs focus:border-unerd-volt" />
                            @error('slug') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 dark:text-zinc-300 mb-1">
                                Kota Basis
                            </label>
                            <input type="text" wire:model="city"
                                   placeholder="Jakarta"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-slate-900 dark:text-white font-medium focus:border-unerd-volt" />
                            @error('city') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 dark:text-zinc-300 mb-1">
                            Deskripsi Komunitas (Opsional)
                        </label>
                        <textarea wire:model="description"
                                  rows="3"
                                  placeholder="Komunitas penggiat lari sub-5 pagi GBK Senayan..."
                                  class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-slate-900 dark:text-white font-medium focus:border-unerd-volt"></textarea>
                        @error('description') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Modal Actions -->
                <div class="pt-3 border-t border-slate-200 dark:border-zinc-800 flex items-center justify-end gap-2.5">
                    <button wire:click="closeModal"
                            type="button"
                            class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-300 font-bold text-xs uppercase tracking-wider transition cursor-pointer">
                        Batal
                    </button>
                    <button wire:click="save"
                            type="button"
                            class="px-5 py-2 rounded-xl bg-slate-900 text-white dark:bg-unerd-volt dark:text-black font-black text-xs uppercase tracking-wider hover:opacity-90 transition cursor-pointer shadow-xs">
                        Simpan Komunitas &rarr;
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
