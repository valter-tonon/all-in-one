<?php

namespace App\Providers;

use App\Domain\Entities\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MultitenancyServiceProvider extends ServiceProvider
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
        // Configurar o middleware de tenant para as rotas da API
        Route::middlewareGroup('tenant', [
            \App\Http\Middleware\TenantMiddleware::class,
        ]);

        // Eventos para gerenciar o ciclo de vida do tenant
        Event::listen(\App\Events\TenantCreated::class, function ($event) {
            $this->createTenantDatabase($event->tenant);
            $this->runTenantMigrations($event->tenant);
        });

        Event::listen(\App\Events\TenantDeleted::class, function ($event) {
            $this->deleteTenantDatabase($event->tenant);
        });
    }

    /**
     * Criar o banco de dados para o tenant.
     */
    private function createTenantDatabase(Tenant $tenant): void
    {
        DB::statement("CREATE DATABASE IF NOT EXISTS `{$tenant->database}`");
    }

    /**
     * Executar as migrações para o tenant.
     */
    private function runTenantMigrations(Tenant $tenant): void
    {
        $this->setTenantConnection($tenant);

        $migrator = app('migrator');
        $migrator->setConnection('tenant');
        $migrator->run(database_path('migrations/tenant'));
    }

    /**
     * Excluir o banco de dados do tenant.
     */
    private function deleteTenantDatabase(Tenant $tenant): void
    {
        DB::statement("DROP DATABASE IF EXISTS `{$tenant->database}`");
    }

    /**
     * Configurar a conexão do tenant.
     */
    private function setTenantConnection(Tenant $tenant): void
    {
        config([
            'database.connections.tenant' => [
                'driver' => 'mysql',
                'url' => env('DATABASE_URL'),
                'host' => env('DB_HOST', '127.0.0.1'),
                'port' => env('DB_PORT', '3306'),
                'database' => $tenant->database,
                'username' => env('DB_USERNAME', 'forge'),
                'password' => env('DB_PASSWORD', ''),
                'unix_socket' => env('DB_SOCKET', ''),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'prefix_indexes' => true,
                'strict' => true,
                'engine' => null,
                'options' => extension_loaded('pdo_mysql') ? array_filter([
                    \PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
                ]) : [],
            ],
        ]);
    }
} 