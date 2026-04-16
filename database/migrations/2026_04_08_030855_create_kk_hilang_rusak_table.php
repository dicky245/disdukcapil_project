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
        Schema::create('kk_hilang_rusak', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('layanan_id')->constrained(
                table: 'layanan',
                column: 'layanan_id'
            )->onDelete('cascade');
            $table->string('nomor_antrian')->unique();
            $table->string('nama');
            $table->string('alamat');
            $table->char('nik', 16);
            $table->string('fotokopi_ktp');
            $table->string('fotokopi_izin_tinggal')->nullable();
            $table->string('suket_hilang_rusak');
            $table->string('alasan_penolakan')->nullable();
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
        Schema::dropIfExists('kk_hilang_rusak');
    }
};
