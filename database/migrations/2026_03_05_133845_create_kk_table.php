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
            // Gunakan CHAR(36) untuk UUID sesuai dengan KartuKeluarga model
            $table->char('id', 36)->primary();
            $table->foreignId('layanan_id')->constrained(
                table: 'layanan',
                column: 'layanan_id'
            )->onDelete('cascade');
            $table->string('nomor_registrasi')->unique();
            $table->string('nama');
            $table->string('alamat');
            $table->string('kutipan_perkawinan');
            $table->string('keterangan_pindah')->nullable();
            $table->string('kk_lama');
            $table->string('surat_keterangan_pengganti');
            $table->string('salinan_kepres');
            $table->string('izin_tinggal_asing')->nullable();
            $table->enum('status',['Dokumen Diterima', 'Verifikasi Data','Proses Cetak', 'Siap Pengambilan','Tolak'])->default('Dokumen Diterima');
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
