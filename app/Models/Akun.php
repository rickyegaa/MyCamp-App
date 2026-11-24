<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Akun extends Authenticatable
{
    protected $table = 'akun';
    protected $primaryKey = 'id_akun';
    const UPDATED_AT = null;

    protected $fillable = [
        'role_id',
        'nama_lengkap',
        'email',
        'password',
        'telepon',
        'status_aktif',
    ];

    protected $hidden = ['password'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'status_aktif' => 'boolean',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id_role');
    }
}