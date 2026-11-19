Keputusan V1 bisa dikunci sebagai acuan tim programmer. Dengan lima keputusan terbaru, UNERD Everyday League sudah punya struktur yang cukup jelas untuk dibuat versi demo pada 19 November dan MVP pada Every Week.

Tetapi saya merevisi tiga hal agar sistemnya tidak keliru sejak awal.

| Keputusan | Evaluasi dan penyempurnaan |
| --- | --- |
| Run 500 m–1 km | Rekomendasi 500 meter. Pilih satu jarak resmi, jangan campur waktu 500 m dan 1 km dalam leaderboard yang sama. Finalisasi bergantung pada lintasan yang diizinkan. |
| Kategori Umum / Komunitas / Pekerja | Dipakai untuk segmentasi peserta dan CRM, bukan otomatis menjadi tiga kategori juara. Peserta juga dapat memilih afiliasi komunitas secara terpisah. |
| Individual + Community + Personal Record | Ketiganya ditampilkan. Namun pada 21 November, Personal Record baru menjadi baseline pertama. Perbandingan peningkatan baru valid setelah percobaan berikutnya dengan jarak yang setara. |
| Custom website | Tepat. Gunakan infrastruktur website UNERD yang ada, tanpa aplikasi atau sistem fitness baru. |
| Hadiah fisik tambahan | Boleh direncanakan, tetapi jangan mencantumkan jenis atau nilai hadiah sebelum disahkan. Tujuh artikel sepatu tetap menjadi display produk, bukan hadiah. |

## Dokumen untuk tim programmer

Writing

# WEBSITE DEVELOPMENT BRIEF — V1 FINAL

## UNERD EVERYDAY LEAGUE

### Pilot: UNERD MOVE SERIES — RUN CHALLENGE

**Presentasi Dewan Komisaris:** 19 November 2026\
**Pilot Activation:** Every Week\
**Lokasi:** Gelora Bung Karno, Jakarta\
**Platform:** Existing Custom Website UNERD\
**Anggaran operasional:** Maksimal Rp2.000.000\
**Tim pelaksana:** 8 orang (tanpa honor tambahan)

**Status:** Final Functional Brief — untuk desain, pembagian tugas, dan persiapan development. Belum ada instruksi eksekusi coding.

---

# 1\. PROJECT OBJECTIVE

UNERD Everyday League adalah program aktivasi komunitas yang bertujuan meningkatkan:

1. **Brand Awareness:** memperkenalkan UNERD sebagai brand sepatu Performance dan Everyday Lifestyle.
2. **Website Traffic:** mendatangkan pengunjung baru melalui kegiatan offline dan penyebaran konten.
3. **Community Engagement:** mendorong partisipasi dan interaksi antarpeserta serta komunitas.
4. **Lead Acquisition & CRM:** mengumpulkan data peserta secara terstruktur dan sesuai persetujuan.
5. **Sales Opportunity:** menghubungkan interaksi komunitas dengan produk serta pembelian melalui website UNERD.

**Batasan strategis:** Website bukan aplikasi fitness. Aktivitas komunitas adalah mekanisme pemasaran untuk mengembangkan brand dan bisnis sepatu UNERD.

---

# 2\. BRAND & PROGRAM HIERARCHY

**Master Brand:** UNERD

**Main Community Platform:** UNERD EVERYDAY LEAGUE

**Challenge Series:** UNERD MOVE SERIES

Terdapat tiga konsep challenge:

| Challenge | Deskripsi | Status 21 Nov |
| --- | --- | --- |
| UNERD Run Challenge | Time attack dengan leaderboard | ACTIVE |
| UNERD Step Challenge | Tantangan langkah harian | COMING SOON |
| UNERD On My Feet | Aktivitas dan foto menggunakan sepatu UNERD | COMING SOON |

Pada pilot pertama, hanya Run Challenge yang bisa dipilih untuk pendaftaran.

Nama UNERD harus selalu terlihat pada landing page, registrasi, leaderboard, kartu hasil, dan product discovery.

---

# 3\. CUSTOMER JOURNEY — END TO END

## STEP 1 — SCAN QR

Peserta melihat QR code pada materi aktivasi di GBK.

QR menuju halaman:

`https://[domain-unerd]/everyday-league`

URL bersifat contoh path, bukan alamat yang sudah dikonfirmasi.

