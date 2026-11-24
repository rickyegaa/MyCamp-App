<?php

namespace Database\Seeders;

use App\Models\Akun;
use Illuminate\Database\Seeder;

class AkunSeeder extends Seeder
{
    public function run(): void
    {
        Akun::firstOrCreate(
            ['email' => 'admin@mycamp.com'],
            [
                'role_id' => 1,
                'nama_lengkap' => 'Admin MyCamp',
                'password' => 'password123',
                'telepon' => '081234567890',
                'status_aktif' => true,
            ]
        );

        Akun::firstOrCreate(
            ['email' => 'kasir@mycamp.com'],
            [
                'role_id' => 2,
                'nama_lengkap' => 'Ahmad Sandi (Kasir)',
                'password' => 'password123',
                'telepon' => '081298765432',
                'status_aktif' => true,
            ]
        );
    }
}