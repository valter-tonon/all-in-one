<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Stock;
use App\Domain\Repositories\StockRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentStockRepository implements StockRepositoryInterface
{
    public function getAll(): Collection
    {
        return Stock::all();
    }

    public function findById(int $id): ?Stock
    {
        return Stock::find($id);
    }

    public function findBySku(string $sku): ?Stock
    {
        return Stock::where('sku', $sku)->first();
    }

    public function create(array $data): Stock
    {
        return Stock::create($data);
    }

    public function update(int $id, array $data): ?Stock
    {
        $stock = $this->findById($id);

        if (!$stock) {
            return null;
        }

        $stock->update($data);
        return $stock->fresh();
    }

    public function delete(int $id): bool
    {
        $stock = $this->findById($id);

        if (!$stock) {
            return false;
        }

        return $stock->delete();
    }

    public function search(string $term): Collection
    {
        return Stock::where('name', 'like', "%{$term}%")
            ->orWhere('sku', 'like', "%{$term}%")
            ->orWhere('description', 'like', "%{$term}%")
            ->orWhere('category', 'like', "%{$term}%")
            ->get();
    }

    public function getLowStock(): Collection
    {
        return Stock::where('quantity', '<=', 5)
            ->where('quantity', '>', 0)
            ->get();
    }

    public function getOutOfStock(): Collection
    {
        return Stock::where('quantity', '<=', 0)->get();
    }
} 