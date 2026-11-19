<x-guest-layout>
    <div class="min-h-screen flex flex-col lg:flex-row bg-unerd-canvas dark:bg-unerd-black transition-colors">
        <!-- Left Editorial Showcase Panel (DESKTOP ONLY) -->
        <div class="hidden lg:flex lg:w-5/12 bg-unerd-black text-white p-12 lg:p-16 flex-col justify-between relative overflow-hidden border-r border-zinc-800">
            <!-- Authentic Runner Background Photo -->
            <img src="{{ asset('images/gallery/gallery-2.jpg') }}"
                 alt="UNERD Move GBK Community Runners"
                 class="absolute inset-0 w-full h-full object-cover filter brightness-90 contrast-110 pointer-events-none" />
            <!-- Clean Background Overlay for Legibility -->
            <div class="absolute inset-0 bg-black/60 pointer-events-none"></div>

            <div class="relative z-10 flex items-center justify-between">
                <a href="/" class="inline-flex items-center gap-3">
                    <img src="/images/logos/master-dark.png" alt="UNERD MOVE" class="h-10 w-auto">
                </a>
            </div>

            <div class="my-auto py-10 relative z-10">
                <h1 class="font-display text-4xl lg:text-6xl font-extrabold tracking-[-2px] leading-[0.98] text-white uppercase">
                    RUN. RECORD. <br>
                    <span class="text-unerd-volt">COMPETE.</span>
                </h1>
                <p class="text-xs uppercase tracking-[3px] font-bold text-zinc-300 font-mono mt-4">
                    GBK JAKARTA • TIME ATTACK CHALLENGE
                </p>
            </div>

            <div class="relative z-10 pt-6 border-t border-white/10 text-xs text-zinc-400">
                <span>UNERD MOVE SERIES • TIME ATTACK</span>
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
                <h2 class="font-display text-2xl sm:text-3xl font-extrabold tracking-tight text-unerd-ink dark:text-white">
                    Gabung UNERD MOVE
                </h2>
                <p class="text-xs sm:text-sm text-unerd-body dark:text-zinc-400 mt-1">
                    Pilih kategori pelari dan masukkan ukuran sepatumu untuk join challenge & rekomendasi sepatu performace buat kamu.
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

            <form method="POST" action="{{ route('register') }}" class="space-y-4" x-data="{ role: '{{ old('role_slug', 'umum') }}' }">
                @csrf

                <!-- Role Selector (3 Pilihan: Umum, Komunitas, Profesional) -->
                <div>
                    <x-input-label value="Pilih Kategori Pelari" />
                    <div class="grid grid-cols-3 gap-2 mt-1.5">
                        <label class="relative flex flex-col p-3 rounded-xl border border-unerd-hairline dark:border-zinc-700 cursor-pointer hover:border-unerd-black dark:hover:border-white transition has-[:checked]:border-unerd-black dark:has-[:checked]:border-unerd-volt has-[:checked]:bg-unerd-surface-card dark:has-[:checked]:bg-zinc-800 text-center">
                            <input type="radio" name="role_slug" value="umum" x-model="role" class="sr-only">
                            <span class="font-display text-xs font-bold text-unerd-ink dark:text-white block">
                                Umum
                            </span>
                            <span class="text-[10px] text-unerd-muted dark:text-zinc-400 mt-0.5 block">
                                Individu 1 KM
                            </span>
                        </label>

                        <label class="relative flex flex-col p-3 rounded-xl border border-unerd-hairline dark:border-zinc-700 cursor-pointer hover:border-unerd-black dark:hover:border-white transition has-[:checked]:border-unerd-black dark:has-[:checked]:border-unerd-volt has-[:checked]:bg-unerd-surface-card dark:has-[:checked]:bg-zinc-800 text-center">
                            <input type="radio" name="role_slug" value="komunitas" x-model="role" class="sr-only">
                            <span class="font-display text-xs font-bold text-unerd-ink dark:text-white block">
                                Komunitas
                            </span>
                            <span class="text-[10px] text-unerd-muted dark:text-zinc-400 mt-0.5 block">
                                Klub / Run Crew
                            </span>
                        </label>

                        <label class="relative flex flex-col p-3 rounded-xl border border-unerd-hairline dark:border-zinc-700 cursor-pointer hover:border-unerd-black dark:hover:border-white transition has-[:checked]:border-unerd-black dark:has-[:checked]:border-unerd-volt has-[:checked]:bg-unerd-surface-card dark:has-[:checked]:bg-zinc-800 text-center">
                            <input type="radio" name="role_slug" value="profesional" x-model="role" class="sr-only">
                            <span class="font-display text-xs font-bold text-unerd-ink dark:text-white block">
                                Profesional
                            </span>
                            <span class="text-[10px] text-unerd-muted dark:text-zinc-400 mt-0.5 block">
                                Atlet / Pro
                            </span>
                        </label>
                    </div>

                    <!-- Dropdown & Add Komunitas (Only visible when role === 'komunitas') -->
                    <div x-show="role === 'komunitas'" x-transition class="mt-3 p-3.5 rounded-xl bg-slate-50 dark:bg-zinc-800/60 border border-slate-200 dark:border-zinc-700/60 space-y-1.5">
                        <x-input-label value="Pilih atau Tambah Komunitas Lari" />
                        <x-community-select :communities="$communities ?? []" :selected-id="old('community_id')" />
                        <p class="text-[10px] text-slate-500 dark:text-zinc-400">
                            Cari komunitasmu atau ketik nama baru lalu klik tambah jika belum terdaftar.
                        </p>
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
                        <x-input-label for="shoe_size" value="Ukuran Sepatu" />
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
