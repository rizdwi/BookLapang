# BookLapang

Sistem booking lapangan olahraga berbasis web, dibangun dengan Laravel 11.

Aplikasi ini mendukung dua peran pengguna (admin dan pelanggan), pencegahan booking ganda menggunakan database transaction, serta manajemen jadwal dan lapangan secara lengkap.

## Tech Stack

- **Backend:** Laravel 11 (PHP 8.2+)
- **Frontend:** Blade Templates + Tailwind CSS (CDN)
- **Database:** SQLite (default, bisa diganti MySQL)
- **Auth:** Laravel Breeze
- **Interaktivitas:** Alpine.js (CDN)

## Fitur

| Fitur | Keterangan |
|---|---|
| Multi-role auth | Admin dan pelanggan dengan akses berbeda |
| CRUD Lapangan | Tambah, edit, hapus lapangan olahraga (admin) |
| Jadwal & Slot | Generate slot per jam untuk tiap lapangan (admin) |
| Booking | Pelanggan pilih slot, sistem cek bentrokan via DB transaction |
| Dashboard Admin | Statistik booking, pendapatan, daftar booking terbaru |
| Riwayat Booking | Pelanggan lihat semua booking beserta status |
| Status Booking | Pending, Confirmed, Done, Cancelled |
| Responsif | Tampilan mobile-friendly |

## Struktur Database

```
users (id, name, email, password, role, phone)
  |
  +-- bookings (id, user_id, lapangan_id, jadwal_slot_id, tanggal, jam, total_harga, status)
        |
lapangan (id, nama, tipe, deskripsi, harga_per_jam, foto, alamat, aktif)
  |
  +-- jadwal_slots (id, lapangan_id, tanggal, jam_mulai, jam_selesai, tersedia)
```

## Cara Menjalankan

### Prasyarat
- PHP 8.2+
- Composer
- Node.js (untuk asset build, opsional karena pakai CDN)

### Langkah Install

```bash
# 1. Clone repo
git clone https://github.com/rizdwi/BookLapang.git
cd BookLapang

# 2. Install dependencies
composer install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Buat database SQLite
touch database/database.sqlite

# 5. Jalankan migrasi dan seeder
php artisan migrate --seed

# 6. Jalankan server
php artisan serve
```

Buka `http://localhost:8000` di browser.

### Akun Demo (dari Seeder)

| Role | Email | Password |
|---|---|---|
| Admin | admin@booklapang.com | password |
| Customer | budi@example.com | password |

## Screenshot

[REAL DATA: tambahkan screenshot setelah aplikasi berjalan]

## Lisensi

Project portofolio oleh Rizki Dwi Sandy.
