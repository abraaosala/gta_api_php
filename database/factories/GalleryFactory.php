<?php

namespace Database\Factories;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Gallery>
 */
class GalleryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image' => fake()->imageUrl(800, 600, 'tech'),
            'title' => fake()->sentence(3),
            'category' => fake()->randomElement(['antes-depois', 'laboratorio', 'equipa', 'oficina']),
            'description' => fake()->sentence(8),
            'sort_order' => fake()->numberBetween(0, 10),
            'active' => true,
        ];
    }
}
