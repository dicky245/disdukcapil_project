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

            // NIK ayah (encrypted, gunakan TEXT type)
            $table->text('nik_ayah')->nullable();

            $table->string('nama_ibu');

            // NIK ibu (encrypted, gunakan TEXT type)
            $table->text('nik_ibu')->nullable();

            $table->text('keterangan')->nullable();
            $table->string('surat_keterangan_lahir_mati')->nullable();
            $table->string('ktp_ayah')->nullable();
            $table->string('ktp_ibu')->nullable();
            $table->enum('status', ['Dokumen Diterima', 'Verifikasi Data', 'Proses Cetak', 'Siap Pengambilan', 'Tolak'])->default('Dokumen Diterima');
            $table->softDeletes();
            $table->timestamps();

            // Index untuk NIK fields
            $table->index('nik_ayah');
            $table->index('nik_ibu');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lahir_mati');
    }
};
