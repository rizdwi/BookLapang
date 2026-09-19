<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->index(['user_id', 'status'], 'idx_bookings_user_status');
            $table->index(['jadwal_slot_id', 'status'], 'idx_bookings_slot_status');
            $table->index('tanggal_booking', 'idx_bookings_tanggal');
        });

        Schema::table('jadwal_slots', function (Blueprint $table) {
            $table->index(['lapangan_id', 'tanggal', 'jam_mulai'], 'idx_slots_lapangan_tanggal_jam');
            $table->index(['tersedia', 'tanggal'], 'idx_slots_tersedia_tanggal');
        });

        Schema::table('lapangan', function (Blueprint $table) {
            $table->index(['aktif', 'tipe'], 'idx_lapangan_aktif_tipe');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex('idx_bookings_user_status');
            $table->dropIndex('idx_bookings_slot_status');
            $table->dropIndex('idx_bookings_tanggal');
        });

        Schema::table('jadwal_slots', function (Blueprint $table) {
            $table->dropIndex('idx_slots_lapangan_tanggal_jam');
            $table->dropIndex('idx_slots_tersedia_tanggal');
        });

        Schema::table('lapangan', function (Blueprint $table) {
            $table->dropIndex('idx_lapangan_aktif_tipe');
        });
    }
};
