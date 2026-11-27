<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peralatan extends Model
{
    protected $table = 'peralatan';
    protected $primaryKey = 'id_peralatan';
    public $timestamps = false;

    protected $fillable = [
        'kategori_id', 'kode_alat', 'nama_alat', 'harga_sewa_per_hari',
        'stok_total', 'stok_tersedia', 'status_kondisi', 'foto',
    ];

    protected function casts(): array
    {
        return [
            'harga_sewa_per_hari' => 'decimal:2',
            'stok_total' => 'integer',
            'stok_tersedia' => 'integer',
        ];
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id_kategori');
    }

    /** Jumlah unit yang sedang disewa (dihitung dari stok). */
    public function getStokDisewaAttribute(): int
    {
        return $this->stok_total - $this->stok_tersedia;
    }
}
