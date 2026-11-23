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
        Schema::create('akun', function (Blueprint $table) {
            $table->id('id_akun');
            $table->unsignedBigInteger('role_id');
            $table->string('nama_lengkap', 64);
            $table->string('email', 64)->unique();
            $table->string('password', 255);
            $table->string('telepon', 13)->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->timestamp('created_at')->useCurrent()->nullable();

            $table->foreign('role_id')->references('id_role')->on('role')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akun');
    }
};
