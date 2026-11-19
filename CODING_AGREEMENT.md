### 1. Struktur Folder & Fleksibilitas Ekstensi (Flat, Modular, & Extensible)

Penambahan folder baru diperbolehkan dengan aturan ketat: harus merepresentasikan domain fungsional yang jelas, tidak boleh membuat subfolder bertingkat lebih dari 2 level (maksimal `app/Domain/Subdomain`), dan dilarang membuat folder penampung umum yang ambigu (seperti `app/Misc`, `app/Helpers`, atau `app/Utils`).

```
app/
├── Actions/                  <-- Tempat logika bisnis tunggal (Single Responsibility)
│   ├── Orders/               <-- Dikelompokkan per domain fitur
│   │   ├── CreateOrderAction.php
│   │   └── ApproveCreditLimitAction.php
│   ├── Invoices/
│   │   └── GenerateInvoicePdfAction.php
│   └── Visits/
│       └── ValidateGeofenceAction.php
├── Http/
│   ├── Controllers/          <-- HANYA untuk alur non-Livewire (misal: Download PDF, Webhook)
│   ├── Middleware/           <-- Middleware otentikasi, peran, dan status toko
│   └── Requests/             <-- Form Request Validation untuk payload request HTTP
│       └── Orders/
│           └── StoreOrderRequest.php
├── Livewire/                 <-- UI Component Controller
│   ├── Sales/                <-- Antarmuka Field Sales (Pilar #02 PWA)
│   │   ├── CheckinModal.php
│   │   └── TakingOrderCart.php
│   ├── Portal/              <-- Antarmuka B2B Client Portal (Pilar #03)
│   │   ├── OrderHistory.php
│   │   └── DocumentVault.php
│   └── Shared/               <-- Komponen bersama lintas antarmuka
├── Models/                   <-- Eloquent Models murni relasi, mutator, casting, dan query scope
├── Policies/                 <-- Otorisasi hak akses granular per model
└── Support/                  <-- Nilai konstan atau enum statis
    └── Enums/
        ├── OrderStatus.php
        └── PaymentTerm.php

resources/
└── views/
    ├── components/           <-- Komponen UI Blade yang dipakai ulang (Reusable UI Atoms)
    ├── layouts/
    │   ├── sales.blade.php   <-- Layout shell viewport mobile
    │   └── portal.blade.php  <-- Layout shell desktop enterprise workspace
    └── livewire/
        ├── sales/
        └── portal/
```

### 2. Konvensi Penamaan Tanpa Singkatan (Standardized Full-Word Conventions)

Dilarang keras menggunakan singkatan yang memicu ambigu (seperti `cust`, `calc`, `qty`, `inv`, `trx`, `btn`, `addr`). Gunakan kata bahasa Inggris penuh yang merepresentasikan konteks secara langsung.

- **Tabel Database:** `snake_case`, bentuk jamak kata benda penuh (contoh: `clients`, `product_price_tiers`, `sales_visits`).
- **Kolom Database:** `snake_case`, kata benda deskriptif (contoh: `credit_limit`, `is_blocked`, `registered_by_user_id`).
- **Foreign Key:** `singular_table_name_id` tanpa disingkat (contoh: `client_id`, `product_id`, `sales_order_id`).
- **Model Eloquent:** `PascalCase`, kata benda tunggal penuh (contoh: `Client`, `ProductPriceTier`, `SalesVisit`).
- **Livewire Components:** `PascalCase`, spesifik menggambarkan modul (contoh: `SalesTakingOrderCart.php`).
- **Blade Views:** `kebab-case.blade.php` (contoh: `taking-order-cart.blade.php`).
- **Action Classes:** Kata kerja transitif imperatif di awal + objek + akhiran `Action` (contoh: `CreateOrderAction`, `ApproveCreditLimitAction`, `ValidateGeofenceCoordinatesAction`).
- **Functions & Methods:** `camelCase`, wajib menggunakan kata kerja aksi standar global (contoh: `calculateTotalOutstandingBalance()`, `retrieveActiveProductList()`).
    - Gunakan awalan `is`, `has`, atau `should` untuk fungsi boolean (contoh: `isOverCreditLimit()`, `hasExceededDuePaymentDays()`).
