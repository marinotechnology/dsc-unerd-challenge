<div class="space-y-6">
    <!-- Live Notification Banner -->
    @if ($feedbackMessage)
        <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-300 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs font-semibold flex items-center justify-between gap-2 shadow-xs transition">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>{{ $feedbackMessage }}</span>
            </div>
            <button wire:click="$set('feedbackMessage', '')" type="button" class="text-xs text-emerald-600 dark:text-emerald-400 hover:opacity-75 font-bold cursor-pointer">
                &times;
            </button>
        </div>
    @endif

    <!-- Control Header -->
    <div class="bg-white dark:bg-[#181818] p-5 sm:p-6 rounded-2xl border border-slate-200 dark:border-zinc-800 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold bg-unerd-volt/15 text-slate-900 dark:text-unerd-volt border border-unerd-volt/30 uppercase tracking-wider">
                    KATALOG PRODUK UNERD
                </span>
                <span class="text-xs font-mono text-slate-500 dark:text-zinc-400">
                    Kategori Statis: Lifestyle, Performance, Women
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black font-display uppercase tracking-tight text-slate-900 dark:text-white mt-1">
                Manajemen Produk Sepatu & Footwear
            </h1>
            <p class="text-xs text-slate-500 dark:text-zinc-400 mt-0.5">
                Kelola koleksi sepatu  UNERD yang ditampilkan di beranda tantangan dan dashboard pelari.
            </p>
        </div>

        <button wire:click="openCreateModal"
                type="button"
                class="px-4 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider bg-slate-900 text-white dark:bg-white dark:text-black hover:opacity-90 transition cursor-pointer flex items-center gap-2 shrink-0 shadow-xs">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Tambah Produk Baru</span>
        </button>
    </div>

    <!-- Search & Category Filter Toolbar -->
    <div class="bg-white dark:bg-[#181818] p-4 sm:p-5 rounded-2xl border border-slate-200 dark:border-zinc-800 shadow-xs space-y-3">
        <div class="flex flex-col md:flex-row gap-3">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text"
                       wire:model.live.debounce.250ms="search"
                       placeholder="Cari produk berdasarkan nama, subtitle, atau kategori..."
                       class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-slate-300 dark:border-zinc-700 bg-slate-50 dark:bg-zinc-900 text-slate-900 dark:text-white text-xs sm:text-sm focus:border-unerd-volt focus:ring-1 focus:ring-unerd-volt transition">
                @if ($search !== '')
                    <button wire:click="$set('search', '')" type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-white cursor-pointer font-bold">
                        &times;
                    </button>
                @endif
            </div>

            <!-- Category Filter Tabs -->
            <div class="flex items-center gap-1.5 overflow-x-auto">
                <button type="button" wire:click="$set('categoryFilter', '')"
                        class="px-3 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition cursor-pointer {{ $categoryFilter === '' ? 'bg-slate-900 text-white dark:bg-white dark:text-black' : 'bg-slate-100 dark:bg-zinc-800 text-slate-600 dark:text-zinc-300 hover:bg-slate-200' }}">
                    Semua
                </button>
                @foreach ($categories as $cat)
                    <button type="button" wire:click="$set('categoryFilter', '{{ $cat }}')"
                            class="px-3 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition cursor-pointer {{ $categoryFilter === $cat ? 'bg-slate-900 text-white dark:bg-white dark:text-black' : 'bg-slate-100 dark:bg-zinc-800 text-slate-600 dark:text-zinc-300 hover:bg-slate-200' }}">
                        {{ $cat }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="bg-white dark:bg-[#181818] rounded-2xl border border-slate-200 dark:border-zinc-800 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 dark:bg-zinc-900/50 border-b border-slate-200 dark:border-zinc-800 text-slate-500 dark:text-zinc-400 uppercase tracking-wider text-[10px] font-bold">
                        <th class="py-3.5 px-4">Foto</th>
                        <th class="py-3.5 px-4">Nama Produk</th>
                        <th class="py-3.5 px-4 text-center">Kategori</th>
                        <th class="py-3.5 px-4 text-right">Harga Normal</th>
                        <th class="py-3.5 px-4 text-right">Harga Diskon (10%)</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-center">Link Toko</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-zinc-800/60">
                    @forelse ($products as $item)
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-zinc-900/40 transition" wire:key="product-row-{{ $item->id }}">
                            <!-- Image Thumbnail -->
                            <td class="py-3.5 px-4 w-16">
                                <div class="w-12 h-12 rounded-xl bg-zinc-100 dark:bg-zinc-800 overflow-hidden border border-slate-200 dark:border-zinc-700 shrink-0">
                                    <img src="{{ asset(ltrim($item->image, '/')) }}" alt="{{ $item->name }}" class="w-full h-full object-cover" />
                                </div>
                            </td>

                            <!-- Name & Subtitle -->
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900 dark:text-white text-sm">{{ $item->name }}</div>
                                <div class="text-[11px] text-slate-400">{{ $item->subtitle }}</div>
                            </td>

                            <!-- Penanda Kategori Statis -->
                            <td class="py-3.5 px-4 text-center">
                                @if ($item->category === 'Performance')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-unerd-volt text-slate-950 border border-unerd-volt/40">
                                        Performance
                                    </span>
                                @elseif ($item->category === 'Lifestyle')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-blue-500/15 text-blue-700 dark:text-blue-300 border border-blue-500/30">
                                        Lifestyle
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-rose-500/15 text-rose-700 dark:text-rose-300 border border-rose-500/30">
                                        Women
                                    </span>
                                @endif
                            </td>

                            <!-- Retail Price -->
                            <td class="py-3.5 px-4 text-right font-mono font-bold text-slate-500 dark:text-zinc-400">
                                {{ $item->formattedPrice() }}
                            </td>

                            <!-- Discounted Price -->
                            <td class="py-3.5 px-4 text-right font-mono font-bold text-emerald-600 dark:text-unerd-volt">
                                {{ $item->formattedDiscountedPrice() }}
                            </td>

                            <!-- Status Toggle -->
                            <td class="py-3.5 px-4 text-center">
                                <button wire:click="toggleStatus({{ $item->id }})"
                                        type="button"
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold border transition cursor-pointer {{ $item->is_active ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/30' : 'bg-slate-100 dark:bg-zinc-800 text-slate-400 border-slate-200 dark:border-zinc-700' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $item->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    <span>{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                </button>
                            </td>

                            <!-- Shopee Link -->
                            <td class="py-3.5 px-4 text-center">
                                @if ($item->shopee_url)
                                    <a href="{{ $item->shopee_url }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-flex items-center gap-1 text-[11px] font-bold text-amber-600 dark:text-unerd-volt hover:underline">
                                        <span>Buka</span>
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>

                            <!-- Action Buttons -->
                            <td class="py-3.5 px-4 text-right space-x-1">
                                <button wire:click="editProduct({{ $item->id }})"
                                        type="button"
                                        class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-zinc-800 text-slate-700 dark:text-zinc-200 text-[10px] font-bold hover:bg-slate-200 transition cursor-pointer">
                                    Edit
                                </button>
                                <button wire:click="deleteProduct({{ $item->id }})"
                                        wire:confirm="Yakin ingin menghapus produk ini dari katalog?"
                                        type="button"
                                        class="px-2.5 py-1 rounded-lg bg-rose-50 dark:bg-rose-950/20 text-rose-600 text-[10px] font-bold hover:bg-rose-100 transition cursor-pointer">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-10 text-center text-xs text-slate-500 dark:text-zinc-400">
                                Tidak ada data produk yang sesuai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-200 dark:border-zinc-800">
            {{ $products->links() }}
        </div>
    </div>

    <!-- MODAL TAMBAH / EDIT PRODUK -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs overflow-y-auto"
             wire:key="modal-product-{{ $editingProductId ?? 'new' }}"
             wire:keydown.escape="closeModal">
            <div class="bg-white dark:bg-[#181818] rounded-2xl border border-slate-200 dark:border-zinc-800 p-6 w-full max-w-xl text-left shadow-2xl space-y-4 my-8">
                <div class="flex items-center justify-between border-b border-slate-200 dark:border-zinc-800 pb-3">
                    <div>
                        <span class="text-[10px] uppercase font-mono font-bold text-slate-400">
                            {{ $editingProductId ? 'EDIT PRODUK' : 'TAMBAH PRODUK BARU' }}
                        </span>
                        <h3 class="font-black uppercase tracking-wider text-base text-slate-900 dark:text-white">
                            {{ $editingProductId ? 'Perbarui Data Produk' : 'Katalog Produk Baru' }}
                        </h3>
                    </div>
                    <button wire:click="closeModal" type="button" class="text-slate-400 hover:text-slate-600 dark:hover:text-white text-lg font-bold cursor-pointer">
                        &times;
                    </button>
                </div>

                <form wire:submit="saveProduct" class="space-y-4 text-xs">
                    <div>
                        <label class="block font-bold text-slate-700 dark:text-zinc-300 mb-1">Nama Produk *</label>
                        <input type="text" wire:model="name" placeholder="Contoh: UNERD Beat Flow Pro"
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-zinc-700 bg-slate-50 dark:bg-zinc-900 text-slate-900 dark:text-white font-medium focus:border-unerd-volt" />
                        @error('name') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 dark:text-zinc-300 mb-1">Kategori Statis *</label>
                            <select wire:model="category"
                                    class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-zinc-700 bg-slate-50 dark:bg-zinc-900 text-slate-900 dark:text-white font-bold focus:border-unerd-volt">
                                <option value="Performance">Performance (Speed & Running)</option>
                                <option value="Lifestyle">Lifestyle (Daily & Recovery)</option>
                                <option value="Women">Women (Active Style)</option>
                            </select>
                            @error('category') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 dark:text-zinc-300 mb-1">Tagline / Subtitle</label>
                            <input type="text" wire:model="subtitle" placeholder="Contoh: Road & Sprint 1 KM"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-zinc-700 bg-slate-50 dark:bg-zinc-900 text-slate-900 dark:text-white font-medium focus:border-unerd-volt" />
                            @error('subtitle') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 dark:text-zinc-300 mb-1">Harga Retail Normal (Rp) *</label>
                            <input type="number" wire:model.live="retailPrice"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-zinc-700 bg-slate-50 dark:bg-zinc-900 text-slate-900 dark:text-white font-mono font-bold focus:border-unerd-volt" />
                            @error('retailPrice') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 dark:text-zinc-300 mb-1">Harga Diskon Peserta 10% (Rp)</label>
                            <input type="number" wire:model="discountedPrice"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-zinc-700 bg-slate-50 dark:bg-zinc-900 text-slate-900 dark:text-white font-mono font-bold focus:border-unerd-volt" />
                            @error('discountedPrice') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 dark:text-zinc-300 mb-1">Upload Foto Produk (Storage)</label>
                        <input type="file" wire:model="imageFile" accept="image/*"
                               wire:key="input-product-image-{{ $editingProductId ?? 'new' }}"
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-zinc-700 bg-slate-50 dark:bg-zinc-900 text-slate-900 dark:text-white text-xs file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-slate-900 file:text-white dark:file:bg-unerd-volt dark:file:text-black hover:file:opacity-90 cursor-pointer" />
                        @error('imageFile') <span class="text-rose-500 text-[10px] block mt-1">{{ $message }}</span> @enderror

                        <div wire:loading wire:target="imageFile" class="text-[10px] font-mono text-emerald-600 dark:text-unerd-volt mt-1">
                            Mengunggah gambar...
                        </div>

                        @if ($imageFile)
                            <div class="mt-2.5 flex items-center gap-3 p-2.5 bg-slate-100 dark:bg-zinc-900 rounded-xl border border-slate-200 dark:border-zinc-800">
                                <img src="{{ $imageFile->temporaryUrl() }}" class="w-14 h-14 object-cover rounded-lg border border-slate-300 dark:border-zinc-700 shrink-0" alt="Preview Baru" />
                                <div class="text-[11px] text-slate-600 dark:text-zinc-300">
                                    <span class="font-bold text-emerald-600 dark:text-unerd-volt block">Foto baru terpilih</span>
                                    <span class="text-[10px] text-slate-400">Siap disimpan ke storage</span>
                                </div>
                            </div>
                        @elseif ($image)
                            <div class="mt-2.5 flex items-center gap-3 p-2.5 bg-slate-100 dark:bg-zinc-900 rounded-xl border border-slate-200 dark:border-zinc-800">
                                <img src="{{ asset(ltrim($image, '/')) }}" class="w-14 h-14 object-cover rounded-lg border border-slate-300 dark:border-zinc-700 shrink-0" alt="Foto Saat Ini" />
                                <div class="text-[11px] text-slate-600 dark:text-zinc-300 truncate max-w-xs">
                                    <span class="font-bold text-slate-800 dark:text-zinc-200 block">Foto produk aktif</span>
                                    <span class="font-mono text-[10px] text-slate-400 truncate block">{{ basename($image) }}</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 dark:text-zinc-300 mb-1">Link Shopee Official Store</label>
                        <input type="url" wire:model="shopeeUrl" placeholder="https://shopee.co.id/..."
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-zinc-700 bg-slate-50 dark:bg-zinc-900 text-slate-900 dark:text-white font-mono text-xs focus:border-unerd-volt" />
                        @error('shopeeUrl') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 dark:text-zinc-300 mb-1">Deskripsi Produk</label>
                        <textarea wire:model="description" rows="3" placeholder="Deskripsi fitur dan keunggulan sepatu..."
                                  class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-zinc-700 bg-slate-50 dark:bg-zinc-900 text-slate-900 dark:text-white font-medium focus:border-unerd-volt"></textarea>
                    </div>

                    <div class="flex items-center gap-2 pt-1">
                        <input type="checkbox" id="isActive" wire:model="isActive" class="rounded border-slate-300 text-slate-900 dark:text-unerd-volt focus:ring-unerd-volt" />
                        <label for="isActive" class="font-bold text-slate-700 dark:text-zinc-300 cursor-pointer">
                            Tampilkan produk di halaman website (Aktif)
                        </label>
                    </div>

                    <div class="pt-3 border-t border-slate-200 dark:border-zinc-800 flex justify-end gap-2">
                        <button wire:click="closeModal" type="button" class="px-4 py-2 rounded-xl border border-slate-200 dark:border-zinc-700 text-xs font-bold text-slate-500 cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-slate-900 text-white dark:bg-white dark:text-black font-black text-xs uppercase tracking-wider transition cursor-pointer">
                            {{ $editingProductId ? 'Simpan Perubahan' : 'Tambah Produk' }} &rarr;
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
