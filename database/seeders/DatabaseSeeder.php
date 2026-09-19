<?php

namespace Database\Seeders;

use App\Models\JadwalSlot;
use App\Models\Lapangan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@booklapang.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890'
        ]);

        // Customer
        User::create([
            'name' => 'Budi Customer',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '081987654321'
        ]);

        // Lapangan
        $lapangan1 = Lapangan::create([
            'nama' => 'Lapangan Futsal A',
            'tipe' => 'futsal',
            'deskripsi' => 'Lapangan futsal indoor dengan rumput sintetis premium.',
            'harga_per_jam' => 100000,
            'aktif' => true,
        ]);

        $lapangan2 = Lapangan::create([
            'nama' => 'Lapangan Badminton 1',
            'tipe' => 'badminton',
            'deskripsi' => 'Lapangan badminton karpet vinyl standar BWF.',
            'harga_per_jam' => 50000,
            'aktif' => true,
        ]);
        
        $lapangan3 = Lapangan::create([
            'nama' => 'Lapangan Basket Outdoor',
            'tipe' => 'basket',
            'deskripsi' => 'Lapangan basket outdoor dengan ring standar internasional.',
            'harga_per_jam' => 75000,
            'aktif' => true,
        ]);

        $lapangan4 = Lapangan::create([
            'nama' => 'Lapangan Tenis VIP',
            'tipe' => 'tenis',
            'deskripsi' => 'Lapangan tenis outdoor hard court.',
            'harga_per_jam' => 120000,
            'aktif' => true,
        ]);

        // Generate Jadwal untuk hari ini dan besok
        $lapangans = [$lapangan1, $lapangan2, $lapangan3, $lapangan4];
        
        foreach ($lapangans as $lapangan) {
            for ($i = 0; $i < 3; $i++) {
                $tanggal = Carbon::today()->addDays($i)->format('Y-m-d');
                $startHour = 8; // Jam 8 pagi
                
                for ($j = 0; $j < 10; $j++) { // 10 slot per hari
                    $mulai = sprintf('%02d:00:00', $startHour + $j);
                    $selesai = sprintf('%02d:00:00', $startHour + $j + 1);
                    
                    JadwalSlot::create([
                        'lapangan_id' => $lapangan->id,
                        'tanggal' => $tanggal,
                        'jam_mulai' => $mulai,
                        'jam_selesai' => $selesai,
                        'tersedia' => true,
                    ]);
                }
            }
        }
    }
}
