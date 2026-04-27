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
        Schema::create('akte_lahir', function (Blueprint $table) {
            // Gunakan CHAR(36) untuk UUID sesuai dengan AkteLahir model
            $table->char('id', 36)->primary();
            $table->char('layanan_id', 36);
            $table->foreign('layanan_id')
                ->references('layanan_id')
                ->on('layanan')
                ->onDelete('cascade');

            // NIK bayi
            $table->text('nik')->nullable();

            $table->string('nomor_registrasi');
            $table->string('nama');
            $table->string('alamat');
            $table->string('fotokopi_buku_nikah');
            $table->string('surat_bidan');
            $table->string('ktp_orangtua');
            $table->string('fotokopi_kk');
            $table->string('identitas_saksi');
            $table->timestamps();

            // Index untuk NIK
            $table->index('nik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akte_lahir');
    }
};