**Tampilan halaman pertama:**

- Logo UNERD.
- Judul: UNERD EVERYDAY LEAGUE.
- Tagline: EVERYDAY COUNTS.
- Hero: UNERD MOVE SERIES — RUN CHALLENGE.
- Deskripsi kompetisi singkat.
- Tombol JOIN THE CHALLENGE.
- Tombol VIEW LEADERBOARD.
- Area pengenalan sepatu UNERD.

**Tracking:** Sistem merekam sumber kunjungan menggunakan UTM atau identifikasi QR campaign.

## STEP 2 — CHOOSE CHALLENGE

Pengunjung melihat tiga kartu challenge.

- Run Challenge dapat dipilih.
- Step Challenge dan On My Feet hanya menampilkan status Coming Soon.

Setelah memilih Run Challenge, peserta melihat:

- Lokasi dan tanggal.
- Jarak resmi setelah finalisasi.
- Aturan challenge dan persyaratan keselamatan.
- Informasi leaderboard dan penghargaan.
- Tombol REGISTER NOW.

Tidak boleh ada informasi hadiah yang belum disetujui.

## STEP 3 — REGISTRATION FORM

Formulir registrasi wajib memiliki field berikut:

| Field | Tipe | Kewajiban |
| --- | --- | --- |
| Nama lengkap | Text | Wajib |
| Nama tampilan leaderboard | Text | Wajib |
| WhatsApp | Phone | Wajib |
| Email | Email | Wajib |
| Ukuran sepatu | Dropdown sesuai size chart UNERD | Wajib |
| Kategori peserta | Dropdown | Wajib |
| Nama komunitas | Pilihan komunitas terdaftar | Opsional |
| Minat produk | Performance / Lifestyle / Belum menentukan | Opsional |

**Kategori peserta:**

- Umum
- Komunitas
- Pekerja

Kategori ini digunakan untuk segmentasi dan analisis audiens. Peserta berkategori Pekerja tetap dapat bergabung dalam leaderboard komunitas melalui pemilihan afiliasi yang terpisah.

**Persetujuan:**

- Persetujuan syarat dan ketentuan challenge.
- Pemberitahuan pemrosesan data pribadi.
- Persetujuan penampilan nama tampilan dan hasil pada leaderboard.
- Checkbox marketing opt-in yang terpisah, tidak dicentang otomatis.

Registrasi harus mudah dilakukan dari ponsel dan tidak memerlukan pembuatan password.

## STEP 4 — REGISTRATION SUCCESS

Setelah submit berhasil:

1. Data peserta tersimpan.
2. Sistem membuat Participant ID unik.
3. Peserta melihat konfirmasi registrasi.
4. Sistem menampilkan nomor peserta dan informasi check-in.
5. Peserta bisa menuju leaderboard.

Contoh Participant ID: `UMS-0001`.

Hindari registrasi ganda melalui pemeriksaan nomor WhatsApp/email pada challenge yang sama. Admin harus dapat menangani pengecualian secara manual.

## STEP 5 — EVENT CHECK-IN

Petugas membuka halaman admin.

Alur:

1. Cari Participant ID.
2. Verifikasi pendaftaran.
3. Ubah status menjadi CHECKED-IN.
4. Peserta diarahkan ke area challenge.

Status peserta:

- Registered
- Checked-in
- Completed
- DNS (tidak hadir)
- DNF (tidak selesai)
- Disqualified, jika diperlukan

## STEP 6 — RUN CHALLENGE

**Rekomendasi format:** Time Attack 500 meter.

Jarak final harus diukur dan disetujui di area GBK yang diizinkan.

Ketentuan:

- Semua peserta mengikuti jarak resmi yang sama.
- Satu percobaan resmi per peserta untuk pilot.
- Stopwatch/manual timing.
- Petugas mencatat hasil.
- Admin memvalidasi hasil sebelum publikasi.
- Peserta dengan status DNF/DNS tidak memperoleh ranking waktu.

Waktu disimpan dalam detik agar mudah dihitung dan diurutkan, lalu ditampilkan dalam format menit:detik.

## STEP 7 — LEADERBOARD

Terdapat tiga tampilan.

### A. Individual Leaderboard

Menampilkan:

- Ranking
- Display name
- Kategori peserta
- Nama komunitas, bila ada
- Waktu resmi

