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
            // Gunakan CHAR(36) untuk UUID sesuai dengan Keagamaan_Model
            $table->char('keagamaan_id', 36)->primary();
            // Gunakan CHAR(36) untuk user_id yang merujuk ke UUID users
            $table->char('user_id', 36)->nullable();

            $table->foreignId('jenis_keagamaan_id')->constrained(
                table: 'jenis_keagamaan',
                column: 'jenis_keagamaan_id'
            )->onDelete('cascade');
            $table->text('alamat');
            $table->enum('status', ['aktif', 'non-aktif'])->default('aktif');
            $table->timestamps();

            // Foreign key constraint untuk user_id
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
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
