<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Lapangan extends Model
{
    use HasFactory;

    protected $table = 'lapangan';

    protected $fillable = [
        'nama',
        'tipe',
        'deskripsi',
        'harga_per_jam',
        'foto',
        'alamat',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    /**
     * Scope a query to only include active lapangan.
     */
    public function scopeAktif(Builder $query): void
    {
        $query->where('aktif', true);
    }

    /**
     * Get the jadwal slots for the lapangan.
     */
    public function jadwalSlots(): HasMany
    {
        return $this->hasMany(JadwalSlot::class);
    }

    /**
     * Get the bookings for the lapangan.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
