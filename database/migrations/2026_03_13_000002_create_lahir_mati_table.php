<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lahir_mati', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layanan_id')->constrained(
                table: 'layanan',
                column: 'layanan_id'
            )->onDelete('cascade');
            $table->string('nama_bayi');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->datetime('tgl_lahir');
            $table->string('tempat_lahir');
            $table->string('nama_ayah');
            $table->string('nik_ayah');
            $table->string('nama_ibu');
            $table->string('nik_ibu');
            $table->text('keterangan')->nullable();
            $table->string('surat_keterangan_lahir_mati')->nullable();
            $table->string('ktp_ayah')->nullable();
            $table->string('ktp_ibu')->nullable();
            $table->enum('status', ['Dokumen Diterima', 'Verifikasi Data', 'Proses Cetak', 'Siap Pengambilan', 'Tolak'])->default('Dokumen Diterima');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lahir_mati');
    }
};
