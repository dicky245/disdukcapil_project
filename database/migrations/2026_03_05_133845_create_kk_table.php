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
        Schema::create('kk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layanan_id')->constrained('layanan');
            $table->string('nomor_registrasi')->unique();
            $table->string('nama');
            $table->string('alamat');
            $table->string('kutipan_perkawinan');
            $table->string('keterangan_pindah')->nullable();
            $table->string('kk_lama');
            $table->string('surat_keterangan_pengganti');
            $table->string('salinan_kepres');
            $table->string('izin_tinggal_asing')->nullable();
            $table->enum('status',['menunggu','disetujui','ditolak'])->default('menunggu');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kk');
    }
};
