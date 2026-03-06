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
            $table->foreignId('antrian_online_id')->constrained(
                table: 'antrian_online',
                column: 'antrian_online_id'
            )->onDelete('cascade');
            $table->string('status', 100);
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
            $table->timestamps();

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
