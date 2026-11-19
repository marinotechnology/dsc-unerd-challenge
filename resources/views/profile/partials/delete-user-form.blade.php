<section class="space-y-4">
    <header class="pb-3 border-b border-rose-200 dark:border-rose-900/30">
        <h2 class="text-lg font-bold font-display text-rose-600 dark:text-rose-400 uppercase tracking-tight">
            Hapus Akun Pelari
        </h2>
        <p class="mt-1 text-xs text-slate-500 dark:text-zinc-400">
            Setelah akun kamu dihapus, seluruh data profil, histori lari, dan riwayat voucher akan dihapus secara permanen.
        </p>
    </header>

    <div>
        <button type="button"
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-xs cursor-pointer">
            Hapus Akun Saya
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-white dark:bg-[#1a1a1a] rounded-2xl text-slate-900 dark:text-white">
            @csrf
            @method('delete')

            <h2 class="text-lg font-black font-display uppercase tracking-tight text-slate-900 dark:text-white">
                Apakah kamu yakin ingin menghapus akun?
            </h2>

            <p class="mt-2 text-xs text-slate-600 dark:text-zinc-400 leading-relaxed">
                Tindakan ini tidak dapat dibatalkan. Masukkan kata sandi kamu untuk mengonfirmasi bahwa kamu ingin menghapus akun ini secara permanen.
            </p>

            <div class="mt-5">
                <label for="password" class="sr-only">Kata Sandi</label>
                <input id="password"
                       name="password"
                       type="password"
                       class="w-full sm:w-3/4 px-4 py-2.5 rounded-xl border border-slate-300 dark:border-white/10 bg-slate-50 dark:bg-[#121212] text-slate-900 dark:text-white text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500"
                       placeholder="Masukkan kata sandi kamu" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1.5" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button"
                        x-on:click="$dispatch('close')"
                        class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 text-slate-700 dark:text-slate-300 font-bold text-xs uppercase tracking-wider hover:bg-slate-200 dark:hover:bg-white/10 transition cursor-pointer">
                    Batal
                </button>

                <button type="submit"
                        class="px-5 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-xs cursor-pointer">
                    Hapus Akun Permanen
                </button>
            </div>
        </form>
    </x-modal>
</section>
