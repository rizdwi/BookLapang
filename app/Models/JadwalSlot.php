<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class JadwalSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'lapangan_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'tersedia',
        'harga',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tersedia' => 'boolean',
        'harga' => 'integer',
    ];

    public function scopeTersedia(Builder $query): void
    {
        $query->where('tersedia', true);
    }

    public function lapangan(): BelongsTo
    {
        return $this->belongsTo(Lapangan::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function bookingSlots(): HasMany
    {
        return $this->hasMany(BookingSlot::class);
    }

    public function getHargaEfektifAttribute(): int
    {
        if ($this->harga && $this->harga > 0) {
            return $this->harga;
        }

        return $this->lapangan ? $this->lapangan->harga_per_jam : 0;
    }
}
