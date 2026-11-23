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
        Schema::create('peralatan', function (Blueprint $table) {
            $table->id('id_peralatan');
            $table->unsignedBigInteger('kategori_id');
            $table->string('kode_alat', 20);
            $table->string('nama_alat', 100);
            $table->decimal('harga_sewa_per_hari', 15, 2);
            $table->integer('stok_total');
            $table->integer('stok_tersedia');
            $table->enum('status_kondisi', ['baik', 'perlu_perbaikan'])->default('baik');
            $table->string('foto', 255)->nullable();

            $table->foreign('kategori_id')->references('id_kategori')->on('kategori')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peralatan');
    }
};
