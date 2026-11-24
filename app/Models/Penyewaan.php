<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyewaan extends Model
{
    protected $table = 'penyewaan';
    protected $primaryKey = 'id_penyewaan';
    protected $guarded = ['id_penyewaan'];
    public $timestamps = false;

    public function penyewa()
    {
        return $this->belongsTo(Penyewa::class, 'penyewa_id', 'id_penyewa');
    }

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'akun_id', 'id_akun');
    }

    public function details()
    {
        return $this->hasMany(DetailPenyewaan::class, 'penyewaan_id', 'id_penyewaan');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'penyewaan_id', 'id_penyewaan');
    }
}