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
        Schema::create('keagamaan', function (Blueprint $table) {
            $table->id('keagamaan_id');
            $table->foreignId('jenis_keagamaan_id')->constrained(
                table: 'jenis_keagamaan',
                column: 'jenis_keagamaan_id'
            )->onDelete('cascade');
            $table->text('alamat');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index('jenis_keagamaan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keagamaan');
    }
};
