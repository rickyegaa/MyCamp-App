<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenyewaan extends Model
{
    protected $table = 'detail_penyewaan';
    protected $primaryKey = 'id_detail';
    protected $guarded = ['id_detail'];
    public $timestamps = false;

    public function penyewaan()
    {
        return $this->belongsTo(Penyewaan::class, 'penyewaan_id', 'id_penyewaan');
    }

    public function peralatan()
    {
        return $this->belongsTo(Peralatan::class, 'peralatan_id', 'id_peralatan');
    }
}