Urutan berdasarkan waktu tercepat yang sudah diverifikasi.

Kategori peserta tidak otomatis memisahkan ranking individual pada pilot.

### B. Community Leaderboard

Menampilkan:

- Ranking komunitas
- Nama komunitas
- Jumlah peserta yang menyelesaikan challenge
- Skor komunitas

**Usulan formula pilot:** rata-rata waktu tiga anggota tercepat yang terverifikasi dari komunitas yang sama.

Syarat minimal tiga finisher. Komunitas yang belum memenuhi syarat tetap dapat terlihat sebagai peserta, tetapi belum masuk ranking kompetitif.

Nama komunitas harus memakai ID atau daftar pilihan agar tidak terjadi duplikasi ejaan.

### C. Personal Record

Menampilkan:

- Participant ID
- Nama tampilan
- Waktu terbaik peserta
- Tanggal dan nama challenge
- Riwayat waktu, ketika tersedia

**Pada pilot pertama:** waktu menjadi BASELINE RECORD.

Personal improvement baru dihitung ketika peserta mengikuti challenge berikutnya dengan jarak dan aturan yang sebanding.

Jangan membuat data peningkatan fiktif untuk peserta baru.

## STEP 8 — SHARE RESULTS

Peserta dapat melihat kartu pencapaian digital berisi:

- Logo UNERD
- UNERD EVERYDAY LEAGUE
- UNERD RUN CHALLENGE
- Nama tampilan peserta
- Catatan waktu
- Ranking
- Tanggal event
- Ajakan mengunjungi program UNERD

Untuk MVP, kartu hasil cukup dapat di-screenshot dan dibagikan. Otomatisasi gambar dan integrasi Instagram bukan kebutuhan wajib.

## STEP 9 — PRODUCT DISCOVERY

Di bawah leaderboard atau hasil personal, wajib ada modul produk:

**YOUR NEXT MOVE STARTS WITH UNERD.**

Menampilkan akses ke:

- UNERD Performance
- UNERD Lifestyle
- UNERD Women

Tujuh artikel yang tersedia secara fisik digunakan untuk product display di lokasi. Bila masing-masing mempunyai halaman produk, dapat ditambahkan QR produk untuk mengukur ketertarikan pengunjung.

Setiap tombol produk menuju katalog/halaman produk UNERD yang sudah aktif.

Website tidak perlu membuat checkout baru.

## STEP 10 — NEXT CHALLENGE & RETENTION

Di bagian bawah halaman tampilkan:

**YOUR NEXT CHALLENGE STARTS HERE.**

Pengunjung dapat menyatakan minat untuk mengikuti challenge berikutnya.

Tidak perlu menjanjikan jadwal mingguan tertentu sebelum disetujui.

---

# 4\. DATA ARCHITECTURE

Programmer harus menyiapkan empat kelompok data.

### TABLE A — PARTICIPANTS

- participant\_id
- full\_name
- display\_name
- whatsapp
- email
- shoe\_size
- participant\_category
- community\_id
- product\_interest
- marketing\_consent
- consent\_timestamp
- consent\_version
- registration\_timestamp
- acquisition\_source

### TABLE B — CHALLENGES

- challenge\_id
- challenge\_name
- challenge\_type
- event\_date
- distance\_meter
- location
- challenge\_status

### TABLE C — RESULTS

- result\_id
- participant\_id
- challenge\_id
- checkin\_status
- completion\_status
- recorded\_time\_seconds
- verified\_time\_seconds
- verification\_status
- verified\_by
- recorded\_at

Ranking dihitung dari hasil yang sudah disahkan dan tidak perlu disimpan sebagai nilai tetap.

### TABLE D — ACTIVITY EVENTS

Data aktivitas minimal:

- campaign\_view
- challenge\_selected
- registration\_started
- registration\_completed
- leaderboard\_view
- result\_view
- share\_result\_click
- product\_click
- purchase, bila tracking tersedia

Setiap event memerlukan timestamp dan sumber kunjungan bila tersedia.

**Penting:** aktivitas website harus menggunakan identitas analytics yang sesuai. Jangan mengirim nomor WhatsApp atau email ke sistem analytics sebagai parameter publik.

---

# 5\. CRM FRAMEWORK

Data digunakan untuk membentuk segmen:

