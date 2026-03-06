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
        Schema::create('jenis_keagamaan', function (Blueprint $table) {
            $table->id('jenis_keagamaan_id');
            $table->string('nama_jenis_keagamaan', 100)->unique();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index('nama_jenis_keagamaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_keagamaan');
    }
};
