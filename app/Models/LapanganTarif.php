<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LapanganTarif extends Model
{
    use HasFactory;

    protected $table = 'lapangan_tarifs';

    protected $fillable = [
        'lapangan_id',
        'tipe_hari',
        'jam_mulai',
        'jam_selesai',
        'harga',
        'label',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'harga' => 'integer',
    ];

    public function lapangan(): BelongsTo
    {
        return $this->belongsTo(Lapangan::class);
    }
}
