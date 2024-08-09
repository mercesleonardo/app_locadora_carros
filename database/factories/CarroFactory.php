<?php

namespace Database\Factories;

use App\Models\Modelo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Carro>
 */
class CarroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'modelo_id' => Modelo::factory(),
            'placa' => strtoupper(fake()->regexify('[A-Z]{3}[0-9]{4}')),
            'disponivel' => fake()->boolean(),
            'km' => fake()->numberBetween(0, 100000),
        ];
    }
}
