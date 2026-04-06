<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('akte_kematian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layanan_id')->constrained(
                table: 'layanan',
                column: 'layanan_id'
            )->onDelete('cascade');
            $table->string('nama_almarhum');

            // NIK fields (encrypted, gunakan TEXT type)
            $table->text('nik_almarhum')->nullable();
            $table->text('nik_pelapor')->nullable();

            $table->date('tgl_meninggal');
            $table->string('tempat_meninggal');
            $table->text('sebab_meninggal')->nullable();
            $table->string('nama_pelapor');
            $table->string('hubungan_pelapor');
            $table->string('surat_keterangan_kematian')->nullable();
            $table->string('ktp_almarhum')->nullable();
            $table->string('kartu_keluarga')->nullable();
            $table->enum('status', ['Dokumen Diterima', 'Verifikasi Data', 'Proses Cetak', 'Siap Pengambilan', 'Tolak'])->default('Dokumen Diterima');
            $table->softDeletes();
            $table->timestamps();

            // Index untuk NIK fields
            $table->index('nik_almarhum');
            $table->index('nik_pelapor');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akte_kematian');
    }
};
