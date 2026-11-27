<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Peralatan;
use Illuminate\Database\Seeder;

class KatalogSeeder extends Seeder
{
    public function run(): void
    {
        $tenda = Kategori::firstOrCreate(['nama_kategori' => 'Tenda'], ['deskripsi' => 'Tenda berbagai kapasitas']);
        $tas = Kategori::firstOrCreate(['nama_kategori' => 'Tas & Carrier'], ['deskripsi' => 'Carrier dan daypack']);
        $masak = Kategori::firstOrCreate(['nama_kategori' => 'Peralatan Masak'], ['deskripsi' => 'Kompor, nesting, dan perlengkapan makan']);
        Kategori::firstOrCreate(['nama_kategori' => 'Paket Hemat'], ['deskripsi' => 'Paket kombinasi alat camping']);

        $data = [
            [$tenda->id_kategori, 'TND-001', 'Tenda Dome Kapasitas 4', 50000, 5],
            [$tenda->id_kategori, 'TND-002', 'Tenda Dome Kapasitas 2', 35000, 6],
            [$tas->id_kategori, 'TAS-001', 'Carrier 60L', 30000, 8],
            [$masak->id_kategori, 'MSK-001', 'Kompor Portable', 15000, 10],
            [$masak->id_kategori, 'MSK-002', 'Nesting Set', 10000, 10],
        ];

        foreach ($data as [$kat, $kode, $nama, $harga, $stok]) {
            Peralatan::firstOrCreate(['kode_alat' => $kode], [
                'kategori_id' => $kat,
                'nama_alat' => $nama,
                'harga_sewa_per_hari' => $harga,
                'stok_total' => $stok,
                'stok_tersedia' => $stok,
                'status_kondisi' => 'baik',
            ]);
        }
    }
}
