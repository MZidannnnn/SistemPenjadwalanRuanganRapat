<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ruangan>
 */
class RuanganFactory extends Factory
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
            'nama_ruangan' => 'Ruang Rapat ' . $this->faker->unique()->word(),
            'kapasitas' => $this->faker->numberBetween(10, 50),
            'fasilitas' => 'AC, Proyektor, Papan Tulis',
            'lokasi' => 'Gedung ' . $this->faker->randomElement(['A', 'B', 'C']) . ' Lantai ' . $this->faker->numberBetween(1, 4),
            'status' => $this->faker->randomElement(['tersedia', 'dalam perbaikan']),

        ];
    }
}
