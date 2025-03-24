<?php

namespace App\Application\Services;

use App\Application\DTOs\PlanDTO;
use App\Domain\Entities\Plan;
use App\Domain\Repositories\PlanRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PlanService
{
    public function __construct(
        private PlanRepositoryInterface $repository
    ) {
    }

    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }

    /**
     * Obter planos com paginação e filtros
     */
    public function getPaginated(int $perPage = 10, ?string $searchTerm = null, ?string $statusFilter = null): LengthAwarePaginator
    {
        return $this->repository->getPaginated($perPage, $searchTerm, $statusFilter);
    }

    public function findById(int $id): ?Plan
    {
        return $this->repository->findById($id);
    }

    public function create(PlanDTO $dto): Plan
    {
        return $this->repository->create([
            'name' => $dto->name,
            'description' => $dto->description,
            'price' => $dto->price,
            'features' => $dto->features,
            'status' => $dto->status,
        ]);
    }

    public function update(int $id, PlanDTO $dto): ?Plan
    {
        return $this->repository->update($id, [
            'name' => $dto->name,
            'description' => $dto->description,
            'price' => $dto->price,
            'features' => $dto->features,
            'status' => $dto->status,
        ]);
    }

    public function delete(int $id): bool
    {
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
} 