@props([
    'name' => 'community_id',
    'selectedId' => null,
    'selectedName' => '',
    'communities' => [],
    'label' => 'Komunitas Lari Afiliasi',
    'placeholder' => 'Cari nama komunitas lari...',
])

@php
    $communitiesList = collect($communities)->map(fn ($c) => [
        'id' => is_array($c) ? $c['id'] : $c->id,
        'name' => is_array($c) ? $c['name'] : $c->name,
        'city' => is_array($c) ? ($c['city'] ?? 'Jakarta') : ($c->city ?? 'Jakarta'),
    ])->values();

    $initialSelectedId = old($name, $selectedId);
    $initialSelectedName = $selectedName;

    if ($initialSelectedId && empty($initialSelectedName)) {
        $found = $communitiesList->firstWhere('id', (int) $initialSelectedId);
        if ($found) {
            $initialSelectedName = $found['name'];
        }
    }
@endphp

<div x-data="{
        open: false,
        search: '',
        selectedId: @js($initialSelectedId),
        selectedName: @js($initialSelectedName),
        communities: @js($communitiesList),
        isAdding: false,
        addError: '',

        get filtered() {
            if (!this.search.trim()) return this.communities;
            const q = this.search.toLowerCase().trim();
            return this.communities.filter(c =>
                c.name.toLowerCase().includes(q) || (c.city && c.city.toLowerCase().includes(q))
            );
        },

        get canAdd() {
            const q = this.search.trim().toLowerCase();
            if (q.length < 2) return false;
            return !this.communities.some(c => c.name.toLowerCase() === q);
        },

        select(comm) {
            this.selectedId = comm.id;
            this.selectedName = comm.name;
            this.open = false;
            this.search = '';
        },

        clear() {
            this.selectedId = null;
            this.selectedName = '';
            this.search = '';
            this.open = false;
        },

        async addNewCommunity() {
            const name = this.search.trim();
            if (!name) return;

            this.isAdding = true;
            this.addError = '';

            try {
                const response = await fetch('{{ route('communities.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']')?.getAttribute('content') || '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name: name,
                        city: 'Jakarta'
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    this.addError = data.message || 'Gagal menambahkan komunitas';
                    return;
                }

                if (data.community) {
                    this.communities.unshift(data.community);
                    this.select(data.community);
                }
            } catch (err) {
                this.addError = 'Terjadi kesalahan jaringan.';
            } finally {
                this.isAdding = false;
            }
        }
    }"
    @click.outside="open = false"
    class="relative space-y-1.5 text-left">

    <!-- Hidden Input for Standard Form Submissions -->
    <input type="hidden" name="{{ $name }}" :value="selectedId ?? ''">

    <!-- Active Selected Display or Search Input Trigger -->
    <div class="relative">
        <template x-if="selectedId && !open">
            <div class="flex items-center justify-between p-3 rounded-xl border border-unerd-volt/40 bg-unerd-volt/5 dark:bg-unerd-volt/10 transition">
                <div class="flex items-center gap-2.5 min-w-0">
                    <span class="w-7 h-7 rounded-lg bg-unerd-volt text-unerd-ink font-bold flex items-center justify-center shrink-0 text-xs">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </span>
                    <div class="truncate">
                        <span class="block text-xs font-bold text-slate-900 dark:text-white truncate" x-text="selectedName"></span>
                        <span class="block text-[10px] text-slate-500 dark:text-zinc-400">Komunitas Terpilih</span>
                    </div>
                </div>
                <div class="flex items-center gap-1.5 shrink-0">
                    <button type="button" @click="open = true" class="px-2.5 py-1 text-[11px] font-bold rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-200 transition">
                        Ganti
                    </button>
                    <button type="button" @click="clear()" class="p-1 rounded-lg text-slate-400 hover:text-rose-500 transition" title="Hapus Pilihan">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </template>

        <template x-if="!selectedId || open">
            <div class="relative">
                <input type="text"
                       x-model="search"
                       @focus="open = true"
                       @keydown.escape="open = false"
                       placeholder="{{ $placeholder }}"
                       class="block w-full rounded-xl border border-slate-300 dark:border-zinc-700 bg-white dark:bg-[#121212] text-slate-900 dark:text-white px-3.5 py-2.5 pl-9 text-xs sm:text-sm focus:border-unerd-volt focus:ring-1 focus:ring-unerd-volt transition">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <template x-if="search">
                    <button type="button" @click="search = ''" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-zinc-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </template>
            </div>
        </template>
    </div>

    <!-- Dropdown Panel -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute z-50 left-0 right-0 mt-1 max-h-60 overflow-y-auto rounded-xl border border-slate-200 dark:border-zinc-700 bg-white dark:bg-[#181818] shadow-xl p-1.5 text-xs space-y-1">

        <template x-if="addError">
            <div class="p-2 text-[11px] text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/40 rounded-lg" x-text="addError"></div>
        </template>

        <!-- List of filtered communities -->
        <template x-for="comm in filtered" :key="comm.id">
            <button type="button"
                    @click="select(comm)"
                    class="w-full text-left p-2.5 rounded-lg hover:bg-slate-100 dark:hover:bg-zinc-800 flex items-center justify-between group transition">
                <div>
                    <span class="font-bold text-slate-900 dark:text-white block group-hover:text-unerd-volt-dark dark:group-hover:text-unerd-volt" x-text="comm.name"></span>
                    <span class="text-[10px] text-slate-400 dark:text-zinc-500" x-text="comm.city || 'Jakarta'"></span>
                </div>
                <template x-if="selectedId == comm.id">
                    <span class="text-emerald-500 dark:text-unerd-volt font-bold text-xs">&#10003;</span>
                </template>
            </button>
        </template>

        <!-- No matching result -->
        <template x-if="filtered.length === 0 && !canAdd">
            <div class="p-3 text-center text-slate-400 dark:text-zinc-500 text-xs">
                Ketik nama komunitas untuk mencari atau menambahkan...
            </div>
        </template>

        <!-- Add New Community Button -->
        <template x-if="canAdd">
            <div class="pt-1 border-t border-slate-100 dark:border-zinc-800">
                <button type="button"
                        @click="addNewCommunity()"
                        :disabled="isAdding"
                        class="w-full p-2.5 rounded-lg bg-unerd-volt/10 hover:bg-unerd-volt/20 text-slate-900 dark:text-white border border-unerd-volt/30 flex items-center gap-2 text-left transition font-bold">
                    <span class="w-5 h-5 rounded-full bg-unerd-volt text-unerd-ink flex items-center justify-center font-black text-xs shrink-0">+</span>
                    <span class="truncate">
                        Tambahkan komunitas <strong class="text-unerd-volt-dark dark:text-unerd-volt" x-text="'&ldquo;' + search.trim() + '&rdquo;'"></strong>
                    </span>
                    <span x-show="isAdding" class="ml-auto text-[10px] text-slate-400 animate-pulse">Menyimpan...</span>
                </button>
            </div>
        </template>
    </div>
</div>
