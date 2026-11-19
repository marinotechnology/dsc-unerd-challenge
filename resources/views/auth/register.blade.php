<x-guest-layout>
    <div class="min-h-screen flex flex-col lg:flex-row bg-unerd-canvas dark:bg-unerd-black transition-colors">
        <!-- Left Editorial Showcase Panel (DESKTOP ONLY) -->
        <div class="hidden lg:flex lg:w-5/12 bg-unerd-black text-white p-12 lg:p-16 flex-col justify-between relative overflow-hidden border-r border-zinc-800">
            <!-- Authentic Runner Background Photo -->
            <img src="{{ asset('images/gallery/gallery-2.jpg') }}"
                 alt="UNERD Move GBK Community Runners"
                 class="absolute inset-0 w-full h-full object-cover opacity-25 filter brightness-75 contrast-125 scale-105 pointer-events-none" />
            <!-- Background Overlay for Legibility -->
            <div class="absolute inset-0 bg-black/80 pointer-events-none"></div>

            <div class="relative z-10 flex items-center justify-between">
                <a href="/" class="inline-flex items-center gap-3">
                    <img src="/images/logos/master-dark.png" alt="UNERD MOVE" class="h-10 w-auto">
                </a>
                <span class="px-2.5 py-1 rounded-pill bg-white/10 backdrop-blur-xs text-unerd-volt text-[10px] font-mono font-bold uppercase border border-white/10">
                    Challenge 2026
                </span>
            </div>

            <div class="my-auto py-10 relative z-10">
                <span class="px-3 py-1 bg-unerd-volt text-unerd-ink font-display text-[11px] font-extrabold uppercase tracking-[2px] rounded-pill inline-block mb-4">
                    REGISTRASI PELARI GBK
                </span>
                <h1 class="font-display text-4xl lg:text-5xl font-extrabold tracking-[-1.5px] leading-[1.0] text-white mb-4 uppercase">
                    RUN. RECORD. <br>
                    <span class="text-unerd-volt">COMPETE.</span>
                </h1>
                <p class="text-xs uppercase tracking-[3px] font-bold text-zinc-400 mb-6 font-mono">
                    GBK JAKARTA • 1 KM SPRINT CHALLENGE
                </p>
                <p class="text-zinc-200 text-sm leading-relaxed max-w-sm font-sans">
                    Daftarkan akun pelarimu untuk mengikuti <span class="text-white font-bold">UNERD Move Series 1 KM Run Challenge</span>, pilih kategori pelari (Umum, Komunitas, atau Profesional), dan pantau catatan waktumu secara live di leaderboard!
                </p>

                <div class="space-y-3 mt-8 pt-8 border-t border-zinc-800/80 max-w-sm text-xs">
                    <div class="flex items-center gap-2.5 text-zinc-300">
                        <span class="w-5 h-5 rounded-full bg-unerd-volt/20 text-unerd-volt flex items-center justify-center shrink-0">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span>Nomor BIB Digital & Tracking Waktu Otomatis</span>
                    </div>
                    <div class="flex items-center gap-2.5 text-zinc-300">
                        <span class="w-5 h-5 rounded-full bg-unerd-volt/20 text-unerd-volt flex items-center justify-center shrink-0">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span>Leaderboard Khusus Sesuai Kategori Pelari</span>
                    </div>
                    <div class="flex items-center gap-2.5 text-zinc-300">
                        <span class="w-5 h-5 rounded-full bg-unerd-volt/20 text-unerd-volt flex items-center justify-center shrink-0">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span>Voucher Diskon Belanja 10% Sepatu UNERD</span>
                    </div>
                </div>
            </div>

            <div class="relative z-10 pt-6 border-t border-zinc-800/80 text-xs text-zinc-400 flex items-center justify-between">
                <span>UNERD MOVE SERIES • GBK Jakarta</span>
                <div class="flex items-center -space-x-2">
                    <img src="{{ asset('images/gallery/gallery-4.jpg') }}" alt="Runner GBK" class="w-7 h-7 rounded-full object-cover border-2 border-zinc-900" />
                    <img src="{{ asset('images/gallery/gallery-5.jpg') }}" alt="Runner GBK" class="w-7 h-7 rounded-full object-cover border-2 border-zinc-900" />
                    <img src="{{ asset('images/gallery/gallery-6.jpg') }}" alt="Runner GBK" class="w-7 h-7 rounded-full object-cover border-2 border-zinc-900" />
                </div>
            </div>
        </div>

        <!-- Right / Mobile Main Form Panel -->
        <div class="w-full lg:w-7/12 p-6 sm:p-10 lg:p-16 flex flex-col justify-center max-w-lg mx-auto">
            <!-- Mobile Brand Header & Theme Switcher -->
            <div class="flex items-center justify-between pb-6 mb-4 border-b border-unerd-hairline dark:border-zinc-800">
                <a href="/" class="flex items-center gap-2">
                    <x-application-logo />
                </a>
                <x-theme-toggle />
            </div>

            <div class="mb-6">
                <div class="inline-flex items-center gap-2 mb-2">
                    <span class="px-2.5 py-0.5 rounded-pill bg-unerd-volt text-unerd-ink font-display text-[10px] font-extrabold uppercase tracking-wider">
                        REGISTRASI PELARI
                    </span>
                    <span class="text-[11px] uppercase tracking-wider text-unerd-muted dark:text-zinc-400 font-bold">
                        1 KM Challenge GBK
                    </span>
                </div>
                <h2 class="font-display text-2xl sm:text-3xl font-extrabold tracking-tight text-unerd-ink dark:text-white">
                    Gabung UNERD MOVE
                </h2>
                <p class="text-xs sm:text-sm text-unerd-body dark:text-zinc-400 mt-1">
                    Pilih kategori pelari dan masukkan ukuran sepatumu untuk mendapatkan rekomendasi produk & nomor BIB resmi.
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-md bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-200 text-xs">
                    <div class="font-bold mb-1">Periksa data registrasi:</div>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Role Selector (3 Pilihan: Umum, Komunitas, Profesional) -->
                <div>
                    <x-input-label value="Pilih Kategori Pelari" />
                    <div class="grid grid-cols-3 gap-2 mt-1.5">
                        <label class="relative flex flex-col p-3 rounded-xl border border-unerd-hairline dark:border-zinc-700 cursor-pointer hover:border-unerd-black dark:hover:border-white transition has-[:checked]:border-unerd-black dark:has-[:checked]:border-unerd-volt has-[:checked]:bg-unerd-surface-card dark:has-[:checked]:bg-zinc-800 text-center">
                            <input type="radio" name="role_slug" value="umum" class="sr-only" {{ old('role_slug', 'umum') === 'umum' ? 'checked' : '' }}>
                            <span class="font-display text-xs font-bold text-unerd-ink dark:text-white block">
                                Umum
                            </span>
                            <span class="text-[10px] text-unerd-muted dark:text-zinc-400 mt-0.5 block">
                                Individu 1 KM
                            </span>
                        </label>

                        <label class="relative flex flex-col p-3 rounded-xl border border-unerd-hairline dark:border-zinc-700 cursor-pointer hover:border-unerd-black dark:hover:border-white transition has-[:checked]:border-unerd-black dark:has-[:checked]:border-unerd-volt has-[:checked]:bg-unerd-surface-card dark:has-[:checked]:bg-zinc-800 text-center">
                            <input type="radio" name="role_slug" value="komunitas" class="sr-only" {{ old('role_slug') === 'komunitas' ? 'checked' : '' }}>
                            <span class="font-display text-xs font-bold text-unerd-ink dark:text-white block">
                                Komunitas
                            </span>
                            <span class="text-[10px] text-unerd-muted dark:text-zinc-400 mt-0.5 block">
                                Klub / Run Crew
                            </span>
                        </label>

                        <label class="relative flex flex-col p-3 rounded-xl border border-unerd-hairline dark:border-zinc-700 cursor-pointer hover:border-unerd-black dark:hover:border-white transition has-[:checked]:border-unerd-black dark:has-[:checked]:border-unerd-volt has-[:checked]:bg-unerd-surface-card dark:has-[:checked]:bg-zinc-800 text-center">
                            <input type="radio" name="role_slug" value="profesional" class="sr-only" {{ old('role_slug') === 'profesional' ? 'checked' : '' }}>
                            <span class="font-display text-xs font-bold text-unerd-ink dark:text-white block">
                                Profesional
                            </span>
                            <span class="text-[10px] text-unerd-muted dark:text-zinc-400 mt-0.5 block">
                                Atlet / Pro
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Name & Shoe Size (Grid) -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="sm:col-span-2">
                        <x-input-label for="name" value="Nama Lengkap Pelari" />
                        <x-text-input id="name"
                                      class="block w-full mt-1"
                                      type="text"
                                      name="name"
                                      :value="old('name')"
                                      required
                                      autofocus
                                      autocomplete="name"
                                      placeholder="Contoh: Pratama Ardiansyah" />
                    </div>

                    <div>
                        <x-input-label for="shoe_size" value="Ukuran Sepatu (EU)" />
                        <select id="shoe_size" name="shoe_size" required class="block mt-1 w-full rounded-md border border-unerd-hairline dark:border-zinc-700 bg-white dark:bg-zinc-900 text-unerd-ink dark:text-white px-3 py-2.5 text-xs sm:text-sm focus:border-unerd-volt focus:ring-1 focus:ring-unerd-volt transition">
                            @foreach (range(38, 45) as $size)
                                <option value="{{ $size }}" {{ old('shoe_size', 42) == $size ? 'selected' : '' }}>EU {{ $size }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Email & Phone (Grid) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <x-input-label for="email" value="Alamat Email" />
                        <x-text-input id="email"
                                      class="block w-full mt-1"
                                      type="email"
                                      name="email"
                                      :value="old('email')"
                                      required
                                      autocomplete="username"
                                      placeholder="nama@email.com" />
                    </div>

                    <div>
                        <x-input-label for="phone_number" value="No. WhatsApp / HP" />
                        <x-text-input id="phone_number"
                                      class="block w-full mt-1"
                                      type="text"
                                      name="phone_number"
                                      :value="old('phone_number')"
                                      placeholder="081234567890" />
                    </div>
                </div>

                <!-- Password & Confirm -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <x-input-label for="password" value="Kata Sandi" />
                        <x-text-input id="password"
                                      class="block w-full mt-1"
                                      type="password"
                                      name="password"
                                      required
                                      autocomplete="new-password"
                                      placeholder="Min. 8 karakter" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" value="Konfirmasi Sandi" />
                        <x-text-input id="password_confirmation"
                                      class="block w-full mt-1"
                                      type="password"
                                      name="password_confirmation"
                                      required
                                      autocomplete="new-password"
                                      placeholder="Ulangi sandi" />
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-3">
                    <x-primary-button class="w-full text-center py-3">
                        Daftar Akun Pelari Sekarang →
                    </x-primary-button>
                </div>
            </form>

            <div class="mt-6 text-center text-xs text-unerd-body dark:text-zinc-400">
                Sudah memiliki akun terdaftar?
                <a href="{{ route('login') }}" class="font-bold text-unerd-ink dark:text-white hover:underline ms-1">
                    Masuk ke Akun
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
