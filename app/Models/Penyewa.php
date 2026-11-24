<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyewa extends Model
{
    protected $table = 'penyewa';
    protected $primaryKey = 'id_penyewa';
    public $timestamps = false;

    protected $fillable = [
        'nik_ktm',
        'nama_lengkap',
        'telepon',
        'alamat',
    ];
}