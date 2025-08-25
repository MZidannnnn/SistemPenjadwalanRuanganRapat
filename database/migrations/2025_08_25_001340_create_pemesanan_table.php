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
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id('id_pemesanan');
            // Foreign Key yang menghubungkan ke tabel 'users'
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Foreign Key yang menghubungkan ke tabel 'ruangans'
            $table->foreignId('id_ruangan')->constrained(
                table: 'ruangan',
                column: 'id_ruangan'
            )->onDelete('cascade');
            $table->string('nama_kegiatan');
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai');
            // Enum untuk status peminjaman
            $table->enum('status', ['ditolak', 'selesai', 'dibatalkan']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
