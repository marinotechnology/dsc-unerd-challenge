<x-guest-layout>
    <div class="py-6 sm:py-10">
        <div class="max-w-xl mx-auto px-4 sm:px-6">
            <!-- Navigation Back (Route Back History) -->
            <div class="mb-6 flex items-center justify-between">
                <a href="{{ url()->previous() ?? route('home') }}"
                   onclick="if (window.history.length > 1) { window.history.back(); return false; }"
                   class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-600 hover:text-slate-900 dark:text-zinc-400 dark:hover:text-white transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Kembali</span>
                </a>
                <span class="text-xs font-mono font-bold text-slate-400 dark:text-zinc-500">{{ $participant->participant_id }}</span>
            </div>

            <!-- DIGITAL RESULT CARD (Clean, Solid, No Gradients) -->
            <div id="resultCard" class="relative bg-slate-900 dark:bg-[#181818] rounded-3xl border-2 border-unerd-volt p-6 sm:p-8 shadow-xl text-white mb-6">
                <!-- Card Header -->
                <div class="flex items-center justify-between border-b border-white/10 pb-4 mb-6">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-unerd-volt"></span>
                        <span class="text-xs font-black tracking-widest uppercase text-unerd-volt">
                            UNERD MOVE SERIES &bull; TIME ATTACK
                        </span>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-md bg-white/10 text-[10px] font-mono font-bold text-slate-300">
                        {{ $result?->period?->cleanName() ?? 'GBK JAKARTA' }}
                    </span>
                </div>

                <!-- Runner Identity -->
                <div class="text-center mb-6">
                    <span class="text-[10px] font-mono uppercase tracking-widest text-slate-400 block font-bold">OFFICIAL RUNNER</span>
                    <h1 class="text-2xl sm:text-3xl font-black text-white uppercase tracking-tight mt-0.5">
                        {{ $participant->display_name }}
                    </h1>
                    <div class="inline-flex flex-wrap items-center justify-center gap-2 mt-1.5 text-xs text-slate-300 font-medium">
                        <span class="font-mono text-unerd-volt font-bold">{{ $participant->participant_id }}</span>
                        <span class="text-slate-500">&bull;</span>
                        <span class="font-mono">EU {{ $participant->shoe_size }}</span>
                        <span class="text-slate-500">&bull;</span>
                        <span>{{ $participant->community ? $participant->community->name : 'Mandiri' }}</span>
                    </div>
                </div>

                <!-- Result Stats Box -->
                @if ($result)
                    <div class="bg-white/5 rounded-2xl border border-white/10 p-5 text-center my-4">
                        <span class="text-[10px] uppercase font-mono tracking-widest text-slate-400 block font-bold">
                            CATATAN WAKTU (3 KM RUN)
                        </span>
                        <div class="text-4xl sm:text-5xl font-black tracking-wider text-unerd-volt font-mono my-2.5">
                            {{ $result->formatted_time }}
                        </div>

                        <div class="grid grid-cols-3 gap-2 pt-3 border-t border-white/10 text-xs">
                            <div>
                                <span class="block text-[10px] uppercase text-slate-400 font-mono">Jarak</span>
                                <span class="font-bold text-white">3.0 KM</span>
                            </div>
                            <div>
                                <span class="block text-[10px] uppercase text-slate-400 font-mono">Pace</span>
                                <span class="font-bold text-white font-mono">{{ $result->formatted_pace }}</span>
                            </div>
                            <div>
                                <span class="block text-[10px] uppercase text-slate-400 font-mono">Peringkat</span>
                                <span class="font-bold text-amber-400 font-mono">#{{ $rank }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Clean Prize / Voucher Badge (if available) -->
                    <div class="my-4 p-3.5 rounded-xl bg-black/40 border border-white/10 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs">
                        <div>
                            <span class="text-[10px] font-mono uppercase text-slate-400 block">Apresiasi & Hadiah Pelari</span>
                            <span class="font-bold text-white block mt-0.5">{{ $prize['title'] ?? 'Finisher UNERD Move' }}</span>
                        </div>
                        <div class="text-left sm:text-right">
                            <span class="text-[10px] font-mono uppercase text-slate-400 block">Kode Voucher</span>
                            <span class="font-mono font-black text-unerd-volt select-all">{{ $voucherCode }}</span>
                        </div>
                    </div>
                @else
                    <div class="bg-amber-500/10 rounded-2xl border border-amber-500/30 p-5 text-center my-4">
                        <p class="text-xs font-bold text-amber-300">Menunggu Verifikasi Waktu</p>
                        <p class="text-[11px] text-slate-400 mt-1">
                            Kamu telah terdaftar. Selesaikan sprint 3 KM di lintasan dan kru akan mencatat waktumu langsung di stopwatch.
                        </p>
                    </div>
                @endif

                <!-- Card Footer: Tagline UNERD Performance -->
                <div class="pt-4 border-t border-white/10 flex items-center justify-between text-xs font-mono">
                    <span class="font-bold text-slate-400 tracking-wider uppercase">Engineered for Every Week Performance</span>
                    <!-- <span class="font-black text-unerd-volt tracking-widest uppercase">RACE. MOVE. SHARE.</span> -->
                </div>
            </div>

            <!-- Share Action Buttons (Native Web Share + WhatsApp + Salin Link) -->
            <div class="space-y-2.5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                    <!-- Native Web Share Button -->
                    <button type="button" onclick="shareResult()"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl font-black text-xs uppercase tracking-wider bg-slate-900 text-white dark:bg-unerd-volt dark:text-black hover:opacity-90 transition shadow-xs cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                        </svg>
                        <span>Bagikan ke Media Sosial</span>
                    </button>

                    <!-- WhatsApp Share Button -->
                    <a href="https://api.whatsapp.com/send?text={{ rawurlencode('Catatan waktu 3 KM ' . $participant->display_name . ' di UNERD Move Series: ' . ($result?->formatted_time ?? '--:--') . '! Cek kartu hasil lengkap di sini: ' . url()->current()) }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl font-black text-xs uppercase tracking-wider bg-emerald-600 hover:bg-emerald-700 text-white transition shadow-xs">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.698.077-1.119-.057-.271-.086-.607-.216-1.045-.407-1.848-.807-3.045-2.677-3.137-2.8-.093-.124-.752-1-.752-1.908s.475-1.355.644-1.539c.17-.184.372-.23.496-.23.125 0 .25.001.359.006.115.005.27-.044.423.322.158.38.54 1.317.587 1.412.048.096.08.209.016.333-.064.124-.096.202-.19.313-.095.111-.2.248-.286.333-.095.095-.195.198-.084.388.111.19.493.813 1.057 1.315.727.647 1.341.847 1.532.942.19.096.302.08.414-.048.112-.128.477-.556.604-.746.128-.19.255-.158.429-.095.174.064 1.107.522 1.298.617.19.095.317.143.364.223.048.079.048.46-.096.865z"/>
                        </svg>
                        <span>Share ke WhatsApp</span>
                    </a>
                </div>

                <!-- Copy Link Button with Notification -->
                <button type="button" onclick="copyCardLink()"
                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-slate-100 hover:bg-slate-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-200 transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    <span id="copyBtnText">Salin Tautan Kartu Hasil</span>
                </button>
            </div>

            <script>
                function shareResult() {
                    if (navigator.share) {
                        navigator.share({
                            title: 'Kartu Hasil Lari - {{ $participant->display_name }}',
                            text: 'Catatan waktu 3 KM: {{ $result?->formatted_time ?? "--:--" }} di UNERD Move Series!',
                            url: window.location.href,
                        }).catch(() => {});
                    } else {
                        copyCardLink();
                    }
                }

                function copyCardLink() {
                    navigator.clipboard.writeText(window.location.href);
                    const btnText = document.getElementById('copyBtnText');
                    if (btnText) {
                        const original = btnText.innerText;
                        btnText.innerText = 'Tautan Berhasil Disalin!';
                        setTimeout(() => { btnText.innerText = original; }, 2500);
                    }
                }
            </script>
        </div>
    </div>
</x-guest-layout>
