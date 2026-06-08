<?php

namespace Database\Factories;

use App\Models\BusinessInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BusinessInfo>
 */
class BusinessInfoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => 'main',
            'company_name' => 'GTA Tech',
            'address' => 'Luanda, Angola',
            'phone' => '+244 900 000 000',
            'email' => 'info@gtatech.ao',
            'working_hours' => 'Seg-Sex: 8h-18h, Sáb: 9h-13h',
            'about' => 'A GTA Tech é uma empresa angolana especializada em reparação e venda de dispositivos electrónicos.',
            'facebook' => 'https://facebook.com/gtatech',
            'instagram' => 'https://instagram.com/gtatech',
            'whatsapp' => 'https://wa.me/244900000000',
        ];
    }
}
