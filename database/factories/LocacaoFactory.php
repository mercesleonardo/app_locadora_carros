<?php

namespace Database\Factories;

use App\Models\Carro;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Locacao>
 */
class LocacaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dataInicio = fake()->dateTimeBetween('-1 month', 'now');
        $dataFinalPrevisto = fake()->dateTimeBetween($dataInicio, '+1 month');
        $dataFinalRealizado = fake()->dateTimeBetween($dataInicio, $dataFinalPrevisto);

        return [
            'cliente_id' => Cliente::factory(),
            'carro_id' => Carro::factory(),
            'data_inicio_periodo' => $dataInicio,
            'data_final_previsto_periodo' => $dataFinalPrevisto,
            'data_final_realizado_periodo' => $dataFinalRealizado,
            'km_inicial' => fake()->numberBetween(0, 1000),
            'km_final' => fake()->numberBetween(1010, 1800),
            'valor_diaria' => fake()->randomFloat(2, 10, 250)
        ];
    }
}
