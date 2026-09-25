<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BookingSlot;
use App\Models\JadwalSlot;
use App\Models\Lapangan;
use App\Models\LapanganTarif;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with 25 realistic venues across 5 sports and 5 regions.
     */
    public function run(): void
    {
        // 1. Akun Pengguna
        $admin = User::firstOrCreate(
            ['email' => 'admin@booklapang.com'],
            [
                'name' => 'Rizki Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '081385084327',
            ]
        );

        $customerBudi = User::firstOrCreate(
            ['email' => 'budi@example.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'phone' => '081234567890',
            ]
        );

        $customerDwi = User::firstOrCreate(
            ['email' => 'dwi@example.com'],
            [
                'name' => 'Dwi Prasetyo',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'phone' => '081987654321',
            ]
        );

        // 2. Definisi 25 Lapangan (5 Olahraga x 5 Lokasi Berbeda di DKI Jakarta)
        $venues = [
            // --- FUTSAL (5 Lokasi) ---
            [
                'nama' => 'Arena Futsal Premiere (Indoor)',
                'tipe' => 'futsal',
                'harga_per_jam' => 150000,
                'foto' => 'lapangan/futsal.jpg',
                'alamat' => 'Jl. Pemuda No. 42, Rawamangun, Jakarta Timur',
                'deskripsi' => 'Lapangan futsal indoor bertaraf internasional dengan rumput sintetis monofilament 50mm yang empuk dan aman untuk sendi. Didukung pencahayaan LED 500 Lux anti-silau, ventilasi sirkulasi udara besar, jaring pengaman keliling, serta tribun penonton. Fasilitas: ruang ganti ber-AC, loker kunci, shower air hangat, musholla bersih, dan kantin.',
                'peak_harga' => 175000,
            ],
            [
                'nama' => 'Kuningan Village Futsal Stadium',
                'tipe' => 'futsal',
                'harga_per_jam' => 175000,
                'foto' => 'lapangan/futsal.jpg',
                'alamat' => 'Jl. Karbela Timur No. 1, Kuningan, Setiabudi, Jakarta Selatan',
                'deskripsi' => 'Venue futsal prestisius di kawasan segitiga emas Kuningan dengan lantai interlocking polypropylene standar turnamen FIFA. Favorit komunitas eksekutif kantor, dilengkapi ruang VIP ber-AC, coffee shop santai, area parkir basement aman, dan penerangan malam berkekuatan tinggi.',
                'peak_harga' => 200000,
            ],
            [
                'nama' => 'Grand Futsal Intercon',
                'tipe' => 'futsal',
                'harga_per_jam' => 135000,
                'foto' => 'lapangan/futsal.jpg',
                'alamat' => 'Jl. Meruya Ilir Raya No. 88, Srengseng, Kebon Jeruk, Jakarta Barat',
                'deskripsi' => 'Arena futsal semi-outdoor dengan rumput sintetis impor tebal bebas pasir kasar. Memiliki ventilasi angin silang alami yang sejuk, area tribun duduk lapang, musholla terawat, area parkir mobil/motor lega, serta penyewaan rompi dan sepatu futsal lengkap.',
                'peak_harga' => 155000,
            ],
            [
                'nama' => 'Kelapa Gading Sport Center Futsal',
                'tipe' => 'futsal',
                'harga_per_jam' => 160000,
                'foto' => 'lapangan/futsal.jpg',
                'alamat' => 'Jl. Boulevard Raya Blok PA 1, Kelapa Gading, Jakarta Utara',
                'deskripsi' => 'Lapangan futsal indoor lantai vinyl taraflex khusus turnamen dengan peredaman kejut maksimal. Dilengkapi papan skor digital elektronik, sound system arena, tribun penonton bertingkat, serta ruang bilas shower air panas yang higienis.',
                'peak_harga' => 185000,
            ],
            [
                'nama' => 'Senayan Elite Futsal Arena',
                'tipe' => 'futsal',
                'harga_per_jam' => 180000,
                'foto' => 'lapangan/futsal.jpg',
                'alamat' => 'Jl. Asia Afrika Pintu 9 Gelora Bung Karno, Tanah Abang, Jakarta Pusat',
                'deskripsi' => 'Lapangan futsal kelas atas di pusat kawasan olahraga nasional Senayan. Menggunakan rumput sintetis Grade A terbaru dengan jaring pembatas kokoh dan tinggi. Akses transportasi sangat mudah (dekat MRT Senayan), parkir luas, dan atmosfer olahraga yang semarak.',
                'peak_harga' => 210000,
            ],

            // --- BADMINTON (5 Lokasi) ---
            [
                'nama' => 'GOR Bulutangkis Djarum Hall 1',
                'tipe' => 'badminton',
                'harga_per_jam' => 65000,
                'foto' => 'lapangan/badminton.jpg',
                'alamat' => 'Jl. Panjang Arteri Kelapa Dua No. 18, Kebon Jeruk, Jakarta Barat',
                'deskripsi' => 'Karpet lapangan vinyl Enlio standar sertifikasi BWF Grade A dengan daya redam pantulan tinggi untuk manuver langkah cepat. Atap hall setinggi 9 meter bebas rintangan smash tinggi, lampu sorot samping anti-silau terarah, sirkulasi udara dingin, dan penyewaan raket/kok turnamen.',
                'peak_harga' => 80000,
            ],
            [
                'nama' => 'Cipayung Prime Badminton Center',
                'tipe' => 'badminton',
                'harga_per_jam' => 60000,
                'foto' => 'lapangan/badminton.jpg',
                'alamat' => 'Jl. Raya Cipayung No. 77, Cipayung, Jakarta Timur',
                'deskripsi' => 'Hall bulutangkis dengan 4 lapangan karpet hijau tebal bersertifikasi resmi PBSI. Dilengkapi lampu spotlight terarah tanpa silau, tribun penonton keluarga, kantin minuman segar, area parkir mobil/motor luas, dan pelatih badminton berpengalaman.',
                'peak_harga' => 75000,
            ],
            [
                'nama' => 'Pancoran Badminton Arena & Hub',
                'tipe' => 'badminton',
                'harga_per_jam' => 75000,
                'foto' => 'lapangan/badminton.jpg',
                'alamat' => 'Jl. MT Haryono Kav. 53, Pancoran, Jakarta Selatan',
                'deskripsi' => 'Venue badminton strategis di Jakarta Selatan dengan exhaust fan turbin berdaya hisap besar sehingga hawa hall tetap adem saat main malam. Karpet vinyl anti-slip empuk, parkir mobil aman dengan penjagaan 24 jam, musholla ber-AC, dan dekat Stasiun LRT Cikoko.',
                'peak_harga' => 90000,
            ],
            [
                'nama' => 'Sunter Sports Hall Badminton',
                'tipe' => 'badminton',
                'harga_per_jam' => 70000,
                'foto' => 'lapangan/badminton.jpg',
                'alamat' => 'Jl. Danau Sunter Utara Blok G7, Sunter Agung, Tanjung Priok, Jakarta Utara',
                'deskripsi' => 'Hall bulutangkis bersih berstandar kejuaraan dengan karpet badminton profesional bertekstur grip prima. Jarak antar lapangan sangat lega, lampu tidak menyilaukan mata saat lob tinggi, dan tersedia ruang ganti terpisah yang wangi.',
                'peak_harga' => 85000,
            ],
            [
                'nama' => 'Cempaka Putih Badminton Hall',
                'tipe' => 'badminton',
                'harga_per_jam' => 55000,
                'foto' => 'lapangan/badminton.jpg',
                'alamat' => 'Jl. Cempaka Putih Tengah No. 31, Cempaka Putih, Jakarta Pusat',
                'deskripsi' => 'Hall bulutangkis favorit komunitas di Jakarta Pusat. Karpet badminton lentur terawat prima, dinding kontras gelap untuk memudahkan tracking laju shuttlecock, harga sewa bersahabat, dan area istirahat pemain berkanopi teduh.',
                'peak_harga' => 70000,
            ],

            // --- BASKET (5 Lokasi) ---
            [
                'nama' => 'Champions Basketball Court',
                'tipe' => 'basket',
                'harga_per_jam' => 120000,
                'foto' => 'lapangan/basket.jpg',
                'alamat' => 'Jl. Metro Pondok Indah Blok BB, Kebayoran Lama, Jakarta Selatan',
                'deskripsi' => 'Lapangan basket indoor lantai kayu hardwood maple Amerika dengan bantalan pegas berstandar kompetisi FIBA. Dilengkapi ring hidrolik fleksibel (breakaway rim) dengan papan pantul tempered glass transparan tebal, papan skor digital, dan tribun 150 penonton.',
                'peak_harga' => 145000,
            ],
            [
                'nama' => 'The Hawks Basketball Arena',
                'tipe' => 'basket',
                'harga_per_jam' => 135000,
                'foto' => 'lapangan/basket.jpg',
                'alamat' => 'Jl. Kyai Tapa No. 101, Tomang, Grogol Petamburan, Jakarta Barat',
                'deskripsi' => 'Arena basket modern berlantai parquette kayu jati halus anti-licin dengan garis resmi turnamen. Dilengkapi sistem pencahayaan standar kejuaraan IBL, ring pegas standar turnamen, loker penyimpanan barang terjamin, dan ruang istirahat atlet ber-AC.',
                'peak_harga' => 160000,
            ],
            [
                'nama' => 'PIK Basketball Center',
                'tipe' => 'basket',
                'harga_per_jam' => 160000,
                'foto' => 'lapangan/basket.jpg',
                'alamat' => 'Jl. Pantai Indah Kapuk Boulevard No. 28, Penjaringan, Jakarta Utara',
                'deskripsi' => 'Fasilitas basket indoor mewah dengan pendingin ruangan AC sentral, lantai kayu solid maple, 2 unit ring hidrolik gantung kelas profesional, scoring board nirkabel, lounge kafe pemain dengan aneka kopi, serta shower air hangat eksklusif.',
                'peak_harga' => 190000,
            ],
            [
                'nama' => 'Menteng Pro Basketball Court',
                'tipe' => 'basket',
                'harga_per_jam' => 140000,
                'foto' => 'lapangan/basket.jpg',
                'alamat' => 'Jl. HOS Cokroaminoto No. 64, Menteng, Jakarta Pusat',
                'deskripsi' => 'Lapangan basket semi-indoor di kawasan prestisius Menteng berlantai interlock mat standar turnamen 3x3 dunia. Ring per pegas standar kompetisi, area duduk pemain teduh, musholla bersih, dan kantin dengan aneka makanan sehat.',
                'peak_harga' => 165000,
            ],
            [
                'nama' => 'Metropolitan Basketball Hall',
                'tipe' => 'basket',
                'harga_per_jam' => 110000,
                'foto' => 'lapangan/basket.jpg',
                'alamat' => 'Jl. Kolonel Sugiono No. 45, Duren Sawit, Jakarta Timur',
                'deskripsi' => 'Hall basket indoor favorit pelajar dan komunitas Jakarta Timur. Memiliki lantai vinyl anti-slip tebal, ring basket kokoh dengan pelindung busa tebal pada tiang hidrolik, pencahayaan LED terang merata, dan area parkir motor/mobil lapang.',
                'peak_harga' => 130000,
            ],

            // --- TENIS (5 Lokasi) ---
            [
                'nama' => 'Centre Court Tennis Club',
                'tipe' => 'tenis',
                'harga_per_jam' => 140000,
                'foto' => 'lapangan/tenis.jpg',
                'alamat' => 'Jl. Cilandak KKO Raya No. 25, Pasar Minggu, Jakarta Selatan',
                'deskripsi' => 'Lapangan tenis hard court premium berlapis akrilik Plexipave bertaraf turnamen ITF dengan kecepatan bola medium-fast. Garis lapangan sangat presisi, net baja kokoh dengan tali pengatur ketinggian tengah terstandarisasi, serta lampu sorot malam hari 1000 Watt. Area istirahat pemain teduh dan dispenser air gratis.',
                'peak_harga' => 165000,
            ],
            [
                'nama' => 'Senayan Tennis Stadium',
                'tipe' => 'tenis',
                'harga_per_jam' => 175000,
                'foto' => 'lapangan/tenis.jpg',
                'alamat' => 'Jl. Pintu Satu Senayan No. 1, Gelora, Tanah Abang, Jakarta Pusat',
                'deskripsi' => 'Venue tenis bersejarah dengan lapangan outdoor berlapis hardcourt internasional di jantung komplek olahraga GBK. Lingkungan hijau asri, tiang net profesional, kursi wasit resmi turnamen, ruang ganti bersih dengan shower air hangat, dan akses mudah via MRT.',
                'peak_harga' => 200000,
            ],
            [
                'nama' => 'Puri Indah Tennis Executive Court',
                'tipe' => 'tenis',
                'harga_per_jam' => 150000,
                'foto' => 'lapangan/tenis.jpg',
                'alamat' => 'Jl. Puri Lingkar Luar No. 12, Kembangan Selatan, Jakarta Barat',
                'deskripsi' => 'Klub tenis privat asri dengan permukaan cushion court yang empuk dan ramah sendi serta lutut. Dilengkapi ball boy terlatih, penyewaan raket tenis Babolat dan Wilson, lounge istirahat ber-AC, dan area parkir aman.',
                'peak_harga' => 175000,
            ],
            [
                'nama' => 'Ancol Beachside Tennis Club',
                'tipe' => 'tenis',
                'harga_per_jam' => 135000,
                'foto' => 'lapangan/tenis.jpg',
                'alamat' => 'Jl. Lodan Timur No. 7, Ancol, Pademangan, Jakarta Utara',
                'deskripsi' => 'Sensasi bermain tenis unik di tepi pantai dengan semilir angin laut segar. Hardcourt mulus tanpa retakan, pencahayaan LED sorot malam hari yang terang benderang, serta kafe terbuka di tepi lapangan untuk bersantai setelah bermain.',
                'peak_harga' => 155000,
            ],
            [
                'nama' => 'Cijantung Elite Tennis Court',
                'tipe' => 'tenis',
                'harga_per_jam' => 120000,
                'foto' => 'lapangan/tenis.jpg',
                'alamat' => 'Jl. Raya Bogor Km 24, Cijantung, Pasar Rebo, Jakarta Timur',
                'deskripsi' => 'Lapangan tenis semi-indoor dengan atap kanopi kokoh pelindung terik matahari dan hujan rintik. Garis lapangan sangat presisi, net kencang berkualitas, toilet dan ruang bilas bersih, serta tarif bermain yang sangat bersahabat.',
                'peak_harga' => 140000,
            ],

            // --- BOLA VOLI (5 Lokasi) ---
            [
                'nama' => 'Garuda Volleyball Hall',
                'tipe' => 'voli',
                'harga_per_jam' => 85000,
                'foto' => 'lapangan/voli.jpg',
                'alamat' => 'Jl. Tebet Timur Dalam Raya No. 88, Tebet, Jakarta Selatan',
                'deskripsi' => 'Lapangan bola voli indoor berlantai taraflex anti-slip dengan penyerapan getaran maksimal berstandar PBVSI. Dilengkapi tiang dan net hidrolik dengan bantalan busa pelindung benturan, antena net standar resmi, serta jarak servis belakang garis lapangan yang lega. Terdapat ruang medis pertolongan pertama, loker pemain, dan toilet bersih.',
                'peak_harga' => 100000,
            ],
            [
                'nama' => 'Velodrome Volleyball Arena',
                'tipe' => 'voli',
                'harga_per_jam' => 95000,
                'foto' => 'lapangan/voli.jpg',
                'alamat' => 'Jl. Pemuda No. 10, Rawamangun, Pulo Gadung, Jakarta Timur',
                'deskripsi' => 'Arena bola voli berstandar kejuaraan daerah dekat stasiun LRT Velodrome Rawamangun. Menggunakan lantai interlock karet elastis, net kompetisi Mikasa, pencahayaan merata bebas bayangan, tribun penonton kapasitas 120 orang, dan shower mandi bersih.',
                'peak_harga' => 115000,
            ],
            [
                'nama' => 'Citra Garden Volleyball Center',
                'tipe' => 'voli',
                'harga_per_jam' => 75000,
                'foto' => 'lapangan/voli.jpg',
                'alamat' => 'Jl. Citra Garden 2 Blok H1, Kalideres, Jakarta Barat',
                'deskripsi' => 'Fasilitas voli indoor terawat dengan sirkulasi udara optimal dan langit-langit hall tinggi. Garis batas lapangan kontras jelas, tiang net kokoh dengan pengencang katrol baja, area pemanasan samping yang luas, dan area parkir bebas biaya.',
                'peak_harga' => 90000,
            ],
            [
                'nama' => 'North Jakarta Volleyball Hall',
                'tipe' => 'voli',
                'harga_per_jam' => 90000,
                'foto' => 'lapangan/voli.jpg',
                'alamat' => 'Jl. Pegangsaan Dua No. 99, Kelapa Gading, Jakarta Utara',
                'deskripsi' => 'Hall voli modern dengan karpet vinyl multi-sports tebal 6mm yang sangat empuk saat landing spike keras. Dilengkapi papan skor digital LED, bola voli turnamen resmi berstandar PBVSI, loker pakaian dengan kunci, dan kantin higienis.',
                'peak_harga' => 105000,
            ],
            [
                'nama' => 'Harmoni Merdeka Volleyball Court',
                'tipe' => 'voli',
                'harga_per_jam' => 80000,
                'foto' => 'lapangan/voli.jpg',
                'alamat' => 'Jl. Suryopranoto No. 20, Petojo Selatan, Gambir, Jakarta Pusat',
                'deskripsi' => 'Hall voli di pusat kota Jakarta dengan akses dekat halte TransJakarta Harmoni. Lantai kayu terlapisi matras anti-licin, atap tinggi bebas hambatan bola tinggi, pencahayaan LED terang, dan ruang ganti bersih dengan fasilitas shower.',
                'peak_harga' => 95000,
            ],
        ];

        // Bersihkan dan reset data sebelumnya agar fresh
        DB::statement('PRAGMA foreign_keys = OFF;');
        BookingSlot::truncate();
        Booking::truncate();
        JadwalSlot::truncate();
        LapanganTarif::truncate();
        Lapangan::truncate();
        DB::statement('PRAGMA foreign_keys = ON;');

        // Buat data 25 lapangan dan aturan tarif dinamisnya
        $createdLapangans = [];
        foreach ($venues as $v) {
            $peakHarga = $v['peak_harga'];
            unset($v['peak_harga']);
            $v['aktif'] = true;

            $lap = Lapangan::create($v);

            // Tambahkan tarif dinamis jam malam / peak hour (18:00 - 22:00)
            LapanganTarif::create([
                'lapangan_id' => $lap->id,
                'tipe_hari' => 'all',
                'jam_mulai' => '18:00:00',
                'jam_selesai' => '22:00:00',
                'harga' => $peakHarga,
                'label' => 'Tarif Jam Malam (Peak Hours)',
                'aktif' => true,
            ]);

            $createdLapangans[] = $lap;
        }

        // 3. Generate Slot Waktu untuk 7 Hari ke Depan (Jam 08:00 s/d 22:00 = 14 slot/hari)
        $today = Carbon::today();
        $slotBatch = [];
        $now = now();

        foreach ($createdLapangans as $lap) {
            $defaultPrice = $lap->harga_per_jam;
            $peakTarif = LapanganTarif::where('lapangan_id', $lap->id)->first();

            for ($d = 0; $d < 7; $d++) {
                $tanggal = (clone $today)->addDays($d)->format('Y-m-d');

                for ($h = 8; $h < 22; $h++) {
                    $jamMulai = sprintf('%02d:00:00', $h);
                    $jamSelesai = sprintf('%02d:00:00', $h + 1);

                    // Tentukan harga dinamis jika masuk jam peak (18:00 ke atas)
                    $slotPrice = ($peakTarif && $jamMulai >= '18:00:00') ? $peakTarif->harga : $defaultPrice;

                    $slotBatch[] = [
                        'lapangan_id' => $lap->id,
                        'tanggal' => $tanggal,
                        'jam_mulai' => $jamMulai,
                        'jam_selesai' => $jamSelesai,
                        'harga' => $slotPrice,
                        'tersedia' => true,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];

                    if (count($slotBatch) >= 300) {
                        JadwalSlot::insert($slotBatch);
                        $slotBatch = [];
                    }
                }
            }
        }

        if (!empty($slotBatch)) {
            JadwalSlot::insert($slotBatch);
        }

        // 4. Buat Sampel Transaksi Nyata Agar Dashboard & Riwayat Terisi
        $futsal1 = $createdLapangans[0];
        $badminton1 = $createdLapangans[5];
        $basket1 = $createdLapangans[10];

        $slotDone1 = JadwalSlot::where('lapangan_id', $futsal1->id)->whereDate('tanggal', Carbon::today())->where('jam_mulai', '09:00:00')->first();
        if ($slotDone1) {
            $slotDone1->update(['tersedia' => false]);
            $bDone = Booking::create([
                'kode_booking' => 'BK-' . date('ymd') . '-01A1',
                'user_id' => $customerBudi->id,
                'lapangan_id' => $futsal1->id,
                'jadwal_slot_id' => $slotDone1->id,
                'tanggal_booking' => $slotDone1->tanggal,
                'jam_mulai' => $slotDone1->jam_mulai,
                'jam_selesai' => $slotDone1->jam_selesai,
                'total_harga' => $slotDone1->harga_efektif,
                'status' => 'done',
                'metode_pembayaran' => 'qris',
                'catatan' => 'Sparing rutin futsal mingguan',
            ]);
            BookingSlot::create([
                'booking_id' => $bDone->id,
                'jadwal_slot_id' => $slotDone1->id,
                'harga' => $slotDone1->harga_efektif,
            ]);
        }

        $slotConfirmed = JadwalSlot::where('lapangan_id', $badminton1->id)->whereDate('tanggal', Carbon::today())->where('jam_mulai', '19:00:00')->first();
        if ($slotConfirmed) {
            $slotConfirmed->update(['tersedia' => false]);
            $bConf = Booking::create([
                'kode_booking' => 'BK-' . date('ymd') . '-02B2',
                'user_id' => $customerDwi->id,
                'lapangan_id' => $badminton1->id,
                'jadwal_slot_id' => $slotConfirmed->id,
                'tanggal_booking' => $slotConfirmed->tanggal,
                'jam_mulai' => $slotConfirmed->jam_mulai,
                'jam_selesai' => $slotConfirmed->jam_selesai,
                'total_harga' => $slotConfirmed->harga_efektif,
                'status' => 'confirmed',
                'metode_pembayaran' => 'transfer_bca',
                'catatan' => 'Siapkan 2 tabung shuttlecock',
            ]);
            BookingSlot::create([
                'booking_id' => $bConf->id,
                'jadwal_slot_id' => $slotConfirmed->id,
                'harga' => $slotConfirmed->harga_efektif,
            ]);
        }

        $slotPending = JadwalSlot::where('lapangan_id', $basket1->id)->whereDate('tanggal', Carbon::tomorrow())->where('jam_mulai', '16:00:00')->first();
        if ($slotPending) {
            $slotPending->update(['tersedia' => false]);
            $bPend = Booking::create([
                'kode_booking' => 'BK-' . date('ymd') . '-03C3',
                'user_id' => $customerBudi->id,
                'lapangan_id' => $basket1->id,
                'jadwal_slot_id' => $slotPending->id,
                'tanggal_booking' => $slotPending->tanggal,
                'jam_mulai' => $slotPending->jam_mulai,
                'jam_selesai' => $slotPending->jam_selesai,
                'total_harga' => $slotPending->harga_efektif,
                'status' => 'pending',
                'metode_pembayaran' => 'qris',
                'expires_at' => now()->addMinutes(15),
                'catatan' => 'Latihan 3x3 komunitas kampus',
            ]);
            BookingSlot::create([
                'booking_id' => $bPend->id,
                'jadwal_slot_id' => $slotPending->id,
                'harga' => $slotPending->harga_efektif,
            ]);
        }
    }
}
