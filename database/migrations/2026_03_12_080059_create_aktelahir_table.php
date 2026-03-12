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
        Schema::create('aktelahir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layanan_id')->constrained(
                table: 'layanan',
                column: 'layanan_id'
            )->onDelete('cascade');
            $table->string('nomor_registrasi');
            $table->string('nama');
            $table->string('alamat');
            $table->string('fotokopi_buku_nikah');
            $table->string('surat_bidan');
            $table->string('ktp_orangtua');
            $table->string('fotokopi_kk');
            $table->string('identitas_saksi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktelahir');
    }
};
