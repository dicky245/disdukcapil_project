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
        Schema::create('akte_kematian', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            
            // Foreign keys
            $table->foreignId('layanan_id')->constrained(
                table: 'layanan',
                column: 'layanan_id'
            )->onDelete('cascade');
            $table->uuid('antrian_online_id')->nullable();
            
            // Form fields
            $table->string('nomor_registrasi')->nullable();
            
            // Data Pelapor
            $table->string('nik_pelapor')->index();
            $table->string('nomor_kk_pelapor')->nullable();
            $table->string('nama_pelapor');
            $table->string('hubungan_pelapor');
            
            // Identitas Jenazah
            $table->string('nik_almarhum')->nullable()->index();
            $table->string('nama_almarhum');
            
            // Rincian Kematian
            $table->date('tgl_meninggal');
            $table->string('tempat_meninggal');
            $table->text('sebab_meninggal')->nullable();
            $table->string('yang_menerangkan')->nullable();
            
            // Data Saksi
            $table->string('nik_saksi_1')->nullable();
            $table->string('nama_saksi_1')->nullable();
            $table->string('nik_saksi_2')->nullable();
            $table->string('nama_saksi_2')->nullable();
            
            // File uploads
            $table->string('surat_keterangan_kematian')->nullable();
            $table->string('ktp_almarhum')->nullable();
            $table->string('kartu_keluarga')->nullable();
            $table->string('dokumen_perjalanan')->nullable();
            
            // Status dan metadata
            $table->enum('status', ['Dokumen Diterima', 'Verifikasi Data', 'Proses Cetak', 'Siap Pengambilan', 'Tolak'])
                ->default('Dokumen Diterima');
            $table->text('alasan_penolakan')->nullable();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes (nik_pelapor & nik_almarhum already indexed inline above)
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akte_kematian');
    }
};
