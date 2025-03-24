<?php

namespace Database\Seeders;

use App\Domain\Entities\Plan;
use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpa os planos existentes
        Plan::truncate();
        
        // Cria os planos padrão
        $plans = [
            [
                'name' => 'Plano Básico',
                'description' => 'Ideal para pequenas empresas que estão começando',
                'price' => 99.90,
                'features' => json_encode([
                    'Até 5 usuários',
                    'Gerenciamento de estoque básico',
                    'Relatórios mensais',
                    'Suporte por email'
                ]),
                'status' => 'active'
            ],
            [
                'name' => 'Plano Profissional',
                'description' => 'Perfeito para empresas em crescimento',
                'price' => 199.90,
                'features' => json_encode([
                    'Até 15 usuários',
                    'Gerenciamento de estoque avançado',
                    'Relatórios semanais',
                    'Suporte por email e chat',
                    'Integração com sistemas de pagamento'
                ]),
                'status' => 'active'
            ],
            [
                'name' => 'Plano Enterprise',
                'description' => 'Solução completa para grandes empresas',
                'price' => 399.90,
                'features' => json_encode([
                    'Usuários ilimitados',
                    'Gerenciamento de estoque completo',
                    'Relatórios em tempo real',
                    'Suporte prioritário 24/7',
                    'Integração com sistemas de pagamento e ERP',
                    'API completa para integrações personalizadas'
                ]),
                'status' => 'active'
            ]
        ];
        
        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
} 