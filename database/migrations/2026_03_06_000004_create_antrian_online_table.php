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
        Schema::create('antrian_online', function (Blueprint $table) {
            $table->id('antrian_online_id');
            $table->string('nomor_antrian', 20)->unique();
            $table->string('nama_lengkap', 100);
            $table->foreignId('layanan_id')->constrained(
                table: 'layanan',
                column: 'layanan_id'
            )->onDelete('cascade');
            $table->enum('status_antrian', ['Menunggu', 'Sedang Diproses', 'Selesai', 'Dibatalkan'])->default('Menunggu');
            $table->timestamps();
            $table->index('nomor_antrian');
            $table->index('tanggal');
            $table->index('status_antrian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antrian_online');
    }
};
