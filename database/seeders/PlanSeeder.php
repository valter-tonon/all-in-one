<?php

namespace Database\Seeders;

use App\Domain\Entities\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Plano Básico',
                'description' => 'Acesso a recursos básicos do sistema',
                'price' => 99.90,
                'features' => json_encode(['Acesso ao sistema', 'Suporte por email', 'Até 3 usuários']),
                'status' => 'active',
            ],
            [
                'name' => 'Plano Profissional',
                'description' => 'Acesso a recursos avançados e suporte prioritário',
                'price' => 199.90,
                'features' => json_encode(['Acesso ao sistema', 'Suporte prioritário', 'Até 10 usuários', 'Relatórios avançados']),
                'status' => 'active',
            ],
            [
                'name' => 'Plano Enterprise',
                'description' => 'Acesso completo a todos os recursos e suporte dedicado',
                'price' => 399.90,
                'features' => json_encode(['Acesso ao sistema', 'Suporte dedicado 24/7', 'Usuários ilimitados', 'Relatórios avançados', 'API completa', 'Personalização']),
                'status' => 'active',
            ],
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
} 