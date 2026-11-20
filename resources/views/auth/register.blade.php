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
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-unerd-volt/20 text-unerd-volt border border-unerd-volt/40 text-[11px] font-mono font-bold uppercase tracking-wider mb-4">
                    <span class="w-2 h-2 rounded-full bg-unerd-volt animate-ping"></span>
                    <span>1-Step Registration & Challenge Pass</span>
                </div>
                <h1 class="font-display text-4xl lg:text-6xl font-extrabold tracking-[-2px] leading-[0.98] text-white uppercase">
                    RUN. RECORD. <br>
                    <span class="text-unerd-volt">COMPETE.</span>
                </h1>
                <p class="text-xs uppercase tracking-[3px] font-bold text-zinc-300 font-mono mt-4">
                    GBK JAKARTA • TIME ATTACK CHALLENGE
                </p>

                <!-- 1-Step Benefit Bullets on Desktop -->
                <div class="mt-8 space-y-2.5 pt-6 border-t border-white/10 text-xs text-zinc-300">
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 rounded-full bg-unerd-volt text-black flex items-center justify-center font-bold text-[10px]">✓</span>
                        <span>Akun Pelari & Profil Ukuran Sepatu</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 rounded-full bg-unerd-volt text-black flex items-center justify-center font-bold text-[10px]">✓</span>
                        <span>Otomatis Terdaftar di Time Attack Challenge GBK</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 rounded-full bg-unerd-volt text-black flex items-center justify-center font-bold text-[10px]">✓</span>
                        <span>Terbit Nomor ID Pelari (UMS ID) untuk Booth Start</span>
                    </div>
                </div>
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

            @if ($activePeriod ?? null)
                <!-- Kartu Prominen Challenge Pass (Penanda Jelas Otomatis Join Challenge) -->
                <div class="mb-6 rounded-2xl bg-zinc-950 text-white border-2 border-unerd-volt shadow-xl overflow-hidden relative">
                    <!-- Accent Volt Top Header Strip -->
                    <div class="bg-unerd-volt px-4 py-2 flex items-center justify-between text-black">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-black animate-ping"></span>
                            <span class="font-display font-black text-xs uppercase tracking-wider">
                                Join Challenge
                            </span>
                        </div>
                        <!-- <span class="px-2 py-0.5 rounded bg-black text-unerd-volt text-[10px] font-mono font-black uppercase tracking-wider">
                            Join Challenge
                        </span> -->
                    </div>

                    <!-- Inner Card Details -->
                    <div class="p-4 sm:p-5 space-y-3">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-white/10 pb-3">
                            <div>
                                <div class="text-[10px] font-mono font-bold uppercase tracking-wider text-unerd-volt">
                                    
                                </div>
                                <h3 class="font-display font-black text-base sm:text-lg uppercase text-white mt-0.5">
                                    {{ $activePeriod->cleanName() }}
                                </h3>
                            </div>
                            <div class="inline-flex items-center gap-1.5 self-start sm:self-center px-2.5 py-1 rounded-lg bg-white/10 text-white font-mono font-bold text-xs">
                                <span>🏁</span>
                                <span>Jarak {{ $activePeriod->formattedDistance() }}</span>
                            </div>
                        </div>

                        <!-- 3 Fast Specs Grid -->
                        <div class="grid grid-cols-3 gap-2 text-center text-[11px] font-mono">
                            <div class="p-2 rounded-lg bg-white/5 border border-white/5">
                                <div class="text-[9px] uppercase text-zinc-400 font-bold">LOKASI</div>
                                <div class="font-bold text-white mt-0.5 truncate">
                                    {{ explode(',', $activePeriod->location ?? 'GBK Jakarta')[0] }}
                                </div>
                            </div>
                            <div class="p-2 rounded-lg bg-white/5 border border-white/5">
                                <div class="text-[9px] uppercase text-zinc-400 font-bold">TANGGAL</div>
                                <div class="font-bold text-white mt-0.5">
                                    {{ $activePeriod->event_date ? $activePeriod->event_date->format('d/m/Y') : 'Hari Ini' }}
                                </div>
                            </div>
                            <div class="p-2 rounded-lg bg-white/5 border border-white/5">
                                <div class="text-[9px] uppercase text-zinc-400 font-bold">WAKTU (WIB)</div>
                                <div class="font-bold text-unerd-volt mt-0.5">
                                    {{ $activePeriod->formattedTimeRange() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mb-5">
                <h2 class="font-display text-2xl sm:text-3xl font-extrabold tracking-tight text-unerd-ink dark:text-white">
                    Form Pendaftaran Akun & Challenge
                </h2>
                <p class="text-xs sm:text-sm text-unerd-body dark:text-zinc-400 mt-1">
                    Silakan isi data diri Anda di bawah ini untuk mengaktifkan akun dan mengklaim nomor peserta lari.
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
                <input type="hidden" name="join_challenge" value="{{ request('join_challenge', 1) }}">

                <!-- Role Selector (4 Pilihan: Women, Umum, Community, Pro) -->
                <div>
                    <div class="flex items-center justify-between">
                        <x-input-label value="Pilih Kategori Pelari" class="mb-0" />
                        <span class="text-[10px] text-unerd-volt dark:text-unerd-volt font-mono font-bold uppercase">
                            Leaderboard Terpisah
                        </span>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mt-1.5">
                        <!-- 1. Women -->
                        <label class="relative flex flex-col p-3 rounded-xl border border-unerd-hairline dark:border-zinc-700 cursor-pointer hover:border-unerd-black dark:hover:border-white transition has-[:checked]:border-unerd-black dark:has-[:checked]:border-unerd-volt has-[:checked]:bg-unerd-surface-card dark:has-[:checked]:bg-zinc-800 text-center">
                            <input type="radio" name="role_slug" value="women" x-model="role" class="sr-only">
                            <span class="font-display text-xs font-bold text-unerd-ink dark:text-white block">
                                Women
                            </span>
                            <!-- <span class="text-[10px] text-unerd-muted dark:text-zinc-400 mt-0.5 block">
                                Pelari Wanita
                            </span> -->
                        </label>

                        <!-- 2. Umum -->
                        <label class="relative flex flex-col p-3 rounded-xl border border-unerd-hairline dark:border-zinc-700 cursor-pointer hover:border-unerd-black dark:hover:border-white transition has-[:checked]:border-unerd-black dark:has-[:checked]:border-unerd-volt has-[:checked]:bg-unerd-surface-card dark:has-[:checked]:bg-zinc-800 text-center">
                            <input type="radio" name="role_slug" value="umum" x-model="role" class="sr-only">
                            <span class="font-display text-xs font-bold text-unerd-ink dark:text-white block">
                                Umum
                            </span>
                            <!-- <span class="text-[10px] text-unerd-muted dark:text-zinc-400 mt-0.5 block">
                                Individu {{ $activePeriod ? $activePeriod->formattedDistance() : '3 KM' }}
                            </span> -->
                        </label>

                        <!-- 3. Community -->
                        <label class="relative flex flex-col p-3 rounded-xl border border-unerd-hairline dark:border-zinc-700 cursor-pointer hover:border-unerd-black dark:hover:border-white transition has-[:checked]:border-unerd-black dark:has-[:checked]:border-unerd-volt has-[:checked]:bg-unerd-surface-card dark:has-[:checked]:bg-zinc-800 text-center">
                            <input type="radio" name="role_slug" value="komunitas" x-model="role" class="sr-only">
                            <span class="font-display text-xs font-bold text-unerd-ink dark:text-white block">
                                Community
                            </span>
                            <!-- <span class="text-[10px] text-unerd-muted dark:text-zinc-400 mt-0.5 block">
                                Klub / Run Crew
                            </span> -->
                        </label>

                        <!-- 4. Pro -->
                        <label class="relative flex flex-col p-3 rounded-xl border border-unerd-hairline dark:border-zinc-700 cursor-pointer hover:border-unerd-black dark:hover:border-white transition has-[:checked]:border-unerd-black dark:has-[:checked]:border-unerd-volt has-[:checked]:bg-unerd-surface-card dark:has-[:checked]:bg-zinc-800 text-center">
                            <input type="radio" name="role_slug" value="profesional" x-model="role" class="sr-only">
                            <span class="font-display text-xs font-bold text-unerd-ink dark:text-white block">
                                Pro / Atlet
                            </span>
                            <!-- <span class="text-[10px] text-unerd-muted dark:text-zinc-400 mt-0.5 block">
                                Atlet / Pro
                            </span> -->
                        </label>
                    </div>

                    <!-- Dropdown & Add Komunitas (Only visible when role === 'komunitas') -->
                    <div x-show="role === 'komunitas' || role === 'community'" x-transition class="mt-3 p-3.5 rounded-xl bg-slate-50 dark:bg-zinc-800/60 border border-slate-200 dark:border-zinc-700/60 space-y-1.5">
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

                <!-- Single Password Field -->
                <div x-data="{ showPassword: false }">
                    <x-input-label for="password" value="Kata Sandi" />
                    <div class="relative mt-1">
                        <input id="password"
                               :type="showPassword ? 'text' : 'password'"
                               name="password"
                               required
                               autocomplete="new-password"
                               placeholder="Min. 8 karakter"
                               class="w-full h-11 px-3.5 pr-10 text-sm rounded-md border border-unerd-hairline dark:border-zinc-700 bg-white dark:bg-zinc-900 text-unerd-ink dark:text-zinc-100 placeholder-unerd-muted dark:placeholder-zinc-500 focus:outline-none focus:border-unerd-black dark:focus:border-white focus:ring-1 focus:ring-unerd-black dark:focus:ring-white transition shadow-xs" />
                        <button type="button"
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition focus:outline-none cursor-pointer"
                                aria-label="Toggle password visibility">
                            <svg x-show="!showPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full inline-flex flex-col items-center justify-center py-3.5 px-4 rounded-xl bg-unerd-volt hover:bg-unerd-volt-dark text-unerd-ink transition shadow-lg cursor-pointer group">
                        <span class="font-display font-black text-xs sm:text-sm uppercase tracking-wider flex items-center gap-2">
                            <span>DAFTAR AKUN & Join CHALLENGE</span>
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </span>
                        <!-- <span class="text-[10px] font-medium text-unerd-ink/80 mt-0.5">
                            1x Submit: Akun aktif & otomatis diterbitkan nomor ID Pelari resmi
                        </span> -->
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center text-xs text-unerd-body dark:text-zinc-400">
                Sudah memiliki akun terdaftar?
                <a href="{{ route('login', ['join_challenge' => request('join_challenge', 1)]) }}" class="font-bold text-unerd-ink dark:text-white hover:underline ms-1">
                    Masuk ke Akun
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
