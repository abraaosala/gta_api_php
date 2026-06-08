<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'category' => fake()->randomElement(['smartphone', 'laptop', 'tablet', 'acessorio']),
            'price' => fake()->randomFloat(2, 10000, 500000),
            'original_price' => fake()->randomFloat(2, 20000, 600000),
            'image' => '',
            'description' => fake()->paragraph(),
            'specs' => [fake()->word().': '.fake()->word(), fake()->word().': '.fake()->word()],
        ];
    }
}
