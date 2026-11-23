# 🏕️ MyCamp — Sistem Informasi Penyewaan Perlengkapan Camping

**MyCamp** adalah aplikasi berbasis web yang dikembangkan menggunakan framework **Laravel** untuk membantu pengelolaan operasional internal (_back-office_) pada usaha penyewaan perlengkapan camping dan outdoor. Sistem ini dirancang untuk menggantikan pencatatan manual agar pengelolaan stok alat, transaksi penyewaan multi-item, perhitungan denda otomatis, serta rekapitulasi laporan pendapatan berjalan lebih cepat dan akurat.

---

## 👥 Identitas Kelompok

- **Mata Kuliah:** Pemrograman Berbasis Website (PWEB) — Kelas D
- **Kelompok:** Kelompok 7

| No  | Nama Anggota                     | NIM            |
| :-- | :------------------------------- | :------------- |
| 1   | Riki Ega Pramana                 | `202410103023` |
| 2   | Aulia Fadly Juang Sabilur Rosyad | `232410103081` |
| 3   | Ardillan Prasetyo Irawan         | `252410103097` |
| 4   | Ahmad Sandi Fahman               | `252410103098` |

---

## ✨ Fitur Utama Sistem

- **Autentikasi & Hak Akses Berbasis Role:** Pembatasan akses antara **Admin** (akses penuh seluruh fitur) dan **Kasir** (akses operasional transaksi harian) menggunakan Laravel Middleware.
- **Manajemen Katalog & Kondisi Alat:** Pengelolaan data kategori, daftar peralatan outdoor, harga sewa per hari, pemantauan kondisi alat (`baik` / `perlu_perbaikan`), serta sinkronisasi stok otomatis.
- **Manajemen Data Penyewa:** Pencatatan biodata pelanggan beserta nomor identitas jaminan (NIK/KTM) yang dikelola langsung oleh petugas gerai.
- **Transaksi Penyewaan Multi-Item:** Pencatatan penyewaan beberapa jenis peralatan dalam satu nota transaksi lengkap dengan kalkulasi durasi hari dan total biaya secara dinamis menggunakan **jQuery**.
- **Pengembalian & Kalkulasi Denda Otomatis:** Pemrosesan pengembalian barang, pemulihan stok tersedia secara otomatis, serta perhitungan denda keterlambatan dan kerusakan.
- **Dashboard & Laporan Pendapatan:** Ringkasan statistik penyewaan alat terpopuler dan rekapitulasi pendapatan rental berdasarkan filter periode.

---

## 🛠️ Teknologi yang Digunakan

- **Backend:** PHP 8.x & Laravel Framework
- **Frontend:** Blade Templating Engine, HTML5, CSS3, Bootstrap, & jQuery
- **Database:** MySQL (Laragon)

---

## 🗄️ Struktur Basis Data

Sistem ini menggunakan **8 tabel relasional** yang telah dinormalisasi:

1. `role` — Menyimpan daftar peran pengguna (`Admin`, `Kasir`).
2. `akun` — Menyimpan data akun staf internal yang memiliki akses login.
3. `penyewa` — Menyimpan data pelanggan dan identitas jaminan penyewaan.
4. `kategori` — Menyimpan pengelompokan jenis perlengkapan camping & paket hemat.
5. `peralatan` — Menyimpan detail unit alat, tarif harian, stok total, stok tersedia, dan kondisi barang.
6. `penyewaan` — Menyimpan data header transaksi penyewaan.
7. `detail_penyewaan` — Tabel penghubung (_junction table_) untuk rincian alat yang disewa per transaksi.
8. `pengembalian` — Menyimpan data pengembalian aktual serta kalkulasi denda keterlambatan/kerusakan.

---

## 🚀 Panduan Instalasi Lokal

1. **Clone repositori ini:**

    ```bash
    git clone [https://github.com/rickyegaa/MyCamp-App.git](https://github.com/rickyegaa/MyCamp-App.git)
    cd MyCamp-App
    ```

2. **Instal dependensi PHP:**

    ```bash
    composer install
    ```

3. **Salin dan atur konfigurasi environment (`.env`):**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

    Sesuaikan pengaturan database MySQL (Laragon) di dalam file `.env`:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=db_mycamp
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4. **Buat database & jalankan migrasi:**
   Buat database baru bernama `db_mycamp` di phpMyAdmin/HeidiSQL, lalu jalankan perintah:

    ```bash
    php artisan migrate --seed
    ```

5. **Jalankan server lokal:**
    ```bash
    php artisan serve
    ```
    Akses aplikasi melalui browser di `http://127.0.0.1:8000`.
