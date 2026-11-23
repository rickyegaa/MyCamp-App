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
        Schema::create('detail_penyewaan', function (Blueprint $table) {
            $table->id('id_detail_penyewaan');
            $table->unsignedBigInteger('penyewaan_id');
            $table->unsignedBigInteger('peralatan_id');
            $table->integer('jumlah');
            $table->decimal('harga_sewa', 15, 2);
            $table->decimal('sub_total', 15, 2);

            $table->foreign('penyewaan_id')->references('id_penyewaan')->on('penyewaan')->onDelete('cascade');
            $table->foreign('peralatan_id')->references('id_peralatan')->on('peralatan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_penyewaan');
    }
};
