<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Tenant;
use App\Domain\Repositories\TenantRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentTenantRepository implements TenantRepositoryInterface
{
    public function getAll(): Collection
    {
        return Tenant::all();
    }

    public function getPaginated(int $perPage = 10, ?string $searchTerm = null, ?string $statusFilter = null): LengthAwarePaginator
    {
        $query = Tenant::query();
        
        // Aplicar filtro de busca
        if (!empty($searchTerm)) {
            $query->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('domain', 'like', "%{$searchTerm}%");
        }
        
        // Aplicar filtro de status
        if (!empty($statusFilter)) {
            $query->where('status', $statusFilter);
        }
        
        return $query->paginate($perPage);
    }

    public function findById(int $id): ?Tenant
    {
        return Tenant::find($id);
    }

    public function findByName(string $name): ?Tenant
    {
        return Tenant::where('name', $name)->first();
    }

    public function create(array $data): Tenant
    {
        return Tenant::create($data);
    }

    public function update(int $id, array $data): ?Tenant
    {
        $tenant = $this->findById($id);

        if (!$tenant) {
            return null;
        }

        $tenant->update($data);
        return $tenant->fresh();
    }

    public function delete(int $id): bool
    {
        $tenant = $this->findById($id);

        if (!$tenant) {
            return false;
        }

        return $tenant->delete();
    }

    public function search(string $term): Collection
    {
        return Tenant::where('name', 'like', "%{$term}%")
            ->orWhere('domain', 'like', "%{$term}%")
            ->get();
    }

    public function count(): int
    {
        return Tenant::count();
    }
} 