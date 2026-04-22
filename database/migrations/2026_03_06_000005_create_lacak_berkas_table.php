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
        Schema::create('lacak_berkas', function (Blueprint $table) {
            $table->id('lacak_berkas_id');
            // Gunakan TEXT untuk UUID foreign key (SQLite lebih kompatibel dengan TEXT)
            $table->text('antrian_online_id');
            $table->string('status', 100);
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('antrian_online_id')
                ->references('antrian_online_id')
                ->on('antrian_online')
                ->onDelete('cascade');

            $table->index('antrian_online_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lacak_berkas');
    }
};
