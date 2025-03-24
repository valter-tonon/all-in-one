<?php

namespace App\Console\Commands;

use App\Application\DTOs\TenantDTO;
use App\Application\Services\TenantService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class TenantCreate extends Command
{
    /**
     * O nome e a assinatura do comando.
     *
     * @var string
     */
    protected $signature = 'tenant:create {name} {domain?} {--plan=basic}';

    /**
     * A descrição do comando.
     *
     * @var string
     */
    protected $description = 'Cria um novo tenant no sistema';

    /**
     * Executa o comando.
     */
    public function handle(TenantService $tenantService)
    {
        $name = $this->argument('name');
        $domain = $this->argument('domain') ?? Str::slug($name) . '.localhost';
        $plan = $this->option('plan');
        
        $database = 'tenant_' . Str::slug($name);
        
        $this->info("Criando tenant: $name");
        $this->info("Domínio: $domain");
        $this->info("Banco de dados: $database");
        $this->info("Plano: $plan");
        
        try {
            $dto = new TenantDTO(
                name: $name,
                database: $database,
                domain: $domain,
                plan: $plan
            );
            
            $tenant = $tenantService->create($dto);
            
            $this->info("Tenant criado com sucesso!");
            $this->table(
                ['ID', 'Nome', 'Domínio', 'Banco de Dados', 'Plano', 'Status'],
                [[$tenant->id, $tenant->name, $tenant->domain, $tenant->database, $tenant->plan, $tenant->status]]
            );
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Erro ao criar tenant: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
} 