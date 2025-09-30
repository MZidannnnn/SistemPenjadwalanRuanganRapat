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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('ruangan_id')->constrained('ruangan')->onDelete('cascade');
            $table->string('nama_kegiatan');
            $table->dateTime('tanggal');
            $table->Time('waktu_mulai');
            $table->Time('waktu_selesai');
            // Enum untuk status peminjaman
            $table->enum('status', ['dijadwalkan', 'selesai', 'dibatalkan'])->default('dijadwalkan');
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
