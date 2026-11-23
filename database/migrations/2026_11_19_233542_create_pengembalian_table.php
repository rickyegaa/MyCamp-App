<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id('id_pengembalian');
            $table->unsignedBigInteger('penyewaan_id');
            $table->unsignedBigInteger('akun_id');
            $table->date('tanggal_aktual_kembali');
            $table->integer('hari_terlambat');
            $table->decimal('denda_terlambat', 15, 2);
            $table->decimal('denda_kerusakan', 15, 2);
            $table->decimal('total_denda', 15, 2);
            $table->text('keterangan')->nullable();

            $table->foreign('penyewaan_id')->references('id_penyewaan')->on('penyewaan')->onDelete('cascade');
            $table->foreign('akun_id')->references('id_akun')->on('akun')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};
