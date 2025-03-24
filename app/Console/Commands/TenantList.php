<?php

namespace App\Console\Commands;

use App\Application\Services\TenantService;
use Illuminate\Console\Command;

class TenantList extends Command
{
    /**
     * O nome e a assinatura do comando.
     *
     * @var string
     */
    protected $signature = 'tenant:list {--active} {--inactive}';

    /**
     * A descrição do comando.
     *
     * @var string
     */
    protected $description = 'Lista todos os tenants do sistema';

    /**
     * Executa o comando.
     */
    public function handle(TenantService $tenantService)
    {
        $this->info("Listando tenants...");
        
        try {
            $tenants = $tenantService->getAll();
            
            // Filtrar por status se necessário
            if ($this->option('active')) {
                $tenants = $tenants->filter(fn($tenant) => $tenant->status === 'active');
            }
            
            if ($this->option('inactive')) {
                $tenants = $tenants->filter(fn($tenant) => $tenant->status === 'inactive');
            }
            
            if ($tenants->isEmpty()) {
                $this->warn("Nenhum tenant encontrado.");
                return Command::SUCCESS;
            }
            
            $this->info("Total de tenants: " . $tenants->count());
            
            $tableData = $tenants->map(function ($tenant) {
                return [
                    $tenant->id,
                    $tenant->name,
                    $tenant->domain,
                    $tenant->database,
                    $tenant->plan,
                    $tenant->status
                ];
            })->toArray();
            
            $this->table(
                ['ID', 'Nome', 'Domínio', 'Banco de Dados', 'Plano', 'Status'],
                $tableData
            );
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Erro ao listar tenants: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
} 