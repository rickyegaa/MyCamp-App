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
        Schema::create('penyewa', function (Blueprint $table) {
            $table->id('id_penyewa');
            $table->string('nik_ktm', 20);
            $table->string('nama_lengkap', 64);
            $table->string('telepon', 15);
            $table->text('alamat');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyewa');
    }
};
