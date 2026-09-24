<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel tarif dinamis per lapangan berdasarkan hari dan jam
        Schema::create('lapangan_tarifs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lapangan_id')->constrained('lapangan')->onDelete('cascade');
            $table->enum('tipe_hari', ['weekday', 'weekend', 'all'])->default('all');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->integer('harga');
            $table->string('label')->nullable(); // misal "Peak Hour", "Non-Peak"
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lapangan_tarifs');
    }
};
