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

    protected $appends = [
        'foto_url',
        'wilayah',
    ];

    /**
     * Get wilayah / region for location filtering & badges
     */
    public function getWilayahAttribute(): string
    {
        if (empty($this->alamat)) {
            return 'Jakarta';
        }
        foreach (['Jakarta Selatan', 'Jakarta Pusat', 'Jakarta Barat', 'Jakarta Timur', 'Jakarta Utara'] as $region) {
            if (stripos($this->alamat, $region) !== false) {
                return $region;
            }
        }
        return 'Jakarta';
    }

    /**
     * Get image URL with automatic fallback for local and Vercel CDN
     */
    public function getFotoUrlAttribute(): string
    {
        if (empty($this->foto)) {
            $defaultTipe = $this->tipe ?: 'futsal';
            return asset('images/lapangan/' . $defaultTipe . '.jpg');
        }

        // Support full external URL (e.g. Cloudinary, S3, Unsplash)
        if (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://')) {
            return $this->foto;
        }

        $filename = basename($this->foto);

        // Check in public/images/lapangan/ (Vercel & local static assets)
        if (file_exists(public_path('images/lapangan/' . $filename))) {
            return asset('images/lapangan/' . $filename);
        }

        // Check in public/images/
        if (file_exists(public_path('images/' . $this->foto))) {
            return asset('images/' . $this->foto);
        }

        // Fallback to sport type image
        $sportTipe = $this->tipe ?: 'futsal';
        if (file_exists(public_path('images/lapangan/' . $sportTipe . '.jpg'))) {
            return asset('images/lapangan/' . $sportTipe . '.jpg');
        }

        return asset('images/lapangan/' . $filename);
    }

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

    /**
     * Get the dynamic tariffs for the lapangan.
     */
    public function tarifs(): HasMany
    {
        return $this->hasMany(LapanganTarif::class);
    }
}
