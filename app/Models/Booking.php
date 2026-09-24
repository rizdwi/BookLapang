<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_booking',
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
        'expires_at',
    ];

    protected $casts = [
        'tanggal_booking' => 'date',
        'expires_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lapangan(): BelongsTo
    {
        return $this->belongsTo(Lapangan::class);
    }

    public function jadwalSlot(): BelongsTo
    {
        return $this->belongsTo(JadwalSlot::class);
    }

    public function bookingSlots(): HasMany
    {
        return $this->hasMany(BookingSlot::class);
    }

    public function scopePending(Builder $query): void
    {
        $query->where('status', 'pending');
    }

    public function scopeConfirmed(Builder $query): void
    {
        $query->where('status', 'confirmed');
    }

    public function isExpired(): bool
    {
        if ($this->status !== 'pending') {
            return false;
        }

        $expireTime = $this->expires_at ?? $this->created_at?->addMinutes(15);
        return $expireTime ? now()->greaterThan($expireTime) : false;
    }

    public function remainingSeconds(): int
    {
        if ($this->status !== 'pending') {
            return 0;
        }

        $expireTime = $this->expires_at ?? $this->created_at?->addMinutes(15);
        if (!$expireTime) {
            return 0;
        }

        return max(0, (int) now()->diffInSeconds($expireTime, false));
    }
}
