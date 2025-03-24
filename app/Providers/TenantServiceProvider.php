<?php

namespace App\Providers;

use App\Domain\Entities\Tenant;
use App\Events\TenantCreated;
use App\Events\TenantDeleted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class TenantServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registrar listeners para eventos de tenant
        Event::listen(TenantCreated::class, function (TenantCreated $event) {
            $this->createTenantDatabase($event->tenant);
            $this->runTenantMigrations($event->tenant);
        });

        Event::listen(TenantDeleted::class, function (TenantDeleted $event) {
            $this->deleteTenantDatabase($event->tenant);
        });
    }

    /**
     * Criar banco de dados para o tenant
     */
    private function createTenantDatabase(Tenant $tenant): void
    {
        $database = $tenant->database;
        
        // Criar o banco de dados
        DB::statement("CREATE DATABASE IF NOT EXISTS `{$database}`");
    }

    /**
     * Executar migrações para o tenant
     */
    private function runTenantMigrations(Tenant $tenant): void
    {
        $this->setTenantConnection($tenant);
        
        // Executar migrações
        $migrationPath = database_path('migrations/tenant');
        
        if (file_exists($migrationPath)) {
            $this->app->make('migrator')->run($migrationPath);
        }
    }

    /**
     * Excluir banco de dados do tenant
     */
    private function deleteTenantDatabase(Tenant $tenant): void
    {
        $database = $tenant->database;
        
        // Excluir o banco de dados
        DB::statement("DROP DATABASE IF EXISTS `{$database}`");
    }

    /**
     * Configurar conexão para o tenant
     */
    private function setTenantConnection(Tenant $tenant): void
    {
        config([
            'database.connections.tenant.database' => $tenant->database
        ]);
        
        DB::purge('tenant');
        DB::reconnect('tenant');
    }
} 