<section>
    <header class="pb-4 border-b border-slate-200 dark:border-white/10">
        <h2 class="text-lg font-bold font-display text-slate-900 dark:text-white uppercase tracking-tight">
            Informasi Profil & Data Pelari
        </h2>
        <p class="mt-1 text-xs text-slate-500 dark:text-zinc-400">
            Perbarui nama lengkap, email, nomor kontak, serta ukuran sepatu UNERD kamu.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-5" x-data="{ selectedSize: {{ old('shoe_size', $user->shoe_size ?? 42) }} }">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-700 dark:text-zinc-300 mb-1.5">
                Nama Lengkap Pelari
            </label>
            <input id="name" name="name" type="text"
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-white/10 bg-slate-50 dark:bg-[#121212] text-slate-900 dark:text-white text-sm focus:border-unerd-volt focus:ring-1 focus:ring-unerd-volt transition"
                   value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            <x-input-error class="mt-1.5" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-700 dark:text-zinc-300 mb-1.5">
                Alamat Email
            </label>
            <input id="email" name="email" type="email"
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-white/10 bg-slate-50 dark:bg-[#121212] text-slate-900 dark:text-white text-sm focus:border-unerd-volt focus:ring-1 focus:ring-unerd-volt transition"
                   value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error class="mt-1.5" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 text-xs">
                    <p class="text-amber-600 dark:text-amber-400">
                        Alamat email belum diverifikasi.
                        <button form="send-verification" class="underline font-bold hover:opacity-80">
                            Kirim ulang email verifikasi.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-1 font-medium text-xs text-emerald-600 dark:text-emerald-400">
                            Tautan verifikasi baru telah dikirim ke email kamu.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- WhatsApp / Phone Number -->
        <div>
            <label for="phone_number" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-700 dark:text-zinc-300 mb-1.5">
                Nomor WhatsApp / HP
            </label>
            <input id="phone_number" name="phone_number" type="tel"
                   placeholder="Contoh: 081234567890"
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-white/10 bg-slate-50 dark:bg-[#121212] text-slate-900 dark:text-white text-sm focus:border-unerd-volt focus:ring-1 focus:ring-unerd-volt transition"
                   value="{{ old('phone_number', $user->phone_number) }}" />
            <x-input-error class="mt-1.5" :messages="$errors->get('phone_number')" />
            <span class="block text-[11px] text-slate-400 dark:text-zinc-500 mt-1 font-mono">
                Digunakan untuk konfirmasi klaim hadiah podium & voucher diskon.
            </span>
        </div>

        <!-- Shoe Size Selection (EU 38 - 45) -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-700 dark:text-zinc-300">
                    Ukuran Sepatu Lari (EU)
                </label>
                <span class="text-xs font-mono font-bold text-emerald-600 dark:text-unerd-volt">
                    Terpilih: EU <span x-text="selectedSize"></span>
                </span>
            </div>

            <!-- Hidden input that submits the value -->
            <input type="hidden" name="shoe_size" :value="selectedSize">

            <div class="grid grid-cols-4 sm:grid-cols-8 gap-2">
                @foreach ([38, 39, 40, 41, 42, 43, 44, 45] as $size)
                    <button type="button"
                            @click="selectedSize = {{ $size }}"
                            class="py-2.5 px-3 rounded-xl border text-xs font-mono font-bold transition flex items-center justify-center cursor-pointer"
                            :class="selectedSize === {{ $size }}
                                ? 'bg-slate-900 dark:bg-unerd-volt text-white dark:text-black border-slate-900 dark:border-unerd-volt shadow-xs'
                                : 'bg-slate-50 dark:bg-white/5 text-slate-700 dark:text-zinc-300 border-slate-200 dark:border-white/10 hover:border-unerd-volt'">
                        EU {{ $size }}
                    </button>
                @endforeach
            </div>
            <x-input-error class="mt-1.5" :messages="$errors->get('shoe_size')" />
            <span class="block text-[11px] text-slate-400 dark:text-zinc-500 mt-1 font-mono">
                Ukuran sepatu ini akan menjadi acuan saat kamu memenangkan hadiah sepatu juara 1 atau voucher diskon.
            </span>
        </div>

        <!-- Submit Button & Feedback -->
        <div class="pt-4 flex items-center gap-4">
            <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-slate-900 text-white dark:bg-unerd-volt dark:text-black font-black font-display text-xs uppercase tracking-wider hover:opacity-90 transition shadow-sm cursor-pointer">
                Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }"
                     x-show="show"
                     x-transition
                     x-init="setTimeout(() => show = false, 3000)"
                     class="text-xs font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Profil berhasil diperbarui.</span>
                </div>
            @endif
        </div>
    </form>
</section>
