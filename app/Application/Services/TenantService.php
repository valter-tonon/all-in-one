<?php

namespace App\Application\Services;

use App\Application\DTOs\TenantDTO;
use App\Domain\Entities\Tenant;
use App\Domain\Exceptions\TenantNotFoundException;
use App\Domain\Repositories\TenantRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;

class TenantService
{
    public function __construct(
        private TenantRepositoryInterface $repository
    ) {
    }

    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }

    /**
     * Obter tenants com paginação e filtros
     */
    public function getPaginated(int $perPage = 10, ?string $searchTerm = null, ?string $statusFilter = null): LengthAwarePaginator
    {
        return $this->repository->getPaginated($perPage, $searchTerm, $statusFilter);
    }

    public function findById(int $id): Tenant
    {
        $tenant = $this->repository->findById($id);

        if (!$tenant) {
            throw new TenantNotFoundException();
        }

        return $tenant;
    }

    public function create(TenantDTO $dto): Tenant
    {
        // Garantir que o nome do banco de dados seja único e seguro
        $database = 'tenant_' . Str::slug($dto->name) . '_' . Str::random(5);

        // Criar o tenant no banco de dados landlord
        $tenant = $this->repository->create([
            'name' => $dto->name,
            'database' => $database,
            'domain' => $dto->domain,
            'plan' => $dto->plan,
            'status' => $dto->status,
        ]);

        // Criar o banco de dados para o tenant
        $this->createTenantDatabase($database);

        return $tenant;
    }

    public function update(int $id, TenantDTO $dto): Tenant
    {
        $tenant = $this->findById($id);

        $updatedTenant = $this->repository->update($id, [
            'name' => $dto->name,
            'domain' => $dto->domain,
            'plan' => $dto->plan,
            'status' => $dto->status,
        ]);

        if (!$updatedTenant) {
            throw new TenantNotFoundException();
        }

        return $updatedTenant;
    }

    public function delete(int $id): bool
    {
        $tenant = $this->findById($id);
        
        // Remover o banco de dados do tenant
        $this->deleteTenantDatabase($tenant->database);
        
        return $this->repository->delete($id);
    }

    public function search(string $term): Collection
    {
        return $this->repository->search($term);
    }

    public function count(): int
    {
        return $this->repository->count();
    }

    private function createTenantDatabase(string $database): void
    {
        DB::statement("CREATE DATABASE IF NOT EXISTS `{$database}`");
    }

    private function deleteTenantDatabase(string $database): void
    {
        DB::statement("DROP DATABASE IF EXISTS `{$database}`");
    }
} 