<?php

namespace Database\Factories;

use App\Models\Feature;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Feature>
 */
class FeatureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $features = [
            ['title' => 'Reparações Expresso', 'description' => 'Mais de 85% das reparações de ecrã ou substituições de baterias são efetuadas e concluídas em menos de 1 hora.', 'badge' => 'Velocidade Máxima', 'icon' => 'Timer'],
            ['title' => 'Diagnóstico 100% Gratuito', 'description' => 'Na GTA-Tech avaliamos o seu telemóvel ou computador fisicamente sem cobrar nada. Só avança se aprovar o orçamento.', 'badge' => 'Sem Compromisso', 'icon' => 'HeartHandshake'],
            ['title' => 'Garantia de 90 Dias', 'description' => 'Todas as nossas intervenções e substituições de componentes vêm com uma garantia de 3 meses registada por escrito.', 'badge' => 'Tranquilidade Total', 'icon' => 'ShieldCheck'],
            ['title' => 'Peças de Alta Gama', 'description' => 'Damos primazia a componentes de teor original com calibração de TrueTone e taxas de refresco idênticas de fábrica.', 'badge' => 'Qualidade Premium', 'icon' => 'Award'],
            ['title' => 'Laboratório Antiestático', 'description' => 'Dispomos de equipamentos profissionais calibrados contra descargas eletrostáticas, garantindo integridade total da placa.', 'badge' => 'Segurança Total', 'icon' => 'CheckCircle'],
            ['title' => 'Centralizados em Cabinda', 'description' => 'Estamos localizados numa área nobre com segurança e fácil estacionamento para sua total comodidade.', 'badge' => 'Estacionamento Fácil', 'icon' => 'MapPin'],
        ];

        $feature = fake()->randomElement($features);

        return $feature + ['sort_order' => fake()->numberBetween(0, 10), 'active' => true];
    }
}
