<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\JadwalSlot;
use App\Models\Lapangan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Pengguna
        $admin = User::create([
            'name' => 'Rizki Admin',
            'email' => 'admin@booklapang.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081385084327',
        ]);

        $customerBudi = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '081234567890',
        ]);

        $customerDwi = User::create([
            'name' => 'Dwi Prasetyo',
            'email' => 'dwi@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '081987654321',
        ]);

        // 2. Data Lapangan dengan Deskripsi Mendalam, Fasilitas & Foto Realistis
        $lapangan1 = Lapangan::create([
            'nama' => 'Arena Futsal Premiere (Indoor)',
            'tipe' => 'futsal',
            'deskripsi' => 'Lapangan futsal indoor bertaraf internasional menggunakan rumput sintetis monofilament 50mm yang empuk dan aman untuk lutut. Didukung sistem pencahayaan LED 500 Lux anti-silau, ventilasi sirkulasi udara besar, jaring pengaman keliling, serta tribun penonton. Fasilitas penunjang: ruang ganti ber-AC, loker penyimpanan dengan kunci, shower air hangat, musholla bersih, dan kantin minuman dingin.',
            'harga_per_jam' => 150000,
            'foto' => 'lapangan/futsal.jpg',
            'alamat' => 'Jl. Pemuda No. 42, Rawamangun, Jakarta Timur',
            'aktif' => true,
        ]);

        $lapangan2 = Lapangan::create([
            'nama' => 'Gor Bulutangkis Djarum Hall 1',
            'tipe' => 'badminton',
            'deskripsi' => 'Karpet lapangan vinyl Enlio standar sertifikasi BWF Grade A dengan daya redam pantulan tinggi untuk kenyamanan manuver langkah cepat. Atap hall setinggi 9 meter bebas rintangan smash tinggi, lampu sorot samping terarah yang tidak menyilaukan pandangan pemain, serta sirkulasi udara sejuk. Tersedia penyewaan raket, kok turnamen, serta area pemanasan khusus.',
            'harga_per_jam' => 65000,
            'foto' => 'lapangan/badminton.jpg',
            'alamat' => 'Jl. Panjang Arteri Kelapa Dua No. 18, Kebon Jeruk, Jakarta Barat',
            'aktif' => true,
        ]);

        $lapangan3 = Lapangan::create([
            'nama' => 'Champions Basketball Court',
            'tipe' => 'basket',
            'deskripsi' => 'Lapangan basket indoor lantai kayu hardwood maple Amerika dengan bantalan pegas berstandar kompetisi FIBA. Dilengkapi ring hidrolik fleksibel (breakaway rim) dengan papan pantul tempered glass transparan tebal. Garis lapangan standar NBA & FIBA untuk full court 5x5 maupun half court 3x3. Dilengkapi papan skor digital LED, sound system arena, dan tribun berkapasitas 150 penonton.',
            'harga_per_jam' => 120000,
            'foto' => 'lapangan/basket.jpg',
            'alamat' => 'Jl. Metro Pondok Indah Blok BB, Kebayoran Lama, Jakarta Selatan',
            'aktif' => true,
        ]);

        $lapangan4 = Lapangan::create([
            'nama' => 'Centre Court Tennis Club',
            'tipe' => 'tenis',
            'deskripsi' => 'Lapangan tenis hard court premium berlapis akrilik Plexipave bertaraf turnamen ITF dengan kecepatan bola medium-fast. Garis lapangan sangat presisi, net baja kokoh dengan tali pengatur ketinggian tengah terstandarisasi, serta lampu sorot malam hari 1000 Watt untuk sesi main petang hingga malam. Area istirahat pemain teduh dengan kanopi pelindung panas dan dispenser air gratis.',
            'harga_per_jam' => 140000,
            'foto' => 'lapangan/tenis.jpg',
            'alamat' => 'Jl. Cilandak KKO Raya No. 25, Pasar Minggu, Jakarta Selatan',
            'aktif' => true,
        ]);

        $lapangan5 = Lapangan::create([
            'nama' => 'Garuda Volleyball Hall',
            'tipe' => 'voli',
            'deskripsi' => 'Lapangan bola voli indoor berlantai taraflex anti-slip dengan penyerapan getaran maksimal berstandar PBVSI. Dilengkapi tiang dan net hidrolik dengan bantalan busa pelindung benturan, antena net standar resmi, serta jarak servis belakang garis lapangan yang lega. Terdapat ruang medis pertolongan pertama, loker pemain, dan toilet bersih.',
            'harga_per_jam' => 85000,
            'foto' => 'lapangan/voli.jpg',
            'alamat' => 'Jl. Tebet Timur Dalam Raya No. 88, Tebet, Jakarta Selatan',
            'aktif' => true,
        ]);

        $lapangans = [$lapangan1, $lapangan2, $lapangan3, $lapangan4, $lapangan5];

        // 3. Generate Slot Waktu 7 Hari ke Depan (Jam 08:00 s/d 22:00)
        $slotTersediaCollection = [];

        foreach ($lapangans as $lapangan) {
            for ($d = 0; $d < 7; $d++) {
                $tanggal = Carbon::today()->addDays($d)->format('Y-m-d');
                $startHour = 8; // Jam 8 pagi

                for ($h = 0; $h < 14; $h++) { // 14 slot per hari hingga jam 22:00
                    $mulai = sprintf('%02d:00:00', $startHour + $h);
                    $selesai = sprintf('%02d:00:00', $startHour + $h + 1);

                    $slot = JadwalSlot::create([
                        'lapangan_id' => $lapangan->id,
                        'tanggal' => $tanggal,
                        'jam_mulai' => $mulai,
                        'jam_selesai' => $selesai,
                        'tersedia' => true,
                    ]);

                    $slotTersediaCollection[] = $slot;
                }
            }
        }

        // 4. Buat Sampel Transaksi Nyata Agar Dashboard & Riwayat Terisi
        // Transaksi 1: Selesai di masa lalu / kemarin (menghasilkan omset di admin)
        $bookingDone = Booking::create([
            'user_id' => $customerBudi->id,
            'lapangan_id' => $lapangan1->id,
            'jadwal_slot_id' => $slotTersediaCollection[0]->id,
            'tanggal_booking' => Carbon::yesterday()->format('Y-m-d'),
            'jam_mulai' => '19:00:00',
            'jam_selesai' => '20:00:00',
            'total_harga' => $lapangan1->harga_per_jam,
            'status' => 'done',
            'metode_pembayaran' => 'qris',
            'catatan' => 'Sparing rutin futsal mingguan tim kantor',
        ]);

        // Transaksi 2: Selesai untuk badminton
        $bookingDone2 = Booking::create([
            'user_id' => $customerDwi->id,
            'lapangan_id' => $lapangan2->id,
            'jadwal_slot_id' => $slotTersediaCollection[1]->id,
            'tanggal_booking' => Carbon::yesterday()->format('Y-m-d'),
            'jam_mulai' => '20:00:00',
            'jam_selesai' => '21:00:00',
            'total_harga' => $lapangan2->harga_per_jam,
            'status' => 'done',
            'metode_pembayaran' => 'transfer_bca',
            'catatan' => 'Pinjam kok 2 tabung',
        ]);

        // Transaksi 3: Dikonfirmasi untuk Hari Ini (slot menjadi tidak tersedia)
        $slotHariIni = $slotTersediaCollection[5]; // Futsal jam 13:00 hari ini
        $slotHariIni->update(['tersedia' => false]);
        Booking::create([
            'user_id' => $customerBudi->id,
            'lapangan_id' => $slotHariIni->lapangan_id,
            'jadwal_slot_id' => $slotHariIni->id,
            'tanggal_booking' => Carbon::today()->format('Y-m-d'),
            'jam_mulai' => $slotHariIni->jam_mulai,
            'jam_selesai' => $slotHariIni->jam_selesai,
            'total_harga' => $lapangan1->harga_per_jam,
            'status' => 'confirmed',
            'metode_pembayaran' => 'transfer_bca',
            'catatan' => 'Rompi tim sudah disiapkan sendiri',
        ]);

        // Transaksi 4: Menunggu Pembayaran/Konfirmasi (Pending) untuk Budi Besok
        $slotBesok = $slotTersediaCollection[18]; // Besok malam
        $slotBesok->update(['tersedia' => false]);
        Booking::create([
            'user_id' => $customerBudi->id,
            'lapangan_id' => $slotBesok->lapangan_id,
            'jadwal_slot_id' => $slotBesok->id,
            'tanggal_booking' => $slotBesok->tanggal,
            'jam_mulai' => $slotBesok->jam_mulai,
            'jam_selesai' => $slotBesok->jam_selesai,
            'total_harga' => $lapangan1->harga_per_jam,
            'status' => 'pending',
            'metode_pembayaran' => 'qris',
            'catatan' => 'Mohon siapkan bola futsal ekstra',
        ]);

        // Transaksi 5: Dibatalkan
        $slotBatal = $slotTersediaCollection[25];
        Booking::create([
            'user_id' => $customerDwi->id,
            'lapangan_id' => $slotBatal->lapangan_id,
            'jadwal_slot_id' => $slotBatal->id,
            'tanggal_booking' => $slotBatal->tanggal,
            'jam_mulai' => $slotBatal->jam_mulai,
            'jam_selesai' => $slotBatal->jam_selesai,
            'total_harga' => $lapangan2->harga_per_jam,
            'status' => 'cancelled',
            'metode_pembayaran' => 'cash',
            'catatan' => 'Batal karena anggota tim sakit',
        ]);
    }
}
