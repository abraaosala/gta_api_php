<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'role' => fake()->randomElement(['Técnico Sénior', 'Técnico de Reparação', 'Atendimento ao Cliente', 'Gerente de Operações', 'Especialista em Microsoldadura']),
            'photo' => fake()->imageUrl(300, 300, 'people'),
            'bio' => fake()->paragraph(2),
            'social_links' => ['facebook' => '', 'instagram' => '', 'linkedin' => '', 'whatsapp' => ''],
            'sort_order' => fake()->numberBetween(0, 10),
            'active' => true,
        ];
    }
}
