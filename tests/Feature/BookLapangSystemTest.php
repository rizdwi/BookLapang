<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\BookingSlot;
use App\Models\JadwalSlot;
use App\Models\Lapangan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookLapangSystemTest extends TestCase
{
    use RefreshDatabase;

    private function createCustomer(array $overrides = []): User
    {
        return User::create(array_merge([
            'name' => 'John Doe',
            'email' => 'customer@test.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
            'no_hp' => '081234567890',
        ], $overrides));
    }

    private function createAdmin(array $overrides = []): User
    {
        return User::create(array_merge([
            'name' => 'Admin Boss',
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'no_hp' => '081299998888',
        ], $overrides));
    }

    private function createLapangan(array $overrides = []): Lapangan
    {
        return Lapangan::create(array_merge([
            'nama' => 'Gor Futsal Juara',
            'tipe' => 'futsal',
            'deskripsi' => 'Lapangan futsal vinyl standar internasional',
            'harga_per_jam' => 150000,
            'is_aktif' => true,
            'fasilitas' => ['Toilet', 'WiFi', 'Parkir'],
            'alamat' => 'Jakarta Selatan',
        ], $overrides));
    }

    public function test_landing_and_catalog_render_properly(): void
    {
        $lapangan = $this->createLapangan();

        $response = $this->get('/');
        $response->assertStatus(200);

        $responseCatalog = $this->get('/lapangan');
        $responseCatalog->assertStatus(200);
        $responseCatalog->assertSee($lapangan->nama);
    }

    public function test_catalog_and_detail_handle_malformed_query_params_gracefully(): void
    {
        $lapangan = $this->createLapangan();

        // Parameter tanggal tidak valid / manipulasi query string
        $response1 = $this->get('/lapangan?tanggal=bukan-tanggal&jam=99:99');
        $response1->assertStatus(200);

        $response2 = $this->get("/lapangan/{$lapangan->id}?tanggal=invalid-date");
        $response2->assertStatus(200);
    }

    public function test_authentication_and_admin_authorization_guards(): void
    {
        $customer = $this->createCustomer();
        $admin = $this->createAdmin();

        // Guest dilarang ke halaman terproteksi
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/admin/dashboard')->assertRedirect('/login');

        // Customer dilarang mengakses halaman admin
        $this->actingAs($customer)->get('/admin/dashboard')->assertStatus(403);
        $this->actingAs($customer)->get('/admin/timetable')->assertStatus(403);

        // Admin dapat mengakses dashboard dan timetable
        $this->actingAs($admin)->get('/admin/dashboard')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/timetable')->assertStatus(200);
    }

    public function test_registration_prevents_privilege_escalation(): void
    {
        $response = $this->post('/register', [
            'name' => 'Hacker Wannabe',
            'email' => 'hacker@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin', // Percobaan eskalasi hak akses
        ]);

        $response->assertRedirect('/');

        $user = User::where('email', 'hacker@test.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('customer', $user->role, 'Role harus tetap customer meskipun disuntik admin di form registrasi');
    }

    public function test_idor_protection_on_booking_tickets(): void
    {
        $userA = $this->createCustomer(['email' => 'usera@test.com']);
        $userB = $this->createCustomer(['email' => 'userb@test.com']);
        $lapangan = $this->createLapangan();

        $slot = JadwalSlot::create([
            'lapangan_id' => $lapangan->id,
            'tanggal' => Carbon::tomorrow()->format('Y-m-d'),
            'jam_mulai' => '10:00:00',
            'jam_selesai' => '11:00:00',
            'harga' => 150000,
            'tersedia' => false,
        ]);

        $bookingA = Booking::create([
            'user_id' => $userA->id,
            'lapangan_id' => $lapangan->id,
            'jadwal_slot_id' => $slot->id,
            'kode_booking' => 'BK-TEST-USERA',
            'tanggal_booking' => Carbon::tomorrow()->format('Y-m-d'),
            'jam_mulai' => '10:00:00',
            'jam_selesai' => '11:00:00',
            'total_harga' => 150000,
            'status' => 'confirmed',
        ]);

        // User A dapat melihat tiket miliknya
        $this->actingAs($userA)->get("/booking/{$bookingA->id}/ticket")->assertStatus(200);

        // User B dilarang (IDOR) melihat tiket User A
        $this->actingAs($userB)->get("/booking/{$bookingA->id}/ticket")->assertStatus(403);

        // User B dilarang membatalkan pesanan User A
        $this->actingAs($userB)->post("/booking/{$bookingA->id}/cancel")->assertStatus(403);
    }

    public function test_booking_multi_slot_integrity_and_validation(): void
    {
        $customer = $this->createCustomer();
        $lapangan1 = $this->createLapangan(['nama' => 'Lapangan 1']);
        $lapangan2 = $this->createLapangan(['nama' => 'Lapangan 2']);

        $slotL1 = JadwalSlot::create([
            'lapangan_id' => $lapangan1->id,
            'tanggal' => Carbon::tomorrow()->format('Y-m-d'),
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '09:00:00',
            'harga' => 100000,
            'tersedia' => true,
        ]);

        $slotL2 = JadwalSlot::create([
            'lapangan_id' => $lapangan2->id,
            'tanggal' => Carbon::tomorrow()->format('Y-m-d'),
            'jam_mulai' => '09:00:00',
            'jam_selesai' => '10:00:00',
            'harga' => 100000,
            'tersedia' => true,
        ]);

        // Percobaan booking slot campuran dari 2 lapangan berbeda
        $resMix = $this->actingAs($customer)->get("/booking/create?slot_ids={$slotL1->id},{$slotL2->id}");
        $resMix->assertSessionHas('error');

        // Booking valid di satu lapangan
        $resValid = $this->actingAs($customer)->post('/booking/store', [
            'lapangan_id' => $lapangan1->id,
            'jadwal_slot_ids' => [$slotL1->id],
            'metode_pembayaran' => 'qris',
        ]);

        $resValid->assertRedirect();
        $this->assertDatabaseHas('bookings', [
            'user_id' => $customer->id,
            'lapangan_id' => $lapangan1->id,
            'status' => 'pending',
        ]);

        // Slot harus terkunci (tersedia = false)
        $this->assertEquals(0, $slotL1->fresh()->tersedia);
    }

    public function test_admin_cannot_delete_slot_with_active_booking(): void
    {
        $admin = $this->createAdmin();
        $customer = $this->createCustomer();
        $lapangan = $this->createLapangan();

        $slot = JadwalSlot::create([
            'lapangan_id' => $lapangan->id,
            'tanggal' => Carbon::tomorrow()->format('Y-m-d'),
            'jam_mulai' => '14:00:00',
            'jam_selesai' => '15:00:00',
            'harga' => 150000,
            'tersedia' => false,
        ]);

        $booking = Booking::create([
            'user_id' => $customer->id,
            'lapangan_id' => $lapangan->id,
            'jadwal_slot_id' => $slot->id,
            'kode_booking' => 'BK-ACTIVE-DEL',
            'tanggal_booking' => Carbon::tomorrow()->format('Y-m-d'),
            'jam_mulai' => '14:00:00',
            'jam_selesai' => '15:00:00',
            'total_harga' => 150000,
            'status' => 'confirmed',
        ]);

        BookingSlot::create([
            'booking_id' => $booking->id,
            'jadwal_slot_id' => $slot->id,
            'harga' => 150000,
        ]);

        // Admin mencoba menghapus slot yang sedang aktif dipesan
        $res = $this->actingAs($admin)->delete("/admin/jadwal/{$slot->id}");
        $res->assertSessionHas('error');

        // Pastikan slot tidak terhapus dari database
        $this->assertDatabaseHas('jadwal_slots', ['id' => $slot->id]);
    }

    public function test_admin_cannot_delete_lapangan_with_active_booking(): void
    {
        $admin = $this->createAdmin();
        $customer = $this->createCustomer();
        $lapangan = $this->createLapangan();

        $slot = JadwalSlot::create([
            'lapangan_id' => $lapangan->id,
            'tanggal' => Carbon::tomorrow()->format('Y-m-d'),
            'jam_mulai' => '16:00:00',
            'jam_selesai' => '17:00:00',
            'harga' => 150000,
            'tersedia' => false,
        ]);

        Booking::create([
            'user_id' => $customer->id,
            'lapangan_id' => $lapangan->id,
            'jadwal_slot_id' => $slot->id,
            'kode_booking' => 'BK-VENUE-DEL',
            'tanggal_booking' => Carbon::tomorrow()->format('Y-m-d'),
            'jam_mulai' => '16:00:00',
            'jam_selesai' => '17:00:00',
            'total_harga' => 150000,
            'status' => 'confirmed',
        ]);

        $res = $this->actingAs($admin)->delete("/admin/lapangan/{$lapangan->id}");
        $res->assertSessionHas('error');

        $this->assertDatabaseHas('lapangan', ['id' => $lapangan->id]);
    }

    public function test_double_booking_prevention_on_same_slot(): void
    {
        $customer1 = $this->createCustomer(['email' => 'c1@test.com']);
        $customer2 = $this->createCustomer(['email' => 'c2@test.com']);
        $lapangan = $this->createLapangan();

        $slot = JadwalSlot::create([
            'lapangan_id' => $lapangan->id,
            'tanggal' => Carbon::tomorrow()->format('Y-m-d'),
            'jam_mulai' => '19:00:00',
            'jam_selesai' => '20:00:00',
            'harga' => 175000,
            'tersedia' => true,
        ]);

        // Customer 1 memesan slot
        $res1 = $this->actingAs($customer1)->post('/booking/store', [
            'lapangan_id' => $lapangan->id,
            'jadwal_slot_ids' => [$slot->id],
            'metode_pembayaran' => 'qris',
        ]);
        $res1->assertRedirect();
        $this->assertEquals(0, $slot->fresh()->tersedia);

        // Customer 2 mencoba memesan slot yang sama (harus ditolak)
        $res2 = $this->actingAs($customer2)->post('/booking/store', [
            'lapangan_id' => $lapangan->id,
            'jadwal_slot_ids' => [$slot->id],
            'metode_pembayaran' => 'transfer_bca',
        ]);
        $res2->assertSessionHas('error');

        // Pastikan hanya ada 1 booking di database untuk slot tersebut
        $this->assertEquals(1, Booking::where('jadwal_slot_id', $slot->id)->count());
    }

    public function test_expired_pending_booking_is_auto_released(): void
    {
        $customer = $this->createCustomer();
        $lapangan = $this->createLapangan();

        $slotOld = JadwalSlot::create([
            'lapangan_id' => $lapangan->id,
            'tanggal' => Carbon::yesterday()->format('Y-m-d'),
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '09:00:00',
            'harga' => 100000,
            'tersedia' => false,
        ]);

        // Pesanan pending yang sudah kedaluwarsa 30 menit lalu
        $oldBooking = Booking::create([
            'user_id' => $customer->id,
            'lapangan_id' => $lapangan->id,
            'jadwal_slot_id' => $slotOld->id,
            'kode_booking' => 'BK-OLD-EXPIRED',
            'tanggal_booking' => Carbon::yesterday()->format('Y-m-d'),
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '09:00:00',
            'total_harga' => 100000,
            'status' => 'pending',
            'expires_at' => now()->subMinutes(30),
            'created_at' => now()->subMinutes(45),
        ]);

        $slotNew = JadwalSlot::create([
            'lapangan_id' => $lapangan->id,
            'tanggal' => Carbon::tomorrow()->format('Y-m-d'),
            'jam_mulai' => '10:00:00',
            'jam_selesai' => '11:00:00',
            'harga' => 100000,
            'tersedia' => true,
        ]);

        // User memesan slot baru, sistem harus otomatis meng-cancel pesanan lama yang expired
        // dan tidak memblokir user
        $res = $this->actingAs($customer)->post('/booking/store', [
            'lapangan_id' => $lapangan->id,
            'jadwal_slot_ids' => [$slotNew->id],
            'metode_pembayaran' => 'qris',
        ]);

        $res->assertRedirect();
        $this->assertEquals('cancelled', $oldBooking->fresh()->status);
        $this->assertEquals(1, $slotOld->fresh()->tersedia);
    }

    public function test_admin_checkin_lookup(): void
    {
        $admin = $this->createAdmin();
        $customer = $this->createCustomer();
        $lapangan = $this->createLapangan();

        $slot = JadwalSlot::create([
            'lapangan_id' => $lapangan->id,
            'tanggal' => Carbon::today()->format('Y-m-d'),
            'jam_mulai' => '10:00:00',
            'jam_selesai' => '11:00:00',
            'harga' => 150000,
            'tersedia' => false,
        ]);

        $booking = Booking::create([
            'user_id' => $customer->id,
            'lapangan_id' => $lapangan->id,
            'jadwal_slot_id' => $slot->id,
            'kode_booking' => 'BK-ALPHA-999',
            'tanggal_booking' => Carbon::today()->format('Y-m-d'),
            'jam_mulai' => '10:00:00',
            'jam_selesai' => '11:00:00',
            'total_harga' => 150000,
            'status' => 'confirmed',
        ]);

        // Cari dengan kode booking lengkap
        $resFull = $this->actingAs($admin)->get('/admin/checkin?code=BK-ALPHA-999');
        $resFull->assertStatus(200);
        $resFull->assertSee($customer->name);

        // Cari dengan ID angka berawalan tanda pagar
        $resId = $this->actingAs($admin)->get('/admin/checkin?code=' . urlencode("#{$booking->id}"));
        $resId->assertStatus(200);
        $resId->assertSee($customer->name);
    }
}
