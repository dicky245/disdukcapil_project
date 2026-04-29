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
        Schema::table('antrian_online', function (Blueprint $table) {
            // Tambahkan kolom untuk path file KTP hasil scan
            $table->string('file_ktp_path', 500)->nullable()->after('alamat');
            
            // Kolom untuk menyimpan raw text hasil OCR
            $table->text('ocr_raw_text')->nullable()->after('file_ktp_path');
            
            // Kolom confidence keseluruhan
            $table->decimal('ocr_confidence', 5, 4)->nullable()->after('ocr_raw_text');
            
            // JSON field untuk menyimpan field confidence per field
            $table->json('ocr_field_confidence')->nullable()->after('ocr_confidence');
            
            // Timestamp untuk OCR processing
            $table->timestamp('ocr_processed_at')->nullable()->after('ocr_field_confidence');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antrian_online', function (Blueprint $table) {
            $table->dropColumn([
                'file_ktp_path',
                'ocr_raw_text',
                'ocr_confidence',
                'ocr_field_confidence',
                'ocr_processed_at',
            ]);
        });
    }
};
