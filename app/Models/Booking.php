<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lapangan_id',
        'jadwal_slot_id',
        'tanggal_booking',
        'jam_mulai',
        'jam_selesai',
        'total_harga',
        'status',
        'metode_pembayaran',
        'catatan',
    ];

    protected $casts = [
        'tanggal_booking' => 'date',
    ];

    /**
     * Get the user that owns the booking.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the lapangan for this booking.
     */
    public function lapangan(): BelongsTo
    {
        return $this->belongsTo(Lapangan::class);
    }

    /**
     * Get the jadwal slot for this booking.
     */
    public function jadwalSlot(): BelongsTo
    {
        return $this->belongsTo(JadwalSlot::class);
    }

    /**
     * Scope a query to only include pending bookings.
     */
    public function scopePending(Builder $query): void
    {
        $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include confirmed bookings.
     */
    public function scopeConfirmed(Builder $query): void
    {
        $query->where('status', 'confirmed');
    }
}
