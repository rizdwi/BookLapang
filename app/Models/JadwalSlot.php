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
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tersedia' => 'boolean',
    ];

    /**
     * Scope a query to only include available slots.
     */
    public function scopeTersedia(Builder $query): void
    {
        $query->where('tersedia', true);
    }

    /**
     * Get the lapangan that owns the slot.
     */
    public function lapangan(): BelongsTo
    {
        return $this->belongsTo(Lapangan::class);
    }

    /**
     * Get the bookings for the slot.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
