<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyewa extends Model
{
    protected $table = 'penyewa';
    protected $primaryKey = 'id_penyewa';
    protected $guarded = ['id_penyewa'];
    public $timestamps = false;

    public function penyewaan()
    {
        return $this->hasMany(Penyewaan::class, 'penyewa_id', 'id_penyewa');
    }
}