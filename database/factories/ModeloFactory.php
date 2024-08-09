<?php

namespace Database\Factories;

use App\Models\Marca;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Modelo>
 */
class ModeloFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nome = fake()->unique()->word();
        return [
            'marca_id' => Marca::factory(),
            'nome' => $nome,
            'slug' => Str::slug($nome),
            'imagem' => fake()->imageUrl(),
            'numero_portas' => fake()->numberBetween(1,5),
            'lugares' => fake()->numberBetween(1,5),
            'airbag' => fake()->boolean(),
            'abs' => fake()->boolean()
        ];
    }
}
