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
        Schema::create('penyewaan', function (Blueprint $table) {
            $table->id('id_penyewaan');
            $table->string('kode_transaksi', 20);
            $table->unsignedBigInteger('penyewa_id');
            $table->unsignedBigInteger('akun_id');
            $table->date('tanggal_sewa');
            $table->date('tanggal_rencana_kembali');
            $table->integer('durasi_hari');
            $table->decimal('total_biaya', 15, 2);
            $table->enum('status', ['disewa', 'selesai'])->default('disewa');

            $table->foreign('penyewa_id')->references('id_penyewa')->on('penyewa')->onDelete('cascade');
            $table->foreign('akun_id')->references('id_akun')->on('akun')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyewaan');
    }
};
