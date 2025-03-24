<?php

namespace App\Application\Services;

use App\Application\DTOs\StockDTO;
use App\Domain\Entities\Stock;
use App\Domain\Exceptions\StockNotFoundException;
use App\Domain\Repositories\StockRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class StockService
{
    public function __construct(
        private StockRepositoryInterface $repository
    ) {
    }

    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }

    public function findById(int $id): Stock
    {
        $stock = $this->repository->findById($id);

        if (!$stock) {
            throw new StockNotFoundException();
        }

        return $stock;
    }

    public function create(StockDTO $dto): Stock
    {
        // Gerar SKU se não fornecido
        $sku = $dto->sku ?? $this->generateSku($dto->name, $dto->category);

        return $this->repository->create([
            'name' => $dto->name,
            'description' => $dto->description,
            'quantity' => $dto->quantity,
            'price' => $dto->price,
            'sku' => $sku,
            'category' => $dto->category,
            'status' => $dto->status,
        ]);
    }

    public function update(int $id, StockDTO $dto): Stock
    {
        $stock = $this->findById($id);

        $updatedStock = $this->repository->update($id, [
            'name' => $dto->name,
            'description' => $dto->description,
            'quantity' => $dto->quantity,
            'price' => $dto->price,
            'sku' => $dto->sku ?? $stock->sku,
            'category' => $dto->category,
            'status' => $dto->status,
        ]);

        if (!$updatedStock) {
            throw new StockNotFoundException();
        }

        return $updatedStock;
    }

    public function delete(int $id): bool
    {
        $this->findById($id);
        
        return $this->repository->delete($id);
    }

    public function search(string $term): Collection
    {
        return $this->repository->search($term);
    }

    public function getLowStock(): Collection
    {
        return $this->repository->getLowStock();
    }

    public function getOutOfStock(): Collection
    {
        return $this->repository->getOutOfStock();
    }

    private function generateSku(string $name, ?string $category): string
    {
        $prefix = $category ? strtoupper(substr($category, 0, 3)) : 'PRD';
        $namePart = strtoupper(substr(Str::slug($name), 0, 5));
        $random = strtoupper(Str::random(5));
        
        return "{$prefix}-{$namePart}-{$random}";
    }
} 