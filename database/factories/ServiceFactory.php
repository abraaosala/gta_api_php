<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'icon' => '🔧',
            'features' => [fake()->sentence(), fake()->sentence(), fake()->sentence()],
            'price_range' => fake()->randomElement(['5.000 - 15.000 Kz', '10.000 - 30.000 Kz', '15.000 - 50.000 Kz']),
            'avg_time' => fake()->randomElement(['1-2 dias', '3-5 dias', '1 semana']),
        ];
    }
}
