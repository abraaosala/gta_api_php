<?php

namespace Database\Factories;

use App\Models\EstimatorDevice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EstimatorDevice>
 */
class EstimatorDeviceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Smartphone', 'Laptop', 'Tablet', 'Smartwatch', 'Desktop']),
            'icon' => '📱',
            'base_price' => fake()->randomFloat(2, 5000, 50000),
        ];
    }
}
