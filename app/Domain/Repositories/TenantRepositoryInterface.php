<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Tenant;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface TenantRepositoryInterface
{
    public function getAll(): Collection;
    
    public function getPaginated(int $perPage = 10, ?string $searchTerm = null, ?string $statusFilter = null): LengthAwarePaginator;
    
    public function findById(int $id): ?Tenant;
    
    public function findByName(string $name): ?Tenant;
    
    public function create(array $data): Tenant;
    
    public function update(int $id, array $data): ?Tenant;
    
    public function delete(int $id): bool;
    
    public function search(string $term): Collection;
    
    public function count(): int;
} 