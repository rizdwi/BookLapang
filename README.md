# BookLapang - Sistem Reservasi Lapangan Olahraga

Aplikasi web pemesanan lapangan olahraga berbasis fullstack dengan arsitektur **Laravel 11**, dirancang untuk menangani konkurensi tinggi, proteksi pemesanan bentrok (*race-condition safe*), serta manajemen alur transaksi multi-peran (Admin & Pelanggan).

---

## Fitur Utama

### 1. Transaksi & Logika Bisnis
- **Anti-Bentrok (Concurrency-Safe):** Menggunakan `DB::transaction()` dan pesimistik locking `lockForUpdate()` pada slot jadwal untuk mencegah pemesanan ganda di detik yang sama.
- **Proteksi Pembatasan Reservasi:** Pengguna dibatasi maksimal memiliki pesanan belum lunas (*status pending*) pada $\le 2$ lapangan berbeda. Sistem secara otomatis menolak pembuatan pesanan pada lapangan ke-3 sebelum pembayaran sebelumnya diselesaikan atau dibatalkan.
- **Visualisasi Pembayaran Interaktif:**
  - **QRIS Standar Nasional:** Menampilkan QR Code dinamis resmi, batas waktu pembayaran 15 menit, dan total tagihan instan.
  - **BCA Virtual Account:** Menampilkan nomor VA terformat (`80777` + nomor ponsel), tombol salin nomor rekening satu klik, dan panduan transfer m-BCA/ATM.
  - **Dasbor Pembayaran:** Pelanggan dapat membuka kembali barcode QRIS atau nomor VA kapan saja melalui tombol *Bayar Sekarang* di dasbor.
- **Pembatalan Mandiri:** Pelanggan dapat membatalkan pesanan yang masih berstatus menunggu (*pending*), yang secara otomatis membuka kembali ketersediaan slot jadwal secara real-time.

### 2. Arsitektur Performa & Skalabilitas (Enterprise Ready)
- **Rate Limiting:** Throttle terdistribusi untuk membatasi akses publik (60 req/min) dan mencegah spam brute-force checkout (10 req/min).
- **In-Memory Caching:** Caching katalog lapangan aktif via Facade `Cache` dengan *automatic cache invalidation* saat admin memperbarui data lapangan.
- **Database Composite Indexing:** Indeks gabungan pada `(user_id, status)`, `(jadwal_slot_id, status)`, dan `(lapangan_id, tanggal, jam_mulai)` untuk eksekusi query sub-milidetik.
- **Asynchronous Task Queue:** Pemrosesan notifikasi dan pembuatan invoice tiket melalui background job (`ProcessBookingNotificationJob`) untuk menjaga *response time* HTTP tetap cepat.
- **Dokumentasi Skalabilitas Lengkap:** Panduan arsitektur produksi (*High Availability, Redis Cluster, Kafka/RabbitMQ, Connection Pooling, APM Monitoring*) tersedia di [ARCHITECTURE.md](ARCHITECTURE.md).

---

## Tech Stack

- **Backend:** PHP 8.2+, Laravel 11 Framework
- **Frontend:** Blade Templates, Tailwind CSS (CDN), Alpine.js (Reaktivitas UI)
- **Database:** SQLite (Lokal) / MySQL Ready (Produksi)
- **Auth & Keamanan:** Role-Based Access Control (Admin vs Customer), CSRF Protection, Hash Bcrypt

---

## Struktur Basis Data

```
users (id, name, email, password, role, phone)
  |
  +-- bookings (id, user_id, lapangan_id, jadwal_slot_id, tanggal_booking, jam_mulai, jam_selesai, total_harga, status, metode_pembayaran, catatan)
        |
lapangan (id, nama, tipe, deskripsi, harga_per_jam, foto, alamat, aktif)
  |
  +-- jadwal_slots (id, lapangan_id, tanggal, jam_mulai, jam_selesai, tersedia)
```

---

## Cara Menjalankan Secara Lokal

### Prasyarat
- PHP 8.2+
- Composer
- Git

### Langkah Instalasi
```bash
# 1. Clone repositori
git clone https://github.com/rizdwi/BookLapang.git
cd BookLapang

# 2. Install dependensi
composer install

# 3. Konfigurasi environment
cp .env.example .env
php artisan key:generate

# 4. Buat file SQLite & jalankan migrasi seeder
touch database/database.sqlite
php artisan migrate --seed

# 5. Buat tautan berkas foto
php artisan storage:link

# 6. Jalankan server lokal
php artisan serve
```

Buka peramban di `http://127.0.0.1:8000`.

### Akun Uji Coba

| Peran | Email | Kata Sandi | Akses |
|---|---|---|---|
| **Admin** | `admin@booklapang.com` | `password` | Kelola Lapangan, Generate Jadwal Massal, Approval Transaksi, Pantau Omset |
| **Pelanggan 1** | `budi@example.com` | `password` | Pemesanan Lapangan, Pembayaran QRIS/VA, Dasbor Riwayat |
| **Pelanggan 2** | `dwi@example.com` | `password` | Uji coba simulasi multi-pengguna |

---

## Lisensi & Hak Cipta

Dikembangkan oleh **Rizki Dwi Sandy** sebagai karya portofolio mandiri untuk posisi *Junior Fullstack Web Developer*.
