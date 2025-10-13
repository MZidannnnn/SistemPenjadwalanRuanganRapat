<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Ruangan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pemesanan>
 */
class PemesananFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
                        'user_id' => User::inRandomOrder()->first()->id,
            'ruangan_id' => Ruangan::inRandomOrder()->first()->id,
            
            // Buat nama kegiatan palsu dengan 3 kata
            'nama_kegiatan' => fake()->sentence(3),

        ];
    }
}
