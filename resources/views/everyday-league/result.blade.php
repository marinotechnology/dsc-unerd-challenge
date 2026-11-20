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
            <div id="resultCard" class="relative bg-slate-900 dark:bg-[#181818] rounded-3xl border-2 border-unerd-volt p-6 sm:p-8 shadow-xl text-white mb-6 overflow-hidden">
                <!-- Watermark Logo UNERD (Subtle Opacity) -->
                <div class="absolute right-4 bottom-4 pointer-events-none select-none opacity-5">
                    <img src="/images/logos/icon-dark.png" alt="" class="w-36 h-36 object-contain">
                </div>

                <!-- Card Header (Logo di baris atas, Event Name di baris bawahnya) -->
                <div class="flex flex-col items-center justify-center text-center border-b border-white/10 pb-4 mb-6 relative z-10 gap-2.5">
                    <img src="/images/logos/master-dark.png" alt="UNERD" class="h-7 sm:h-8 w-auto object-contain">
                    <span class="px-3.5 py-1 rounded-full bg-white/10 text-[11px] font-mono font-bold text-unerd-volt uppercase tracking-wider">
                        {{ $result?->period?->name ?? 'TIME ATTACK GBK VOL 1' }}
                    </span>
                </div>

                <!-- Runner Identity -->
                <div class="text-center mb-6 relative z-10">
                    <span class="text-[10px] font-mono uppercase tracking-widest text-slate-400 block font-bold">OFFICIAL RUNNER</span>
                    <h1 class="text-2xl sm:text-3xl font-black text-white uppercase tracking-tight mt-1">
                        {{ $participant->display_name }}
                    </h1>
                    <div class="inline-flex flex-wrap items-center justify-center gap-2 mt-2 text-xs text-slate-300 font-medium">
                        <span class="font-mono text-unerd-volt font-bold">{{ $participant->participant_id }}</span>
                        <span class="text-slate-500">&bull;</span>
                        <span class="font-bold text-emerald-400 font-mono">{{ $participant->participant_category ?? 'Umum' }}</span>
                        <span class="text-slate-500">&bull;</span>
                        <span class="font-mono">EU {{ $participant->shoe_size }}</span>
                        <span class="text-slate-500">&bull;</span>
                        <span>{{ $participant->community ? $participant->community->name : 'Mandiri' }}</span>
                    </div>
                </div>

                <!-- Result Stats Box -->
                @if ($result)
                    <div class="bg-white/5 rounded-2xl border border-white/10 p-5 text-center my-4 relative z-10">
                        <span class="text-[10px] uppercase font-mono tracking-widest text-slate-400 block font-bold">
                            CATATAN WAKTU ({{ $activePeriod ? $activePeriod->formattedDistance() : '3 KM' }} RUN)
                        </span>
                        <div class="text-4xl sm:text-5xl font-black tracking-wider text-unerd-volt font-mono my-3">
                            {{ $result->formatted_time }}
                        </div>

                        <div class="grid grid-cols-3 gap-2 pt-4 border-t border-white/10 text-xs">
                            <div>
                                <span class="block text-[10px] uppercase text-slate-400 font-mono">Jarak</span>
                                <span class="font-bold text-white">{{ $activePeriod ? $activePeriod->formattedDistance() : '3.0 KM' }}</span>
                            </div>
                            <div>
                                <span class="block text-[10px] uppercase text-slate-400 font-mono">Pace</span>
                                <span class="font-bold text-white font-mono">{{ $result->formatted_pace }}</span>
                            </div>
                            <div>
                                <span class="block text-[10px] uppercase text-slate-400 font-mono">Peringkat ({{ in_array($participant->participant_category, ['Umum', 'Komunitas'], true) ? 'Umum & Komunitas' : ($participant->participant_category ?? 'Umum') }})</span>
                                <span class="font-bold text-amber-400 font-mono">#{{ $rank }}</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-amber-500/10 rounded-2xl border border-amber-500/30 p-5 text-center my-4 relative z-10">
                        <p class="text-xs font-bold text-amber-300">Menunggu Verifikasi Waktu</p>
                        <p class="text-[11px] text-slate-400 mt-1">
                            Kamu telah terdaftar. Selesaikan sprint {{ $activePeriod ? $activePeriod->formattedDistance() : '3 KM' }} di lintasan dan panitia akan mencatat waktumu langsung di stopwatch.
                        </p>
                    </div>
                @endif

                <!-- Card Footer: Tagline UNERD Performance -->
                <div class="pt-4 border-t border-white/10 flex items-center justify-between text-xs font-mono relative z-10">
                    <span class="font-bold text-slate-400 tracking-wider uppercase">Engineered for Every Week Performance</span>
                    <span class="hidden">{{ $voucherCode }}</span>
                </div>
            </div>

            <!-- Share Action Buttons (Download Story PNG + Native Web Share + Salin Link) -->
            <div class="space-y-2.5">
                <!-- Highlight Utama: Download Kartu Instagram Story PNG (Warna Netral, Bersih & Elegan) -->
                <button type="button" onclick="downloadStoryCard()" id="downloadStoryBtn"
                    class="w-full inline-flex items-center justify-center gap-2.5 px-4 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-slate-900 hover:bg-black text-white dark:bg-white dark:hover:bg-zinc-200 dark:text-black border border-slate-800 dark:border-white/20 transition shadow-xs cursor-pointer">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                    <span id="downloadStoryBtnText">Download Gambar Kartu Story (PNG)</span>
                </button>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                    <!-- Native Web Share Button -->
                    <button type="button" onclick="shareResult()"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl font-bold text-xs uppercase tracking-wider bg-white dark:bg-zinc-900 border border-slate-300 dark:border-zinc-700 text-slate-900 dark:text-white hover:bg-slate-50 dark:hover:bg-zinc-800 transition shadow-xs cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                        </svg>
                        <span>Bagikan ke Media Sosial</span>
                    </button>

                    <!-- Copy Link Button with Notification -->
                    <button type="button" onclick="copyCardLink()"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl font-bold text-xs uppercase tracking-wider bg-white dark:bg-zinc-900 border border-slate-300 dark:border-zinc-700 text-slate-700 dark:text-zinc-300 hover:bg-slate-50 dark:hover:bg-zinc-800 transition cursor-pointer shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <span id="copyBtnText">Salin Tautan Kartu Hasil</span>
                    </button>
                </div>
            </div>

            <!-- Hidden Canvas for Instagram Story generation -->
            <canvas id="storyCanvas" width="1080" height="1920" class="hidden"></canvas>

            <script>
                // Generate and download High-Res 1080x1920 Instagram Story Card
                function downloadStoryCard() {
                    const btnText = document.getElementById('downloadStoryBtnText');
                    const origText = btnText.innerText;
                    btnText.innerText = 'Membuat Gambar Story...';

                    const canvas = document.getElementById('storyCanvas');
                    const ctx = canvas.getContext('2d');

                    // 1. Background gradient (Sleek dark theme with neon volt accent)
                    const bgGrad = ctx.createLinearGradient(0, 0, 0, 1920);
                    bgGrad.addColorStop(0, '#09090b');
                    bgGrad.addColorStop(0.5, '#121214');
                    bgGrad.addColorStop(1, '#09090b');
                    ctx.fillStyle = bgGrad;
                    ctx.fillRect(0, 0, 1080, 1920);

                    // Volt border frame
                    ctx.strokeStyle = '#FED83A';
                    ctx.lineWidth = 14;
                    ctx.strokeRect(40, 40, 1000, 1840);

                    // Inner border subtle
                    ctx.strokeStyle = 'rgba(255, 255, 255, 0.08)';
                    ctx.lineWidth = 2;
                    ctx.strokeRect(60, 60, 960, 1800);

                    // Load Logo image
                    const logoImg = new Image();
                    logoImg.src = '/images/logos/master-dark.png';
                    logoImg.onload = function() {
                        drawContent();
                    };
                    logoImg.onerror = function() {
                        drawContent();
                    };

                    function drawContent() {
                        // 2. Draw Logo at top (Strictly Sized & Centered)
                        const logoW = 180;
                        const logoH = 180;
                        const logoY = 120;
                        try {
                            if (logoImg.complete && logoImg.naturalWidth > 0) {
                                ctx.drawImage(logoImg, 540 - (logoW / 2), logoY, logoW, logoH);
                            } else {
                                ctx.font = '900 44px sans-serif';
                                ctx.fillStyle = '#FFFFFF';
                                ctx.textAlign = 'center';
                                ctx.fillText('UNERD MOVE', 540, logoY + 100);
                            }
                        } catch (e) {
                            ctx.font = '900 44px sans-serif';
                            ctx.fillStyle = '#FFFFFF';
                            ctx.textAlign = 'center';
                            ctx.fillText('UNERD MOVE', 540, logoY + 100);
                        }

                        // Event Badge (Row directly below UNERD Logo, never overlapping)
                        const eventNameY = logoY + logoH + 50; // Y = 350
                        ctx.font = 'bold 26px monospace';
                        ctx.fillStyle = '#FED83A';
                        ctx.textAlign = 'center';
                        ctx.fillText('{{ strtoupper($result?->period?->name ?? "GBK SERIES") }}', 540, eventNameY);

                        // Divider line below event name
                        const dividerY = eventNameY + 40; // Y = 390
                        ctx.strokeStyle = 'rgba(255, 255, 255, 0.15)';
                        ctx.lineWidth = 2;
                        ctx.beginPath();
                        ctx.moveTo(140, dividerY);
                        ctx.lineTo(940, dividerY);
                        ctx.stroke();

                        // 3. Official Runner Title & Name (Clearly Separated)
                        ctx.font = 'bold 22px monospace';
                        ctx.fillStyle = '#A1A1AA';
                        ctx.fillText('OFFICIAL RUNNER', 540, 445);

                        ctx.font = '900 68px sans-serif';
                        ctx.fillStyle = '#FFFFFF';
                        ctx.fillText('{{ strtoupper($participant->display_name) }}', 540, 520);

                        // Runner Meta (ID, Category, Shoe Size)
                        ctx.font = 'bold 28px monospace';
                        ctx.fillStyle = '#FED83A';
                        ctx.fillText('ID: {{ $participant->participant_id }}  •  {{ strtoupper($participant->participant_category ?? "UMUM") }}  •  EU {{ $participant->shoe_size }}', 540, 580);

                        // 4. Main Stats Card (Spacious & Clean Layout)
                        ctx.fillStyle = 'rgba(255, 255, 255, 0.04)';
                        roundRect(ctx, 100, 640, 880, 680, 32);
                        ctx.fill();
                        ctx.strokeStyle = 'rgba(254, 216, 58, 0.4)';
                        ctx.lineWidth = 3;
                        roundRect(ctx, 100, 640, 880, 680, 32);
                        ctx.stroke();

                        ctx.font = 'bold 26px monospace';
                        ctx.fillStyle = '#A1A1AA';
                        ctx.fillText('CATATAN WAKTU RESMI ({{ $activePeriod ? $activePeriod->formattedDistance() : "3 KM" }})', 540, 750);

                        // Big Time Display
                        ctx.font = '900 145px monospace';
                        ctx.fillStyle = '#FED83A';
                        ctx.fillText('{{ $result?->formatted_time ?? "--:--" }}', 540, 930);

                        // 3 Fast Stats (Jarak, Pace, Peringkat)
                        ctx.strokeStyle = 'rgba(255, 255, 255, 0.1)';
                        ctx.lineWidth = 2;
                        ctx.beginPath();
                        ctx.moveTo(140, 1040);
                        ctx.lineTo(940, 1040);
                        ctx.stroke();

                        // Col 1: Jarak
                        ctx.font = 'bold 22px monospace';
                        ctx.fillStyle = '#A1A1AA';
                        ctx.fillText('JARAK', 240, 1110);
                        ctx.font = '900 42px sans-serif';
                        ctx.fillStyle = '#FFFFFF';
                        ctx.fillText('{{ $activePeriod ? $activePeriod->formattedDistance() : "3.0 KM" }}', 240, 1175);

                        // Col 2: Pace
                        ctx.font = 'bold 22px monospace';
                        ctx.fillStyle = '#A1A1AA';
                        ctx.fillText('PACE', 540, 1110);
                        ctx.font = '900 42px monospace';
                        ctx.fillStyle = '#FED83A';
                        ctx.fillText('{{ $result?->formatted_pace ?? "-" }}', 540, 1175);

                        // Col 3: Peringkat
                        ctx.font = 'bold 22px monospace';
                        ctx.fillStyle = '#A1A1AA';
                        ctx.fillText('PERINGKAT', 840, 1110);
                        ctx.font = '900 46px monospace';
                        ctx.fillStyle = '#34D399';
                        ctx.fillText('#{{ $rank }}', 840, 1175);
                        ctx.font = 'bold 18px sans-serif';
                        ctx.fillStyle = '#A1A1AA';
                        ctx.fillText('({{ in_array($participant->participant_category, ["Umum", "Komunitas"], true) ? "Umum & Komunitas" : ($participant->participant_category ?? "Umum") }})', 840, 1220);

                        // 5. Footer Taglines & Hashtags
                        ctx.textAlign = 'center';
                        ctx.font = 'bold 24px monospace';
                        ctx.fillStyle = '#A1A1AA';
                        ctx.fillText('ENGINEERED FOR EVERY WEEK PERFORMANCE', 540, 1460);

                        ctx.font = 'bold 28px sans-serif';
                        ctx.fillStyle = '#FED83A';
                        ctx.fillText('#UNERDMOVE  #RUNWITHUNERD  #TIMEATTACK', 540, 1530);

                        ctx.font = '22px monospace';
                        ctx.fillStyle = '#71717A';
                        ctx.fillText('Leaderboard Live: unerd.id', 540, 1600);

                        // Convert to Blob & Share / Download
                        canvas.toBlob(function(blob) {
                            if (!blob) {
                                btnText.innerText = origText;
                                return;
                            }

                            const fileName = 'UNERD-MOVE-Story-{{ $participant->participant_id }}.png';
                            const file = new File([blob], fileName, { type: 'image/png' });

                            // Check if Mobile supports sharing image file directly (Instagram Stories sheet)
                            if (navigator.canShare && navigator.canShare({ files: [file] })) {
                                navigator.share({
                                    files: [file],
                                    title: 'Hasil Lari UNERD Move - {{ $participant->display_name }}',
                                    text: 'Catatan waktu {{ $activePeriod ? $activePeriod->formattedDistance() : "3 KM" }}: {{ $result?->formatted_time ?? "--:--" }}! Peringkat #{{ $rank }} Kategori {{ $participant->participant_category ?? "Umum" }}. #UNERDMOVE',
                                }).then(() => {
                                    btnText.innerText = 'Berhasil Dibagikan!';
                                    setTimeout(() => { btnText.innerText = origText; }, 2500);
                                }).catch(() => {
                                    triggerDownload(blob, fileName);
                                });
                            } else {
                                triggerDownload(blob, fileName);
                            }
                        }, 'image/png');
                    }

                    function triggerDownload(blob, fileName) {
                        const url = URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = fileName;
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                        URL.revokeObjectURL(url);

                        btnText.innerText = 'Gambar Tersimpan di Galeri/Download!';
                        setTimeout(() => { btnText.innerText = origText; }, 3000);

                        // If user wants to open Instagram
                        setTimeout(() => {
                            window.open('https://www.instagram.com/', '_blank');
                        }, 1200);
                    }

                    function roundRect(ctx, x, y, width, height, radius) {
                        ctx.beginPath();
                        ctx.moveTo(x + radius, y);
                        ctx.lineTo(x + width - radius, y);
                        ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
                        ctx.lineTo(x + width, y + height - radius);
                        ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
                        ctx.lineTo(x + radius, y + height);
                        ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
                        ctx.lineTo(x, y + radius);
                        ctx.quadraticCurveTo(x, y, x + radius, y);
                        ctx.closePath();
                    }
                }

                function shareResult() {
                    if (navigator.share) {
                        navigator.share({
                            title: 'Kartu Hasil Lari - {{ $participant->display_name }}',
                            text: 'Catatan waktu {{ $activePeriod ? $activePeriod->formattedDistance() : "3 KM" }}: {{ $result?->formatted_time ?? "--:--" }} di UNERD Move Series! Peringkat #{{ $rank }} (Kategori {{ $participant->participant_category ?? "Umum" }})',
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
