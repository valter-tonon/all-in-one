<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Plan;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface PlanRepositoryInterface
{
    public function getAll(): Collection;
    
    public function getPaginated(int $perPage = 10, ?string $searchTerm = null, ?string $statusFilter = null): LengthAwarePaginator;
    
    public function findById(int $id): ?Plan;
    
    public function findByName(string $name): ?Plan;
    
    public function create(array $data): Plan;
    
    public function update(int $id, array $data): ?Plan;
    
    public function delete(int $id): bool;
    
    public function search(string $term): Collection;
    
    public function count(): int;
} 