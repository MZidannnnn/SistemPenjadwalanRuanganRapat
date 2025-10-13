<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Pemesanan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PemesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
                Pemesanan::query()->delete();

        // Lakukan perulangan 50 kali untuk membuat 50 data pemesanan
        for ($i = 0; $i < 50; $i++) {
            // Tentukan jam mulai secara acak antara 08:00 - 15:00
            $startHour = rand(8, 15);
            $startMinute = rand(0, 1) ? 0 : 30; // Mulai di jam bulat atau menit ke-30

            // Buat objek waktu mulai untuk tanggal 13 Oktober 2025
            $waktuMulai = Carbon::create(2025, 10, 13, $startHour, $startMinute, 0);

            // Buat waktu selesai dengan durasi acak 1-3 jam
            $waktuSelesai = $waktuMulai->copy()->addHours(rand(1, 3));

            // Gunakan factory untuk membuat data, tapi timpa waktu_mulai dan waktu_selesai
            Pemesanan::factory()->create([
                'waktu_mulai' => $waktuMulai,
                'waktu_selesai' => $waktuSelesai,
            ]);
        }

    }
}