| Segmen | Definisi |
| --- | --- |
| Visitor | Mengakses halaman campaign |
| Registrant | Menyelesaikan pendaftaran |
| Active Member | Mengikuti challenge |
| Product Prospect | Menunjukkan minat melalui product click |
| Marketing Lead | Memberikan marketing opt-in |
| Customer | Melakukan pembelian teratribusi |

Segmen tersebut boleh saling tumpang tindih. Status pembelian bukan pengganti status komunitas.

**Data flow:**

Website Registration → Secure Database → Challenge Results → CRM Segmentation → Product Interest → Sales Tracking.

Database harus dapat diekspor CSV. Akses terbatas bagi admin berwenang.

Kebijakan retensi dan penghapusan data pribadi, serta pemberitahuan privasi, perlu disahkan sebelum website menerima data nyata.

**Tidak termasuk scope:** automated WhatsApp blast, chatbot, loyalty points, CRM berbayar baru, atau integrasi fitness tracker.

---

# 6\. ADMIN DASHBOARD — MVP

Programmer membuat admin sederhana dengan fungsi:

1. Melihat seluruh peserta.
2. Search berdasarkan Participant ID, nama, atau kontak.
3. Update check-in.
4. Memasukkan hasil waktu.
5. Verifikasi atau koreksi hasil.
6. Mengatur komunitas peserta.
7. Melihat leaderboard individual dan komunitas.
8. Mengekspor data.
9. Melihat ringkasan statistik campaign.

Admin membutuhkan login yang aman. Halaman publik tidak boleh menampilkan database pribadi.

Apabila development dashboard penuh terlalu berat, boleh menggunakan back-office yang sudah tersedia di custom website selama seluruh fungsi minimum terpenuhi.

---

# 7\. KPI & ANALYTICS

### Primary KPI — Pilot 21 November

**Awareness**

- Konten yang membagikan campaign
- Brand mentions
- Reach konten yang dapat diukur
- Brand recall sederhana melalui survei singkat

**Website**

- Unique campaign visitors
- Registration conversion rate
- Leaderboard views
- New vs returning visitors, jika tersedia

**Community**

- Registered participants
- Checked-in participants
- Completed challenges
- Jumlah komunitas aktif
- Minat mengikuti challenge berikutnya

### Secondary KPI — Commercial

- Product click-through rate
- Add-to-cart, jika tracking tersedia
- Purchase conversion
- Revenue teratribusi
- Marketing opt-in rate
- Cost per registered participant
- Cost per product lead

Contoh definisi:

Registration Rate = Completed Registrations / Unique Landing Page Visitors × 100%

Product Interest Rate = Unique Product Clickers / Unique Campaign Visitors × 100%

Sales Conversion Rate = Attributed Buyers / Unique Campaign Visitors × 100%

Sumber pembelian harus dapat ditelusuri secara wajar melalui campaign attribution, bukan dengan mengklaim semua pembeli pada hari tersebut berasal dari event.

---

# 8\. TECHNICAL PRIORITIES

### P0 — Wajib berfungsi 21 November

- Mobile-responsive campaign landing page.
- QR campaign attribution.
- Pemilihan Run Challenge.
- Form registrasi dan validasi.
- Database peserta.
- Participant ID.
- Check-in admin.
- Input dan verifikasi hasil.
- Individual leaderboard.
- Community leaderboard.
- Personal baseline record.
- Link produk UNERD.
- Tracking interaksi inti.
- Export CSV.
- Pengamanan dan pemberitahuan privasi.

### P1 — Bila memungkinkan

- Digital achievement card yang mudah dibagikan.
- Individual result page dengan tautan aman.
- Minat mengikuti challenge selanjutnya.
- Ringkasan dashboard KPI.

### OUT OF SCOPE — Tidak dibangun sekarang

- GPS tracking.
- Smartwatch integration.
- Automatic step counter.
- Upload foto dan moderasi UGC.
- Loyalty engine.
- Sistem level/badge kompleks.
- Aplikasi mobile.
- Sistem pembayaran baru.
- CRM automation penuh.

---

# 9\. DELIVERY PLAN

### 19 NOVEMBER — PITCH DEMO

Yang harus bisa ditunjukkan:

1. Homepage campaign.
2. Choose challenge.
3. Form pendaftaran.
4. Registration success.
5. Individual dan community leaderboard.
6. Personal record page.
7. Product discovery.
8. Diagram penyimpanan data dan CRM.

