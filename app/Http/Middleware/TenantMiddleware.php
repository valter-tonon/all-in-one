<?php

namespace App\Http\Middleware;

use App\Domain\Entities\Tenant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Obter o tenant pelo domínio ou pelo header X-Tenant-ID
        $tenant = $this->getTenant($request);

        if (!$tenant) {
            return response()->json(['message' => 'Tenant não encontrado'], 404);
        }

        // Verificar se o tenant está ativo
        if (!$tenant->isActive()) {
            return response()->json(['message' => 'Tenant inativo'], 403);
        }

        // Configurar a conexão do tenant
        $this->setTenantConnection($tenant);

        // Adicionar o tenant ao request para uso posterior
        $request->tenant = $tenant;

        return $next($request);
    }

    /**
     * Obter o tenant pelo domínio ou pelo header X-Tenant-ID.
     */
    private function getTenant(Request $request): ?Tenant
    {
        // Verificar se o tenant foi especificado no header
        $tenantId = $request->header('X-Tenant-ID');
        if ($tenantId) {
            return Tenant::find($tenantId);
        }

        // Verificar se o tenant foi especificado pelo domínio
        $host = $request->getHost();
        return Tenant::where('domain', $host)->first();
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

        // Definir a conexão padrão como tenant
        DB::purge('tenant');
        DB::reconnect('tenant');
    }
} 