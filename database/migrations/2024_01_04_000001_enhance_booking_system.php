<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah expires_at & kode_booking pada tabel bookings
        Schema::table('bookings', function (Blueprint $table) {
            $table->dateTime('expires_at')->nullable()->after('catatan');
            $table->string('kode_booking')->nullable()->after('id');
        });

        // 2. Tambah kolom harga pada jadwal_slots untuk dynamic pricing
        Schema::table('jadwal_slots', function (Blueprint $table) {
            $table->integer('harga')->nullable()->after('tersedia');
        });

        // 3. Tambah nomor HP pada tabel users jika belum ada
        if (!Schema::hasColumn('users', 'no_hp')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('no_hp')->nullable()->after('email');
            });
        }

        // 4. Tabel relasi multi-slot: booking_slots
        Schema::create('booking_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->foreignId('jadwal_slot_id')->constrained('jadwal_slots')->onDelete('cascade');
            $table->integer('harga')->default(0);
            $table->timestamps();
        });

        // 5. Backfill kode_booking dan booking_slots untuk data booking yang sudah ada
        $existingBookings = DB::table('bookings')->get();
        foreach ($existingBookings as $b) {
            $kode = 'BK-' . str_pad($b->id, 5, '0', STR_PAD_LEFT);
            DB::table('bookings')->where('id', $b->id)->update([
                'kode_booking' => $kode,
            ]);

            if ($b->jadwal_slot_id) {
                DB::table('booking_slots')->insert([
                    'booking_id' => $b->id,
                    'jadwal_slot_id' => $b->jadwal_slot_id,
                    'harga' => $b->total_harga,
                    'created_at' => $b->created_at ?? now(),
                    'updated_at' => $b->updated_at ?? now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_slots');

        Schema::table('jadwal_slots', function (Blueprint $table) {
            $table->dropColumn('harga');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['expires_at', 'kode_booking']);
        });

        if (Schema::hasColumn('users', 'no_hp')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('no_hp');
            });
        }
    }
};
