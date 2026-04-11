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
        Schema::create('pisah_kk', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('layanan_id')->constrained(
                table: 'layanan',
                column: 'layanan_id'
            )->onDelete('cascade');
            $table->string('nomor_registrasi')->unique();
            $table->string('nama');
            $table->string('alamat');
            $table->char('nik', 16);
            $table->string('formulir_f102');
            $table->string('fotokopi_buku_nikah');
            $table->string('kk_lama');
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
        Schema::dropIfExists('pisah_kk');
    }
};
