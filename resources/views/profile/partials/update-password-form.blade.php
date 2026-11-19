<section>
    <header class="pb-4 border-b border-slate-200 dark:border-white/10">
        <h2 class="text-lg font-bold font-display text-slate-900 dark:text-white uppercase tracking-tight">
            Perbarui Kata Sandi
        </h2>
        <p class="mt-1 text-xs text-slate-500 dark:text-zinc-400">
            Pastikan akun kamu menggunakan kata sandi yang aman dan tidak mudah ditebak.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <label for="update_password_current_password" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-700 dark:text-zinc-300 mb-1.5">
                Kata Sandi Saat Ini
            </label>
            <input id="update_password_current_password" name="current_password" type="password"
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-white/10 bg-slate-50 dark:bg-[#121212] text-slate-900 dark:text-white text-sm focus:border-unerd-volt focus:ring-1 focus:ring-unerd-volt transition"
                   autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1.5" />
        </div>

        <!-- New Password -->
        <div>
            <label for="update_password_password" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-700 dark:text-zinc-300 mb-1.5">
                Kata Sandi Baru
            </label>
            <input id="update_password_password" name="password" type="password"
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-white/10 bg-slate-50 dark:bg-[#121212] text-slate-900 dark:text-white text-sm focus:border-unerd-volt focus:ring-1 focus:ring-unerd-volt transition"
                   autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1.5" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="update_password_password_confirmation" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-700 dark:text-zinc-300 mb-1.5">
                Konfirmasi Kata Sandi Baru
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-white/10 bg-slate-50 dark:bg-[#121212] text-slate-900 dark:text-white text-sm focus:border-unerd-volt focus:ring-1 focus:ring-unerd-volt transition"
                   autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1.5" />
        </div>

        <div class="pt-4 flex items-center gap-4">
            <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-slate-900 text-white dark:bg-unerd-volt dark:text-black font-black font-display text-xs uppercase tracking-wider hover:opacity-90 transition shadow-sm cursor-pointer">
                Simpan Kata Sandi
            </button>

            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }"
                     x-show="show"
                     x-transition
                     x-init="setTimeout(() => show = false, 3000)"
                     class="text-xs font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Kata sandi berhasil diperbarui.</span>
                </div>
            @endif
        </div>
    </form>
</section>