- **Variables:** `camelCase`, kata benda deskriptif penuh (contoh: `$currentOutstandingBalance`, bukan `$curBal`).
- **Enums:** `PascalCase` dengan nilai string eksplisit (contoh: `OrderStatus::PENDING_CONFIRMATION->value`).

### 3. Aturan Komponen Blade & Prinsip Reusability (Strict DRY & KISS)

Untuk menjaga kode tetap ringkas dan tidak memicu pembuatan file sampah:

- **Aturan Minimal 2 Kali Pakai:** Dilarang memecah markup Blade ke file komponen baru di `resources/views/components/` jika elemen UI tersebut hanya dipakai sekali di satu tempat. Tulis langsung markup secara *inline* di dalam file view induknya.
- **Kapan Boleh Dibuat Komponen Terpisah:** Sebuah markup hanya boleh diekstrak menjadi file komponen tersendiri di `resources/views/components/` jika terbukti dipanggil minimal **2 kali** pada halaman atau modul yang berbeda, dengan variasi yang hanya diatur lewat attributes/props (contoh: status badge, tombol tindakan utama, modal alert, form input wrapper).

### 4. Manajemen Kunci Rahasia & Konfigurasi (Strict Credential Protection)

- **Wajib Environment Variable:** Dilarang keras menaruh API key, kredensial database, token third-party (WhatsApp gateway, Cloudflare Turnstile, Mailer), atau secret URL langsung di dalam file kode sumber (`.php`, `.blade.php`, `.js`).
- **Akses Melalui Config Layer:** Semua pemanggilan variabel lingkungan wajib dideklarasikan di file konfigurasi dalam folder `config/` (misal: `config/services.php`), lalu diakses di kode program via helper `config('services.service_name.key')`.
- **Larangan Pemanggilan `env()` di Aplikasi:** Fungsi `env()` hanya boleh dipanggil di dalam file folder `config/*`. Dilarang memanggil `env()` langsung di Controller, Action, Model, atau Livewire karena nilai akan bernilai `null` saat perintah `php artisan config:cache` dijalankan di server.

### 5. Aturan Peletakan Function & Anatomi File (File Anatomy)

#### A. Anatomi Action Class (`app/Actions/*`)

Wajib hanya memiliki **1 method publik** sebagai *entry point* bernama `execute()` atau `handle()`. Semua fungsi validasi internal dan penyimpanan modular diatur berstatus `private`.

```
<?php

declare(strict_types=1);

namespace App\Actions\Orders;

use App\Models\Order;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

final class CreateOrderAction{
    public function __construct(){}

    public function execute(Client $client, array $orderItems, string $idempotencyKey): Order{
        return DB::transaction(function () use ($client, $orderItems, $idempotencyKey){
            $this->validateCreditLimitSufficiency($client, $orderItems);
            return $this->persistOrderToDatabase($client, $orderItems, $idempotencyKey);
        });
    }

    private function validateCreditLimitSufficiency(Client $client, array $orderItems): void{
        // Logika verifikasi limit kredit
    }

    private function persistOrderToDatabase(Client $client, array $orderItems, string $key): Order{
        // Simpan ke database
    }
}
```

#### B. Anatomi Livewire Component (`app/Livewire/*`)

Urutan struktur dari atas ke bawah:

1. Public Properties (UI state binding).
2. Protected/Private Properties.
3. Hook siklus hidup (`mount()`, `boot()`).
4. Action/Event Handlers (fungsi yang dipanggil tombol antarmuka).
5. Method `render()` wajib berada di baris terbawah class.

#### C. Anatomi Model Eloquent (`app/Models/*`)

Urutan deklarasi di dalam Model:

