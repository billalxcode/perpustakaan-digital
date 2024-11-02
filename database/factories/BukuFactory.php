<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Buku>
 */
class BukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = fake('id_ID');

        return [
            'cover' => 'https://dummyimage.com/400x600/000/fff&text=Sample+Buku',
            'judul' => $faker->sentence(3),
            'penulis' => $faker->name(),
            'penerbit' => $faker->company(),
            'tahun_terbit' => $faker->year(),
        ];
    }
}
