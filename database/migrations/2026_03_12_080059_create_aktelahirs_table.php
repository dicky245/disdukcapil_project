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
        Schema::create('aktelahirs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('layanan_id')->constrained(
                table: 'layanan',
                column: 'layanan_id'
            )->onDelete('cascade');
            $table->string('nomor_registrasi');
            $table->string('nama_pelapor');
            $table->char('nik_pelapor', 16);
            $table->string('nomor_dokumen');
            $table->string('nomor_kk');
            $table->string('kewarganegaraan_pelapor');
            $table->string('nama_saksi1');
            $table->char('nik_saksi1', 16);
            $table->string('nomor_kk_saksi1');
            $table->string('kewarganegaraan_saksi1');
            $table->string('nama_saksi2');
            $table->char('nik_saksi2', 16);
            $table->string('nomor_kk_saksi2');
            $table->string('kewarganegaraan_saksi2');
            $table->string('nama_ayah');
            $table->char('nik_ayah', 16);
            $table->string('tempat_lahir_ayah');
            $table->string('tanggal_lahir_ayah');
            $table->string('kewarganegaraan_ayah');
            $table->string('nama_ibu');
            $table->char('nik_ibu', 16);
            $table->string('tempat_lahir_ibu');
            $table->string('tanggal_lahir_ibu');
            $table->string('kewarganegaraan_ibu');
            $table->string('nama_anak');
            $table->string('jenis_kelamin');
            $table->string('tempat_dilahirkan');
            $table->string('tempat_kelahiran');
            $table->string('hari_tanggal_lahir');
            $table->string('pukul');
            $table->string('jenis_kelahiran');
            $table->string('kelahiran_ke');
            $table->string('penolong');
            $table->string('berat_bayi');
            $table->string('panjang_bayi');
            $table->string('file_surat_lahir');
            $table->string('file_buku_nikah');
            $table->string('file_kk');
            $table->string('file_sptjm_kelahiran')->nullable();
            $table->string('file_sptjm_pasutri')->nullable();
            $table->string('file_berita_acara_polisi')->nullable();
            $table->string('alasan_penolakan')->nullable();
            $table->enum('status',['Dokumen Diterima', 'Verifikasi Data','Proses Cetak', 'Siap Pengambilan','Tolak'])->default('Dokumen Diterima');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktelahirs');
    }
};
