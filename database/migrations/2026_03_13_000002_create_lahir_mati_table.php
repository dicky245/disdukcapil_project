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
        Schema::create('lahir_mati', function (Blueprint $table) {
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
            $table->string('nama_pelapor');
            $table->string('hubungan_pelapor');
            
            // Rincian Lahir Mati
            $table->date('tgl_lahir');
            $table->string('tempat_lahir');
            $table->integer('lama_kandungan')->nullable();
            $table->string('penolong_persalinan')->nullable();
            
            // Data Orang Tua
            $table->string('nik_ayah')->index();
            $table->string('nama_ayah');
            $table->string('nik_ibu')->index();
            $table->string('nama_ibu');
            
            // Data Bayi (opsional)
            $table->string('nama_bayi')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            
            // Data Saksi
            $table->string('nik_saksi_1')->nullable();
            $table->string('nama_saksi_1')->nullable();
            $table->string('nik_saksi_2')->nullable();
            $table->string('nama_saksi_2')->nullable();
            
            // File uploads
            $table->string('surat_keterangan_lahir_mati')->nullable();
            $table->string('ktp_ayah')->nullable();
            $table->string('ktp_ibu')->nullable();
            $table->string('kk_orangtua')->nullable();
            
            // Status dan metadata
            $table->enum('status', ['Dokumen Diterima', 'Verifikasi Data', 'Proses Cetak', 'Siap Pengambilan', 'Tolak'])
                ->default('Dokumen Diterima');
            $table->text('alasan_penolakan')->nullable();
            $table->text('keterangan')->nullable();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes (nik_pelapor, nik_ayah, nik_ibu already indexed inline above)
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lahir_mati');
    }
};
