<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Role
        DB::table('role')->insertOrIgnore([
            ['id_role' => 1, 'nama_role' => 'Admin'],
            ['id_role' => 2, 'nama_role' => 'Kasir'],
        ]);

        // 2. Data Akun Petugas
        DB::table('akun')->updateOrInsert(
            ['email' => 'admin@mycamp.com'],
            [
                'role_id'      => 1,
                'nama_lengkap' => 'Admin MyCamp',
                'password'     => Hash::make('password123'),
                'telepon'      => '081234567890',
                'status_aktif' => 1,
            ]
        );

        // 3. Data Penyewa
        DB::table('penyewa')->insertOrIgnore([
            [
                'id_penyewa'   => 1,
                'nik_ktm'      => '3509123456780001',
                'nama_lengkap' => 'Rizky Rayhan Ramadhan',
                'telepon'      => '081234567891',
                'alamat'       => 'Jl. Diponegoro No. 10, Yogyakarta',
            ],
            [
                'id_penyewa'   => 2,
                'nik_ktm'      => '3509123456780002',
                'nama_lengkap' => 'Amalia Izzati Faidia',
                'telepon'      => '081234567892',
                'alamat'       => 'Jl. Mastrip No. 24, Jember',
            ],
            [
                'id_penyewa'   => 3,
                'nik_ktm'      => '3501843456780002',
                'nama_lengkap' => 'Riki Ega Pramana',
                'telepon'      => '081543123432',
                'alamat'       => 'Jl. Sudirman No. 7, Surabaya',
            ],
        ]);

        // 4. Data Kategori Peralatan (Induk kategori_id)
        $tabelKategori = Schema::hasTable('kategori_peralatan') ? 'kategori_peralatan' : 'kategori';
        if (Schema::hasTable($tabelKategori)) {
            $pkKategori = Schema::hasColumn($tabelKategori, 'id_kategori') ? 'id_kategori' : 'id';
            $colNamaKat = Schema::hasColumn($tabelKategori, 'nama_kategori') ? 'nama_kategori' : 'nama';

            DB::table($tabelKategori)->insertOrIgnore([
                [$pkKategori => 1, $colNamaKat => 'Tenda & Shelter'],
                [$pkKategori => 2, $colNamaKat => 'Tas & Perlengkapan Masak'],
            ]);
        }

        // 5. Data Peralatan Camping (Otomatis menyesuaikan kolom tabel)
        $items = [
            [
                'id_peralatan'        => 1,
                'kategori_id'         => 1,
                'kode_alat'           => 'ALT-001',
                'nama_alat'           => 'Tenda Dome Kapasitas 4 Orang',
                'harga_sewa_per_hari' => 50000,
                'stok_total'          => 8,
                'stok_tersedia'       => 8,
                'kondisi'             => 'Baik',
            ],
            [
                'id_peralatan'        => 2,
                'kategori_id'         => 2,
                'kode_alat'           => 'ALT-002',
                'nama_alat'           => 'Carrier Gunung 60L',
                'harga_sewa_per_hari' => 35000,
                'stok_total'          => 10,
                'stok_tersedia'       => 10,
                'kondisi'             => 'Baik',
            ],
            [
                'id_peralatan'        => 3,
                'kategori_id'         => 2,
                'kode_alat'           => 'ALT-003',
                'nama_alat'           => 'Kompor Portable + Nesting',
                'harga_sewa_per_hari' => 25000,
                'stok_total'          => 12,
                'stok_tersedia'       => 12,
                'kondisi'             => 'Baik',
            ],
        ];

        $kolomAda = Schema::getColumnListing('peralatan');
        $rowsPeralatan = array_map(
            fn($item) => array_intersect_key($item, array_flip($kolomAda)),
            $items
        );

        DB::table('peralatan')->upsert(
            $rowsPeralatan,
            ['id_peralatan'],
            ['kategori_id', 'nama_alat', 'harga_sewa_per_hari', 'stok_tersedia']
        );
    }
}