<?php

namespace Database\Factories;

use App\Models\ProcessStep;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProcessStep>
 */
class ProcessStepFactory extends Factory
{
    public function definition(): array
    {
        return [
            'step' => fake()->numberBetween(1, 10),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'icon' => '📱',
        ];
    }
}