Data simulasi harus diberi label DEMO.

**Demo komisaris tidak harus terhubung ke database produksi.**

### 20 NOVEMBER — FUNCTIONAL TESTING

Uji dari ponsel:

- QR → Website.
- Register → Data tersimpan.
- Registrasi duplikat.
- Participant ID.
- Admin check-in.
- Input dan verifikasi waktu.
- Ranking individual dan komunitas.
- Export data.
- Product link dan checkout.
- Analytics dan consent.

### 21 NOVEMBER — LIVE PILOT

- Registrasi peserta.
- Check-in.
- Run challenge.
- Pencatatan hasil.
- Leaderboard.
- Product discovery.
- Dokumentasi, CRM, dan evaluasi.

---

# 10\. ACCEPTANCE CRITERIA

Website layak live apabila:

- Registrasi tidak kehilangan data.
- ID peserta unik.
- Formulir dan consent berfungsi.
- Hasil yang belum diverifikasi tidak muncul di ranking.
- Ranking hanya membandingkan jarak yang sama.
- Community ranking mengikuti formula yang disahkan.
- Personal record pilot ditandai sebagai baseline.
- Nomor WhatsApp/email tidak muncul secara publik.
- Admin bisa mengekspor data dan memulihkan pencatatan bila terjadi gangguan.
- Link produk dan checkout telah diuji.
- Tracking traffic dan registrasi dapat dibaca.
- Tampilan berfungsi pada ponsel.

---

# 11\. IMPLEMENTATION CONSTRAINTS

Anggaran operasional pilot maksimal Rp2 juta.

Delapan anggota tim pelaksana tidak menerima honor tambahan dari anggaran ini.

Tujuh artikel sepatu berfungsi sebagai display.

Hadiah fisik tambahan belum ditentukan. Sistem tidak boleh menjanjikan bentuk atau nilai hadiah sebelum disahkan.

Seluruh development harus memanfaatkan platform custom website yang sudah tersedia sejauh memungkinkan.

**Prinsip final: bangun sistem yang cukup untuk menguji awareness, community acquisition, traffic, leads, dan product interest — bukan membangun platform fitness lengkap.**

**END OF WEBSITE BRIEF V1.0**

## Diagram alur untuk programmer

QR GBK / Community / Social Media

UNERD Website — Everyday League

Choose Challenge → Registration

Secure Participant Database

Event & Results

Check-in, waktu, leaderboard

CRM & Analytics

Segmentasi, lead, opt-in

UNERD Product Discovery

Product Click → Checkout → Sales Attribution

## Empat hal yang tetap harus diputuskan tim sebelum live

Brief fungsional sudah final. Namun saya tidak akan menganggap spesifikasi lapangannya selesai sampai empat hal ini dipastikan.

| Keputusan | Rekomendasi |
| --- | --- |
| Jarak resmi | 500 meter, jika diizinkan dan lintasan aman; jika tidak, satu jarak alternatif yang konsisten |
| Formula community leaderboard | Rata-rata tiga waktu tercepat tiap komunitas, minimum tiga finisher |
| Hadiah fisik | Tetapkan jenis, jumlah, kategori pemenang, dan nilai maksimum dari anggaran |
| Integrasi website | Konfirmasi database, admin login, analytics, dan hubungan dengan sistem checkout existing |

Dari delapan anggota tim, saya juga merekomendasikan satu orang menjadi PIC tunggal website dan database, sehingga hasil registrasi, verifikasi lomba, dan ekspor data tidak dikelola oleh banyak orang tanpa kontrol.

### Pesan singkat untuk programmer

> “Kita tidak membangun aplikasi fitness. Kita membangun satu campaign page milik UNERD yang bisa menerima peserta melalui QR, menyimpan data, menjalankan challenge dengan leaderboard, mengukur traffic, dan mengarahkan pengunjung ke produk sepatu. Demo untuk komisaris harus memperlihatkan keseluruhan pengalaman, sedangkan MVP tanggal 21 November cukup menjalankan fungsi inti dengan stabil.”

Kesimpulan: V1 ini sudah cukup sebagai functional specification untuk tim website dan dasar demo komisaris. Tidak ada coding atau perubahan pada website yang saya lakukan.

If you want, I can:

- Define final prize details and categories
- Confirm official race distance and safety approval
- Establish website integration and admin workflow