<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Update NIK fields to support encrypted data
     * NIK di Indonesia adalah 16 digit, tapi setelah encryption akan lebih panjang
     */
    public function up(): void
    {
        // Update akte_lahir table (nama table yang benar)
        Schema::table('akte_lahir', function (Blueprint $table) {
            // Tambah field nik jika belum ada
            if (!Schema::hasColumn('akte_lahir', 'nik')) {
                $table->text('nik')->nullable()->after('nama');
            }
        });

        // Update akte_kematian table
        Schema::table('akte_kematian', function (Blueprint $table) {
            // Ubah tipe data untuk mendukung encrypted NIK
            $table->text('nik_almarhum')->nullable()->change();
            $table->text('nik_pelapor')->nullable()->change();
        });

        // Update lahir_mati table
        Schema::table('lahir_mati', function (Blueprint $table) {
            // Ubah tipe data untuk mendukung encrypted NIK
            $table->text('nik_ayah')->nullable()->change();
            $table->text('nik_ibu')->nullable()->change();
        });

        // Update keagamaan table jika ada field nik
        if (Schema::hasTable('keagamaan')) {
            Schema::table('keagamaan', function (Blueprint $table) {
                if (Schema::hasColumn('keagamaan', 'nik_suami')) {
                    $table->text('nik_suami')->nullable()->change();
                }
                if (Schema::hasColumn('keagamaan', 'nik_istri')) {
                    $table->text('nik_istri')->nullable()->change();
                }
            });
        }

        // Update kartu_keluarga table jika ada
        if (Schema::hasTable('kartu_keluarga')) {
            Schema::table('kartu_keluarga', function (Blueprint $table) {
                if (Schema::hasColumn('kartu_keluarga', 'nomor_kk')) {
                    $table->text('nomor_kk')->nullable()->change();
                }
                if (Schema::hasColumn('kartu_keluarga', 'nik_kepala_keluarga')) {
                    $table->text('nik_kepala_keluarga')->nullable()->change();
                }
            });
        }
    }

    public function down(): void
    {
        // Rollback changes
        Schema::table('akte_lahir', function (Blueprint $table) {
            if (Schema::hasColumn('akte_lahir', 'nik')) {
                $table->dropColumn('nik');
            }
        });

        Schema::table('akte_kematian', function (Blueprint $table) {
            $table->string('nik_almarhum', 16)->nullable()->change();
            $table->string('nik_pelapor', 16)->nullable()->change();
        });

        Schema::table('lahir_mati', function (Blueprint $table) {
            $table->string('nik_ayah', 16)->nullable()->change();
            $table->string('nik_ibu', 16)->nullable()->change();
        });
    }
};
