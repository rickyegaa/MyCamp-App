<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $table = 'pengembalian';
    protected $primaryKey = 'id_pengembalian';
    protected $guarded = ['id_pengembalian'];
    public $timestamps = false;

    public function penyewaan()
    {
        return $this->belongsTo(Penyewaan::class, 'penyewaan_id', 'id_penyewaan');
    }

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'akun_id', 'id_akun');
    }
}