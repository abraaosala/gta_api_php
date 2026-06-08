<?php

namespace Database\Factories;

use App\Models\EstimatorDevice;
use App\Models\EstimatorIssue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EstimatorIssue>
 */
class EstimatorIssueFactory extends Factory
{
    public function definition(): array
    {
        return [
            'device_id' => EstimatorDevice::factory(),
            'name' => fake()->randomElement([
                'Ecrã partido',
                'Bateria com problemas',
                'Não liga',
                'Problema de software',
                'Danos por água',
                'Botões não funcionam',
            ]),
            'price_multiplier' => fake()->randomFloat(2, 0.3, 2.0),
        ];
    }
}