1. Trait usage (`HasFactory`, `SoftDeletes`).
2. Property konfigurasi (`$table`, `$fillable`, `$casts`).
3. Relasi Eloquent (`belongsTo`, `hasMany`).
4. Query Scopes lokal (awalan `scope*`).
5. Mutator dan Accessor format modern (`Attribute::make()`).

### 6. Standar Basis Data & Keandalan Laravel (Laravel Best Practices)

- **Tipe Data Finansial Mutlak:** Kolom harga, limit kredit, nominal pembayaran, dan pajak wajib memakai:PHP
    
    ```
    $table->decimal('total_amount', 15, 2);
    ```
    
    *Dilarang memakai float atau double.*
    
- **Pencegahan Data Duplikat (Idempotency):** Transaksi pesanan wajib menyertakan kolom token pencegah eksekusi ganda:PHP
    
    ```
    $table->uuid('idempotency_token')->unique();
    ```
    
- **Proteksi N+1 Query:** Wajib mengaktifkan pencegahan *lazy loading* di `app/Providers/AppServiceProvider.php`:PHP
    
    ```
    public function boot(): void{
        Model::preventLazyLoading(! $this->app->isProduction());
    }
    ```
    
- **Mass Assignment Strictness:** Dilarang menggunakan `$guarded = []`. Daftarkan seluruh kolom yang dapat diisi secara eksplisit pada array `$fillable`.
- **Proteksi Data Transaksional:** Tabel `clients`, `products`, `orders`, dan `invoices` wajib menggunakan trait `SoftDeletes`.

### 7. Standar Penulisan Catatan & Komentar (Documentation Standard)

- **Larangan Obvious Comments:** Dilarang menulis komentar yang sekadar mengulang kode (misal: `// simpan data user` di atas `$user->save()`).
- **Why, Not What:** Komentar hanya diperuntukkan menjelaskan alasan keputusan bisnis spesifik atau aturan regulasi teknis.
- **Tag Tugas Standar:** Gunakan hanya tag  untuk kode sementara:
    - `// TODO: Implementasi toleransi berat timbangan jembatan saat modul timbang terpasang.`
    - `// SECURITY: Pastikan token transaksi divalidasi sebelum file binary dialirkan.`

### 8. Standardisasi Hilir (Hostinger Ready)

- **Relatif Path Helper:** Dilarang memakai hardcoded path sistem operasi lokal. Wajib gunakan `base_path()`, `storage_path()`, atau `public_path()`.
- **Penyimpanan Berkas Privat:** Dokumen faktur dan Surat Jalan wajib masuk ke disk lokal privat (`storage/app/vault/`) dan disajikan via *Streamed Response* terotentikasi, bukan ditaruh di folder publik.
- **Build Aset:** Selalu jalankan kompilasi aset sebelum commit final untuk memastikan direktori aset terbarui:Bash
    
    ```
    npm run build
    ```
    

### 9. Ketentuan Version Control & Git Workflow (GitHub Standards)

Untuk menjaga riwayat commit tetap bersih dan mudah dilacak:

- **Standar Conventional Commits:** Pesan commit wajib diawali tipe aksi berhuruf kecil diikuti lingkup modul:
    - `feat(orders): add atomic calculation for credit limit approval`
    - `fix(geofence): adjust radius threshold tolerance to eighty meters`
    - `refactor(catalog): extract repetitive query into reusable scope`
    - `chore(config): register cloudflare turnstile credential binding`
- **Larangan Commit Berkas Rahasia:** File `.env`, folder `/vendor`, `/node_modules`, dan berkas lokal hasil kompilasi dev dilarang keras di-push ke repositori. Pastikan `.gitignore` default Laravel terpasang utuh.
- **Branching Strategy:**
    - Branch `main`: Cabang produksi stabil, siap deploy ke instance server hosting klien.
    - Branch `staging`: Cabang integrasi pengujian fungsional modul sebelum rilis.