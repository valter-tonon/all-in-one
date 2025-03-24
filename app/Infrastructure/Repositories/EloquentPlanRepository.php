<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Plan;
use App\Domain\Repositories\PlanRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentPlanRepository implements PlanRepositoryInterface
{
    public function getAll(): Collection
    {
        return Plan::all();
    }

    public function getPaginated(int $perPage = 10, ?string $searchTerm = null, ?string $statusFilter = null): LengthAwarePaginator
    {
        $query = Plan::query();
        
        // Aplicar filtro de busca
        if (!empty($searchTerm)) {
            $query->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
        }
        
        // Aplicar filtro de status
        if (!empty($statusFilter)) {
            $query->where('status', $statusFilter);
        }
        
        return $query->paginate($perPage);
    }

    public function findById(int $id): ?Plan
    {
        return Plan::find($id);
    }

    public function findByName(string $name): ?Plan
    {
        return Plan::where('name', $name)->first();
    }

    public function create(array $data): Plan
    {
        return Plan::create($data);
    }

    public function update(int $id, array $data): ?Plan
    {
        $plan = $this->findById($id);

        if (!$plan) {
            return null;
        }

        $plan->update($data);
        return $plan->fresh();
    }

    public function delete(int $id): bool
    {
        $plan = $this->findById($id);

        if (!$plan) {
            return false;
        }

        return $plan->delete();
    }

    public function search(string $term): Collection
    {
        return Plan::where('name', 'like', "%{$term}%")
            ->orWhere('description', 'like', "%{$term}%")
            ->get();
    }

    public function count(): int
    {
        return Plan::count();
    }
} 