<x-guest-layout>
    <div class="min-h-screen flex flex-col lg:flex-row bg-unerd-canvas dark:bg-unerd-black transition-colors">
        <!-- Left Editorial Showcase Panel (ONLY ON DESKTOP, HIDDEN ON MOBILE PER REQUEST) -->
        <div class="hidden lg:flex lg:w-1/2 bg-unerd-black text-white p-12 lg:p-16 flex-col justify-between relative overflow-hidden border-r border-zinc-800">
            <!-- Authentic Runner Background Photo -->
            <img src="{{ asset('images/gallery/gallery-1.jpg') }}"
                 alt="UNERD Move GBK Runners"
                 class="absolute inset-0 w-full h-full object-cover filter brightness-90 contrast-110 pointer-events-none" />
            <!-- Clean Background Overlay for Legibility -->
            <div class="absolute inset-0 bg-black/60 pointer-events-none"></div>

            <!-- Top Header with Master Logo for Desktop -->
            <div class="relative z-10 flex items-center justify-between">
                <a href="/" class="inline-flex items-center gap-3">
                    <img src="/images/logos/master-dark.png" alt="UNERD MOVE" class="h-10 w-auto">
                </a>
            </div>

            <!-- Center Editorial Narrative: Super Clean Bold Typography Tagline -->
            <div class="my-auto py-10 relative z-10">
                <h1 class="font-display text-4xl lg:text-6xl font-extrabold tracking-[-2px] leading-[0.98] text-white uppercase">
                    UNERD MOVE <br>
                    <span class="text-unerd-volt">SERIES.</span>
                </h1>
                <p class="text-xs uppercase tracking-[3px] font-bold text-zinc-300 font-mono mt-4">
                    RACE. MOVE. SHARE.
                </p>
            </div>

            <!-- Footer Desktop -->
            <div class="relative z-10 pt-6 border-t border-white/10 text-xs text-zinc-400">
                <span>Race Your Time. Own Your Rank.</span>
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

            @if (request('join_challenge') || ($joinChallenge ?? false))
                <div class="mb-4 inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-unerd-surface-card dark:bg-zinc-900 border border-unerd-hairline dark:border-zinc-800 text-xs shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-unerd-volt shrink-0 animate-pulse"></span>
                    <span class="font-display font-extrabold text-[11px] uppercase tracking-wider text-unerd-ink dark:text-white">
                        Join Challenge
                    </span>
                    <!-- <span class="text-unerd-muted dark:text-zinc-600 font-mono text-[10px]">&bull;</span> -->
                    <!-- <span class="text-unerd-body dark:text-zinc-300 text-[11px]">
                        Masuk untuk lanjut ke pendaftaran event
                    </span> -->
                </div>
            @endif

            <div class="mb-6">
                <h2 class="font-display text-2xl sm:text-3xl font-extrabold tracking-tight text-unerd-ink dark:text-white">
                    Masuk ke UNERD MOVE
                </h2>
                <p class="text-xs sm:text-sm text-unerd-body dark:text-zinc-400 mt-1">
                    Akses history challenge, leaderboard challenge, voucher, dan info produk unerd performance lainnya.
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
                @if (request('join_challenge') || ($joinChallenge ?? false))
                    <input type="hidden" name="join_challenge" value="1">
                @endif

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
                    <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer select-none group">
                        <input id="remember_me"
                               type="checkbox"
                               value="1"
                               class="w-4 h-4 rounded border-slate-300 dark:border-zinc-700 text-slate-900 dark:text-unerd-volt focus:ring-2 focus:ring-slate-900 dark:focus:ring-unerd-volt dark:bg-zinc-900 cursor-pointer transition"
                               name="remember">
                        <span class="text-xs font-medium text-slate-600 dark:text-zinc-300 group-hover:text-slate-900 dark:group-hover:text-white transition">Ingat saya</span>
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
                <a href="{{ route('register', ['join_challenge' => 1]) }}" class="font-bold text-unerd-ink dark:text-white hover:underline ms-1">
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
