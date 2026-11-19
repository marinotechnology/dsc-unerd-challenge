<x-guest-layout>
    <div class="min-h-screen flex flex-col lg:flex-row bg-unerd-canvas dark:bg-unerd-black transition-colors">
        <!-- Left Editorial Showcase Panel (ONLY ON DESKTOP, HIDDEN ON MOBILE PER REQUEST) -->
        <div class="hidden lg:flex lg:w-1/2 bg-unerd-black text-white p-12 lg:p-16 flex-col justify-between relative overflow-hidden border-r border-zinc-800">
            <!-- Authentic Runner Background Photo -->
            <img src="{{ asset('images/gallery/gallery-1.jpg') }}"
                 alt="UNERD Move GBK Runners"
                 class="absolute inset-0 w-full h-full object-cover opacity-25 filter brightness-75 contrast-125 scale-105 pointer-events-none" />
            <!-- Background Overlay for Legibility -->
            <div class="absolute inset-0 bg-black/80 pointer-events-none"></div>

            <!-- Top Header with Master Logo for Desktop -->
            <div class="relative z-10 flex items-center justify-between">
                <a href="/" class="inline-flex items-center gap-3">
                    <img src="/images/logos/master-dark.png" alt="UNERD MOVE" class="h-10 w-auto">
                </a>
                <span class="px-2.5 py-1 rounded-pill bg-white/10 backdrop-blur-xs text-unerd-volt text-[10px] font-mono font-bold uppercase tracking-wider border border-white/10">
                    GBK 1 KM Challenge
                </span>
            </div>

            <!-- Center Editorial Narrative (Audience: Runners) -->
            <div class="my-auto py-10 relative z-10">
                <div class="inline-flex items-center gap-2 mb-4">
                    <span class="px-3 py-1 bg-unerd-volt text-unerd-ink font-display text-[11px] font-extrabold uppercase tracking-[2px] rounded-pill">
                        PILOT ACTIVATION GBK • 21 NOV 2026
                    </span>
                </div>
                <h1 class="font-display text-4xl lg:text-5xl font-extrabold tracking-[-2px] leading-[1.0] text-white mb-4 uppercase">
                    UNERD MOVE <br>
                    <span class="text-unerd-volt">SERIES</span>
                </h1>
                <p class="text-xs uppercase tracking-[3px] font-bold text-zinc-400 mb-6 font-mono">
                    RACE. MOVE. SHARE.
                </p>
                <p class="text-zinc-200 text-sm leading-relaxed max-w-md font-sans">
                    Tantangan lari sprint 1.000 meter di lintasan GBK Jakarta. Catat rekor waktu terbaikmu dengan stopwatch resmi kru, raih posisi puncak di leaderboard kategori, dan menangkan sepatu UNERD serta voucher belanja.
                </p>

                <!-- Fast Highlights -->
                <div class="grid grid-cols-2 gap-3 mt-8 pt-8 border-t border-zinc-800/80 max-w-md text-xs">
                    <div class="flex items-start gap-2.5 p-3 rounded-xl bg-white/5 backdrop-blur-xs border border-white/10">
                        <span class="text-unerd-volt shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <circle cx="12" cy="12" r="10" stroke-width="2"/>
                                <polyline points="12 6 12 12 16 14" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <div>
                            <span class="font-bold text-white block">Official Timing</span>
                            <span class="text-[11px] text-zinc-400">Stopwatch Resmi Panitia</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5 p-3 rounded-xl bg-white/5 backdrop-blur-xs border border-white/10">
                        <span class="text-unerd-volt shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21h8m-4-4v4m-6-17h12a2 2 0 012 2v2a6 6 0 01-6 6h0a6 6 0 01-6-6V4a2 2 0 012-2zm-2 4H2a2 2 0 00-2 2v1a4 4 0 004 4h2m12-7h2a2 2 0 012 2v1a4 4 0 01-4 4h-2" />
                            </svg>
                        </span>
                        <div>
                            <span class="font-bold text-white block">Live Leaderboard</span>
                            <span class="text-[11px] text-zinc-400">Umum, Komunitas & Pro</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5 p-3 rounded-xl bg-white/5 backdrop-blur-xs border border-white/10">
                        <span class="text-unerd-volt shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </span>
                        <div>
                            <span class="font-bold text-white block">Hadiah Sepatu</span>
                            <span class="text-[11px] text-zinc-400">Podium 1 Sepatu Pilihan</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5 p-3 rounded-xl bg-white/5 backdrop-blur-xs border border-white/10">
                        <span class="text-unerd-volt shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                        </span>
                        <div>
                            <span class="font-bold text-white block">Voucher Finisher</span>
                            <span class="text-[11px] text-zinc-400">Diskon 10% Semua Koleksi</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Desktop with Mini Gallery Preview -->
            <div class="relative z-10 pt-6 border-t border-zinc-800/80 text-xs text-zinc-400 flex items-center justify-between">
                <span>"Race Your Time. Own Your Rank."</span>
                <div class="flex items-center -space-x-2">
                    <img src="{{ asset('images/gallery/gallery-2.jpg') }}" alt="Runner GBK" class="w-7 h-7 rounded-full object-cover border-2 border-zinc-900" />
                    <img src="{{ asset('images/gallery/gallery-3.jpg') }}" alt="Runner GBK" class="w-7 h-7 rounded-full object-cover border-2 border-zinc-900" />
                    <img src="{{ asset('images/gallery/gallery-4.jpg') }}" alt="Runner GBK" class="w-7 h-7 rounded-full object-cover border-2 border-zinc-900" />
                </div>
            </div>
        </div>

        <!-- Right / Mobile Main Form Panel (Mobile-first, clean & focused without clutter) -->
        <div class="w-full lg:w-1/2 p-6 sm:p-10 lg:p-16 flex flex-col justify-center max-w-md mx-auto">
            <!-- Mobile Brand Header & Theme Switcher -->
            <div class="flex items-center justify-between pb-6 mb-4 border-b border-unerd-hairline dark:border-zinc-800">
                <a href="/" class="flex items-center gap-2">
                    <!-- Icon logo on mobile, Master logo on desktop -->
                    <x-application-logo />
                </a>
                <x-theme-toggle />
            </div>

            <div class="mb-6">
                <div class="inline-flex items-center gap-2 mb-2">
                    <span class="text-[11px] uppercase tracking-wider text-unerd-muted dark:text-zinc-400 font-bold">
                        UNERD Move Series
                    </span>
                </div>
                <h2 class="font-display text-2xl sm:text-3xl font-extrabold tracking-tight text-unerd-ink dark:text-white">
                    Masuk ke UNERD MOVE
                </h2>
                <p class="text-xs sm:text-sm text-unerd-body dark:text-zinc-400 mt-1">
                    Akses catatan waktu lari, leaderboard komunitas, voucher, dan dashboard peran Anda.
                </p>
            </div>

            <!-- Session Status / Errors -->
            @if (session('status'))
                <div class="mb-5 p-3.5 rounded-md bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 text-xs font-medium">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-md bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-200 text-xs">
                    <div class="font-bold mb-1">Gagal autentikasi:</div>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Clean Mobile-First Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" value="Alamat Email" />
                    <x-text-input id="email"
                                  class="block w-full"
                                  type="email"
                                  name="email"
                                  :value="old('email')"
                                  required
                                  autofocus
                                  autocomplete="username"
                                  placeholder="nama@email.com" />
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <x-input-label for="password" value="Kata Sandi" class="mb-0" />
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs text-unerd-muted dark:text-zinc-400 hover:text-unerd-ink dark:hover:text-white transition">
                                Lupa sandi?
                            </a>
                        @endif
                    </div>
                    <x-text-input id="password"
                                  class="block w-full"
                                  type="password"
                                  name="password"
                                  required
                                  autocomplete="current-password"
                                  placeholder="••••••••" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between pt-1">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me"
                               type="checkbox"
                               class="rounded-xs border-unerd-hairline dark:border-zinc-700 text-unerd-black dark:text-white shadow-none focus:ring-unerd-black dark:focus:ring-white w-4 h-4 cursor-pointer"
                               name="remember">
                        <span class="ms-2 text-xs font-medium text-unerd-body dark:text-zinc-400">Ingat sesi saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <x-primary-button class="w-full text-center">
                        Masuk ke Portal →
                    </x-primary-button>
                </div>
            </form>

            <!-- Register Link -->
            <div class="mt-6 text-center text-xs text-unerd-body dark:text-zinc-400">
                Belum mendaftar UNERD MOVE?
                <a href="{{ route('register') }}" class="font-bold text-unerd-ink dark:text-white hover:underline ms-1">
                    Daftar Peserta Baru
                </a>
            </div>
        </div>
    </div>

    <script>
        function fillCredentials(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
    </script>
</x-guest-layout>
